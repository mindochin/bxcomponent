<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("iblock"))
	return;

$arIBlock = [];
$rsIBlock = CIBlock::GetList(Array("sort" => "asc"), Array("ACTIVE"=>"Y"));
while($arr = $rsIBlock->Fetch())
{
	$arIBlock[$arr["ID"]] = "[".$arr["ID"]."] ".$arr["NAME"];
}

$arEvent = [];
//$arFilter = ['SITE_ID' => SITE_ID];//определяет неверно, тк через аякс и админку
$arFilter = ['TYPE_ID' => 'MINDOCHIN_COMMENTS'];
$dbType = CEventMessage::GetList($by="ID", $order="DESC", $arFilter);
while($arType = $dbType->GetNext())
	$arEvent[$arType["ID"]] = "[".$arType["ID"]."] ".$arType["SUBJECT"];

$arComponentParameters = [
	"GROUPS" => [],
	"PARAMETERS" => [
		"IBLOCK_ID" => [
			"PARENT" => "DATA_SOURCE",
			"NAME" => 'Инфоблок с комментариями',
			"TYPE" => "LIST",
			"VALUES" => $arIBlock,
			"REFRESH" => "Y",
		],
		"ARTICLE_ID" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => "ID статьи",
			"TYPE" => "TEXTBOX",
		),
		"ARTICLE_IBLOCK" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => "Инфоблок со статьями",
			"TYPE" => "TEXTBOX",
		),
		"ARTICLE_NAME" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => "Название статьи",
			"TYPE" => "TEXTBOX",
		),
		"ARTICLE_URL" => array(
			"PARENT" => "DATA_SOURCE",
			"NAME" => "Ссылка на статью",
			"TYPE" => "TEXTBOX",
		),
		"PREMODERATE" => array(
			"NAME" => "Премодерация",
			"TYPE" => "CHECKBOX",
			"DEFAULT" => "Y",
		),
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