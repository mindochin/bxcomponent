<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

global $DB, $DBType, $APPLICATION;

/***************************
* создадим почтовые события
***************************/
function create_event_type($arEventFields=array()) {
	global $DB;
	$EventTypeID = 0;
	$et = new CEventType;
	$EventTypeID = $et->Add($arEventFields);
	return $EventTypeID;
}


$arData = array(
	'MINDOCHIN_FORM_ORDER'
);


if( is_array($arData) && count($arData)>0 ) {	

	$ev = new CEventMessage;

	foreach($arData as $EVENT_TYPE) {
		
		$rsET = CEventType::GetList(Array("TYPE_ID" => $EVENT_TYPE));
		if (!$arET = $rsET->Fetch())
		{
			$et = new CEventType;
			$arETID = $et->Add(array(				
				'LID'           => 'ru',
				'EVENT_NAME'    => $EVENT_TYPE,
				'NAME'          => 'Заявка из формы',
				'DESCRIPTION'   => '#EMAIL# - E-Mail пользователя
#EMAIL_TO# - E-mail администратора (получатель письма)
#PAGE_NAME# - название страницы
#MESSAGE# - все заполненные на сайте сообщения
',
			));
		}
		$rsEM = CEventMessage::GetList($by="", $order="desc", Array(				
			"TYPE_ID"       => $EVENT_TYPE,				
			"ACTIVE"        => "Y",			
		));
		if (!$arEM = $rsEM->Fetch())
		{				
			$emess = new CEventMessage;
			$arMessage = Array(
				'ACTIVE' 		=> 'Y',
				'EVENT_NAME' 	=> $EVENT_TYPE,
				'LID'			=> $arCurrentValues["SITE_ID"],
				'EMAIL_FROM'	=> '#EMAIL_FROM#',
				'EMAIL_TO'		=> '#EMAIL_TO#',
				'BCC'			=> '',
				'SUBJECT'		=> 'Заявка с сайта  «#PAGE_NAME#»',
				'BODY_TYPE'		=> 'html',
				'MESSAGE'		=> '#MESSAGE#',
			);

			if (!$emess->Add($arMessage))
			{
				ShowError($emess->LAST_ERROR);
			}
		}
	}
}
/******************
* создадим инфоблок
*******************/
/*ImportXMLFile(
   string file_name,
   string iblock_type = "-",
   array site_id = '',
   )*/