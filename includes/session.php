<?php ob_start() ?>
<?php
class session{
	private $loggedIn = false;
	public $userId;
	public $message;

	function __construct(){
		session_start();

		$this->checkLogin();

		$this->checkMessage();

		if($this->loggedIn){
			//Action to take right away if user is logged in
		}else{
			//Action to take right away if user is not logged in
		}
	}
	public function isLoggedIn(){
		return $this->loggedIn;
	}
	public function login($user){

		if($user){
			$this->userId = $_SESSION['userId'] = $user->id;
			$this->loggedIn = true;
		}
	}
	public function logout(){
		unset($_SESSION['userId']);
		unset($this->userId);
		$this->loggedIn = false;
		return true;
	}
	public function message($msg=""){
		if(!empty($msg)){
			$_SESSION['message'] = $msg;
		}else{
			return $this->message;
		}
	}
	private function checkLogin(){
		if(isset($_SESSION['userId'])){
			$this->userId = $_SESSION['userId'];
			$this->loggedIn = true;
		}else{
			unset($this->userId);
			$this->loggedIn = false;
		}
	}
	private function checkMessage(){
		// Is there a message stored in the session
		if(isset($_SESSION['message'])){
			$this->message = $_SESSION['message'];
			unset($_SESSION['message']);
		}else{
			$this->message = "";
		}
	}
}
$session = new session();
$message = $session->message();
?>