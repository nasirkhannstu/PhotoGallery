<?php require_once("../../includes/initialize.php") ?>
<?php if(!$session->isLoggedIn()){redirectTo('login.php');} ?>

<?php 
	if(empty($_GET['id'])){
		$session->message("No Photograph id was provided");
		redirectTo('index.php');
	}

	$photo = photograph::findById($_GET['id']);
	if($photo && $photo->destroy()){
		$session->message("The photo {$photo->file_name} was deleted");
		redirectTo('listphotos.php');
	}else{
		$session->message("The photo could not be deleted");
		redirectTo('listphotos.php');
	}
?>
<?php if(isset($database)){$database->closeConnection(); } ?>