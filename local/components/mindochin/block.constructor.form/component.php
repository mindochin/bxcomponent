<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */
/** @global CMain $APPLICATION */

/** @global CIntranetToolbar $INTRANET_TOOLBAR */

use Bitrix\Main\Context,
	Bitrix\Main\Type\DateTime,
	Bitrix\Main\Loader,
	Bitrix\Iblock;
  
if(!CModule::IncludeModule("iblock"))
	return false;
        
$arResult = $arFields = $arProps = array();

$arFilter = Array('IBLOCK_ID' => $arParams["IBLOCK_ID"], "ID" => $arParams["BLOCK_NAME"], "IBLOCK_ACTIVE" => "Y", "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array("SORT"=>"ASC"), $arFilter, false);

while($ob = $res->GetNextElement())
{
	$arFields = $ob->GetFields();
	$arProps = $ob->GetProperties();
	
	if(!empty($arFields["DETAIL_PICTURE"])) {
		$bgImg = CFile::ResizeImageGet($arFields["DETAIL_PICTURE"], array('width'=>1920, 'height'=>1080), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);
		if(!isset($bgImg['src'])) {
			$tempBgImg = CFile::GetFileArray($arFields["DETAIL_PICTURE"]);
			$bgImg['src'] = $tempBgImg['SRC'];
			$bgImg['height'] = $tempBgImg['HEIGHT'];
			$bgImg['width'] = $tempBgImg['WIDTH'];
			$tempBgImg = false;
		}
		$arResult['BACKGROUND_IMAGE'] = $bgImg;
	}
	$arResult['ID'] = $arFields["ID"];
	$arResult['FORM_NAME'] = $arFields["NAME"];
	
	if(!empty($arProps["SUBTITLE"]) and empty($arParams['SUBTITLE'])) {
		$arResult['SUBTITLE'] = $arProps["SUBTITLE"]['~VALUE'];
	}
	if(!empty($arParams['SUBTITLE'])) {
		$arResult['SUBTITLE'] = $arParams["SUBTITLE"];
	}
	if(!empty($arProps["TITLE"]['~VALUE']) and empty($arParams['TITLE'])) {
		$arResult['TITLE'] = $arProps["TITLE"]['~VALUE'];
	}
	if(!empty($arParams['TITLE'])) {
		$arResult['TITLE'] = $arParams["TITLE"];
	}
	if(!empty($arProps["FORM_TITLE"]['~VALUE'])) {
		$arResult['FORM_TITLE'] = $arProps["FORM_TITLE"]['~VALUE'];
	}
	if(!empty($arProps["FORM_POS"]['VALUE_XML_ID'])) {
		$arResult['FORM_POS'] = $arProps["FORM_POS"]['VALUE_XML_ID'];
	}
	if(!empty($arProps["BUTTON_TITLE"])) {
		$arResult['BUTTON_TITLE'] = $arProps["BUTTON_TITLE"]['~VALUE'];
	}
	if(isset($arProps["FORM_INPUTS"]) and is_array($arProps["FORM_INPUTS"]['VALUE'])) {
		$arResult['FORM_INPUTS'] = $arProps["FORM_INPUTS"];
	}
	if(!empty($arProps["YA_METRIKA_ID"])) {
		$arResult['YA_METRIKA_ID'] = $arProps["YA_METRIKA_ID"]['VALUE'];
	}
	if(!empty($arProps["YA_GOAL_ID"])) {
		$arResult['YA_GOAL_ID'] = $arProps["YA_GOAL_ID"]['VALUE'];
	}
	if(!empty($arProps["THANKS_TEXT"])) {
		$arResult['THANKS_TEXT'] = $arProps["THANKS_TEXT"]['VALUE'];
	}
	if(!empty($arFields["PREVIEW_TEXT"])) {
		$arResult['PREVIEW_TEXT'] = $arFields["~PREVIEW_TEXT"];
	}
	if(!empty($arProps["BG_IMAGE_FON"]['VALUE_XML_ID']))
		$arResult['BG_IMAGE_FON'] = $arProps["BG_IMAGE_FON"]['VALUE_XML_ID'];
}
//echo "<pre>"; print_r($arFields); echo "</pre>";
$this->includeComponentTemplate();

if($arParams['FORM_AS'] == 'block')
{
$arButtons = CIBlock::GetPanelButtons(
	$arParams["IBLOCK_ID"],
	$arFields["ID"],
	$arFields["IBLOCK_SECTION_ID"],
	Array(
		//"RETURN_URL" => $arReturnUrl,
		"SECTION_BUTTONS" => false,
	)
);
if($APPLICATION->GetShowIncludeAreas())
	$this->addIncludeAreaIcons(CIBlock::GetComponentMenu($APPLICATION->GetPublicShowMode(), $arButtons));

}
?>
<?/*
 $arRes = Array();

        $arRes["OK"] = "N";

        $element_id = intval(trim($_REQUEST["element"]));
        

        if($_REQUEST["send"] == "Y" && $element_id > 0)
        {
               $email = "";
                $phone = "";
                $name = "";
                
                $countName = 0;
                $countPhone = 0;
                $countEmail = 0;

                if(strlen($comment) > 0)
                    $message .= $comment;

                // $message = '<b>'.GetMessage("KRAKEN_MESSAGE_TITLE_FORM").': </b><br><br>';

                
                foreach($arIBlockElement["PROPERTIES"]["FORM_PROP_INPUTS"]["VALUE"] as $k => $arVal)
                {



                    $type = $arIBlockElement["PROPERTIES"]["FORM_PROP_INPUTS"]["DESCRIPTION"][$k];
                                                                            
                    $type = explode(";", ToLower($type));

                    if(!empty($type))
                    {
                        foreach($type as $k1=>$val)
                            $type[$k1] = trim($val);
                    }

                    if($type[0] == "radio" || $type[0] == "checkbox" || $type[0] == "select")
                    {

                        $list = explode(";", htmlspecialcharsBack($arVal));                                                    
                        $first = $list[0];

                        if(substr_count($first, "<") > 0 && substr_count($first, ">") > 0)
                        {
                            $tit = str_replace(array("<", ">"), array("", ""), $first);
                            unset($list[0]);
                            
                            if(!empty($_REQUEST["input_".$element_id."_$k"]) && is_array($_REQUEST["input_".$element_id."_$k"]) || strlen(trim($_REQUEST["input_".$element_id."_$k"])) > 0)
                                $message .= '<b>'.$tit.': </b> ';
                        }


                        if(!empty($_REQUEST["input_".$element_id."_$k"]) && is_array($_REQUEST["input_".$element_id."_$k"]))
                        {
                            
                            $check_array = $_REQUEST["input_".$element_id."_$k"];
                            
                            if(SITE_CHARSET == "windows-1251")
                            {
                                if(!empty($check_array))
                                {
                                    foreach($check_array as $c=>$check)
                                        $check_array[$c] = utf8win1251(trim($check));
                                }
                            }
                            
                            $message .= implode(", ", $check_array).'<br>';

                        }

                        else
                        {

                            if(strlen(trim($_REQUEST["input_".$element_id."_$k"]))>0)
                            {
                                $check = trim($_REQUEST["input_".$element_id."_$k"]);
                                
                                if(SITE_CHARSET == "windows-1251")
                                    $check = utf8win1251($check);

                                $message .= $check.'<br>';
                            }
                            
                        }

                    }

                    else
                    {

                        if(strlen(trim($_REQUEST["input_".$element_id."_$k"]))>0)
                        {
                            $desc = trim($_REQUEST["input_".$element_id."_$k"]);
    
                            if(SITE_CHARSET == "windows-1251")
                                $desc = utf8win1251(trim($_REQUEST["input_".$element_id."_$k"]));
    
                            $message .= '<b>'.$arVal.': </b>'.$desc.'<br>';
                            
                            if($type[0] == "name")
                            {
                                if($countName <= 0)
                                    $name = $desc;
     
                                $countName++;
                            }
                            
                            if($type[0] == "phone")
                            {
                                if($countPhone <= 0)
                                    $phone = $desc;
     
                                $countPhone++;
                            }
                            
                            if($type[0] == "email")
                            {
                                if($countEmail <= 0)
                                    $email = $desc;
     
                                $countEmail++;
                            }
                        }

                    }



                    if(!empty($_FILES["input_".$element_id."_$k"]["name"]))
                    {
                        $arFile = array();

                        foreach ($_FILES["input_".$element_id."_$k"]["name"] as $key => $name)
                        {
                            if($_FILES["input_".$element_id."_$k"]["error"][$key] == 0)
                            {

                                if(SITE_CHARSET == "windows-1251")
                                    $filename = utf8win1251($name);
                                else
                                    $filename = $name;

                                $arParams = array("safe_chars"=>".", "max_len" => 1000);
                                $filename = Cutil::translit($filename,"ru",$arParams);
                                
                                $filename = basename($filename);
                        
                                $newname = $_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH.'/kraken_tmp_file/'.$filename;
                                if (!file_exists($newname)) 
                                {
                                    move_uploaded_file($_FILES["input_".$element_id."_$k"]["tmp_name"][$key], $newname);
                                }

                                $arFile[] = $newname;
                            }
                        }

                        $arFiles = array_merge($arFiles, $arFile);
                    }
                }

            }



            $form_name = strip_tags($arIBlockElement["~NAME"]);

            if(strlen($KRAKEN_TEMPLATE_ARRAY["MAIL_FROM"]['VALUE']) > 0)
                $email_from = htmlspecialcharsBack(trim($KRAKEN_TEMPLATE_ARRAY["MAIL_FROM"]['VALUE']));
            else
                $email_from = htmlspecialcharsBack(trim($arSite['EMAIL']));


            if(strlen($KRAKEN_TEMPLATE_ARRAY["MAIL_TO"]['VALUE']) > 0)
                $email_to = htmlspecialcharsBack(trim($KRAKEN_TEMPLATE_ARRAY["MAIL_TO"]['VALUE']));
            else
                $email_to = htmlspecialcharsBack(trim($arSite['EMAIL']));

            $arMailto = array();

            $arMailto = explode(",", $email_to);


            $arEventFields = array(
                "MESSAGE" => $message,
                "HEADER" => $header,
                "FORM_NAME" => $form_name,
                "EMAIL_FROM" => $email_from,
                "EMAIL"         => $email,
                "NAME"           => $name,
                "PHONE"          => $phone,
                "CHECK_VALUE"    => $check_value,
                "COUNT"          => $count,
                "DATE"          => $date,
                "TEXT"          => $text,
                "ADDRESS"          => $address,
                "MORE_INFO" =>  $comment,
                "URL" => $url,
                "PAGE_NAME" => $arSite['NAME']
            );

         
            if(!empty($_FILES["userfile"]["name"]))
            {
                

                foreach ($_FILES["userfile"]["name"] as $key => $name)
                {

                    if($_FILES["userfile"]["error"][$key] == 0)
                    {

                        if($form_admin == 'light')
                        {
                            if(SITE_CHARSET == "windows-1251")
                                $filename = utf8win1251($name);
                            else
                                $filename = $name;

                            $arParams = array("safe_chars"=>".", "max_len" => 1000);
                            $filename = Cutil::translit($filename,"ru",$arParams);
                            
                            $filename = basename($filename);
                    
                            $newname = $_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH.'/kraken_tmp_file/'.$filename;
                            if (!file_exists($newname)) 
                            {
                                move_uploaded_file($_FILES["userfile"]["tmp_name"][$key], $newname);
                            }

                            $arFiles[] = $newname;
                        }
                    }
                }
            }

            $toAdminFile = false;

            if(!empty($arFiles))
                $toAdminFile = true;


            if(!empty($arMailto))
            {
                foreach ($arMailto as $email_to_val)
                {
                    $arEventFields["EMAIL_TO"] = $email_to_val;
                    
                    if($toAdminFile)
                    {
                        if(CEvent::Send("KRAKEN_USER_INFO_".SITE_ID, SITE_ID, $arEventFields, "Y", "", $arFiles))
                            $arRes["OK"] = "Y";
                    }

                    else
                    {
                        if(CEvent::Send("KRAKEN_USER_INFO_".SITE_ID, SITE_ID, $arEventFields, "Y", ""))
                            $arRes["OK"] = "Y";
                    }
                }
            }

            $arFilesIb = Array();
            if(!empty($arFiles))
            {
                foreach ($arFiles as $value) {
                    $arFilesIb[] = array("VALUE" => CFile::MakeFileArray($value));
                }
            }

            if(!empty($arIBlockElement["PROPERTIES"]['FORM_TEXT']["~VALUE"]["TEXT"]) || !empty($arIBlockElement['PROPERTIES']['FORM_FILES']['VALUE']) || strlen($arIBlockElement["PROPERTIES"]['FORM_THEME']["VALUE"]) > 0)
            {

                $arMailUserto = array();
                $arMailUserto = explode(",", $email);


                $arEventFields2 = array(
                    "EMAIL_FROM" => $email_from,
                    "MESSAGE_FOR_USER" => $arIBlockElement["PROPERTIES"]['FORM_TEXT']["~VALUE"]["TEXT"],
                    "THEME" => $arIBlockElement["PROPERTIES"]['FORM_THEME']["~VALUE"]
                );

                $files = $arIBlockElement['PROPERTIES']['FORM_FILES']['VALUE'];

                if(!empty($arMailUserto))
                {
                    foreach ($arMailUserto as $email_to_val)
                    {
                        $arEventFields2["EMAIL_TO"] = $email_to_val;

                        if(!empty($files))
                        {
                            if(CEvent::Send("KRAKEN_FOR_USER_".SITE_ID, SITE_ID, $arEventFields2, "Y", "", $files))
                                $arRes["OK"] = "Y";
                        }
                        else
                        {
                            if(CEvent::Send("KRAKEN_FOR_USER_".SITE_ID, SITE_ID, $arEventFields2))
                                $arRes["OK"] = "Y";
                        }

                    }

                }

                
            }



            $arRes["SCRIPTS"] = '';

            $yaGoal = $KRAKEN_TEMPLATE_ARRAY["METRIKA_GOAL"]['VALUE'];

            $gogCat = $KRAKEN_TEMPLATE_ARRAY["GOOGLE_CATEGORY"]['VALUE'];
            $gogAct = $KRAKEN_TEMPLATE_ARRAY["GOOGLE_ACTION"]['VALUE'];

            $gtmEvn = $KRAKEN_TEMPLATE_ARRAY["GTM_EVENT"]['VALUE'];
            $gtmCat = $KRAKEN_TEMPLATE_ARRAY["GTM_CATEGORY"]['VALUE'];
            $gtmAct = $KRAKEN_TEMPLATE_ARRAY["GTM_ACTION"]['VALUE'];

            if(strlen($arIBlockElement['PROPERTIES']['YANDEX_GOAL']['VALUE']) > 0)
                $yaGoal = $arIBlockElement['PROPERTIES']['YANDEX_GOAL']['VALUE'];


            if(strlen($arIBlockElement['PROPERTIES']['GOOGLE_GOAL_CATEGORY']['VALUE'])>0)
                $gogCat = $arIBlockElement['PROPERTIES']['GOOGLE_GOAL_CATEGORY']['VALUE'];

            if(strlen($arIBlockElement['PROPERTIES']['GOOGLE_GOAL_ACTION']['VALUE'])>0)
                $gogAct = $arIBlockElement['PROPERTIES']['GOOGLE_GOAL_ACTION']['VALUE'];


            if(strlen($arIBlockElement['PROPERTIES']['GTM_EVENT']['VALUE'])>0)
                $gtmEvn = $arIBlockElement['PROPERTIES']['GTM_EVENT']['VALUE'];

            if(strlen($arIBlockElement['PROPERTIES']['GTM_GOAL_CATEGORY']['VALUE'])>0)
                $gtmCat = $arIBlockElement['PROPERTIES']['GTM_GOAL_CATEGORY']['VALUE'];

            if(strlen($arIBlockElement['PROPERTIES']['GTM_GOAL_ACTION']['VALUE'])>0)
                $gtmAct = $arIBlockElement['PROPERTIES']['GTM_GOAL_ACTION']['VALUE'];



            if(!empty($KRAKEN_TEMPLATE_ARRAY["ID_METRIKA"]) && strlen($yaGoal) > 0)
            {

                foreach($KRAKEN_TEMPLATE_ARRAY["ID_METRIKA"] as $idVal)
                {
                    $arRes["SCRIPTS"] .= 'yaCounter'.htmlspecialcharsbx(trim($idVal)).'.reachGoal("'.htmlspecialcharsbx(trim($yaGoal)).'"); ';
                }
            }
            
            if(strlen($KRAKEN_TEMPLATE_ARRAY['GOOGLE']["VALUE"]) && strlen($gogCat) > 0 && strlen($gogAct) > 0)
            {

                if($KRAKEN_TEMPLATE_ARRAY['GOOGLE_FLAG_GA'])
                    $arRes["SCRIPTS"] .= 'ga("send", "event", "'.htmlspecialcharsbx(trim($gogCat)).'", "'.htmlspecialcharsbx(trim($gogAct)).'"); ';

                if($KRAKEN_TEMPLATE_ARRAY['GOOGLE_FLAG_GTAG'])
                    $arRes["SCRIPTS"] .= 'gtag("event","'.htmlspecialcharsbx(trim($gogAct)).'",{"event_category":"'.htmlspecialcharsbx(trim($gogCat)).'"}); ';
                
            }

            if(strlen($KRAKEN_TEMPLATE_ARRAY["ID_GTM"]) > 0 && strlen($gtmEvn) > 0)
                $arRes["SCRIPTS"] .= 'dataLayer.push({"event": "'.htmlspecialcharsbx(trim($gtmEvn)).'", "eventCategory": "'.htmlspecialcharsbx(trim($gtmCat)).'", "eventAction": "'.htmlspecialcharsbx(trim($gtmAct)).'"});';

            if(strlen($arIBlockElement['PROPERTIES']['FORM_JS_AFTER_SEND']['VALUE']) > 0)
                $arRes["SCRIPTS"] .= $arIBlockElement['PROPERTIES']['FORM_JS_AFTER_SEND']['VALUE'];
            

            require($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/concept.kraken/crm.php');
            
            $arRes = json_encode($arRes);
         	echo $arRes;


            //infoblock
            if($KRAKEN_TEMPLATE_ARRAY["SAVE_IN_IB"]['VALUE'][0] == 'Y')
            {
                
                $request_iblock_code = "concept_kraken_site_requests_".SITE_ID;
                
                $res = CIBlock::GetList(Array(), Array("CODE"=>$request_iblock_code), false);
                
                while($ar_res = $res->GetNext())
                    $request_iblock_id = $ar_res["ID"];
                
                
                $el = new CIBlockElement;
                
                $request_message = str_replace(Array("<b>","</b>","<br>", "<br/>"), Array("", "", "\r\n", "\r\n"), $message);
                
                $request_text = "";
                
                //$request_text .= GetMessage("MESSAGE_TEXT1")."\r\n";
                $request_text .= GetMessage("KRAKEN_MESSAGE_TEXT2").$arSite['NAME']."\r\n";
                $request_text .= GetMessage("KRAKEN_MESSAGE_TEXT3").$header."\r\n";
                $request_text .= GetMessage("KRAKEN_MESSAGE_TEXT6").$form_name."\r\n\r\n";
                $request_text .= GetMessage("KRAKEN_MESSAGE_TEXT4").$url."\r\n\r\n";
                $request_text .= GetMessage("KRAKEN_MESSAGE_TEXT5")."\r\n\r\n";
                $request_text .= $request_message;




                $arLoadProductArray = Array(         
                  "IBLOCK_ID"      => $request_iblock_id,
                  "NAME"           => GetMessage("KRAKEN_INFOBLOCK_TITLE").date("d.m.Y H:i:s"),
                  "ACTIVE"         => "Y",            
                  "PREVIEW_TEXT"   => $request_text
                );
                
                $id_el = $el->Add($arLoadProductArray);

                if(!empty($arFilesIb))
                    CIBlockElement::SetPropertyValueCode($id_el, "REQ_FILES", $arFilesIb);
                

            }

            if (file_exists($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH.'/kraken_tmp_file/'))
                foreach (glob($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH.'/kraken_tmp_file/*') as $file)
                    unlink($file);
	else
        {
        	$arRes = json_encode($arRes);
        	echo $arRes;
        }
*/?>