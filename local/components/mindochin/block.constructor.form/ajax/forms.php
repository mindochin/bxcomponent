<?require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)	die();
define('NO_AGENT_CHECK', true);
CModule::IncludeModule('iblock');
$arRes = Array();
$arRes["OK"] = "N";
$element_id = intval(trim($_REQUEST["element"]));
$site_id = (string) $_REQUEST['site_id'];

if($_REQUEST["send"] == "Y" && $element_id > 0) {
	
	$r = CIBlockElement::GetList(Array(), Array("ID"=> $element_id, "ACTIVE"=>"Y"));

	while($ob = $r->GetNextElement())
	{
		$arElementFields = $ob->GetFields();  
		$arElementProperties = $ob->GetProperties();
	}

	$rsSites = CSite::GetByID($site_id);
	$arSite = $rsSites->Fetch();
	//echo json_encode($arSite);
	$header = trim($_REQUEST["header"]);
	$url = trim($_REQUEST["url"]);
	$url = urldecode($url);
	$message = '';
	$arFiles = array();
	$email = "";
	$phone = "";
	$name = "";
	
	$countName = 0;
	$countPhone = 0;
	$countEmail = 0;
	
	$form_name = strip_tags($arElementFields["~NAME"]);
	
	$td_style = ' style="padding: 5px 2px; vertical-align: top; border-top: 1px solid #dee2e6;"';
	
	$message .= '<p>Заявка с сайта ' . $arSite['NAME'] . ' со страницы ' . $url .'</p>';
	$message .= '<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse;">';
	$message .= '<tr><thead><th colspan="2" style="vertical-align: bottom; border-bottom: 3px solid #dee2e6; padding: 3px;">Данные формы:</th></thead></tr>';
	if(!empty($heaser))
		$message .= '<tr><td'. $td_style .'><b>Заголовок:</b></td><td'. $td_style .'>' . $header .'</td></tr>';
	$message .= '<tr><td'. $td_style .'><b>Название формы:</b></td><td'. $td_style .'>' . $form_name .'</td></tr>';
	
	foreach($arElementProperties["FORM_INPUTS"]["VALUE"] as $k => $arVal)	{
		
		$type = $arElementProperties["FORM_INPUTS"]["DESCRIPTION"][$k];

		$type = explode(":", ToLower($type));

		if(!empty($type))
		{
			foreach($type as $k1=>$val)
				$type[$k1] = trim($val);
		}

		if($type[0] == "radio" || $type[0] == "checkbox" || $type[0] == "select")
		{

			$list = explode(";", htmlspecialcharsBack($arVal));                                                    
			$first = $list[0];
			
			$message .= '<tr><td'. $td_style .'>';
			if(substr_count($first, "<") > 0 && substr_count($first, ">") > 0)
			{
				$tit = str_replace(array("<", ">"), array("", ""), $first);
				unset($list[0]);
				
				if(!empty($_REQUEST["input_".$element_id."_$k"]) && is_array($_REQUEST["input_".$element_id."_$k"]) || strlen(trim($_REQUEST["input_".$element_id."_$k"])) > 0)
					$message .= '<b>'.$tit.': </b> ';
			}
			$message .= '</td><td'. $td_style .'>';

			if(!empty($_REQUEST["input_".$element_id."_$k"]) && is_array($_REQUEST["input_".$element_id."_$k"]))
			{				
				$check_array = $_REQUEST["input_".$element_id."_$k"];
				$message .= implode(", ", $check_array).'<br>';

			}
			else
			{
				if(strlen(trim($_REQUEST["input_".$element_id."_$k"]))>0)
				{
					$check = trim($_REQUEST["input_".$element_id."_$k"]);
					$message .= $check.'<br>';
				}
			}
			$message .= '</td></tr>';
		}
		else
		{

			if(strlen(trim($_REQUEST["input_".$element_id."_$k"]))>0)
			{
				$desc = trim($_REQUEST["input_".$element_id."_$k"]);
				$message .= '<tr><td'. $td_style .'><b>'.$arVal.': </b></td><td'. $td_style .'>'.$desc.'</td></tr>';
				
				if($type[0] == "name")
				{
					if($countName <= 0) {
						$name = $desc;
						//$message .= 'Имя: ' . $name . '<br>';
					}

					$countName++;
				}
				
				if($type[0] == "phone")
				{
					if($countPhone <= 0) {
						$phone = $desc;
						//$message .= 'Телефон: ' . $phone . '<br>';
					}

					$countPhone++;
				}
				
				if($type[0] == "email")
				{
					if($countEmail <= 0) {
						$email = $desc;
						//$message .= 'Email: ' . $email . '<br>';
					}

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
					$filename = $name;

					$arParams = array("safe_chars"=>".", "max_len" => 1000);
					$filename = Cutil::translit($filename,"ru",$arParams);
					
					$filename = basename($filename);
					
					CheckDirPath($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH.'/tmp_file/');			
					$newname = $_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH.'/tmp_file/'.$filename;
					if (!file_exists($newname)) 
					{
						move_uploaded_file($_FILES["input_".$element_id."_$k"]["tmp_name"][$key], $newname);
					}

					$arFile[] = $newname;
				}
			}

			$arFiles = array_merge($arFiles, $arFile);
			$message .= '<tr><td'. $td_style .'><b>Отправлено файлов:</b></td><td'. $td_style .'>' . count($arFiles) . '</td></tr>';
		}
	}

	if (isset($_SERVER))
	{
		if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER))
		{
			$realip = current(preg_grep("/^(10|172\\.16|192\\.168)\\./",array_map('trim', explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])),PREG_GREP_INVERT));
		}
		$realip = $realip?:@$_SERVER['HTTP_CLIENT_IP']?:@$_SERVER['REMOTE_ADDR']?:NULL;
	}
	
	$message .= '<tr><td'. $td_style .'><b>IP-address:</b></td><td'. $td_style .'>' . $realip?:$realip = '0.0.0.0' . '</td></tr>';
	
	/* product from product page */
	if(!empty($_REQUEST['product']))
		$message .= '<tr><td'. $td_style .'><b>Продукт:</b></td><td'. $td_style .'>' . $_REQUEST['product'] . '</td></tr>';
	
	$message .= '</table>';
	
	$email_from = COption::GetOptionString("main", "email_from");//htmlspecialcharsBack(trim($arSite['EMAIL']));
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
		"URL" => $url,
		"PAGE_NAME" => $arSite['NAME']
	);
//echo "<pre>";print_r($arEventFields);echo "</pre>";die;
	//сообщение админу сайта
	if(!empty($arMailto))
	{
		foreach ($arMailto as $email_to_val)
		{
			$arEventFields["EMAIL_TO"] = $email_to_val;
			
			if(!empty($arFiles))
			{
				if(CEvent::Send("MINDOCHIN_FORM_ORDER", SITE_ID, $arEventFields, "Y", "", $arFiles))
					$arRes["OK"] = "Y";
			}

			else
			{
				if(CEvent::Send("MINDOCHIN_FORM_ORDER", SITE_ID, $arEventFields, "Y", ""))
					$arRes["OK"] = "Y";
			}
		}
	}
	//сообщение юзеру
	$arMailUserto = array();
	$arMailUserto = explode(",", $email);
	if(!empty($arElementProperties["THANKS_TEXT"]["~VALUE"]) and !empty($arMailUserto))
	{

		$arEventFields2 = array(
			"EMAIL_FROM" => $email_from,
			"MESSAGE" => $arElementProperties["THANKS_TEXT"]["~VALUE"],
			"PAGE_NAME" => $arSite['NAME']			
		);
		foreach ($arMailUserto as $email_to_val)
		{
			$arEventFields2["EMAIL_TO"] = $email_to_val;
			if(CEvent::Send("MINDOCHIN_FORM_ORDER", SITE_ID, $arEventFields2))
				$arRes["OK"] = "Y";
		}	
	}

	$arRes["SCRIPTS"] = '';

	if(strlen(trim($arElementProperties['YA_GOAL_ID']['VALUE'])) > 0)
		$yaGoal = $arElementProperties['YA_GOAL_ID']['VALUE'];

	if(strlen(trim($arElementProperties['YA_METRIKA_ID']['VALUE'])) > 0)
		$yaMetrika = $arElementProperties['YA_METRIKA_ID']['VALUE'];
/*
            if(strlen($arElementFields['PROPERTIES']['GOOGLE_GOAL_CATEGORY']['VALUE'])>0)
                $gogCat = $arElementFields['PROPERTIES']['GOOGLE_GOAL_CATEGORY']['VALUE'];

            if(strlen($arElementFields['PROPERTIES']['GOOGLE_GOAL_ACTION']['VALUE'])>0)
                $gogAct = $arElementFields['PROPERTIES']['GOOGLE_GOAL_ACTION']['VALUE'];


            if(strlen($arElementFields['PROPERTIES']['GTM_EVENT']['VALUE'])>0)
                $gtmEvn = $arElementFields['PROPERTIES']['GTM_EVENT']['VALUE'];

            if(strlen($arElementFields['PROPERTIES']['GTM_GOAL_CATEGORY']['VALUE'])>0)
                $gtmCat = $arElementFields['PROPERTIES']['GTM_GOAL_CATEGORY']['VALUE'];

            if(strlen($arElementFields['PROPERTIES']['GTM_GOAL_ACTION']['VALUE'])>0)
                $gtmAct = $arElementFields['PROPERTIES']['GTM_GOAL_ACTION']['VALUE'];
*/

	if(!empty($yaMetrika) && !empty($yaGoal))
	{
		//$arRes["SCRIPTS"] .= 'yaCounter'.htmlspecialcharsbx(trim($idVal)).'.reachGoal("'.htmlspecialcharsbx(trim($yaGoal)).'"); ';
		$arRes["SCRIPTS"] .= 'window.onload = $(function() {yaCounter'.htmlspecialcharsbx(trim($yaMetrika)).'.reachGoal("'.htmlspecialcharsbx(trim($yaGoal)).'")})';
	}
            /*
            if(strlen($KRAKEN_TEMPLATE_ARRAY['GOOGLE']["VALUE"]) && strlen($gogCat) > 0 && strlen($gogAct) > 0)
            {

                if($KRAKEN_TEMPLATE_ARRAY['GOOGLE_FLAG_GA'])
                    $arRes["SCRIPTS"] .= 'ga("send", "event", "'.htmlspecialcharsbx(trim($gogCat)).'", "'.htmlspecialcharsbx(trim($gogAct)).'"); ';

                if($KRAKEN_TEMPLATE_ARRAY['GOOGLE_FLAG_GTAG'])
                    $arRes["SCRIPTS"] .= 'gtag("event","'.htmlspecialcharsbx(trim($gogAct)).'",{"event_category":"'.htmlspecialcharsbx(trim($gogCat)).'"}); ';
                
            }

            if(strlen($KRAKEN_TEMPLATE_ARRAY["ID_GTM"]) > 0 && strlen($gtmEvn) > 0)
                $arRes["SCRIPTS"] .= 'dataLayer.push({"event": "'.htmlspecialcharsbx(trim($gtmEvn)).'", "eventCategory": "'.htmlspecialcharsbx(trim($gtmCat)).'", "eventAction": "'.htmlspecialcharsbx(trim($gtmAct)).'"});';

            if(strlen($arElementFields['PROPERTIES']['FORM_JS_AFTER_SEND']['VALUE']) > 0)
                $arRes["SCRIPTS"] .= $arElementFields['PROPERTIES']['FORM_JS_AFTER_SEND']['VALUE'];
            */
	//добавить что-то свое
	$pathInclude = strip_tags($_REQUEST['tpath']);
	require($_SERVER["DOCUMENT_ROOT"].$pathInclude.'/form.include.php');

	//infoblock
	$request_iblock_id = strip_tags($_REQUEST['ibo']);
	if(!empty($request_iblock_id))
	{	

		$el = new CIBlockElement;
		
		$request_message = str_replace(Array("<b>","</b>","<br>", "<br/>"), Array("", "", "\r\n", "\r\n"), $message);
		
		$request_text = "";
		
		//$request_text .= GetMessage("MESSAGE_TEXT1")."\r\n";
		/*$request_text .= GetMessage("KRAKEN_MESSAGE_TEXT2").$arSite['NAME']."\r\n";
		$request_text .= GetMessage("KRAKEN_MESSAGE_TEXT3").$header."\r\n";
		$request_text .= GetMessage("KRAKEN_MESSAGE_TEXT6").$form_name."\r\n\r\n";
		$request_text .= GetMessage("KRAKEN_MESSAGE_TEXT4").$url."\r\n\r\n";
		$request_text .= GetMessage("KRAKEN_MESSAGE_TEXT5")."\r\n\r\n";*/
		$request_text .= $request_message;

		$arLoadProductArray = Array(         
		  "IBLOCK_ID"		=> $request_iblock_id,
		  "ACTIVE_FROM"		=> gmdate("d.m.Y H:i:s"),
		  "NAME"			=> $form_name.'-'.gmdate("d.m.Y H:i:s"),
		  "ACTIVE"			=> "Y",            
		  "PREVIEW_TEXT"	=> $request_text
		);
		
		if($id_el = $el->Add($arLoadProductArray))
			$arRes['order_id'] = $id_el;
		else
			$arRes['order_id'] = $el->LAST_ERROR;
		
		$arFilesIb = Array();
		if(!empty($arFiles))
		{
			foreach ($arFiles as $value) {
				$arFilesIb[] = array("VALUE" => CFile::MakeFileArray($value));
			}
		}

		if(!empty($arFilesIb))
			CIBlockElement::SetPropertyValueCode($id_el, "FILES", $arFilesIb);
		

	}

	if (file_exists($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH.'/tmp_file/'))
		foreach (glob($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH.'/tmp_file/*') as $file)
			unlink($file);

	

	//bitrix24

			 
		
		//$obHttp = new CHTTP();
		//$result = $obHttp->Post($crmUrl.'crm/configs/import/lead.php', $arParams);
		//$result = json_decode(str_replace('\'', '"', $result), true);
		//$arRes["ER"] = '['.$result['error'].'] '.$result['error_message'];

	$arRes = json_encode($arRes);
	echo $arRes;



}
else
{
   	$arRes = json_encode($arRes);
   	echo $arRes;
}
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/epilog_after.php');
die();
?>