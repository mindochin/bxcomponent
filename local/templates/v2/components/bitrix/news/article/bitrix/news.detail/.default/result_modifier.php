<?//echo'<pre>1111';print_r($arResult);echo'</pre>';
$arSections = $arComments = [];
//////////////////////  get sections
$rsSections = CIBlockElement::GetElementGroups($arResult["ID"]);
while ($s = $rsSections->GetNext())
{
	$arSections[$s['IBLOCK_ELEMENT_ID']][] = [
		'ID' => $s['ID'],
		'NAME' => $s['NAME'],
		'SECTION_PAGE_URL' => $s['SECTION_PAGE_URL'],
	];
}

///////////////////////  get comments count
$rsComments = CIBlockElement::GetList([],['IBLOCK_ID'=>$arParams['COMMENTS_IBLOCK'], 'PROPERTY_ID_RECORD'=>$arResult["ID"], 'ACTIVE'=>'Y'],['PROPERTY_ID_RECORD']);
while ($c = $rsComments->GetNext())
{
	$arComments[$c['PROPERTY_ID_RECORD_VALUE']] = (int)$c['CNT'];
}

$arResult['SECTION_LIST'] = $arSections[$arResult['ID']];
	
if($arResult['PROPERTY_COMMENT_COUNT_VALUE'] != (int)$arComments[$arResult['ID']]){
	CIBlockElement::SetPropertyValues($arResult['ID'], $arResult["IBLOCK_ID"], (int)$arComments[$arResult['ID']], 'COMMENT_COUNT');
}
$arResult['COMMENTS_COUNT'] = (int)$arComments[$arResult['ID']];
$this->__component->SetResultCacheKeys([
    "NAME",
    "PREVIEW_TEXT",
    "PREVIEW_PICTURE",
		"DETAIL_PAGE_URL"
]);