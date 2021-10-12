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
?>
<div class="article-list">
<?/*if($arParams["DISPLAY_TOP_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?><br />
<?endif;*/?>
	<div class="container">		
		<div class="row">
		<?foreach($arResult["ITEMS"] as $arItem):?>
			<?
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
			?>
			<div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-5">
			<div class="card article-card shadow-sm h-100" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
				<a href="<?= $arItem['DETAIL_PAGE_URL']?>">
					<img src="<?= $arItem['PREVIEW_PICTURE']['SRC']?>" alt="<?= $arItem['PREVIEW_PICTURE']['ALT']?>" title="<?= $arItem['PREVIEW_PICTURE']['TITLE']?>" class="card-img-top">
				</a>
					<div class="card-body">								
						<p class="article-meta"><?= $arItem['DISPLAY_ACTIVE_FROM']?> <i class="fa fa-eye"></i>&nbsp;<?= $arItem['SHOW_COUNTER']?> <i class="fa fa-comments"></i>&nbsp;<?= $arItem['COMMENTS_COUNT']?></p>
						<h3><a href="<?= $arItem['DETAIL_PAGE_URL']?>"><?= $arItem['NAME']?></a></h3>
						<?if($arParams['DISPLAY_PREVIEW_TEXT'] != 'N'){?>
						<?= $arItem['PREVIEW_TEXT']?>
						<? } ?>
					</div>
					<div class="card-footer">
						<p class="m-3 text-end"><a href="<?= $arItem['DETAIL_PAGE_URL']?>" class="btn btn-outline-success">Подробнее</a></p>
					</div>
				</div>
			</div>
		<?endforeach;?>
		</div>
		<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
		<div class="row">
			<div class="col text-center">
				<div class="mb-5 px-3 d-inline-flex"><?=$arResult["NAV_STRING"]?></div>
			</div>
		</div>
		<?endif;?>
	</div>
</div>
