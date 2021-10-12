<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$filter = $ids = $arSections = $arComments = [];

foreach($arResult['ITEMS'] as $arItem) {
	$ids[] = $arItem['ID'];
}

$rsSections = CIBlockElement::GetElementGroups($ids);
while ($s = $rsSections->GetNext())
{
	$arSections[$s['IBLOCK_ELEMENT_ID']] = [
		'ID' => $s['ID'],
		'NAME' => $s['NAME'],
		'SECTION_PAGE_URL' => $s['SECTION_PAGE_URL'],
	];
}
$arResult['SECTION_LIST'] = $arSections;

$rsComments = CIBlockElement::GetList([],['IBLOCK_ID'=>4, 'PROPERTY_ID_RECORD'=>$ids, 'ACTIVE'=>'Y'],['PROPERTY_ID_RECORD']);
while ($c = $rsComments->GetNext())
{
	$arComments[$c['PROPERTY_ID_RECORD_VALUE']] = $c['CNT'];
}
$arResult['COMMENTS_COUNT'] = $arComments;
/*
foreach($arResult['ITEMS'] as $arItem) {
	if(array_key_exists($arItem['ID'], $arSections))
}
*/