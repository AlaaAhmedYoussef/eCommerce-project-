<?php 
	ob_start();
	session_start();
	$pageTitle = 'Show Items';
	include "init.php";

	//check if Get request item is numerical & get its integer value
	$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

	$stmt = $conn->prepare("SELECT items.*, users.Username, categories.Name As category_name  FROM items 
		INNER JOIN users ON users.UserID = items.Member_ID
		INNER JOIN categories ON categories.ID = items.Cat_ID WHERE Item_ID = ?");
	$stmt->execute(array($itemid));
	$count = $stmt->rowCount();
	if ($count > 0) {
		$item = $stmt->fetch();
?>
<h1 class="text-center"><?php echo $item['Name'] ?></h1>
<div class="container">
	<div class="row">
		<div class="col-md-3">
			<img class="img-responsive img-thumbnail center-block" src="img.png" alt="" />
		</div>
		<div class="col-md-9 item-info">
			<h2><?php echo $item['Name'] ?></h2>
			<p><?php echo $item['Description'] ?></p>
			<ul class="list-unstyled">
				<li>
					<i class="fa fa-calendar fa-fw"></i>
					<span>Added Date</span> : <?php echo $item['Add_Date'] ?>
				</li>
				<li>
					<i class="fa fa-money fa-fw"></i>
					<span>Price</span> : <?php echo $item['Price'] ?>
				</li>
				<li>
					<i class="fa fa-building fa-fw"></i>
					<span>Made In</span> : <?php echo $item['Country_Made'] ?>
				</li>
				<li>
					<i class="fa fa-tags fa-fw"></i>
					<span>Category</span> : <a href="categories.php?pageid=<?php echo $item['Cat_ID'] ?>"><?php echo $item['category_name'] ?></a>
				</li>
				<li>
					<i class="fa fa-user fa-fw"></i>
					<span>Added By</span> : <a href="#"><?php echo $item['Username'] ?></a>
				</li>
				<li class="tags-items">
					<i class="fa fa-user fa-fw"></i>
					<span>Tags</span> : 
					<!-- <?php 
						$allTags = explode(",", $item['tags']);
						foreach ($allTags as $tag) {
							$tag = str_replace(' ', '', $tag);
							$lowertag = strtolower($tag);
							if (! empty($tag)) {
								echo "<a href='tags.php?name={$lowertag}'>" . $tag . '</a>';
							}
						}
					?> -->
				</li>
			</ul>
		</div>
	</div>
	<hr class="custom-hr">
	<?php if(isset($_SESSION['user']))  {  ?>
	<!-- Start Add Comment -->
	<div class="row">
		<div class="col-md-offset-3">
			<div class="add-comment">
				<h3>Add Your Comment</h3>
				<form>
					<textarea></textarea>
					<input class="btn btn-primary" type="submit" value="Add Comment">
				</form>
			</div>
		</div>
	</div>
	<!-- End Add Comment -->
	<?php } else { 

		echo '<a href="login.php">Login</a> or <a href="login.php">Register</a> to add comment';
	} ?>
	<hr class="custom-hr">
	<div class="row">
		<div class="col-md-3">
			User Image
		</div>
		<div class="col-md-9">
			User Comment
		</div>
	</div>
</div>	

<?php  
	} else {
		echo "There's no such ID";
	}
 	include $tpl . 'footer.php'; 
	ob_end_flush();
?>