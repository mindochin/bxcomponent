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
//echo '<pre>';print_r($arResult); echo '</pre>';
?>
<div class="slider mt-5" id="slider">
<?foreach($arResult["ITEMS"] as $arItem):?>
<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
?>
<div class="card slider-item" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
	<div class="position-relative">
		<img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" class="card-img" alt="<?=$arItem["PREVIEW_PICTURE"]["ALT"]?>">
		<div class="item-overlay text-left">
			<p class="mb-0 name"><?=$arItem['NAME']?></p>
    		<p class="mb-0 age"><?=$arItem['PROPERTIES']['AGE']['VALUE']?></p>
  		</div>
	</div>
            <div class="card-body d-flex justify-content-around">
              <span class="i-block"><i class="i-item rost"></i><span><?=$arItem['PROPERTIES']['HEIGHT']['VALUE']?></span></span>
              <span class="i-block"><i class="i-item grud"></i><span><?=$arItem['PROPERTIES']['SIZE']['VALUE']?></span></span>
              <span class="i-block"><i class="i-item ves"></i><span><?=$arItem['PROPERTIES']['WEIGHT']['VALUE']?></span></span>
            </div>
</div>
<?endforeach;?>
</div>
 <div data-slider="slider" class="slider-progress my-3">
 	<input class="slider-progress-input w-75" min="0" max="0" type="range" step="1">
 </div>
