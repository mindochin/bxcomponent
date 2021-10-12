<?php
//define("NO_KEEP_STATISTIC", true);
//define("NOT_CHECK_PERMISSIONS", true);
//require_once($_SERVER['DOCUMENT_ROOT'] . "/bitrix/modules/main/lib/web/httpclient.php");
function checkSpambots($mail='', $ip='', $name='') {	
	$spambot = $result = false;
	$dir = $_SERVER["DOCUMENT_ROOT"].'/upload/_spambot/';
	$file = $dir . date('Y-m-d') . '.txt';
	$url = "http://api.stopforumspam.org/api";
	$http = new \Bitrix\Main\Web\HttpClient();
	
	if($mail != '') {
		$result = $http->get($url . "?email=" . $mail);		
		if ($http->getStatus() == 200 && $result) {
			$xml = simplexml_load_string($result);
			$appears = (string) $xml->appears;
			$frequency = (int) $xml->frequency;
			\Bitrix\Main\Diag\Debug::writeToFile($mail.' = '.$appears.' ('.$frequency.')'."\r\n", '', "err_mail.log");
			if($appears == 'yes' && $frequency > 50) {
				$spambot = true;
			}
		}
	}
	
	if($ip != '' and $spambot === false) {		
		$result = $http->get($url . "?ip=" . $ip);
		if ($http->getStatus() == 200 && $result) {
			$xml = simplexml_load_string($result);
			$appears = (string) $xml->appears;
			$frequency = (int) $xml->frequency;
			\Bitrix\Main\Diag\Debug::writeToFile($ip.' = '.$appears.' ('.$frequency.')'."\r\n", '', "err_ip.log");
			if($appears == 'yes' && $frequency > 50) {
				$spambot = true;
			}
		}
	}
	if($name != '' and $spambot === false) {
		$result = $http->get($url . "?username=" . $name);
		if ($http->getStatus() == 200 && $result) {
			$xml = simplexml_load_string($result);
			$appears = (string) $xml->appears;
			$frequency = (int) $xml->frequency;
			\Bitrix\Main\Diag\Debug::writeToFile($name.' = '.$appears.' ('.$frequency.')'."\r\n", '', "err_name.log");
			if($appears == 'yes' && $frequency > 50) {
				$spambot = true;
			}
		}	
	}
	// запишем инфо спамера в файл, для статистики например
	if ($spambot === true) {			
		$spambot_info = $ip . ',' . $name . ',' . $mail . ',1';
		file_put_contents($file, $spambot_info . PHP_EOL, FILE_APPEND);	
	}
	return $spambot;
}
?>