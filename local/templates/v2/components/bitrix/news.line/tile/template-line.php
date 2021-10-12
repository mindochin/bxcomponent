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
<div class="article-tile">
	<div class="container">
		
		<h2>Последние записи</h2>

		<?foreach($arResult["ITEMS"] as $arItem):?>
			<?
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
			?>
			<div class="card article-card shadow-sm mb-5" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
					<div class="row g-0">
						<div class="col-lg-3">
							<img src="<?= $arItem['PREVIEW_PICTURE']['SRC']?>" alt="<?= $arItem['PREVIEW_PICTURE']['ALT']?>" title="<?= $arItem['PREVIEW_PICTURE']['TITLE']?>" class="card-img-top">
						</div>
						<div class="col-lg-9">
							<div class="card-body">								
								<p class="article-meta"><?= $arItem['DISPLAY_ACTIVE_FROM']?> <i class="bi bi-eye"></i> <?= $arItem['SHOW_COUNTER']?> <i class="bi bi-chat-dots"></i></p>
								<h3><a href="<?= $arItem['DETAIL_PAGE_URL']?>"><?= $arItem['NAME']?></a></h3>
								<?= $arItem['PREVIEW_TEXT']?>
								<p class="m-3 text-center"><a href="<?= $arItem['DETAIL_PAGE_URL']?>" class="btn btn-outline-success">Подробнее</a></p>			
							</div>						
						</div>
				</div>
			</div>
		<?endforeach;?>

	</div>
</div>
