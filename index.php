<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Мысли о жизни и технологиях");
$APPLICATION->SetTitle("Блог веб-мастера");
?>
<section>
<div class="container">
	<h2 class="section-head"><span>Самые последние статьи</span></h2>
</div>
<?$APPLICATION->IncludeComponent(
	"mindochin:article.list", 
	"tile", 
	array(
		"ACTIVE_DATE_FORMAT" => "j F Y",
		"CACHE_GROUPS" => "N",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"DETAIL_URL" => "",
		"FIELD_CODE" => array(
			0 => "NAME",
			1 => "PREVIEW_TEXT",
			2 => "PREVIEW_PICTURE",
			3 => "DATE_ACTIVE_FROM",
			4 => "SHOW_COUNTER",
			5 => "",
		),
		"IBLOCK_TYPE" => "vladblog",
		"NEWS_COUNT" => "8",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "",
		"COMPONENT_TEMPLATE" => "tile",
		"ARTICLE_IBLOCK" => "1",
		"COMMENTS_IBLOCK" => "4"
	),
	false
);?>
</section>
<section>
<div class="container">
	<h2 class="section-head"><span>Самые популярные статьи</span></h2>
</div>
<?$APPLICATION->IncludeComponent(
	"mindochin:article.list", 
	"tile", 
	array(
		"ACTIVE_DATE_FORMAT" => "j F Y",
		"CACHE_GROUPS" => "N",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"DETAIL_URL" => "",
		"FIELD_CODE" => array(
			0 => "NAME",
			1 => "PREVIEW_TEXT",
			2 => "PREVIEW_PICTURE",
			3 => "DATE_ACTIVE_FROM",
			4 => "SHOW_COUNTER",
			5 => "",
		),
		"IBLOCK_TYPE" => "vladblog",
		"NEWS_COUNT" => "8",
		"SORT_BY1" => "SHOW_COUNTER",
		"SORT_BY2" => "",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "",
		"COMPONENT_TEMPLATE" => "tile",
		"ARTICLE_IBLOCK" => "1",
		"COMMENTS_IBLOCK" => "4"
	),
	false
);?>
</section>
<section>
<div class="container">
	<h2 class="section-head"><span>Самые комментируемые статьи</span></h2>
</div>
<?$APPLICATION->IncludeComponent(
	"mindochin:article.list", 
	"tile", 
	array(
		"ACTIVE_DATE_FORMAT" => "j F Y",
		"CACHE_GROUPS" => "N",
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"DETAIL_URL" => "",
		"FIELD_CODE" => array(
			0 => "NAME",
			1 => "PREVIEW_TEXT",
			2 => "PREVIEW_PICTURE",
			3 => "DATE_ACTIVE_FROM",
			4 => "SHOW_COUNTER",
			5 => "",
		),
		"IBLOCK_TYPE" => "vladblog",
		"NEWS_COUNT" => "8",
		"SORT_BY1" => "PROPERTY_4",
		"SORT_BY2" => "",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "",
		"COMPONENT_TEMPLATE" => "tile",
		"ARTICLE_IBLOCK" => "1",
		"COMMENTS_IBLOCK" => "4"
	),
	false
);?>
</section>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>