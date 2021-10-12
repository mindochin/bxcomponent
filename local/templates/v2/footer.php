<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
	<footer>
		<div class="footer_top">
			<div class="container-md">
				<div class="row">
					<div class="col">
						Решаю проблемы с сайтами на 1С-Битрикс, Yii, Wordpress
					</div>
				</div>
			</div><!-- /.container-md -->
		</div>
		<div class="footer_middle">
		<div class="container-md">
			<div class="row">
				<div class="col-12 col-md-3 footer_contact">
					<?$APPLICATION->IncludeComponent(
	"mindochin:feedback.vue", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"EVENT_MESSAGE_ID" => "7",
		"IBLOCK_ID" => "13"
	),
	false
);?>
					<br>
					<p><a href="https://t.me/mindochin" target="_blank"><i class="fa fa-telegram"></i> Telegram</a></p>
					<p><a href="https://vk.com/vladname_ru" target="_blank"><i class="fa fa-vk"></i> Вконтакте</a></p>
					<p><a href="mailto:web@vladblog.ru"><i class="fa fa-envelope"></i> web@vladname.ru</a></p>
				</div>
				<div class="col-12 col-md-9">
					<?/*<p class="header_section_list">Рубрики</p>					*/?>
				<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section.list", 
	"label", 
	array(
		"IBLOCK_TYPE" => "vladblog",
		"IBLOCK_ID" => "1",
		"SECTION_ID" => "",
		"SECTION_CODE" => "",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "360000",
		"CACHE_GROUPS" => "N",
		"COUNT_ELEMENTS" => "Y",
		"TOP_DEPTH" => "1",
		"SECTION_URL" => "",
		"VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
		"SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"],
		"HIDE_SECTION_NAME" => (isset($arParams["SECTIONS_HIDE_SECTION_NAME"])?$arParams["SECTIONS_HIDE_SECTION_NAME"]:"N"),
		"ADD_SECTIONS_CHAIN" => "N",
		"COMPONENT_TEMPLATE" => "label",
		"SECTION_FIELDS" => array(
			0 => "",
			1 => "",
		),
		"SECTION_USER_FIELDS" => array(
			0 => "",
			1 => "",
		),
		"FILTER_NAME" => "sectionsFilter",
		"CACHE_FILTER" => "N",
		"COUNT_ELEMENTS_FILTER" => "CNT_ACTIVE"
	),
	false
);?>
				</div>
			</div>
			</div><!-- /.container-md -->
		</div>
		<div class="footer_bottom">
			<div class="container-md">
				<div class="row">
					<div class="col">
						<?= SITE_NAME ?> ©2006-<?=date('Y')?>
					</div>
				</div>
			</div><!-- /.container-md -->
		</div>
	</footer>
	<?/*$APPLICATION->IncludeComponent(
	"bitrix:iblock.element.add.form", 
	"feedback_modal", 
	array(
		"CUSTOM_TITLE_DATE_ACTIVE_FROM" => "",
		"CUSTOM_TITLE_DATE_ACTIVE_TO" => "",
		"CUSTOM_TITLE_DETAIL_PICTURE" => "",
		"CUSTOM_TITLE_DETAIL_TEXT" => "",
		"CUSTOM_TITLE_IBLOCK_SECTION" => "",
		"CUSTOM_TITLE_NAME" => "",
		"CUSTOM_TITLE_PREVIEW_PICTURE" => "",
		"CUSTOM_TITLE_PREVIEW_TEXT" => "Сообщение",
		"CUSTOM_TITLE_TAGS" => "",
		"DEFAULT_INPUT_SIZE" => "30",
		"DETAIL_TEXT_USE_HTML_EDITOR" => "N",
		"ELEMENT_ASSOC" => "CREATED_BY",
		"GROUPS" => array(
			0 => "2",
		),
		"IBLOCK_ID" => "13",
		"IBLOCK_TYPE" => "vladblog",
		"LEVEL_LAST" => "Y",
		"LIST_URL" => "",
		"MAX_FILE_SIZE" => "0",
		"MAX_LEVELS" => "100000",
		"MAX_USER_ENTRIES" => "100000",
		"PREVIEW_TEXT_USE_HTML_EDITOR" => "Y",
		"PROPERTY_CODES" => array(
			0 => "PREVIEW_TEXT",
		),
		"PROPERTY_CODES_REQUIRED" => array(
			0 => "PREVIEW_TEXT",
		),
		"RESIZE_IMAGES" => "N",
		"SEF_MODE" => "N",
		"STATUS" => "ANY",
		"STATUS_NEW" => "N",
		"USER_MESSAGE_ADD" => "",
		"USER_MESSAGE_EDIT" => "",
		"USE_CAPTCHA" => "N",
		"AJAX_MODE" => "Y",
		"COMPONENT_TEMPLATE" => "feedback_modal"
	),
	false
);*/?>
	<script type="text/javascript">
	let siteOptions = ({
		//"SITE_DIR" : "<?=SITE_DIR?>",
		"SITE_TEMPLATE_PATH" : "<?=SITE_TEMPLATE_PATH?>",
	})
	</script>
	<?CJSCore::Init();?>
	<?\Bitrix\Main\Page\Asset::getInstance()->addJs( SITE_TEMPLATE_PATH . '/js/bootstrap.bundle.min.js');?>
	<?\Bitrix\Main\Page\Asset::getInstance()->addJs( SITE_TEMPLATE_PATH . '/script.js');?>
	<?\Bitrix\Main\UI\Extension::load("ui.vue");?>
	
	</body>
</html>