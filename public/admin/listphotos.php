<?php require_once("../../includes/initialize.php") ?>
<?php if(!$session->isLoggedIn()){redirectTo('login.php');}?>

<?php  // Find all photos
$photos = photograph::findphotosByUserId($session->userId);
?>

<?php includeLayoutTemplate('adminheader.php') ?>

<h2>Photographs</h2>

<?php echo outputMessage($message); ?>

<table class="bordered">
	<tr>
		<th>Image</th>
		<th>File Name</th>
		<th>Caption</th>
		<th>Size</th>
		<th>Type</th>
		<th>Comments</th>
		<th>&nbsp;</th>
	</tr>
	<?php foreach($photos as $photo): ?>
	<tr>
		<td><img src="../<?php echo $photo->imagePaath(); ?>" width="100"></td>
		<td><?php echo $photo->file_name; ?></td>
		<td><?php echo $photo->caption; ?></td>
		<td><?php echo $photo->sizeAsText(); ?></td>
		<td><?php echo $photo->type; ?></td>
		<td>
			<a href="comments.php?id=<?php echo $photo->id; ?>"><?php echo count($photo->comments()); ?></a>
		</td>
		<td><a href="deletphoto.php?id=<?php echo $photo->id; ?>">Delet</a></td>
	</tr>
<?php endforeach; ?>
</table>
<br>
<a href="photoupload.php">Upload a new photo</a>

<?php includeLayoutTemplate('adminfooter.php') ?>