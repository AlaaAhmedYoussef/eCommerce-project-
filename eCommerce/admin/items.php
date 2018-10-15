<?php 

/*
   items page
*/
   	ob_start();   // Output buffering start .. wait for header to be sent first 

	session_start();
	
	$pageTitle ='Items';

		if (isset($_SESSION['Username'])) {

			

			include 'init.php';

			//here all things go 

			$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';


			//start manage page 

			if ($do == 'Manage'){ // for manage page
				echo "string";

			} elseif ($do == 'Add') {  //Add members page ?>

				 <div class="container">
				 	<h1 class="text-center" >Add New Item</h1>
				 	<form class="form-horizontal" method="POST" action="?do=Insert" > 
						
					
				 		<!-- Start name field-->
				 		<div class="form-group form-group-lg">
				 			<label class="col-sm-2 control-label">Name</label>
				 			<div class="col-sm-10 col-md-6">
				 				<input type="text" name="name" class="form-control"  required= "required" placeholder="Name of the Item">
				 			</div>	
				 		</div>
				 		<!-- End name field-->
				 		<!-- Start Description field-->
				 		<div class="form-group form-group-lg">
				 			<label class="col-sm-2 control-label">Description</label>
				 			<div class="col-sm-10 col-md-6">
				 				<input type="text" name="description" class="form-control"   required= "required" placeholder="Description of the Item">
				 			</div>	
				 		</div>
				 		<!-- End Description field-->	
					 	<!-- Start Price field-->
				 		<div class="form-group form-group-lg">
				 			<label class="col-sm-2 control-label">Price</label>
				 			<div class="col-sm-10 col-md-6">
				 				<input type="text" name="price" class="form-control"  required= "required" placeholder="Price of the Item">
				 			</div>	
				 		</div>
				 		<!-- End Price field-->
				 		<!-- Start Country field-->
				 		<div class="form-group form-group-lg">
				 			<label class="col-sm-2 control-label">Country</label>
				 			<div class="col-sm-10 col-md-6">
				 				<input type="text" name="country" class="form-control"  required= "required" placeholder="Country of the made">
				 			</div>	
				 		</div>
				 		<!-- End Country field-->
				 		<!-- Start Status field-->
				 		<div class="form-group form-group-lg">
				 			<label class="col-sm-2 control-label">Status</label>
				 			<div class="col-sm-10 col-md-6">
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
				 		<!-- Start Rating field-->
<!-- 				 		<div class="form-group form-group-lg">
				 			<label class="col-sm-2 control-label">Rating</label>
				 			<div class="col-sm-10 col-md-6">
				 				<select class="form-control" name="rating">
				 					<option value="0">...</option>
				 					<option value="1">*</option>
				 					<option value="2">**</option>
				 					<option value="3">***</option>
				 					<option value="4">****</option>
				 					<option value="5">*****</option>
				 				</select>
				 			</div>	
				 		</div> -->
				 		<!-- End Rating field-->
				 		<!-- Start Members field-->
				 		<div class="form-group form-group-lg">
				 			<label class="col-sm-2 control-label">Member</label>
				 			<div class="col-sm-10 col-md-6">
				 				<select  name="member">
				 					<option value="0">...</option>
				 					<?php 
				 						$Stmt = $conn->prepare("SELECT * FROM users");
										$Stmt->execute();
										$users = $Stmt->fetchAll();
										foreach ($users as $user) {
										echo "<option value=' " . $user['UserID'] . " '>" . $user['Username'] . "</option>";
										}
				 					 ?>
				 				</select>
				 			</div>	
				 		</div>
				 		<!-- End Members field-->
				 		<!-- Start Categories field-->
				 		<div class="form-group form-group-lg">
				 			<label class="col-sm-2 control-label">Category</label>
				 			<div class="col-sm-10 col-md-6">
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


<?php  
			} elseif ($do == 'Insert') {  // for insert

				if ($_SERVER["REQUEST_METHOD"] == "POST") {

			 		echo "<h1 class='text-center'> Insert Items </h1>";
			 		echo "<div class='container'>";
				 		
				 	$name = $_POST['name'];	
				 	$desc = $_POST['description'];	
				 	$price = $_POST['price'];	
					$country = $_POST['country'];
					$status = $_POST['status'];	
					$member = $_POST['member'];
					$cat = $_POST['category'];

				 	$formErrors = array();

				 	if(empty($name))
				 	{
				 		$formErrors[] = "Name can't be <strong>empty</strong> ";
				  	}

					if(empty($desc))
				 	{
				 		$formErrors[] = "Description cant be <strong>empty</strong> ";
				 	}
				 	if(empty($price))
				 	{
				 		$formErrors[] = "Price cant be <strong>empty</strong> ";
				 	}

				 	if(empty($country))
				 	{
				 		$formErrors[] = "Country cant be <strong>empty</strong> ";
				 	}

					if($status == 0)
				 	{
				 		$formErrors[] = "you Must Choose the <strong>Status</strong> ";
				 	}

				 	if($member == 0)
				 	{
				 		$formErrors[] = "you Must Choose the <strong>Member</strong> ";
				 	}

				 	if($cat == 0)
				 	{
				 		$formErrors[] = "you Must Choose the <strong>Category</strong> ";
				 	}

				 	foreach ($formErrors as $error) {
				 		
				 		echo "<div class='alert alert-danger'>" . $error . "</div>";

				 	}
				 	



				 	// if there is no error insert to DB

				 	 if(empty($formErrors)) {

					 	 // insert the item in DB with this info
					 	 $stmt = $conn->prepare("INSERT INTO items (Name, Description, Price, Country_Made, Status, Add_Date, Cat_ID, Member_ID) 
					 	 		VALUES (:zname, :zdesc, :zprice, :zcountry, :zstatus, now(), :zcat, :zmember)"); 

					 	 $stmt->execute(array(
							 	
							 	'zname'     	=> 	$name,
							 	'zdesc' 		=> 	$desc, 
							 	'zprice'		=> 	$price, 
							 	'zcountry' 	=>	$country,
							 	'zstatus'	=>	$status,
							 	'zcat'		=>   	$cat,
							 	'zmember'	=>	$member
							 	
						));

					 	 $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " record is Inserted </div>";

					 	 redirectHome($theMsg, 'back');
					 }
				
	
				} else {

					echo "<div class='container'>";

					$theMsg = "<div class='alert alert-danger'> Sorry you can't browser this page directly </div>" ; 

					redirectHome($theMsg);

					echo "</div>";
				}

				echo "</div>";


			} elseif ($do == 'Edit') {  //edit member page 

				


			} // if it is " do Edit  page ''
			 elseif ($do == 'Update') {
			 	
			} elseif ($do == 'Delete') { //Delete member page

			 
			}  elseif ($do == 'Approve') { //for approve items
			 	
			 	

			}
			
			include $tpl . 'footer.php'; 

		} else {
			

			header('Location: index.php'); 

			exit();
		}


	ob_end_flush();  // Release the output
 ?>
