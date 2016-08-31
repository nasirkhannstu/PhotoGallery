<?php require_once("../../includes/initialize.php") ?>
<?php if(!$session->isLoggedIn()){redirectTo('login.php');}?>
<?php 
	if (empty($_GET['id'])) {
		$session->message("No Photograph Id was not Provided");
		redirectTo('index.php');
	}
	$photo = photograph::findById($_GET['id']);
	if(!$photo){
		$session->message("The photo could not be located");
		redirectTo('index.php');
	}

	$comments = $photo->comments();
?>
<?php includeLayoutTemplate('adminheader.php') ?>

<a href="listphotos.php">&laquo; Back</a><br><br>

<h2>Comments on <?php echo $photo->file_name; ?></h2>

<div class="comments">

	<?php echo outputMessage($message); ?>

	<?php foreach ($comments as $comment): ?>
	<div class="comment">
		<div class="author">
			<?php echo htmlentities($comment->author); ?> wrote:
		</div>
		<div class="body">
			<?php echo strip_tags($comment->body); ?>
		</div>
		<div class="info">
			<?php echo datetimeToText($comment->created); ?>
		</div>
		<div class="action">
			<a href="deletcomment.php?id=<?php echo $comment->id; ?>">Delet</a>
		</div>
	</div>
	<?php endforeach; ?>
	<?php if(empty($comments)){echo "No Comments";} ?>
</div>

<?php includeLayoutTemplate('adminfooter.php') ?>