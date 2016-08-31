<?php require_once("../includes/initialize.php") ?>
<?php require_once("../includes/createTable.php") ?>
<?php if(!$session->isLoggedIn()){redirectTo('admin/login.php');}?>

<?php 
	// The current oage number
	$page = !empty($_GET['page'])? (int)$_GET['page'] : 1;

	// Records per page
	$perPage = 3;

	//Total record count
	$totalCount = photograph::countAll();
?>

<?php 
	// Find all Photos
	// $photos = photograph::findAll();// Paginating(Use pagination instead)

	// Find all Photos using pagination
	$pagination = new pagination($page, $perPage, $totalCount);

	$sql = "SELECT * FROM photos ";
	$sql .= "LIMIT {$perPage} ";
	$sql .= "OFFSET {$pagination->offset()}";

	$photos = photograph::findBySql($sql);
?>

<?php includeLayoutTemplate('header.php') ?>

<?php foreach($photos as $photo): ?>
	<div class="showphoto" style="float:left;margin-left:20px">
		<a href="photo.php?id=<?php echo $photo->id; ?>">
			<img src="<?php echo $photo->imagePaath(); ?>" style="height:200px">
		</a>
		<p><?php echo $photo->caption; ?></p>
		<p><?php echo $photo->likes; ?></p>
	</div>
<?php endforeach; ?>

<div class="pagination">
<?php 
	photograph::countAll();
	if ($pagination->totalPage() > 1) {
		if($pagination->hasPreviousPage()){
			echo "<a href=\"index.php?page=";
			echo $pagination->previousPage();
			echo "\"> &laquo; Previous ";
		}
		for ($i=1; $i <=$pagination->totalPage() ; $i++) { 
			if($i == $page){
				echo "<span class=\"selected\">{$i}</span>";
			}else{
				echo "<a href=\"index.php?page={$i}\">{$i}</a>";
			}
		}
		if($pagination->hasNextPage()){
			echo "<a href=\"index.php?page=";
			echo $pagination->nextPage();
			echo "\"> Next &raquo; ";
		}
	}
?>
</div>

<?php includeLayoutTemplate('footer.php') ?>