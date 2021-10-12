<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */
/** @global CMain $APPLICATION */

use Bitrix\Main\Loader,
	Bitrix\Main,
	Bitrix\Iblock;

if(!isset($arParams["CACHE_TIME"]))
	$arParams["CACHE_TIME"] = 36000;

$arParams["IBLOCK_TYPE"] = trim($arParams["IBLOCK_TYPE"]);
if($arParams["IBLOCK_TYPE"] == '')
	$arParams["IBLOCK_TYPE"] = "news";
if($arParams["IBLOCK_TYPE"]=="-")
	$arParams["IBLOCK_TYPE"] = "";

if(!is_array($arParams["ARTICLE_IBLOCK"]))
	$arParams["ARTICLE_IBLOCK"] = array($arParams["ARTICLE_IBLOCK"]);
foreach($arParams["ARTICLE_IBLOCK"] as $k=>$v)
	if(!$v)
		unset($arParams["ARTICLE_IBLOCK"][$k]);

if(!is_array($arParams["COMMENTS_IBLOCK"]))
	$arParams["COMMENTS_IBLOCK"] = array($arParams["COMMENTS_IBLOCK"]);
foreach($arParams["COMMENTS_IBLOCK"] as $k=>$v)
	if(!$v)
		unset($arParams["COMMENTS_IBLOCK"][$k]);

if(!is_array($arParams["FIELD_CODE"]))
	$arParams["FIELD_CODE"] = array();
foreach($arParams["FIELD_CODE"] as $key=>$val)
	if(!$val)
		unset($arParams["FIELD_CODE"][$key]);

$arParams["SORT_BY1"] = trim($arParams["SORT_BY1"]);
if($arParams["SORT_BY1"] == '')
	$arParams["SORT_BY1"] = "ACTIVE_FROM";
if(!preg_match('/^(asc|desc|nulls)(,asc|,desc|,nulls){0,1}$/i', $arParams["SORT_ORDER1"]))
	$arParams["SORT_ORDER1"]="DESC";

if($arParams["SORT_BY2"] == '')
	$arParams["SORT_BY2"] = "SORT";
if(!preg_match('/^(asc|desc|nulls)(,asc|,desc|,nulls){0,1}$/i', $arParams["SORT_ORDER2"]))
	$arParams["SORT_ORDER2"]="ASC";

$arParams["NEWS_COUNT"] = intval($arParams["NEWS_COUNT"]);
if($arParams["NEWS_COUNT"]<=0)
	$arParams["NEWS_COUNT"] = 20;

$arParams["DETAIL_URL"]=trim($arParams["DETAIL_URL"]);

$arParams["ACTIVE_DATE_FORMAT"] = trim($arParams["ACTIVE_DATE_FORMAT"]);
if($arParams["ACTIVE_DATE_FORMAT"] == '')
	$arParams["ACTIVE_DATE_FORMAT"] = $DB->DateFormatToPHP(CSite::GetDateFormat("SHORT"));

if($this->startResultCache(false, ($arParams["CACHE_GROUPS"]==="N"? false: $USER->GetGroups())))
{
	if(!Loader::includeModule("iblock"))
	{
		$this->abortResultCache();
		ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
		return;
	}
	$arSelect = array_merge($arParams["FIELD_CODE"], array(
		"ID",
		"IBLOCK_ID",
		"ACTIVE_FROM",
		"DETAIL_PAGE_URL",
		"NAME",
		"PROPERTY_COMMENT_COUNT"
	));
	$arFilter = array (
		"IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
		"IBLOCK_ID"=> $arParams["ARTICLE_IBLOCK"],
		"IBLOCK_LID" => SITE_ID,
		"ACTIVE" => "Y",
		"ACTIVE_DATE" => "Y",
		"CHECK_PERMISSIONS" => "Y",
	);
	$arOrder = array(
		$arParams["SORT_BY1"]=>$arParams["SORT_ORDER1"],
		$arParams["SORT_BY2"]=>$arParams["SORT_ORDER2"],
	);
	if(!array_key_exists("ID", $arOrder))
		$arOrder["ID"] = "DESC";
	$arResult=array(
		"ITEMS"=>array(),
	);
	
	$ids = $arSections = $arComments = [];
	
	$rsItems = CIBlockElement::GetList($arOrder, $arFilter, false, array("nTopCount"=>$arParams["NEWS_COUNT"]), $arSelect);
	$rsItems->SetUrlTemplates($arParams["DETAIL_URL"]);
	while($arItem = $rsItems->GetNext())
	{
		$arButtons = CIBlock::GetPanelButtons(
			$arItem["IBLOCK_ID"],
			$arItem["ID"],
			0,
			array("SECTION_BUTTONS"=>false, "SESSID"=>false)
		);
		$arItem["EDIT_LINK"] = $arButtons["edit"]["edit_element"]["ACTION_URL"];
		$arItem["DELETE_LINK"] = $arButtons["edit"]["delete_element"]["ACTION_URL"];

		if($arItem["ACTIVE_FROM"] <> '')
			$arItem["DISPLAY_ACTIVE_FROM"] = CIBlockFormatProperties::DateFormat($arParams["ACTIVE_DATE_FORMAT"], MakeTimeStamp($arItem["ACTIVE_FROM"], CSite::GetDateFormat()));
		else
			$arItem["DISPLAY_ACTIVE_FROM"] = "";

		Iblock\InheritedProperty\ElementValues::queue($arItem["IBLOCK_ID"], $arItem["ID"]);

		$arResult["ITEMS"][]=$arItem;
		$arResult["LAST_ITEM_IBLOCK_ID"]=$arItem["IBLOCK_ID"];
		
		$ids[] = $arItem['ID'];
	}

	//////////////////////  get sections
	$rsSections = CIBlockElement::GetElementGroups($ids);
	while ($s = $rsSections->GetNext())
	{
		$arSections[$s['IBLOCK_ELEMENT_ID']] = [
			'ID' => $s['ID'],
			'NAME' => $s['NAME'],
			'SECTION_PAGE_URL' => $s['SECTION_PAGE_URL'],
		];
	}
	//$arResult['SECTION_LIST'] = $arSections;

	///////////////////////  get comments count
	$rsComments = CIBlockElement::GetList([],['IBLOCK_ID'=>$arParams['COMMENTS_IBLOCK'], 'PROPERTY_ID_RECORD'=>$ids, 'ACTIVE'=>'Y'],['PROPERTY_ID_RECORD']);
	while ($c = $rsComments->GetNext())
	{
		$arComments[$c['PROPERTY_ID_RECORD_VALUE']] = (int)$c['CNT'];
	}
	//$arResult['COMMENTS_COUNT'] = $arComments;
	
	foreach ($arResult["ITEMS"] as &$arItem)
	{
		$ipropValues = new Iblock\InheritedProperty\ElementValues($arItem["IBLOCK_ID"], $arItem["ID"]);
		$arItem["IPROPERTY_VALUES"] = $ipropValues->getValues();
		Iblock\Component\Tools::getFieldImageData(
			$arItem,
			array('PREVIEW_PICTURE', 'DETAIL_PICTURE'),
			Iblock\Component\Tools::IPROPERTY_ENTITY_ELEMENT,
			'IPROPERTY_VALUES'
		);
		
		$arItem['SECTION_LIST'] = $arSections[$arItem['ID']];
		
		if($arItem['PROPERTY_COMMENT_COUNT_VALUE'] != (int)$arComments[$arItem['ID']]){
			CIBlockElement::SetPropertyValues($arItem['ID'], $arItem["IBLOCK_ID"], (int)$arComments[$arItem['ID']], 'COMMENT_COUNT');
		}
		$arItem['COMMENTS_COUNT'] = (int)$arComments[$arItem['ID']];
	}
	unset($arItem);

	$this->setResultCacheKeys(array(
		"LAST_ITEM_IBLOCK_ID",
	));
	$this->includeComponentTemplate();
}

if(
	$arResult["LAST_ITEM_IBLOCK_ID"] > 0
	&& $USER->IsAuthorized()
	&& $APPLICATION->GetShowIncludeAreas()
	&& CModule::IncludeModule("iblock")
)
{
	$arButtons = CIBlock::GetPanelButtons($arResult["LAST_ITEM_IBLOCK_ID"], 0, 0, array("SECTION_BUTTONS"=>false));
	$this->addIncludeAreaIcons(CIBlock::GetComponentMenu($APPLICATION->GetPublicShowMode(), $arButtons));
}
