<?php ob_start() ?>
<?php require_once("../../includes/initialize.php") ?>
<?php if(!$session->isLoggedIn()){redirectTo('login.php');}?>

<?php
$logout = $session->logout();
header('location: login.php');
?>

<?php if(isset($database)){$database->closeConnection();} ?>