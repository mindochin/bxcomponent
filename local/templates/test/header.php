<? require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php"); ?>
<!doctype html>
<html lang="ru">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
    integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<?$APPLICATION->ShowHead()?>
  <title><?$APPLICATION->ShowTitle()?></title>
</head>

<body>
<div id="panel"><?$APPLICATION->ShowPanel();?></div>
  <div class="container-fluid b1">
    <div class="row mb-3 justify-content-center">
      <div class="col mwidth">
        
          <nav class="navbar navbar-expand-lg navbar-dark">
            <a class="navbar-brand" href="/">
              <img src="img/logo.jpg" width="210" height="80" alt="logo">
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar"
              aria-controls="navbar" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse flex-column" id="navbar">
              <ul class="navbar-nav nav w-100">
                <li class="nav-item active">
                  <a class="nav-link" href="#">Главная</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">Наши мастера</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">Программы</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">О салоне</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">Акции</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">Вакансии</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">Контакты</a>
                </li>
                <a class="btn btn-mybtn mr-auto ml-lg-auto my-2 pl-4 pr-4 my-sm-0" href="callto:+7(880)5555555">+7 (880)
                  555 55 55</a>
              </ul>

            </div>

          </nav>
        
      </div>
    </div>
    <div class="row py-5 justify-content-center">
      <div class="d-none d-lg-block">
        <div class="socblock text-center mr-3 mb-5">
          <img src="img/b-vk.png" width="40px" height="40px">
          <p class="mt-2">Вконтакте</p>
        </div>
        <div class="socblock text-center mr-3 mb-5">
          <img src="img/b-insta.png" width="40px" height="40px">
          <p class="mt-2">Instagram</p>
        </div>
        <div class="socblock text-center mr-3">
          <img src="img/b-whats.png" width="40px" height="40px">
          <p class="mt-2">whatsapp</p>
        </div>
      </div>
      <div class="col mwidth">
        <div class="container">
          <div class="row">
            <div class="col">
              <p class="hp1">Мерси — это</p>
              <h1><?$APPLICATION->IncludeComponent(
						"bitrix:main.include",
						"",
						Array(
							"AREA_FILE_SHOW" => "file",
							"AREA_FILE_SUFFIX" => "inc",
							"EDIT_TEMPLATE" => "",
							"PATH" => SITE_TEMPLATE_PATH . "/include/h1.php"
						)
		);?></h1>
              <p class="hp2"><?$APPLICATION->IncludeComponent(
						"bitrix:main.include",
						"",
						Array(
							"AREA_FILE_SHOW" => "file",
							"AREA_FILE_SUFFIX" => "inc",
							"EDIT_TEMPLATE" => "",
							"PATH" => SITE_TEMPLATE_PATH . "/include/underh1.php"
						)
		);?></p>
              <a class="btn btn-mybtn2 my-2" href="#">Подробнее о программах</a>
            </div>
          </div>
        </div>
      </div>
      <div class="d-none d-lg-block">
        <div class="socblock text-center ml-auto mb-5">
          <img src="img/b-inco.png" width="40px" height="40px">
          <p class="mt-2">Инкогнито</p>
        </div>
        <div class="socblock text-center ml-auto mb-5">
          <img src="img/b-18.png" width="40px" height="40px">
          <p class="mt-2">Только 18+</p>
        </div>
        <div class="socblock text-center ml-auto">
          <img src="img/b-247.png" width="40px" height="40px">
          <p class="mt-2">Работаем 24/7</p>
        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid b2">
    <div class="row py-5 justify-content-center">
      <div class="col mwidth2 text-center">
        <h2>Наши мастера</h2>
<?$APPLICATION->IncludeComponent("bitrix:news.list", "slider", Array(
	"COMPONENT_TEMPLATE" => ".default",
		"IBLOCK_TYPE" => "test",	// Тип информационного блока (используется только для проверки)
		"IBLOCK_ID" => "10",	// Код информационного блока
		"NEWS_COUNT" => "20",	// Количество новостей на странице
		"SORT_BY1" => "ACTIVE_FROM",	// Поле для первой сортировки новостей
		"SORT_ORDER1" => "DESC",	// Направление для первой сортировки новостей
		"SORT_BY2" => "SORT",	// Поле для второй сортировки новостей
		"SORT_ORDER2" => "ASC",	// Направление для второй сортировки новостей
		"FILTER_NAME" => "",	// Фильтр
		"FIELD_CODE" => array(	// Поля
			0 => "",
			1 => "",
		),
		"PROPERTY_CODE" => array(	// Свойства
			0 => "WEIGHT",
			1 => "AGE",
			2 => "SIZE",
			3 => "HEIGHT",
			4 => "",
		),
		"CHECK_DATES" => "Y",	// Показывать только активные на данный момент элементы
		"DETAIL_URL" => "",	// URL страницы детального просмотра (по умолчанию - из настроек инфоблока)
		"AJAX_MODE" => "N",	// Включить режим AJAX
		"AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
		"AJAX_OPTION_STYLE" => "Y",	// Включить подгрузку стилей
		"AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
		"AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
		"CACHE_TYPE" => "A",	// Тип кеширования
		"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
		"CACHE_FILTER" => "N",	// Кешировать при установленном фильтре
		"CACHE_GROUPS" => "Y",	// Учитывать права доступа
		"PREVIEW_TRUNCATE_LEN" => "",	// Максимальная длина анонса для вывода (только для типа текст)
		"ACTIVE_DATE_FORMAT" => "d.m.Y",	// Формат показа даты
		"SET_TITLE" => "N",	// Устанавливать заголовок страницы
		"SET_BROWSER_TITLE" => "N",	// Устанавливать заголовок окна браузера
		"SET_META_KEYWORDS" => "N",	// Устанавливать ключевые слова страницы
		"SET_META_DESCRIPTION" => "N",	// Устанавливать описание страницы
		"SET_LAST_MODIFIED" => "N",	// Устанавливать в заголовках ответа время модификации страницы
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",	// Включать инфоблок в цепочку навигации
		"ADD_SECTIONS_CHAIN" => "N",	// Включать раздел в цепочку навигации
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",	// Скрывать ссылку, если нет детального описания
		"PARENT_SECTION" => "",	// ID раздела
		"PARENT_SECTION_CODE" => "",	// Код раздела
		"INCLUDE_SUBSECTIONS" => "Y",	// Показывать элементы подразделов раздела
		"STRICT_SECTION_CHECK" => "N",	// Строгая проверка раздела для показа списка
		"DISPLAY_DATE" => "Y",	// Выводить дату элемента
		"DISPLAY_NAME" => "Y",	// Выводить название элемента
		"DISPLAY_PICTURE" => "Y",	// Выводить изображение для анонса
		"DISPLAY_PREVIEW_TEXT" => "Y",	// Выводить текст анонса
		"PAGER_TEMPLATE" => ".default",	// Шаблон постраничной навигации
		"DISPLAY_TOP_PAGER" => "N",	// Выводить над списком
		"DISPLAY_BOTTOM_PAGER" => "N",	// Выводить под списком
		"PAGER_TITLE" => "Новости",	// Название категорий
		"PAGER_SHOW_ALWAYS" => "N",	// Выводить всегда
		"PAGER_DESC_NUMBERING" => "N",	// Использовать обратную навигацию
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// Время кеширования страниц для обратной навигации
		"PAGER_SHOW_ALL" => "N",	// Показывать ссылку "Все"
		"PAGER_BASE_LINK_ENABLE" => "N",	// Включить обработку ссылок
		"SET_STATUS_404" => "N",	// Устанавливать статус 404
		"SHOW_404" => "N",	// Показ специальной страницы
		"MESSAGE_404" => "",	// Сообщение для показа (по умолчанию из компонента)
	),
	false
);?>

        <a class="btn btn-mybtn2 my-5" href="#">Все мастера</a>
      </div>
    </div>
  </div>

  <div class="container-fluid b3">
    <div class="row mb-3">
      <div class="col">
        <div class="container">
          <div class="row">
            <div class="col">
              <h2>Забронируйте<br>время за 20 сек</h2>
              <p>И гарантированно получите скидку</p>
<?$APPLICATION->IncludeComponent(
	"mindochin:block.constructor.form", 
	"form", 
	array(
		"COMPONENT_TEMPLATE" => "form",
		"SITE_ID" => "s1",
		"IBLOCK_TYPE" => "test",
		"IBLOCK_ID" => "12",
		"BLOCK_NAME" => "1349",
		"IBLOCK_ORDER" => "10",
		"FORM_AS" => "inline",
		"BLOCK_PADDING" => "",
		"BLOCK_MARGIN" => "",
		"ADD_BUTTON" => "N"
	),
	false
);?>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container footer">
    <div class="row py-3 align-items-center">
      <div class="col-md-3">
        <a class="" href="/">
          <img src="img/logo.jpg" width="210" height="80" alt="logo" class="img-fluid">
        </a>
      </div>
      <div class="col-md-3">
        <p class="mb-0">Мужской SPA-клуб</p>
        <p class="mb-0">&copy; Официальный сайт</p>
      </div>
      <div class="col-md-3 text-center">
        <a href="#">Политика конфиденциальности</a>
      </div>
      <div class="col-md-3 text-center">
        <p class="mb-0">Мы в соцсетях</p>
<?$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"socico", 
	array(
		"COMPONENT_TEMPLATE" => "socico",
		"IBLOCK_TYPE" => "test",
		"IBLOCK_ID" => "11",
		"NEWS_COUNT" => "20",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_ORDER1" => "DESC",
		"SORT_BY2" => "SORT",
		"SORT_ORDER2" => "ASC",
		"FILTER_NAME" => "",
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"PROPERTY_CODE" => array(
			0 => "URL",
			1 => "ICON",
		),
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "36000000",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "N",
		"PREVIEW_TRUNCATE_LEN" => "",
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"SET_TITLE" => "N",
		"SET_BROWSER_TITLE" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_LAST_MODIFIED" => "N",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"INCLUDE_SUBSECTIONS" => "N",
		"STRICT_SECTION_CHECK" => "N",
		"DISPLAY_DATE" => "N",
		"DISPLAY_NAME" => "N",
		"DISPLAY_PICTURE" => "N",
		"DISPLAY_PREVIEW_TEXT" => "N",
		"PAGER_TEMPLATE" => ".default",
		"DISPLAY_TOP_PAGER" => "N",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"PAGER_TITLE" => "Новости",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"SET_STATUS_404" => "N",
		"SHOW_404" => "N",
		"MESSAGE_404" => ""
	),
	false
);?>
      </div>
    </div>
  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js" data-skip-moving="true"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
    crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/js/slick/slick.css" />
	<link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/js/slick/slick-theme.css" />
	<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/js/slick/slick.min.js"></script>
	<link rel="stylesheet" type="text/css" href="<?=SITE_TEMPLATE_PATH?>/js/slick/slick.main.css" />
	<script src="<?=SITE_TEMPLATE_PATH?>/js/slick/slick.main.js"></script>

</body>

</html>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>