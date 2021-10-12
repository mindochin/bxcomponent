<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?$this->setFrameMode(true);?>
<?// echo "<pre>"; print_r($arResult); echo "</pre>";
$strSectionEdit = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_EDIT");
$strSectionDelete = CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "SECTION_DELETE");
$arSectionDeleteParams = array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM'));
if(isset($arResult["SECTIONS"][$arResult["SECTION"]["ID"]]["CHILDREN"]))
	$sectionList = $arResult["SECTIONS"][$arResult["SECTION"]["ID"]]["CHILDREN"];
else
	$sectionList = $arResult["SECTIONS"];?>
<?if(count($sectionList) > 0) :?>
<div class="section_label">

	<div class="section_label_block">
		<?/*<button id="show_more" onclick="toggleShow()" style="display:none;">Показать все / Скрыть</button>*/?>
		<?foreach ($sectionList as $arSection):?>
			<?if($arSection['ELEMENT_CNT'] >0) {?>
			<?$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);?>
			<?$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);?>
			<span class="section_label_item me-2" id="<?=$this->GetEditAreaId($arSection["ID"])?>">
			<a href="<?=$arSection["SECTION_PAGE_URL"]?>" class="btn btn-outline-light btn-sm mb-3">
				<?=$arSection["NAME"]?> <span class="badge badge-secondary"><?=$arSection['ELEMENT_CNT']?></span>
				</a>
			</span>
			<? } ?>
		<?endforeach;?>	
	</div>
</div>
<?endif;?>