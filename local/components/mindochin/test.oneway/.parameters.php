<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if(!CModule::IncludeModule("iblock"))
	return;

if(!CModule::IncludeModule("highloadblock"))
	return;

// создаем иблок и свойства
if(!empty($arCurrentValues["SITE_ID"]) && empty($arCurrentValues["IBLOCK_TYPE"]) && empty($arCurrentValues["IBLOCK_ID"])) {
	$bIblockType = false;
	$res = CIBlockType::GetByID("test");
	if(!$bIblockType = $res->GetNext())	{
		$arFields = [
			'ID'=>'test',
			'SECTIONS'=>'Y',
			'IN_RSS'=>'N',
			'SORT'=>100,
			'LANG'=>[
				'ru'=>['NAME'=>'Для тестов']
			]
		];
		$obBlocktype = new CIBlockType;
		$bIblockType = $obBlocktype->Add($arFields);
	}
	
	if($bIblockType) {
		//add iblock
		$res = CIBlock::GetList([], ['TYPE'=>'test', 'CODE'=>'oneway'],	true);
		$check_ib = false;
		while($ar_res = $res->Fetch())
			if($ar_res) $check_ib = true;
		
		unset($ar_res);
		
		if(!$check_ib) {
			$ib = new CIBlock;
			$arFields = [
				"ACTIVE" => "Y",
				"NAME" => 'Для тестов',
				"CODE" => "oneway",
				"IBLOCK_TYPE_ID" => "test",
				"INDEX_ELEMENT" => "N",
				"INDEX_SECTION" => "N",
				"WORKFLOW" => "N",
				"SITE_ID" => $arCurrentValues["SITE_ID"]
			];
			$ib->Add($arFields);
		}
		
		unset($ib);
		
		//add props
		$res = CIBlock::GetList([], ["CODE"=>'oneway', "SITE_ID" => $arCurrentValues["SITE_ID"]], true);
		$ar_res = $res->Fetch();
		$rsProp = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$ar_res["ID"]));
		while ($arr=$rsProp->Fetch())
			$arPropsCode[] = $arr["CODE"];
		if(!is_array($arPropsCode)){
			$arPropsCode = array();
		}

		$ibp = new CIBlockProperty;

		if(!in_array("ATT_POST", $arPropsCode)) {
			$arFields = [
				"NAME" => 'Должность',
				"ACTIVE" => "Y",
				"SORT" => "100",
				"CODE" => "ATT_POST",
				"PROPERTY_TYPE" => "S",
				"IBLOCK_ID" => $ar_res['ID']
			];
			$propID = $ibp->Add($arFields);
		}
		
		if(!in_array("ATT_PLACE", $arPropsCode)) {
			$arFields = [
				"NAME" => 'Место жительства',
				"ACTIVE" => "Y",
				"SORT" => "110",
				"CODE" => "ATT_PLACE",
				"PROPERTY_TYPE" => "S",
				"IBLOCK_ID" => $ar_res['ID']
			];
			$propID = $ibp->Add($arFields);
		}
		
		if(!in_array("ATT_DATE", $arPropsCode)) {
			$arFields = [
				"NAME" => 'Дата рождения',
				"ACTIVE" => "Y",
				"SORT" => "120",
				"CODE" => "ATT_DATE",
				"PROPERTY_TYPE" => "S",
				"USER_TYPE" => "Date",
				"IBLOCK_ID" => $ar_res['ID']
			];
			$propID = $ibp->Add($arFields);
		}
		
		if(!in_array("ATT_PHOTOS", $arPropsCode)) {
			$arFields = [
				"NAME" => 'Фото для слайдера',
				"ACTIVE" => "Y",
				"SORT" => "130",
				"CODE" => "ATT_PHOTOS",
				"PROPERTY_TYPE" => "F",
				"FILE_TYPE" => 'jpg, gif, bmp, png, jpeg',
				"MULTIPLE" => "Y",
				"IBLOCK_ID" => $ar_res['ID']
			];
			$propID = $ibp->Add($arFields);
		}
		
		unset($arFields);
		unset($ibp);
		unset($propID);

		CIBlock::SetPermission($ar_res['ID'], Array("1"=>"X", "2"=>"R"));
	}
	
	//создадим хайлоадблок
	$hlblock = Bitrix\Highloadblock\HighloadBlockTable::getList(['filter' => ['=TABLE_NAME'=>'test_oneway']])->fetch();
	if($hlblock === false) {
		$result = Bitrix\Highloadblock\HighloadBlockTable::add(array(
			'NAME' => 'TestOneway',
			'TABLE_NAME' => 'test_oneway', 
		));
		if ($result->isSuccess()) {
			$hl_id = $result->getId();
			
			$UFObject = 'HLBLOCK_'.$hl_id;
			
			$arFields = [
				'UF_IMG_ID'=>[
						'ENTITY_ID' => $UFObject,
						'FIELD_NAME' => 'UF_IMG_ID',
						'USER_TYPE_ID' => 'string',
						'MANDATORY' => 'Y',
				],
				'UF_IP_ADDR'=>[
						'ENTITY_ID' => $UFObject,
						'FIELD_NAME' => 'UF_IP_ADDR',
						'USER_TYPE_ID' => 'string',
						'MANDATORY' => 'Y',
				],
			];
			
			foreach($arFields as $field){
				$obUserField  = new CUserTypeEntity;
				
				$userFieldId = $obUserField->Add($field);			
			}
		}
	}
}

$arSites = [''=>'Выбрать'];
$rsSites = CSite::GetList($by="sort", $order="desc", ['ACTIVE'=>'Y']);
while ($arSite = $rsSites->Fetch())
{
	$arSites[$arSite['ID']] = $arSite['NAME'] . ' ['. $arSite['ID'] . ']';
}

$arIBlockType = [];
if(!empty($arCurrentValues["SITE_ID"])) {
	$rsIBlockType = CIBlockType::GetList(["sort"=>"asc"], ["ACTIVE"=>"Y"]);
	while($arr=$rsIBlockType->Fetch())
	{
		if($ar=CIBlockType::GetByIDLang($arr["ID"], LANGUAGE_ID))
			$arIBlockType[$arr["ID"]] = "[".$arr["ID"]."] ".$ar["NAME"];
	}
}
$arIBlock = [];
if(!empty($arCurrentValues["SITE_ID"])) {
	$rsIBlock = CIBlock::GetList(["sort" => "asc"], ["ACTIVE"=>"Y", 'SITE_ID'=>$arCurrentValues["SITE_ID"]]);
	while($arr = $rsIBlock->Fetch())
	{
		$arIBlock[$arr["ID"]] = "[".$arr["ID"]."] ".$arr["NAME"];
	}
}
$arComponentParameters = [
	"GROUPS" => [],
	"PARAMETERS" => [
		"SITE_ID" => [
			"PARENT" => "BASE",
			"NAME" => 'Привязка к сайту',
			"TYPE" => "LIST",
			"VALUES" => $arSites,
			"REFRESH" => "Y",
			"DEFAULT" => "",
		],
		"IBLOCK_TYPE" => [
			"PARENT" => "DATA_SOURCE",
			"NAME" => 'Тип инфоблока',
			"TYPE" => "LIST",
			"VALUES" => $arIBlockType,
			"REFRESH" => "Y",
			"DEFAULT" => "",
		],
		"IBLOCK_ID" => [
			"PARENT" => "DATA_SOURCE",
			"NAME" => 'Инфоблок с данными',
			"TYPE" => "LIST",
			"VALUES" => $arIBlock,
			//"REFRESH" => "Y",
			"DEFAULT" => "",
		],
	],
];
?>