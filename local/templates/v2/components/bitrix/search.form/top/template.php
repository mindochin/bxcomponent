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
$this->setFrameMode(true);?>
<div class="top_search_form">
<form action="<?=$arResult["FORM_ACTION"]?>">
	<div class="input-group">
		<?if($arParams["USE_SUGGEST"] === "Y"):?><?$APPLICATION->IncludeComponent(
			"bitrix:search.suggest.input",
			"",
			array(
				"NAME" => "q",
				"VALUE" => "",
				"INPUT_SIZE" => 15,
				"DROPDOWN_SIZE" => 10,
			),
			$component, array("HIDE_ICONS" => "Y")
			);?><?else:?><input type="text" name="q" class="form-control" placeholder="Найти..." aria-label="Найти..." aria-describedby="search-button-top"><?endif;?>
		<button name="s" class="btn btn-light" type="submit" id="search-button-top"><i class="fa fa-search"></i></button>
	</div>
</form>
</div>