<?php

use Bitrix\Main\Error;
use Bitrix\Main\ErrorCollection;
//use Bitrix\Sale;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

class CommentsVueComponent extends \CBitrixComponent implements \Bitrix\Main\Engine\Contract\Controllerable, \Bitrix\Main\Errorable
{
	/** @var ErrorCollection */
	protected $errorCollection;

	public function configureActions()
	{
		//return [];
		return [
			'getForm' => [
					'-prefilters' => [
							Bitrix\Main\Engine\ActionFilter\Authentication::class,
					],
			],
			'setForm' => [
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
		$string = '<script type="text/javascript">BX.ready(function(){siteOptions["COMMENTS_VUE_PARAMS"] = "'.$this->getSignedParameters() .'";})</script>';
		//$string = '<script>BX.ready(function(){siteOptions["MANAGER_COMPONENT_PATH"] = "' . $this->GetPath() . '"})</script>';
		\Bitrix\Main\Page\Asset::getInstance()->addString($string, false, \Bitrix\Main\Page\AssetLocation::BODY_END);
		\Bitrix\Main\Page\Asset::getInstance()->addJs($this->GetPath() . '/script.js');
		
		$this->errorCollection->clear();
		$this->includeComponentTemplate();

		$this->showErrors();
	}

	protected function listKeysSignedParameters()
	{
		return [
			'IBLOCK_ID',
			'EVENT_MESSAGE_ID',
			'ARTICLE_IBLOCK',
			'ARTICLE_ID',
			'ARTICLE_NAME',
			'ARTICLE_URL',
			'PREMODERATE',
		];
	}

	public function setFormAction($data, $signedParameters)
	{
		$author = htmlspecialcharsbx(trim($data['author']));
		$comment = htmlspecialcharsbx(trim($data['comment']));
		if(empty($author) || mb_strlen($author) < 2){
			$this->errorCollection['author'] = new Error('Поле с именем не должно быть пустым (меньше 2 символов)');
		}
	
		if(empty($comment || mb_strlen($comment) < 10)){
			$this->errorCollection['comment'] = new Error('Поле с комментарием не должно быть пустым (меньше 10 символов)');
		}
		
		$arParams = \Bitrix\Main\Component\ParameterSigner::unsignParameters($this->getName(), $signedParameters);
		if(empty($arParams)){
			$this->errorCollection['arParams'] = new Error('Параметры не определены');
		}
	
		if(count($this->errorCollection) > 0) return ['error' => $this->errorCollection];
		
		$clientIP = '';
		if ($_SERVER["HTTP_X_FORWARDED_FOR"]) $clientIP = $_SERVER["HTTP_X_FORWARDED_FOR"];
		else $clientIP = $_SERVER["HTTP_CLIENT_IP"];
		if(strlen($clientIP) <= 0) {
			$clientIP = $_SERVER["REMOTE_ADDR"];	
		}

		CModule::IncludeModule('iblock');
		$el = new CIBlockElement;
		$arAdd = array(			
				"NAME" => $author,
				"PREVIEW_TEXT" => $comment."\r\n".'--------------'."\r\n".'IP адрес: '.$clientIP,
				"IBLOCK_ID"=> $arParams['IBLOCK_ID'],
				"ACTIVE" => "Y"
		);
		if ($ID = $el->Add($arAdd)){
			$arFields = [
				"AUTHOR" => $author,
				"EMAIL_TO" => COption::GetOptionString("main", "email_from"),
				"COMMENT" => $arAdd["PREVIEW_TEXT"],
				"ARTICLE_NAME" => $arParams["ARTICLE_NAME"],
				"URL" => $arParams["ARTICLE_URL"],
			];
			
			$ev = \Bitrix\Main\Mail\Event::send(["EVENT_NAME" => 'MINDOCHIN_COMMENTS', "C_FIELDS" => $arFields, "LID" => SITE_ID, "LANGUAGE_ID" => 'ru', 'MESSAGE_ID' => $arParams["EVENT_MESSAGE_ID"]]);
			//\Bitrix\Main\Diag\Debug::dumpToFile($ev, '', '__ev');
						
			return ['success' => $ID];
		}
		else{
			$this->errorCollection[] = new Error($el->LAST_ERROR);
			return ['error' => $this->errorCollection];
		}

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
}
