<?php require_once("../../includes/initialize.php") ?>
<?php if(!$session->isLoggedIn()){redirectTo('login.php');}?>

<?php includeLayoutTemplate('adminheader.php') ?>
<div id="main">
	<h2>Menu</h2>
	<?php echo outputMessage($message); ?>
	<ul>
		<li><a href="listphotos.php">Lists Photos</a></li>
		<li><a href="logfile.php"> View Log File</a></li>
		<li><a href="logout.php"> Logout</a></li>
	</ul>
</div>
<?php includeLayoutTemplate('adminfooter.php') ?>
