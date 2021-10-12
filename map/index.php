<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Карта сайта");
?> 
<p><?$APPLICATION->IncludeComponent(
	"bitrix:main.map",
	"",
	Array(
		"LEVEL" => "3",
		"COL_NUM" => "1",
		"SHOW_DESCRIPTION" => "Y",
		"SET_TITLE" => "Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600"
	),
false
);?></p>
 
<p><?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section.list",
	"tree",
	Array(
		"IBLOCK_TYPE" => "article",
		"IBLOCK_ID" => "1",
		"SECTION_ID" => $_REQUEST["SECTION_ID"],
		"SECTION_CODE" => "",
		"SECTION_URL" => "",
		"COUNT_ELEMENTS" => "Y",
		"TOP_DEPTH" => "2",
		"SECTION_FIELDS" => array(),
		"SECTION_USER_FIELDS" => array(),
		"ADD_SECTIONS_CHAIN" => "Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_NOTES" => "",
		"CACHE_GROUPS" => "N"
	)
);?> 
  <br />
 </p>
 
<p><?$APPLICATION->IncludeComponent(
	"bitrix:news.line",
	".default",
	Array(
		"IBLOCK_TYPE" => "article",
		"IBLOCKS" => array("1"),
		"NEWS_COUNT" => "500",
		"FIELD_CODE" => array(),
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_ORDER1" => "DESC",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"DETAIL_URL" => "",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"CACHE_NOTES" => "",
		"CACHE_GROUPS" => "N"
	)
);?></p>
 <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>