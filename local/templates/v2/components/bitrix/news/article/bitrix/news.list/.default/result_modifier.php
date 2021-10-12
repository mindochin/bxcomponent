<?//echo'<pre>';print_r($arResult);echo'</pre>';
$arSections = $arComments = [];
//////////////////////  get sections
$rsSections = CIBlockElement::GetElementGroups($arResult["ELEMENTS"]);
while ($s = $rsSections->GetNext())
{
	$arSections[$s['IBLOCK_ELEMENT_ID']] = [
		'ID' => $s['ID'],
		'NAME' => $s['NAME'],
		'SECTION_PAGE_URL' => $s['SECTION_PAGE_URL'],
	];
}

///////////////////////  get comments count
$rsComments = CIBlockElement::GetList([],['IBLOCK_ID'=>$arParams['COMMENTS_IBLOCK'], 'PROPERTY_ID_RECORD'=>$arResult["ELEMENTS"], 'ACTIVE'=>'Y'],['PROPERTY_ID_RECORD']);
while ($c = $rsComments->GetNext())
{
	$arComments[$c['PROPERTY_ID_RECORD_VALUE']] = (int)$c['CNT'];
}

foreach ($arResult["ITEMS"] as &$arItem){
	$arItem['SECTION_LIST'] = $arSections[$arItem['ID']];
	
	if($arItem['PROPERTY_COMMENT_COUNT_VALUE'] != (int)$arComments[$arItem['ID']]){
		CIBlockElement::SetPropertyValues($arItem['ID'], $arItem["IBLOCK_ID"], (int)$arComments[$arItem['ID']], 'COMMENT_COUNT');
	}
	$arItem['COMMENTS_COUNT'] = (int)$arComments[$arItem['ID']];
}