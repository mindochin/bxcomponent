<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("404 - Страница не найдена / Page Not Found");
?>
<div class="container">
	<div class="row">
		<div class="col">
			<div class="content mb-5">
				<p class="text-center">Почему-то ничего не нашлось.<br>Возможно то, что Вы искали, есть по другому адресу - попробуйте воспользоваться поиском по сайту<p>

<?
$APPLICATION->IncludeComponent("bitrix:search.form", "", Array(
	"PAGE" => "/search/",	// Страница выдачи результатов поиска (доступен макрос #SITE_DIR#)
	),
	false
);?>
<?/*$APPLICATION->IncludeComponent("bitrix:main.map", ".default", array(
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "3600",
	"SET_TITLE" => "N",
	"LEVEL" => "3",
	"COL_NUM" => "1",
	"SHOW_DESCRIPTION" => "Y"
	),
	false
);*/
/*$APPLICATION->IncludeComponent(
	"bitrix:catalog.section.list",
	"",
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
		"ADD_SECTIONS_CHAIN" => "N",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_GROUPS" => "N"
	),
false
);*/?>
		</div>
	</div>
</div>
<div class="row">
		<div class="col">
			<div class="content mb-5">
<?$APPLICATION->IncludeComponent(
	"bitrix:news.line",
	"column",
	Array(
		"ACTIVE_DATE_FORMAT" => "j F Y",
		"CACHE_GROUPS" => "N",
		"CACHE_TIME" => "360000",
		"CACHE_TYPE" => "A",
		"DETAIL_URL" => "",
		"FIELD_CODE" => array("NAME","DATE_ACTIVE_FROM",""),
		"IBLOCKS" => array("1"),
		"IBLOCK_TYPE" => "vladblog",
		"NEWS_COUNT" => "500",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC"
	)
);?>
		</div>
	</div>
</div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>