<?php require_once("../includes/initialize.php") ?>
<?php if(!$session->isLoggedIn()){redirectTo('login.php');} ?>

<?php 
	if(empty($_GET['id'])){
		$session->message("No Photograph id was provided");
		redirectTo('index.php');
	}
	$photo = Photograph::findById($_GET['id']);
	if(!$photo){
		$session->message("The photo could not be located");
		redirectTo('index.php');
	}
	if(isset($_POST['submit'])){
		$author = trim($_POST['author']);
		$body = trim($_POST['body']);
		$newCommewnt = comment::make($photo->id, $author, $body);
		if($newCommewnt && $newCommewnt->save()){
			redirectTo("photo.php?id={$photo->id}");
		}else{
			$message = "There was an error that prevenred the comment from being saved";
		}
	}else{
		$author = "";
		$body = "";
	}

	// Comment listing.  Upore korle processing tiime beshi lagbe for redirect
	$comments = $photo->comments();

?>
<?php includeLayoutTemplate('header.php') ?>
	<a href="index.php">&laquo; Back</a><br><br>
	<div class="indvphoto">
		<img src="<?php echo $photo->imagePaath(); ?>">
		<p><?php echo $photo->caption; ?></p>
	</div>

	<!--List Comment -->
	<div class="comments">
	<?php foreach($comments as $comment): ?>
		<div class="comment">
			<div class="author">
				<?php echo $comment->id; ?>
			</div>
			<div class="author">
				<?php echo $comment->author; ?> wrote:
			</div>
			<div class="body">
				<?php echo $comment->body; ?>
			</div>
			<div class="info">
				<?php echo datetimeToText($comment->created); ?>
			</div>
		</div>
	<?php endforeach; ?>
	<?php if(empty($comments)){echo "No Comments";} ?>
	</div>

	<!-- Comment Form -->
	<div class="commentform">
		<h3>New Comment</h3>
		<?php echo outputMessage($message); ?>

		<form action="photo.php?id=<?php echo $photo->id; ?>" method="POST">
			<table>
				<tr>
					<td>Your Name</td>
					<td><input type="text" name="author" value="<?php echo $author; ?>"></td>
				</tr>
				<tr>
					<td>Your Comment</td>
					<td><textarea name="body" cols="40" rows="8" value="<?php echo $body; ?>"></textarea></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><input type="submit" name="submit" value="Submit Comment"></td>
				</tr>
			</table>
		</form>
	</div>
<?php includeLayoutTemplate('footer.php') ?>