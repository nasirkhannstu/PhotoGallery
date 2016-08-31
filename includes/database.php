<?php require_once("initialize.php") ?>
<?php 
	require_once(LIB_PATH.DS."constant.php");

	class MySQLDatabase{
		private $link;
		public $lastQuery;
		private $magicQuotesActive;
		private $realEscapeStringExists;

		function __construct(){//WHENEVER the object MySQLDatabase is called CONSTRUCT "runs"
			$this->openConection();
			$this->magicQuotesActive = get_magic_quotes_gpc();
			$this->realEscapeStringExists = function_exists("mysql_real_escape_string");
		}
		public function openConection(){
			$this->link = mysql_connect(DB_SERVER,DB_USER,DB_PASS);
			if(!$this->link){
			  die('Could not connect to server');
			}else{
				$db = mysql_select_db(DB_NAME);
				if(!$db){
				  die('Could not connect to Database');
				}
			}
		}// 2/1
		public function closeConnection(){
			if(isset($this->link)){
				mysql_close($this->link);
				unset($link);
			}
		}
		public function query($sql){
			$this->lastQuery = $sql;
			$result = mysql_query($sql); //  2/2
			$this->confirmQuery($result);
			return $result;
		}
		public function escapeValue($value){
			if($this->realEscapeStringExists){ //php v4.3.0 or higher
				if($this->magicQuotesActive){$value = stripslashes($value);}
				$value = mysql_real_escape_string($value);
				$value = strip_tags($value);
				$value = htmlentities($value);
			}else{
				if(!$this->magicQuotesActive){
					$value = addslashes($value);
					$value = strip_tags($value);
					$value = htmlentities($value);
				}// If magic quotes are active, then the slashes are already exists.
			}
			return $value;
		}
		public function fetchArray($result_set){
			return mysql_fetch_array($result_set);
		}
		public function numRows($result_set){
			return mysql_num_rows($result_set);
		}
		public function insertId(){
			return mysql_insert_id($this->link);
		}
		public function affectedRows(){
			return mysql_affected_rows($this->link);
		}
		private function confirmQuery($result){
			if(!$result){
				$output = "Database query failed:".mysql_error()."<br><br>";
				$output .= "Last sql query: ".$this->lastQuery;
				die($output);
			}
		}

	}
	$database = new MySQLDatabase();
?>