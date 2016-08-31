<?php require_once("../../includes/initialize.php") ?>
<?php if(!$session->isLoggedIn()){redirectTo('login.php');}?>

<?php 

	if(!file_exists('../images')){
	  //mkdir() : Making new directory
	  mkdir('../images',0777); // 0777 is php deafult
	  }
	$maxfilesize = 1048576; // 10120 = 10kb, 102400 = 100kb, 1048576 = 1mb

	if(isset($_POST['submit'])){
		$photo = new photograph();
		$photo->caption = $_POST['caption'];
		$photo->userid = $session->userId;
		$photo->location = $_POST['location'];
		$photo->device = $_POST['device'];
		$photo->tags = $_POST['tags'];
		$photo->like = 0;
		$photo->date = strftime("%Y-%m-%d %H:%M:%S", time());
		$photo->attachFile($_FILES['fileUpload']);
		if($photo->save()){
			$session->message("Photograph upload success fully");
			redirectTo('listphotos.php');
		}else{
			$message = join("<br>",$photo->errors);
		}
	}
?>
<?php includeLayoutTemplate('adminheader.php') ?>

	<h2>Photo Upload</h2>
	<?php echo outputMessage($message); ?>

	<form action="photoupload.php" method="POST" enctype="multipart/form-data">
	  <input type="hidden" name="maxfilesize" value="<?php echo $maxfilesize; ?>">
	  <p><input type="file" name="fileUpload"></p>
	  <p>Caption: <input type="text" name="caption"></p>
	  <p>Location: <input type="text" name="location"></p>
	  <p>Device: <input type="text" name="device"></p>
	  <p>Tags: <input type="text" name="tags"></p>
	  <input type="submit" value="Upload" name="submit">
	</form>

<?php includeLayoutTemplate('adminfooter.php'); ?>
