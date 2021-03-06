<?php require_once("../../includes/initialize.php"); ?>
<?php if(!$session->isLoggedIn()){redirectTo('login.php');}?>

<?php 
	$logfile = SITE_ROOT.DS.'logs'.DS.'log.txt';

	if(isset($_GET['clear'])){
	if($_GET['clear'] == true){
		file_put_contents($logfile, '');
		//add the first log entry
		logAction('Logs Cleared', "by User id {$session->userId}");
		//redirect to  this same page so that the url won't
		//have "clear = true"
		redirectTo('logfile.php');
	}}
?>
<?php includeLayoutTemplate('adminheader.php') ?>

<a href="index.php">&laquo; Back</a><br><br>
<h2>Log File</h2>
<p><a href="logfile.php?clear=true">Clear log file</a></p>
<?php 
	if(file_exists($logfile) && is_readable($logfile) && $handle = fopen($logfile, 'r')){
		echo "<ul class='logentries'>";
		while(!feof($handle)){
			$entry = fgets($handle);
			if(trim($entry) != ""){
				echo "<li>{$entry}</li>";
			}
		}
		echo "</ul>";
		fclose($handle);
	}else{
		echo "Could not read from {$logfile}";
	}
?>
<?php includeLayoutTemplate('adminfooter.php') ?>
