<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Галерея");
?> <?$APPLICATION->IncludeComponent(
	"beono:yandexfotki", 
	".default", 
	array(
		"AUTHOR" => "mindochin",
		"ITEMS_LIMIT" => "50",
		"PHOTOS_SORT" => "rpublished",
		"PAGER_TEMPLATE" => "modern",
		"PHOTO_SIZE" => "XL",
		"DISPLAY_DATE" => "N",
		"DISPLAY_ORIGINAL" => "Y",
		"DISPLAY_SHARE" => "N",
		"AJAX_MODE" => "N",
		"SEF_MODE" => "Y",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "3600",
		"CACHE_NOTES" => "",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"SEF_FOLDER" => "/gallery/",
		"SEF_URL_TEMPLATES" => array(
			"albums" => "",
			"album" => "#album_id#/",
			"photo" => "#album_id#/#photo_id#/",
		)
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>