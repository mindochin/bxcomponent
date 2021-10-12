<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("iblock"))
	return;

$arTypes = CIBlockParameters::GetIBlockTypes();


$rsSites = CSite::GetList($by="sort", $order="desc", Array());
while ($arSite = $rsSites->Fetch())
{
	$arSiteID[$arSite["ID"]] = '[' . $arSite["ID"] . ']' . ' ' .$arSite["NAME"];
}

if(!empty($arCurrentValues["IBLOCK_TYPE"]) and !empty($arCurrentValues['SITE_ID']))
	require (__DIR__ . '/install/form.php');

$arIBlocks=array();
$db_iblock = CIBlock::GetList(array("SORT"=>"ASC"), array("SITE_ID" => $arCurrentValues["SITE_ID"], "TYPE" => (!empty($arCurrentValues["IBLOCK_TYPE"]) ? $arCurrentValues["IBLOCK_TYPE"] : ""), 'ACTIVE' => 'Y'));
while($arRes = $db_iblock->Fetch())
	$arIBlocks[$arRes["ID"]] = "[".$arRes["ID"]."] ".$arRes["NAME"];

$arElementNames = Array('');
$dbElementNamesFilter = Array("IBLOCK_ACTIVE" => "Y", "ACTIVE" => "Y", "IBLOCK_TYPE" => $arCurrentValues["IBLOCK_TYPE"], "IBLOCK_ID" => $arCurrentValues["IBLOCK_ID"]);
$dbElementNamesSelect = Array('ID', 'IBLOCK_ID', 'NAME');
$dbElementNamesSort = Array("NAME"=>"ASC");
$dbElementNames = CIBlockElement::GetList($dbElementNamesSort, $dbElementNamesFilter, false, false, $dbElementNamesSelect);
while ($rowElementNames = $dbElementNames->getNext()) {
	$arElementNames[$rowElementNames['ID']] = $rowElementNames['NAME'];
}

$arComponentParameters = array(
	"GROUPS" => array(),
	"PARAMETERS" => array(
		"SITE_ID" => array(
			"PARENT" => "BASE",
			"NAME" => "Привязка к сайту",
			"TYPE" => "LIST",
			"VALUES" => $arSiteID,
			"DEFAULT" => '',			
			"REFRESH" => "Y",
		),	
		"IBLOCK_TYPE" => array(
			"PARENT" => "BASE",
			"NAME" => "Тип инфоблока",
			"TYPE" => "LIST",
			"VALUES" => $arTypes,
			"DEFAULT" => "",
			"REFRESH" => "Y",
		),
		"IBLOCK_ID" => array(
			"PARENT" => "BASE",
			"NAME" => "Инфоблок с формами",
			"TYPE" => "LIST",
			"VALUES" => $arIBlocks,
			"DEFAULT" => '',
			//"ADDITIONAL_VALUES" => "Y",
			"REFRESH" => "Y",
		),
		"BLOCK_NAME" => array(
			"PARENT" => "BASE",
			"NAME" => 'Название формы',
			"TYPE" => "LIST",
			"VALUES" => $arElementNames,
			"DEFAULT" => "",			
		),
		"IBLOCK_ORDER" => array(
			"PARENT" => "BASE",
			"NAME" => "Инфоблок для сохранения заявок",
			"TYPE" => "LIST",
			"VALUES" => $arIBlocks,
			"DEFAULT" => '',
			//"ADDITIONAL_VALUES" => "Y",
			//"REFRESH" => "Y",
		),
		"FORM_AS" => array(
			"PARENT" => "BASE",
			"NAME" => "Форма как",
			"TYPE" => "LIST",
			"VALUES" => array('block' => 'Блок страницы', 'inline' => 'Встроенная', 'modal_btn' => 'Модальная с кнопкой', 'modal' => 'Модальная без кнопки'),
			"DEFAULT" => 'block',
		),
		"BLOCK_PADDING" => array(
			"PARENT" => "BASE",
			"NAME" => "Отступ внутри блока (5px 5px и тд)",
			"TYPE" => "STRING",			
			"DEFAULT" => '',
		),
		"BLOCK_MARGIN" => array(
			"PARENT" => "BASE",
			"NAME" => "Отступ снаружи блока (5px 5px и тд)",
			"TYPE" => "STRING",			
			"DEFAULT" => '',
		),
		/*"CACHE_TIME"  =>  array("DEFAULT"=>36000000),
		"CACHE_GROUPS" => array(
			"PARENT" => "CACHE_SETTINGS",
			"NAME" => GetMessage("MDC_SHBI_CACHE_GROUPS"),
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),*/
	),
);
//дополнительная кнопка внизу блока
$arComponentParameters["PARAMETERS"]['ADD_BUTTON'] = array(
	"PARENT" => "ADD_BUTTON",
	"NAME" => "Доп. кнопка в конце блока",
	"TYPE" => "CHECKBOX",
	//"VALUES" => $previewPicPos,
	"DEFAULT" => 'N',
	//"ADDITIONAL_VALUES" => "Y",
	"REFRESH" => "Y",
);
if($arCurrentValues['ADD_BUTTON'] == 'Y')
{
	$arComponentParameters["PARAMETERS"]['ADD_BUTTON_TITLE'] = array(
		"PARENT" => "ADD_BUTTON",
		"NAME" => "Название доп. кнопки в конце блока",
		"TYPE" => "STRING",
		//"VALUES" => $previewPicPos,
		"DEFAULT" => '',
		//"ADDITIONAL_VALUES" => "Y",
		//"REFRESH" => "Y",
	);
	$arComponentParameters["PARAMETERS"]['ADD_BUTTON_LINK'] = array(
		"PARENT" => "ADD_BUTTON",
		"NAME" => "Ссылка для доп. кнопки (вида /index.php)",
		"TYPE" => "STRING",
		//"VALUES" => $previewPicPos,
		//"DEFAULT" => '/index.php',
		//"ADDITIONAL_VALUES" => "Y",
		//"REFRESH" => "Y",
	);
}