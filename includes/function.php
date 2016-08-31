<?php 
	function stripeZerosFromDate($markedString=""){
		//first remove the marked zero
		$noZero = str_replace('*0', '' , $markedString);
		//then remove any remaining marks
		$cleanedString = str_replace('*', '',$noZero );
		return $cleanedString;
	}
	function redirectTo($location = NULL){
		if($location !=NULL){
			header("Location: {$location}");
			exit;
		}
	}
	function outputMessage($message=""){
		if(!empty($message)){
			return "<p class=\"message\">{$message}</p>";
		}else{
			return "";
		}
	}
	function __autoload($className){
		$className = strtolower($className);
		$path = LIB_PATH.DS."{$className}.php";
		if(file_exists($path)){
			require_once($path);
		}else{
			die("The file {$className}.php could not be found");
		}
	}
	function includeLayoutTemplate($template){
		include(SITE_ROOT.DS.'public'.DS.'layout'.DS.$template);
	}
	function logAction($action, $message=""){
		$logFile = SITE_ROOT.DS.'logs'.DS.'log.txt';
		$new  = file_exists($logFile) ? false : true ;
		if($handle = fopen($logFile, 'a')){
			$timestamp = strftime("%Y-%m-%d %H:%M:%S", time());
			$content = "{$timestamp} | {$action} : {$message}\n";
			fwrite($handle, $content);
			fclose($handle);
			if($new){ chmod($logFile, 0755);}
		}else{
			echo "Could not open log file for writing";
		}
	}
	function datetimeToText($datetime=""){
		$unixdatetime = strtotime($datetime);
		return strftime("%B %d, %Y at %I:%M %p", $unixdatetime);
	}
?>