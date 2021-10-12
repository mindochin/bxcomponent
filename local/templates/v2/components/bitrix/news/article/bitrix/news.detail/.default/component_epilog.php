<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $arParams
 * @var array $templateData
 * @var string $templateFolder
 * @var object $component
 */
//echo "<pre>0000"; print_r($templateData); echo "</pre>";
if(!empty($templateData["DETAIL_PICTURE"])) {
	if(file_exists($_SERVER['DOCUMENT_ROOT'].$templateData['DETAIL_PICTURE']['SRC'])){
		$APPLICATION->SetDirProperty('BACKGROUND_IMAGE', $templateData['DETAIL_PICTURE']['SRC']);
	}
}
$SERVER_PROTOCOL = (CMain::IsHTTPS()) ? "https://" : "http://";

if(!empty($templateData['DETAIL_PAGE_URL']))
	$APPLICATION->AddHeadString('<meta property="og:url" content="' . $SERVER_PROTOCOL . SITE_SERVER_NAME . $templateData['DETAIL_PAGE_URL'] . '">');

if(!empty($templateData['NAME']))
	$APPLICATION->AddHeadString('<meta property="og:title" content="'.$templateData['NAME'].'"/>');

if(!empty($templateData['DETAIL_PICTURE']))
	$APPLICATION->AddHeadString('<meta property="og:image" content="' . $SERVER_PROTOCOL. SITE_SERVER_NAME . $templateData['DETAIL_PICTURE']['SRC'] . '"/>');

if(!empty($templateData['PREVIEW_TEXT']))
	$APPLICATION->AddHeadString('<meta property="og:description" content="'.ucfirst($templateData['PREVIEW_TEXT']).'"/>');

$APPLICATION->AddHeadString('<meta property="og:site_name" content="Блог веб-мастера и человека"/>');
$APPLICATION->AddHeadString('<meta property="og:type" content="article"/>');