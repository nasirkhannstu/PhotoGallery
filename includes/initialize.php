<?php
//echo $_SERVER['DOCUMENT_ROOT'];C:/xampp/htdocs
//directory_separator is a PHP pre defined constant 
//(/ for windows & \ for mac)
defined("DS") ? null : define('DS', DIRECTORY_SEPARATOR);
defined("SITE_ROOT") ? null : define('SITE_ROOT', DS.'xampp'.DS.'htdocs'.DS.'photogallery');
defined("LIB_PATH") ? null : define('LIB_PATH', SITE_ROOT.DS.'includes');

require_once(LIB_PATH.DS."constant.php");
require_once(LIB_PATH.DS."function.php");
require_once(LIB_PATH.DS."session.php");
require_once(LIB_PATH.DS."database.php");
require_once(LIB_PATH.DS."databaseObject.php");
require_once(LIB_PATH.DS."pagination.php");
require_once(LIB_PATH.DS."user.php");
require_once(LIB_PATH.DS."photograph.php");

?>