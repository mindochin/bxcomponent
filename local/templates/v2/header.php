<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if(empty($_SESSION['SITE_NAME'])){
	$arSite = CSite::GetByID(SITE_ID)->Fetch();
	define(SITE_NAME, $arSite['SITE_NAME']);
}
else {define(SITE_NAME, $_SESSION['SITE_NAME']);}

function getHeaderBgImage()
{
	global $APPLICATION;
	$headerBgImage = $APPLICATION->GetProperty("BACKGROUND_IMAGE");
	if (empty($headerBgImage)) $headerBgImage = SITE_TEMPLATE_PATH . '/img/bg_index.jpg';
	return ' style="background-image: url('. \CHTTP::urnEncode($headerBgImage, 'UTF-8') .')"';
}
function getHeaderSubtitle()
{
	global $APPLICATION;
	$headerSubtitle = $APPLICATION->GetProperty("subtitle");
	if (!empty($headerSubtitle)) 
		return '<p class="subtitle">'.$headerSubtitle.'</p>';
}
function showMyTitle()
{
	global $APPLICATION;
	$title = $APPLICATION->GetTitle();
	if (!empty($title))
		return $title;
}
?><!doctype html>
<html lang="ru">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<?\Bitrix\Main\Page\Asset::getInstance()->addCss( SITE_TEMPLATE_PATH . '/css/bootstrap.min.css' );?>
		<?\Bitrix\Main\Page\Asset::getInstance()->addCss( SITE_TEMPLATE_PATH . '/css/font-awesome.min.css' );?>
		<style>@import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,700;1,400;1,700&display=swap');</style>
		<?$APPLICATION->ShowHead();?>
		<title><?$APPLICATION->ShowTitle()?> &mdash; <?=$_SERVER['HTTP_HOST']?></title>
		<link rel="shortcut icon" href="<?= SITE_TEMPLATE_PATH ?>/img/logo.png">
	</head>
	<body>
		<!-- Yandex.Metrika counter -->
		<script type="text/javascript" >
			 (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
			 m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
			 (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

			 ym(20647768, "init", {
						clickmap:true,
						trackLinks:true,
						accurateTrackBounce:true,
						webvisor:true
			 });
		</script>
		<noscript><div><img src="https://mc.yandex.ru/watch/20647768" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
		<!-- /Yandex.Metrika counter -->
		<div id="panel"><?$APPLICATION->ShowPanel();?></div>
		<!--[if lte IE 11] noindex>
		<div class="row">
		<div class="col-md-12">
			 <div class="alert">????????????????????, ?????????? ?? ???????? ???? ???????????????? ???????????? ?? ??????????????????????????! ???????????????????? ?????????????????????? ?????????????? <a rel="nofollow" href="http://www.firefox.com">Firefox</a>, <a rel="nofollow" href="http://www.google.com/chrome/">Chrome</a>, <a href="http://www.opera.com" rel="nofollow">Opera</a></div>
		</div>
		</div>
		<! /noindex [endif]-->
		<header class="bg-overlay bg-overlay-dark"<?$APPLICATION->AddBufferContent('getHeaderBgImage');?>>
		<div class="header_top">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-12 col-lg-5 header_logo">
						<div class="d-flex align-items-center">
							<a href="/" rel="home"  class="site-logo">
								<img src="<?= SITE_TEMPLATE_PATH . '/img/logo.png';?>">
							</a>					
							<p class="site-title fs-4"><?= SITE_NAME ?><span class="d-block fs-6">?????????? ?? ?????????? ?? ??????????????????????</span></p>
						</div>
					</div>
					<div class="col-12 col-md-6 col-lg-4 header_menu">
					<?$APPLICATION->IncludeComponent("bitrix:menu", "top", Array(
						"ROOT_MENU_TYPE" => "top",	// ?????? ???????? ?????? ?????????????? ????????????
							"MENU_CACHE_TYPE" => "A",	// ?????? ??????????????????????
							"MENU_CACHE_TIME" => "86400",	// ?????????? ?????????????????????? (??????.)
							"MENU_CACHE_USE_GROUPS" => "N",	// ?????????????????? ?????????? ??????????????
							"MENU_CACHE_GET_VARS" => "",	// ???????????????? ???????????????????? ??????????????
							"MAX_LEVEL" => "1",	// ?????????????? ?????????????????????? ????????
							"CHILD_MENU_TYPE" => "left",	// ?????? ???????? ?????? ?????????????????? ??????????????
							"USE_EXT" => "N",	// ???????????????????? ?????????? ?? ?????????????? ???????? .??????_????????.menu_ext.php
							"DELAY" => "N",	// ?????????????????????? ???????????????????? ?????????????? ????????
							"ALLOW_MULTI_SELECT" => "N",	// ?????????????????? ?????????????????? ???????????????? ?????????????? ????????????????????????
							"MENU_TITLE" => "???????? ???? ??????????????",
						),
						false
					);?>
					</div>
					<div class="col-12 col-md-6 col-lg-3 header_search">
					<?$APPLICATION->IncludeComponent(
						"bitrix:search.form", 
						"top", 
						array(
							"PAGE" => "/search/",
							"COMPONENT_TEMPLATE" => "top"
						),
						false
					);?>
					</div>
				</div><!-- /.row -->
			</div><!-- /.container-md -->
		</div>	
	
		<div class="top_head">
			<div class="container-md d-flex align-items-center justify-content-center">
				<div class="bloginfo text-center p-3">
					<?if($APPLICATION->GetCurDir() != '/') {?>
					<?$APPLICATION->IncludeComponent(
	"bitrix:breadcrumb", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"START_FROM" => "0",
		"PATH" => "",
		"SITE_ID" => "s1"
	),
	false
);?>
					<? } ?>
					<h1 class="pagetitle text-uppercase"><?$APPLICATION->ShowTitle(false);?></h1>						
					<?//<p>?????????? ?? ?????????? ?? ??????????????????????</p>						?>
				</div>		
			</div>
		</div>
		</header>