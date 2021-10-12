<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
//echo "<pre>"; print_r($arResult); echo "</pre>";
if(!empty($arResult["DETAIL_PICTURE"])) {
	if(file_exists($_SERVER['DOCUMENT_ROOT'].$arResult['DETAIL_PICTURE']['SRC'])){
		//$APPLICATION->SetDirProperty('BACKGROUND_IMAGE', $arResult['DETAIL_PICTURE']['SRC']);
		$templateData['DETAIL_PICTURE'] = $arResult["DETAIL_PICTURE"];
	}
}
$templateData['NAME'] = $arResult['NAME'];
$templateData['DETAIL_PAGE_URL'] = $arResult['DETAIL_PAGE_URL'];

//$this->addExternalCss("//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.0.1/styles/default.min.css");
\Bitrix\Main\Page\Asset::getInstance()->addCss(SITE_TEMPLATE_PATH."/js/hljs/atom-one-dark.min.css");
\Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH."/js/hljs/highlight.min.js",true);
//$this->addExternalCss(SITE_TEMPLATE_PATH."/js/hljs/atom-one-dark.min.css");
//$this->addExternalJS(SITE_TEMPLATE_PATH."/js/hljs/highlight.min.js");
//\Bitrix\Main\Page\Asset::getInstance()->addString("<script>hljs.highlightAll();</script>", \Bitrix\Main\Page\AssetLocation::AFTER_JS);
\Bitrix\Main\Page\Asset::getInstance()->addJs($templateFolder."/script.js");
$SERVER_PROTOCOL = (CMain::IsHTTPS()) ? "https://" : "http://";
?>
<article itemscope itemtype="http://schema.org/BlogPosting">
	<meta itemprop="identifier" content="<?= $arResult['ID'] ?>">
	<meta itemprop="headline" content="<?= $arResult['NAME'] ?>">
	<link itemprop="thumbnailUrl" src="<?= $SERVER_PROTOCOL . SITE_SERVER_NAME . $arResult['PREVIEW_PICTURE']['SRC'] ?>">
	<link itemprop="url" src="<?= $SERVER_PROTOCOL . SITE_SERVER_NAME . $arResult['DETAIL_PAGE_URL'] ?>">
	<meta itemprop="datePublished" content="<?= date(DATE_ISO8601, strtotime($arResult["ACTIVE_FROM"]))?>" />
	<meta itemprop="dateModified" content="<?= date(DATE_ISO8601, strtotime($arResult["TIMESTAMP_X"]))?>" />
	<div class="container">
		<div class="row">
			<div class="col">
			
			<div class="article_meta">				
				<?= $arResult['DISPLAY_ACTIVE_FROM']?> <i class="fa fa-eye"></i>&nbsp;<?= $arResult['SHOW_COUNTER']?> <i class="fa fa-comments"></i>&nbsp;<span itemprop="commentCount"><?= $arResult['COMMENTS_COUNT']?></span>
				
				<span class="article_badge"><i class="fa fa-tags"></i>
				<?foreach($arResult['SECTION_LIST'] as $s){?>
					<a href="<?= $s['SECTION_PAGE_URL']?>" class="badge" itemprop="about"><?= $s['NAME']?></a>
				<?}?>
				</span>			
			</div>

			<div class="article_text" itemprop="articleBody">
				<?= $arResult["DETAIL_TEXT"];?>
			</div>			
			
			<?if(array_key_exists("USE_SHARE", $arParams) && $arParams["USE_SHARE"] == "Y")
			{
				?>
				<div class="news-detail-share">
					<noindex>
					<?
					$APPLICATION->IncludeComponent("bitrix:main.share", "", array(
							"HANDLERS" => $arParams["SHARE_HANDLERS"],
							"PAGE_URL" => $arResult["~DETAIL_PAGE_URL"],
							"PAGE_TITLE" => $arResult["~NAME"],
							"SHORTEN_URL_LOGIN" => $arParams["SHARE_SHORTEN_URL_LOGIN"],
							"SHORTEN_URL_KEY" => $arParams["SHARE_SHORTEN_URL_KEY"],
							"HIDE" => $arParams["SHARE_HIDE"],
						),
						$component,
						array("HIDE_ICONS" => "Y")
					);
					?>
					</noindex>
				</div>
				<?
			}
			?>
			
			</div>
		</div>
	</div>
</article>
<div class="container">
	<div class="row">
		<div class="col">
			<h4 class="section-head mt-0"><span>КОММЕНТАРИИ</span></h4>
			<?if($USER->isAdmin()){
				$APPLICATION->IncludeComponent(
					"mindochin:comments.vue", 
					"", 
					Array(
						"ARTICLE_IBLOCK" => $arResult["IBLOCK_ID"],
						"ARTICLE_ID" => $arResult["ID"],
						"ARTICLE_NAME" => $arResult["NAME"],
						"ARTICLE_URL" => $arResult["DETAIL_PAGE_URL"],
						"EVENT_MESSAGE_ID" => "30",
						"IBLOCK_ID" => "4",
						"PREMODERATE" => "Y"
					),
					$component);
			}
			else{
				$APPLICATION->IncludeComponent(
					"mindochin:comments", 
					"comment", 
					array(
						"IBLOCK_TYPE" => "article",
						"ID_IBLOCK" => "4",
						"PROPERTY" => "ID_RECORD",
						"ID_RECORD" => $arResult["ID"],
						"ARTICLE_NAME" => $arResult["NAME"],
						//"ARTICLE_URL" => $arResult["DETAIL_PAGE_URL"],
						"ARTICLE_IBLOCK" => "1",
						"PREMODERATE" => "Y",
						"USE_CAPTCHA" => "N",
						"COMPONENT_TEMPLATE" => "comment"
					),
					$component,
			);}?>
		</div>
	</div>
</div>