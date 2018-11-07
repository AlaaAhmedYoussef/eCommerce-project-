<?php 
ob_start();
session_start();
$pageTitle = 'Create New Item';
include "init.php";
if (isset($_SESSION['user']))  {
	// print_r($_SESSION);

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$formErrors = array();
			$name 		= filter_var($_POST['name'], FILTER_SANITIZE_STRING);
			$desc 		= filter_var($_POST['description'], FILTER_SANITIZE_STRING);
			$price 		= filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
			$country 	= filter_var($_POST['country'], FILTER_SANITIZE_STRING);
			$status 	= filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
			$category 	= filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
			// $tags 		= filter_var($_POST['tags'], FILTER_SANITIZE_STRING);
			if (strlen($name) < 4) {
				$formErrors[] = 'Item Title Must Be At Least 4 Characters';
			}
			if (strlen($desc) < 10) {
				$formErrors[] = 'Item Description Must Be At Least 10 Characters';
			}
			if (strlen($country) < 2) {
				$formErrors[] = 'Item Title Must Be At Least 2 Characters';
			}
			if (empty($price)) {
				$formErrors[] = 'Item Price Cant Be Empty';
			}
			if (empty($status)) {
				$formErrors[] = 'Item Status Cant Be Empty';
			}
			if (empty($category)) {
				$formErrors[] = 'Item Category Cant Be Empty';
			}
			// Check If There's No Error Proceed The Update Operation
			if (empty($formErrors)) {
				// Insert Userinfo In Database
				$stmt = $conn->prepare("INSERT INTO 
					items(Name, Description, Price, Country_Made, Status, Add_Date, Cat_ID, Member_ID)
					VALUES(:zname, :zdesc, :zprice, :zcountry, :zstatus, now(), :zcat, :zmember)");
				$stmt->execute(array(
					'zname' 	=> $name,
					'zdesc' 		=> $desc,
					'zprice' 	=> $price,
					'zcountry' 	=> $country,
					'zstatus' 	=> $status,
					'zcat'		=> $category,
					'zmember'	=> $_SESSION['uid']
					// ,
					// 'ztags'		=> $tags
				));
				// Echo Success Message
				if ($stmt) {
					$succesMsg = 'Item Has Been Added';
					
				}
			}
	}

?>
	<h1 class="text-center"><?php echo $pageTitle; ?></h1>
	<div class="create-ad block">
		<div class="container">
			<div class="panel panel-primary">
				<div class="panel-heading"><?php echo $pageTitle; ?></div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-8">

							<form class="form-horizontal main-form" method="POST" action="?do=Insert" > 
						
					
						 		<!-- Start name field-->
						 		<div class="form-group form-group-lg">
						 			<label class="col-sm-3 control-label">Name</label>
						 			<div class="col-sm-10 col-md-9">
						 				<input type="text" name="name" class="form-control live"  required= "required" placeholder="Name of the Item" data-class=".live-title">
						 			</div>	
						 		</div>
						 		<!-- End name field-->
						 		<!-- Start Description field-->
						 		<div class="form-group form-group-lg">
						 			<label class="col-sm-3 control-label">Description</label>
						 			<div class="col-sm-10 col-md-9">
						 				<input type="text" name="description" class="form-control live"   required= "required" placeholder="Description of the Item" data-class=".live-desc">
						 			</div>	
						 		</div>
						 		<!-- End Description field-->	
							 	<!-- Start Price field-->
						 		<div class="form-group form-group-lg">
						 			<label class="col-sm-3 control-label">Price</label>
						 			<div class="col-sm-10 col-md-9">
						 				<input type="text" name="price" class="form-control live"  required= "required" placeholder="Price of the Item" data-class=".live-price">
						 			</div>	
						 		</div>
						 		<!-- End Price field-->
						 		<!-- Start Country field-->
						 		<div class="form-group form-group-lg">
						 			<label class="col-sm-3 control-label">Country</label>
						 			<div class="col-sm-10 col-md-9">
						 				<input type="text" name="country" class="form-control"  required= "required" placeholder="Country of the made">
						 			</div>	
						 		</div>
						 		<!-- End Country field-->
						 		<!-- Start Status field-->
						 		<div class="form-group form-group-lg">
						 			<label class="col-sm-3 control-label">Status</label>
						 			<div class="col-sm-10 col-md-9">
						 				<select  name="status">
						 					<option value="">...</option>
											<option value="1">New</option>
						 					<option value="2">Like New</option>
						 					<option value="3">Used</option>
						 					<option value="4">Very Old</option>
						 				</select>
						 			</div>	
						 		</div>
						 		<!-- End Status field-->
						 		<!-- Start Categories field-->
						 		<div class="form-group form-group-lg">
						 			<label class="col-sm-3 control-label">Category</label>
						 			<div class="col-sm-10 col-md-9">
						 				<select  name="category">
						 					<option value="">...</option>
						 					<?php 
						 						$Stmt2 = $conn->prepare("SELECT * FROM categories");
												$Stmt2->execute();
												$categories = $Stmt2->fetchAll();
												foreach ($categories as $category) {
												echo "<option value=' " . $category['ID'] . " '>" . $category['Name'] . "</option>";
												}
						 					 ?>
						 				</select>
						 			</div>	
						 		</div>
						 		<!-- End Categories field-->				 		
						 		<!-- Start submit field-->
						 		<div class="form-group form-group-lg">
						 			<div class="col-sm-offset-3 col-sm-10">
						 				<input type="submit" value="Add Item" class="btn btn-primary btn-sm">
						 			</div>	
						 		</div>
						 		<!-- End submit field-->

				 			</form>
						</div>
						<div class="col-md-4">
							<div class="thumbnail item-box live-preview">
								<span class="price-tag">
									$<span class="live-price">0</span>
								</span>
								<img class="img-responsive" src="img.png" alt="" />
								<div class="caption">
									<h3 class="live-title">Title</h3>
									<p class="live-desc">Description</p>
								<!-- <div class="date">' . $item['Add_Date'] . '</div> -->
								</div>
							</div>
						</div>
					</div>
					<!-- Start Loopiong Through Errors -->
				<?php 
					if (! empty($formErrors)) {
						foreach ($formErrors as $error) {
							echo '<div class="alert alert-danger">' . $error . '</div>';
						}
					}
					if (isset($succesMsg)) {
						echo '<div class="alert alert-success">' . $succesMsg . '</div>';
					}
				?>
				<!-- End Loopiong Through Errors -->
				</div>
			</div>
		</div>
	</div>

<?php  
 	include $tpl . 'footer.php'; 

 } else  {

 		header('Location: login.php');

 		exit();
 }

 ob_end_flush();
?>