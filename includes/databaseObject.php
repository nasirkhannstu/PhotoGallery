<?php require_once(LIB_PATH.DS."database.php"); ?>
<?php 
class databaseObject {

	//He is waiting for late static bindings;
	//http://www.php.net/lsb

	// protected static $tableName = "users";

	// public static function findAll(){
	// //global $database;
	// // $resultSet = $database->query("SELECT * FROM users");
	// // return $resultSet;
	// return self::findBySql("SELECT * FROM ".self::$tableName);
	// }
	// public static function findById($id=0){
	// 	//global $database;
	// 	//$resultSet = $database->query("SELECT * FROM users WHERE id={$id} LIMIT 1");
	// 	$resultArray = static::findBySql("SELECT * FROM ".self::$tableName." WHERE id={$id} LIMIT 1");
	// 	return !empty($resultArray) ? array_shift($resultArray) : false;
	// }
	// public static function findBySql($sql=""){
	// 	global $database;
	// 	$resultSet = $database->query($sql);
	// 	$objectArray = array();
	// 	while($row = $database->fetchArray($resultSet)){
	// 		$objectArray[] = self::instantiate($row);
	// 	}
	// 	return $objectArray;
	// }		
	// private static function instantiate($record){// 2/2 06 07 chapter
	// 	$className = get_called_class();
	// 	$object = new $className; 
	// 	// $object->id         =$record['id'];
	// 	// $object->username   =$record['username'];
	// 	// $object->password   =$record['password'];
	// 	// $object->firstName  =$record['first_name'];
	// 	// $object->lastName   =$record['last_name'];
		
	// 	foreach($record as $attribute => $value){
	// 		if($object->has_attribute($attribute)){
	// 			$object->$attribute = $value;
	// 		}
	// 	}
	// 	return $object;
	// }
	// private function has_attribute($attribute){
	// 	//get_object_vars returns an associative array with all attributes
	// 	$object_vars = get_object_vars($this);
	// 	//we dont care about the values ,we just want to know is the key exists
	// 	//Will return true or false
	// 	return array_key_exists($attribute, $object_vars);
	// }
}
		