<?php

use Bitrix\Main\Error;
use Bitrix\Main\ErrorCollection;
//use Bitrix\Sale;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

class FeedbackVueComponent extends \CBitrixComponent implements \Bitrix\Main\Engine\Contract\Controllerable, \Bitrix\Main\Errorable
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
		$string = '<script type="text/javascript">BX.ready(function(){siteOptions["FEEDBACK_VUE_PARAMS"] = "'.$this->getSignedParameters() .'";})</script>';
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
		];
	}

	public function getFormAction()
	{
		return ['script_url' => $this->GetPath() . '/feedback.js'];
	}

	public function setFormAction($fbContact, $fbMessage, $signedParameters)
	{
		$fbContact = htmlspecialcharsbx(trim($fbContact));
		$fbMessage = htmlspecialcharsbx(trim($fbMessage));
		if(empty($fbContact)){
			$this->errorCollection['fbContact'] = new Error('Поле с контактом не должно быть пустым (меньше 5 символов)');
		}

		if(empty($fbMessage)){
			$this->errorCollection['fbMessage'] = new Error('Поле с сообщением не должно быть пустым (меньше 10 символов)');
		}

    	$arParams = \Bitrix\Main\Component\ParameterSigner::unsignParameters($this->getName(), $signedParameters);
		if(empty($arParams) || empty($arParams['IBLOCK_ID']) || empty($arParams['EVENT_MESSAGE_ID'])){
			$this->errorCollection['arParams'] = new Error('Параметры не определены. Обратитесь к администратору сайта');
		}

		if(count($this->errorCollection) > 0) return ['error' => $this->getErrors()];

		$clientIP = '';
		if ($_SERVER["HTTP_X_FORWARDED_FOR"]) $clientIP = $_SERVER["HTTP_X_FORWARDED_FOR"];
		else $clientIP = $_SERVER["HTTP_CLIENT_IP"];
		if(strlen($clientIP) <= 0) {
			$clientIP = $_SERVER["REMOTE_ADDR"];
		}

		CModule::IncludeModule('iblock');
		$el = new CIBlockElement;
		$arAdd = array(
				"NAME" => $fbContact,
				"PREVIEW_TEXT" => "\r\n".$fbMessage."\r\n".'--------------'."\r\n".'IP адрес: '.$clientIP,
				"IBLOCK_ID"=> $arParams['IBLOCK_ID'],
				"ACTIVE" => "Y"
		);
		if ($ID = $el->Add($arAdd)){
			$arFields = [
				"AUTHOR" => $fbContact,
				"AUTHOR_EMAIL" => $fbContact,
				"EMAIL_TO" => COption::GetOptionString("main", "email_from"),
				"TEXT" => $arAdd["PREVIEW_TEXT"],
			];

			$ev = \Bitrix\Main\Mail\Event::send(["EVENT_NAME" => 'FEEDBACK_FORM', "C_FIELDS" => $arFields, "LID" => SITE_ID, "LANGUAGE_ID" => 'ru', 'MESSAGE_ID' => $arParams["EVENT_MESSAGE_ID"]]);
			//\Bitrix\Main\Diag\Debug::dumpToFile($ev, '', '__ev');

			return ['success' => $ID];
		}
		else{
			$this->errorCollection[] = new Error($el->LAST_ERROR);
			//return ['error'=>$el->LAST_ERROR];
			return ['error' => $this->getErrors()];
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