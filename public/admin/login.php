<?php require_once("../../includes/initialize.php") ?>
<?php if($session->isLoggedIn()){redirectTo('index.php');}?>

<?php 
	if(isset($_POST["submit"])){
		$userName = trim($_POST['username']);
		$password = trim($_POST['password']);

		$foundUser = user::authenticate($userName,$password);

		if($foundUser){
			$session->login($foundUser);
			logAction('login', "{$foundUser->username} logged in");
			redirectTo("index.php");
		}else{
			$message = "Username/Password combination incorrect.";
		}
	}else{
		$userName = "";
		$password = "";
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Photo Gallery</title>
	<link rel="stylesheet" type="text/css" href="../stylsheet/style.css">
</head>
<body>
	<div id="header">
		<h1>Photo Gallery</h1>
	</div>
	<div id="main">
		<h2>Staff Login</h2>
		<?php //echo outputMessage($message); ?>

		<form action="login.php" method="POST">
			<table>
				<tr>
					<td>Username:</td>
					<td><input type="text" name="username" maxlength="30" value="<?php echo htmlentities($userName); ?>"></td>
				</tr>
				<tr>
					<td>Password:</td>
					<td><input type="password" name="password" maxlength="30" value="<?php echo htmlentities($password); ?>"></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" name="submit" value="login"></td>
				</tr>
			</table>
		</form>
	</div>
	<div id="footer">
		Copyright <?php echo date("Y",time()); ?>, Nasir khan
	</div>	
</body>
</html>
<?php if(isset($database)){$database->closeConnection();} ?>