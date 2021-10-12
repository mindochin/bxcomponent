<?php

use Bitrix\Main\Error;
use Bitrix\Main\ErrorCollection;
use Bitrix\Main\Loader;
//use Bitrix\Sale;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

class TestOnewayComponent extends \CBitrixComponent implements \Bitrix\Main\Engine\Contract\Controllerable, \Bitrix\Main\Errorable
{
	/** @var ErrorCollection */
	protected $errorCollection;

	public function configureActions()
	{
		return [
			'setLike' => [
				'-prefilters' => [
					Bitrix\Main\Engine\ActionFilter\Authentication::class,
				],
			],
		];
	}

	public function onPrepareComponentParams($arParams)
	{ //Этот код **будет** выполняться при запуске аяксовых-действий
		$this->errorCollection = new ErrorCollection();
		return $arParams;
	}

	public function executeComponent()
	{ //Этот код **не будет** выполняться при запуске аяксовых-действий
		Loader::includeModule("iblock");
		Loader::IncludeModule('highloadblock');
		CJSCore::Init();
		
		$this->errorCollection->clear();

		$arFilter = Array('IBLOCK_ID' => $this->arParams["IBLOCK_ID"], "IBLOCK_ACTIVE" => "Y", "ACTIVE"=>"Y");
		$res = CIBlockElement::GetList(["SORT"=>"ASC"], $arFilter, false, false, ["ID", "IBLOCK_ID", 'NAME', 'PREVIEW_PICTURE', 'PREVIEW_TEXT', 'PROPERTY_*']);
		$this->arResult['ITEMS'] = [];
		while($ob = $res->GetNextElement()) {
			$arFields = $ob->GetFields();
			$arProps = $ob->GetProperties();
			
			$photo = '';
			if(!empty($arFields["PREVIEW_PICTURE"])) {
				$photo = CFile::GetFileArray($arFields["PREVIEW_PICTURE"]);
				$photo = $photo['SRC'];			
			}
			
			$slider = $likes = [];
			if(!empty($arProps["ATT_PHOTOS"]['VALUE'])) {
				//соберем лайки к фото
				$hlblock = Bitrix\Highloadblock\HighloadBlockTable::getList(['filter' => ['=TABLE_NAME'=>'test_oneway']])->fetch();
				$entity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock)->getDataClass();
				$rsData = $entity::getList([
					'select' => ['UF_IMG_ID', 'CNT'],
					'runtime' => [new Bitrix\Main\Entity\ExpressionField('CNT', 'COUNT(*)')],
					'filter' => ["@UF_IMG_ID" => $arProps["ATT_PHOTOS"]['VALUE']],//\Bitrix\Main\Entity\Query::filter()->whereIn('UF_IMG_ID', $arProps["ATT_PHOTOS"]['VALUE'])
					'group' => ['UF_IMG_ID'],
				]);

				while($arData = $rsData->Fetch()) {
					$likes[$arData['UF_IMG_ID']] = $arData['CNT'];
				}
				
				//соберем фото
				foreach($arProps["ATT_PHOTOS"]['VALUE'] as $slide){
					$slide = CFile::GetFileArray($slide);
					$slider[] = [
						'src'=>$slide['SRC'],
						'id'=>$slide['ID'],
						'like'=>$likes[$slide['ID']] ?? 0,
					];
				}
			}			
			
			$birthday = [];
			if(!empty($arProps["ATT_PHOTOS"]['VALUE'])) {
				// вычислим остаток до дня рождения
				$timestampBd = MakeTimeStamp($arProps['ATT_DATE']['VALUE']);
				$nextBd = new \DateTime(date('Y').'-'.date('m',$timestampBd).'-'.date('d',$timestampBd));
				$currentDate = new \DateTime('today');
				
				$diff = $currentDate->diff($nextBd);
				// др прошло, вычисляем следующее
				if($diff->invert){					
					$nextBd->modify('+1 year');
					$diff = $currentDate->diff($nextBd);
				}
				
				$birthday['next'] = $nextMonths = $nextDays = '';
				if(!empty($diff->m)) {
					$nextMonths = $this->numWord($diff->m, ['месяц', 'месяца', 'месяцев']);
					$birthday['next'] = $nextMonths;
				}
				if(!empty($diff->d)) {
					$nextDays = $this->numWord($diff->d, ['день', 'дня', 'дней']);
					$birthday['next'] = $nextDays;
				}
				if(!empty($diff->m) && !empty($diff->d))
					$birthday['next'] = $nextMonths . ' и ' . $nextDays;
				
				$birthday['value'] = CIBlockFormatProperties::DateFormat('j F Y', MakeTimeStamp($arProps['ATT_DATE']['VALUE']));
				$birthday['year'] = FormatDate("Q", $timestampBd);				
			}
			
			$this->arResult['ITEMS'][] = [
				'NAME'=>$arFields['NAME'],
				'DESCRIPTION'=>$arFields['PREVIEW_TEXT'],
				'PHOTO'=>$photo,
				'POST'=>$arProps['ATT_POST']['VALUE'],
				'PLACE'=>$arProps['ATT_PLACE']['VALUE'],
				'BIRTHDAY'=>$birthday,				
				'SLIDER'=>$slider,
			];
		}
		
		$this->includeComponentTemplate();

		$this->showErrors();
	}

	protected function listKeysSignedParameters()
	{
		return [
			'IBLOCK_ID',
		];
	}

	public function setLikeAction($imgId)
	{
		$result = [];
		$imgId = preg_replace('/[^0-9]/', '', $imgId);
		
		if(empty($imgId)){
			$this->errorCollection['imgId'] = new Error('Поле с лайком должно содержать цифры');
		}

		if(count($this->errorCollection) > 0) return ['error' => $this->getErrors()];
		
		$clientIP = '';
		if ($_SERVER["HTTP_X_FORWARDED_FOR"]) $clientIP = $_SERVER["HTTP_X_FORWARDED_FOR"];
		else $clientIP = $_SERVER["HTTP_CLIENT_IP"];
		if(strlen($clientIP) <= 0) {
			$clientIP = $_SERVER["REMOTE_ADDR"];	
		}
		
		//если нет ип - прочее бессмысленно
		if(empty($clientIP)){
			$this->errorCollection[] = new Error('Необходимые данные не получены');
			return ['error' => $this->getErrors()];
		}
		
		Loader::IncludeModule('highloadblock');

		// есть ли уже лайк с этого ип
		$hlblock = Bitrix\Highloadblock\HighloadBlockTable::getList(['filter' => ['=TABLE_NAME'=>'test_oneway']])->fetch();
		$entity = Bitrix\Highloadblock\HighloadBlockTable::compileEntity($hlblock)->getDataClass();
		$rsData = $entity::getList([
			'select' => ['*'],				
			'filter' => ['=UF_IMG_ID' => $imgId, '=UF_IP_ADDR'=>$clientIP],
		]);

		$result['set'] = 'none';

		if ($arData = $rsData->Fetch()) {
			// если был лайк с этого ип	к этой картинке
			$entity::Delete($arData['ID']);
			$result['set'] = 'delete';
		}else{
			// новый лайк
			$arFields = ['UF_IMG_ID' => $imgId, 'UF_IP_ADDR'=>$clientIP];
			$res = $entity::add($arFields);
			if($res->isSuccess())
				$result['set'] = 'add';
		}
		
		// итого лайков
		$result['count'] = 0;
		
		$rsData = $entity::getList([
			'select' => ['CNT'],
			'runtime' => [new Bitrix\Main\Entity\ExpressionField('CNT', 'COUNT(*)')],
			'filter' => ["=UF_IMG_ID" => $imgId],
		]);

		if ($arData = $rsData->Fetch()) {
			$result['count'] = $arData['CNT'];
		}

		return ['success' => $result];
	}

	protected function showErrors()
	{
		foreach ($this->getErrors() as $error) {
			ShowError($error);
		}
	}

	/**
	 * Getting array of errors.
	 * @return Error[]
	 */
	public function getErrors()
	{
		return $this->errorCollection->toArray();
	}

	/**
	 * Getting once error with the necessary code.
	 * @param string $code Code of error.
	 * @return Error
	 */
	public function getErrorByCode($code)
	{
		return $this->errorCollection->getErrorByCode($code);
	}
	
	/**
	 * Склонение существительных после числительных.
	 * 
	 * @param string $value Значение
	 * @param array $words Массив вариантов, например: array('товар', 'товара', 'товаров')
	 * @param bool $show Включает значение $value в результирующею строку
	 * @return string
	 */
	function numWord($value, $words, $show = true) 
	{
		$num = $value % 100;
		if ($num > 19) { 
			$num = $num % 10; 
		}
		
		$out = ($show) ?  $value . ' ' : '';
		switch ($num) {
			case 1:  $out .= $words[0]; break;
			case 2: 
			case 3: 
			case 4:  $out .= $words[1]; break;
			default: $out .= $words[2]; break;
		}
		
		return $out;
	}
}
