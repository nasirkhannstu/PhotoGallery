<?php require_once(LIB_PATH.DS."database.php"); ?>
<?php 
	class photograph extends databaseObject {
		protected static $tableName = "photos";
		protected static $dbFields = array('id','userid','file_name','type','size','caption','location','device','likes','tags','date');
		public $id;
		public $userid;
		public $file_name;
		public $type;
		public $size;
		public $caption;
		public $location;
		public $device;
		public $likes;
		public $tags;
		public $date;

		private $tempPath;
		protected $uploadDir = "images";
		public $errors = array(); 
		protected $uploadErrors = array(
	      UPLOAD_ERR_OK => "No errors",
	      UPLOAD_ERR_INI_SIZE => "Larger than from UPLOAD_MAX_FILESIZE",
	      UPLOAD_ERR_FORM_SIZE => "Larger than FORM_MAX_FILESIZE",
	      UPLOAD_ERR_PARTIAL => "Partial upload",
	      UPLOAD_ERR_NO_FILE => "No file",
	      UPLOAD_ERR_CANT_WRITE => "Cant write to disk",
	      UPLOAD_ERR_EXTENSION => "File upload stopped by extension"
	    );

		// Pss in $_FILE(['uploaded file']) as an argument
		public function attachFile($file){
			// PErform error chacking on the form parameter
			if(!$file || empty($file) || !is_array($file)){
				$this->errors[] = "No file was uploaded";
				return false;
			}elseif($file['error'] != 0){
				$this->errors[] = $this->uploadErrors[$file['error']];
				return false;
			}else{
				// Set object attribute to the form parameter
				$this->tempPath = $file['tmp_name'];
				$this->file_name = basename($file['name']);
				$this->type = $file['type'];
				$this->size = $file['size'];
				return true;
			}
		}
		public function save(){
			// A new record wont have an id yet.
			if(isset($this->id)){
				$this->update();
			}else{
				//make sure there is no errors
				//Cant save if there are pre existing errors
				if(!empty($this->errors)) { return false; }
				//Make sure the caption is not too large for the DB
				if(strlen($this->caption) > 225){
					$this->errors[] = "The caption can only be 255 charecters long";
					return false;
				}
				// Cant save without filename and temp location
				if(empty($this->file_name) || empty($this->tempPath)){
					$this->error[] = "The file location is not available";
					return false;
				}
				// Determine the target path
				$targetPath = SITE_ROOT.DS. 'public' .DS. $this->uploadDir .DS.$this->file_name;
				//echo $targetPath = "../public/images/".$this->filename;

				// MAke sure a file dosent already exist in the target location
				if(file_exists($targetPath)){
					$this->errors[] = "The file {$this->file_name} already exists.";
					return false;
				}
				//Attempt to move the file
				if(move_uploaded_file($this->tempPath, $targetPath)){
					//success
					//Save a corresponding entry tothe database
					if($this->create()){
						unset($this->tempPath);
						return true;
					}
				}else{
					$this->errors[] = "The file upload failed, possibly due to incorrect permission on the upload folder";
					return false;
				}
			}
		}
		public function destroy(){
			if($this->delet()){
				$targetPath = SITE_ROOT.DS.'public'.DS.$this->imagePaath();
				return unlink($targetPath)? true : false ;
			}else{
				return false;
			}
		}
		public function imagePaath(){
			return $this->uploadDir.'/'.$this->file_name;
		}
		public function sizeAsText(){
			if($this->size < 1024){
				return "{$this->size} bytes";
			}elseif($this->size < 1048576){
				$sizeKb = round($this->size/1024);
				return "{$sizeKb} kb";
			}else{
				$sizeKb = round($this->size < 1048576, 1);
				return "{$sizeKb} MB";
			}
		}
		public function comments(){
			return comment::findCommentsOn($this->id);
		}
		public 	static function findphotosByUserId($id=0){
			global $database;
			return self::findBySql("SELECT * FROM ".self::$tableName." WHERE userid=".$database->escapeValue($id));
		}




		// Common database methods

		public 	static function findAll(){
			//global $database;
			// $resultSet = $database->query("SELECT * FROM users");
			// return $resultSet;
			return self::findBySql("SELECT * FROM ".self::$tableName);
		}
		public static function findById($id=0){
			global $database;
			$resultArray = self::findBySql("SELECT * FROM ".self::$tableName." WHERE id=".$database->escapeValue($id)." LIMIT 1");
			return !empty($resultArray) ? array_shift($resultArray) : false;
		}
		public static function findBySql($sql=""){
			global $database;
			$resultSet = $database->query($sql);
			$objectArray = array();
			while($row = $database->fetchArray($resultSet)){
				$objectArray[] = self::instantiate($row);
			}
			return $objectArray;
		}
		// returns a symple number but findAll() returns massive data
		public static function countAll(){
			global $database;
			$sql = "SELECT COUNT(*) FROM ".self::$tableName;
			$resultSet = $database->query($sql);
			$row = $database->fetchArray($resultSet);
			return array_shift($row);
		}
		private static function instantiate($record){// 2/2 06 07 chapter
			$object = new self(); 
			// $object->id         =$record['id'];
			// $object->username   =$record['username'];
			// $object->password   =$record['password'];
			// $object->firstName  =$record['first_name'];
			// $object->lastName   =$record['last_name'];
			
			foreach($record as $attribute => $value){
				if($object->has_attribute($attribute)){
					$object->$attribute = $value;
				}
			}
			return $object;
		}
		private function has_attribute($attribute){
			//get_object_vars returns an associative array with all attributes
			$object_vars = $this->attributes();
			//we dont care about the values ,we just want to know is the key exists
			//Will return true or false
			return array_key_exists($attribute, $object_vars);
		}
		protected function attributes(){
			// return an array of attribute keyes and their values
			//return get_object_vars($this);
			$attributes = array();
			foreach(self::$dbFields as $field){
				if(property_exists($this, $field)){
					$attributes[$field] = $this->$field;
				}
			}
			return $attributes;
		}
		protected function sanatizedAttributes(){
			global $database;
			$cleanAttributes = array();
			foreach($this->attributes() as $key => $values){
				$cleanAttributes[$key] = $database->escapeValue($values);
			}
			return $cleanAttributes;
		}
		//  Replaced with a custom save()
		// public function save(){
		// 	// A new record won't have an id.
		// 	return isset($this->id) ? $this->update() : $this->create();
		// 	// create and  update protected
		// }
		public function create(){
			global $database;
			$attributes = $this->sanatizedAttributes();
			$sql = "INSERT INTO ".self::$tableName." (";
			$sql .= join(", ", array_keys($attributes));
			$sql .= ") VALUES('";
			$sql .= join("', '", array_values($attributes));
			$sql .= "')";
			
			if($database->query($sql)){
				$this->id = $database->insertId();
				return true;
			}else{
				return true;
			}
		}
		public function update(){
			global $database;
			$attributes = $this->sanatizedAttributes();
			$attribute_pairs = array();
			foreach($attributes as $key => $value){
				$attribute_pairs[] = "{$key}='$value'";
			}
			$sql = "UPDATE ".self::$tableName." SET ";
			$sql .=join(", ", $attribute_pairs);
			$sql .=" WHERE id=".$database->escapeValue($this->id);
			$database->query($sql);
			return ($database->affectedRows()==1) ? true :false;
		}
		public function delet(){
			global $database;
			$sql = "DELETE FROM ".self::$tableName;
			$sql .= " WHERE id=".$database->escapeValue($this->id);
			$sql .= " LIMIT 1";
			$database->query($sql);
			return ($database->affectedRows()==1) ? true : false;
		}
	}
?>