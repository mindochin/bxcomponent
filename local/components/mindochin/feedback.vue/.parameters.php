<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("iblock"))
	return;

if($arCurrentValues["IBLOCK_ID"] > 0)
{
	$arIBlock = CIBlock::GetArrayByID($arCurrentValues["IBLOCK_ID"]);
}

$arIBlockType = CIBlockParameters::GetIBlockTypes();

$arIBlock = [];
$rsIBlock = CIBlock::GetList(Array("sort" => "asc"), Array("TYPE" => $arCurrentValues["IBLOCK_TYPE"], "ACTIVE"=>"Y"));
while($arr = $rsIBlock->Fetch())
{
	$arIBlock[$arr["ID"]] = "[".$arr["ID"]."] ".$arr["NAME"];
}

$site = ($_REQUEST["site"] <> ''? $_REQUEST["site"] : ($_REQUEST["src_site"] <> ''? $_REQUEST["src_site"] : false));
$arFilter = Array("ACTIVE" => "Y");//"TYPE_ID" => "FEEDBACK_FORM", 
if($site !== false)
	$arFilter["LID"] = $site;
$arEvent = Array();
$dbType = CEventMessage::GetList($by="ID", $order="DESC", $arFilter);
while($arType = $dbType->GetNext())
	$arEvent[$arType["ID"]] = "[".$arType["ID"]."] ".$arType["SUBJECT"];

$arComponentParameters = [
	"GROUPS" => [],
	"PARAMETERS" => [
		"IBLOCK_ID" => [
			"PARENT" => "DATA_SOURCE",
			"NAME" => 'Инфоблок для сообщений',
			"TYPE" => "LIST",
			"VALUES" => $arIBlock,
			"REFRESH" => "Y",
		],
		"EVENT_MESSAGE_ID" => [
			"NAME" => 'Почтовый шаблон для уведомлений', 
			"TYPE"=>"LIST", 
			"VALUES" => $arEvent,
			"DEFAULT"=>"", 
			"MULTIPLE"=>"N", 
			"COLS"=>25, 
			"PARENT" => "BASE",
		],
	],
];
?>