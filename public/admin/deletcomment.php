<?php require_once("../../includes/initialize.php") ?>
<?php if(!$session->isLoggedIn()){redirectTo('login.php');} ?>

<?php 
	if(empty($_GET['id'])){
		$session->message("No Comment id was provided");
		redirectTo('index.php');
	}

	$comment = comment::findById($_GET['id']);
	if($comment && $comment->delet()){
		$session->message("The Comment was deleted");
		redirectTo("comments.php?id={$comment->photoid}");
	}else{
		$session->message("The Comment could not be deleted");
		redirectTo('listphotos.php');
	}
?>
<?php if(isset($database)){$database->closeConnection(); } ?>