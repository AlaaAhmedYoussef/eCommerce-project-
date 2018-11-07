<?php 
ob_start();
session_start();
$pageTitle = 'Create New Item';
include "init.php";
if (isset($_SESSION['user']))  {
?>
	<h1 class="text-center"><?php echo $pageTitle; ?></h1>
	<div class="create-ad block">
		<div class="container">
			<div class="panel panel-primary">
				<div class="panel-heading"><?php echo $pageTitle; ?></div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-8">

							<form class="form-horizontal" method="POST" action="?do=Insert" > 
						
					
						 		<!-- Start name field-->
						 		<div class="form-group form-group-lg">
						 			<label class="col-sm-2 control-label">Name</label>
						 			<div class="col-sm-10 col-md-9">
						 				<input type="text" name="name" class="form-control live-name"  required= "required" placeholder="Name of the Item" data-class=".live-title">
						 			</div>	
						 		</div>
						 		<!-- End name field-->
						 		<!-- Start Description field-->
						 		<div class="form-group form-group-lg">
						 			<label class="col-sm-2 control-label">Description</label>
						 			<div class="col-sm-10 col-md-9">
						 				<input type="text" name="description" class="form-control live-desc"   required= "required" placeholder="Description of the Item" data-class=".live-desc">
						 			</div>	
						 		</div>
						 		<!-- End Description field-->	
							 	<!-- Start Price field-->
						 		<div class="form-group form-group-lg">
						 			<label class="col-sm-2 control-label">Price</label>
						 			<div class="col-sm-10 col-md-9">
						 				<input type="text" name="price" class="form-control live-price"  required= "required" placeholder="Price of the Item" data-class=".live-price">
						 			</div>	
						 		</div>
						 		<!-- End Price field-->
						 		<!-- Start Country field-->
						 		<div class="form-group form-group-lg">
						 			<label class="col-sm-2 control-label">Country</label>
						 			<div class="col-sm-10 col-md-9">
						 				<input type="text" name="country" class="form-control"  required= "required" placeholder="Country of the made">
						 			</div>	
						 		</div>
						 		<!-- End Country field-->
						 		<!-- Start Status field-->
						 		<div class="form-group form-group-lg">
						 			<label class="col-sm-2 control-label">Status</label>
						 			<div class="col-sm-10 col-md-9">
						 				<select  name="status">
						 					<option value="0">...</option>
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
						 			<label class="col-sm-2 control-label">Category</label>
						 			<div class="col-sm-10 col-md-9">
						 				<select  name="category">
						 					<option value="0">...</option>
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
						 			<div class="col-sm-offset-2 col-sm-10">
						 				<input type="submit" value="Add Item" class="btn btn-primary btn-sm">
						 			</div>	
						 		</div>
						 		<!-- End submit field-->

				 			</form>
						</div>
						<div class="col-md-4">
							<div class="thumbnail item-box live-preview">
								<span class="price-tag live-price">$0</span>
								<img class="img-responsive" src="img.png" alt="" />
								<div class="caption">
									<h3 class="live-title">Title</h3>
									<p class="live-desc">Description</p>
								<!-- <div class="date">' . $item['Add_Date'] . '</div> -->
								</div>
							</div>
						</div>
					</div>
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