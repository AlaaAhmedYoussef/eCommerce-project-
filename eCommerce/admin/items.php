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
				


				// get all data from items DB to use it 

				$stmt = $conn->prepare("SELECT items.*, 
					categories.Name AS category_name, users.Username FROM items

				INNER JOIN categories ON categories.ID = items.Cat_ID

				INNER JOIN users ON users.UserID = items.Member_ID"); 

				 $stmt->execute();

				 $items = $stmt->fetchAll();

				?> 
			
				<div class="container">

				 	<h1 class="text-center" >Manage Items</h1>
					<div class="table-reponsive">
						<table class="main-table text-center table table-bordered">
							<tr>
								<td>#ID</td>
								<td>Name</td>
								<td>Description</td>
								<td>Price</td>
								<td>Adding Date</td>
								<td>Category</td>
								<td>Username</td>
								<td>Control</td>
							</tr>

							<?php 
								foreach ($items as $item) {
									echo "<tr>";
										echo "<td>" .  $item['Item_ID'] . "</td>";
										echo "<td>" .  $item['Name'] . "</td>";
										echo "<td>" .  $item['Description'] . "</td>";
										echo "<td>" .  $item['Price'] . "</td>";
										echo "<td>" .  $item['Add_Date']  . "</td>";
										echo "<td>" .  $item['category_name']  . "</td>";
										echo "<td>" .  $item['Username']  . "</td>";
										echo "<td>
											<a href='items.php?do=Edit&itemid=" . $item['Item_ID'] . " ' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a> 
										 	<a href='items.php?do=Delete&itemid=" . $item['Item_ID'] . " ' class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";

										 	if($item['Approve'] == 0)  {

										 	echo "<a href='items.php?do=Approve&itemid=" . $item['Item_ID'] . " ' 
										 	class='btn btn-info activate'>
										 	<i class='fa fa-check'></i> Approve</a>";

										     	}

										echo  "</td>";
										 	
									echo "</tr>";	
								}
								
							 ?>
							

							
						</table>
					</div>
					
		
					<a href='items.php?do=Add' class="btn btn-primary btn-sm"> <i class="fa fa-plus"></i> New Item</a>
				</div>

<?php  		} elseif ($do == 'Add') {  //Add members page ?>

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


 
<?php 			} elseif ($do == 'Insert') {  // for insert

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


			} elseif ($do == 'Edit') {  //edit items page 

				
				$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
				
				//check if Item_ID exist in DB

				$stmt = $conn->prepare("SELECT *  FROM  items  WHERE  Item_ID = ?");  //means 1 result .. no need for limit 1

				$stmt->execute(array($itemid));
				$item = $stmt->fetch();   //to get data from DB and put it in $item which is an array 
				$count = $stmt->rowCount();

				
				
				if ($count > 0 ) {  

					
				?>
				
				
				 
				 <div class="container">
				 	<h1 class="text-center" >Edit Items</h1>
				 	<form class="form-horizontal" method="POST" action="?do=Update" > 
			
						<!-- send also id -->
						<input type="hidden" name="itemid" value="<?php echo $itemid; ?>">

						<!-- Start name field-->
				 		<div class="form-group form-group-lg">
				 			<label class="col-sm-2 control-label">Name</label>
				 			<div class="col-sm-10 col-md-6">
				 				<input type="text" name="name" class="form-control"  required= "required" value="<?php echo $item['Name']; ?>" placeholder="Name of the Item">
				 			</div>	
				 		</div>
				 		<!-- End name field-->
				 		<!-- Start Description field-->
				 		<div class="form-group form-group-lg">
				 			<label class="col-sm-2 control-label">Description</label>
				 			<div class="col-sm-10 col-md-6">
				 				<input type="text" name="description" class="form-control"   value="<?php echo $item['Description']; ?>" required= "required" placeholder="Description of the Item">
				 			</div>	
				 		</div>
				 		<!-- End Description field-->	
					 	<!-- Start Price field-->
				 		<div class="form-group form-group-lg">
				 			<label class="col-sm-2 control-label">Price</label>
				 			<div class="col-sm-10 col-md-6">
				 				<input type="text" name="price" class="form-control"  required= "required" value="<?php echo $item['Price']; ?>" placeholder="Price of the Item">
				 			</div>	
				 		</div>
				 		<!-- End Price field-->
				 		<!-- Start Country field-->
				 		<div class="form-group form-group-lg">
				 			<label class="col-sm-2 control-label">Country</label>
				 			<div class="col-sm-10 col-md-6">
				 				<input type="text" name="country" class="form-control"  required= "required" value="<?php echo $item['Country_Made']; ?>" placeholder="Country of the made">
				 			</div>	
				 		</div>
				 		<!-- End Country field-->
				 		<!-- Start Status field-->
				 		<div class="form-group form-group-lg">
				 			<label class="col-sm-2 control-label">Status</label>
				 			<div class="col-sm-10 col-md-6">
				 				<select  name="status">
				 					<option value="1" <?php if ($item['Status'] == 1)  {  echo "selected";} ?> >New</option>
				 					<option value="2" <?php if ($item['Status'] == 2)  {  echo "selected";} ?> >Like New</option>
				 					<option value="3" <?php if ($item['Status'] == 3)  {  echo "selected";} ?> >Used</option>
				 					<option value="4" <?php if ($item['Status'] == 4)  {  echo "selected";} ?> >Very Old</option>
				 				</select>
				 			</div>	
				 		</div>
				 		<!-- End Status field-->
				 		<!-- Start Members field-->
				 		<div class="form-group form-group-lg">
				 			<label class="col-sm-2 control-label">Member</label>
				 			<div class="col-sm-10 col-md-6">
				 				<select  name="member">
				 					<?php 
				 						$Stmt = $conn->prepare("SELECT * FROM users");
										$Stmt->execute();
										$users = $Stmt->fetchAll();
										foreach ($users as $user) {
										echo "<option value=' " . $user['UserID'] . " ' "; 
										if ($item['Member_ID'] == $user['UserID'])  {  echo "selected";} 
										echo ">" . $user['Username'] . "</option>";
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
				 					<?php 
				 						$Stmt2 = $conn->prepare("SELECT * FROM categories");
										$Stmt2->execute();
										$categories = $Stmt2->fetchAll();
										foreach ($categories as $category) {
										echo "<option value=' " . $category['ID'] . " ' ";
										if ($item['Cat_ID'] == $category['ID'])  {  echo "selected";} 
										echo ">" . $category['Name'] . "</option>";
										}
				 					 ?>
				 				</select>
				 			</div>	
				 		</div>
				 		<!-- End Categories field-->				 		
				 		<!-- Start submit field-->
				 		<div class="form-group form-group-lg">
				 			<div class="col-sm-offset-2 col-sm-10">
				 				<input type="submit" value="Save" class="btn btn-primary btn-sm">
				 			</div>	
				 		</div>
				 		<!-- End submit field-->
	
				 	</form>
				 </div>
			<?php  
			// if this id not exist
				}  else {   // else for  "if cout > 0" 

				echo "<div class='container'>";

				$theMsg = "<div class='alert alert-danger'>There's No such ID</div>";

				redirectHome($theMsg);

				echo "</div>";
			}






			} // if it is " do Edit  page ''
			 elseif ($do == 'Update') {

			 	echo "<h1 class='text-center'> Update Categories </h1>";
			 	echo "<div class='container'>";

				 if ($_SERVER["REQUEST_METHOD"] == "POST") {

				 	$itemid = $_POST['itemid'];
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

					$stmt = $conn->prepare("UPDATE  items  
						SET  Name = ?, Description = ?, Price = ?, Country_Made = ?, Status = ?,  Cat_ID = ?, Member_ID = ? WHERE Item_ID = ? ");  

					$stmt->execute(array($name, $desc, $price, $country, $status, $cat, $member, $itemid));
							
					$theMsg = "<div class='alert alert-success'>" . $stmt-> rowCount() . " record is updated </div>";

					redirectHome($theMsg, 'back');

					}

				} else {

						
					$theMsg = "<div class='alert alert-danger'>you can't browser this page directly</div>" ; 

					redirectHome($theMsg, 'back');

						
				}

				echo "</div>";


			 	
			} elseif ($do == 'Delete') { //Delete member page

 				echo "<h1 class='text-center'> Deleted items </h1>";
			 	echo "<div class='container'>";

				 	$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
					
					
					// check if item ID exist in DB with the function

					$check = checkItem('Item_ID', 'items', $itemid); 

										
					// if the ID is exist 
					if ($check > 0 ) {  

						$stmt = $conn->prepare("DELETE FROM items WHERE Item_ID = :zitem"); 

						$stmt->bindParam(":zitem", $itemid);

						$stmt->execute();
							
						$theMsg = "<div class='alert alert-success'>" . $stmt-> rowCount() . " record is deleted </div>";

						redirectHome($theMsg, 'back');

				 	} else {

				 		$theMsg = "<div class='alert alert-danger'>This ID is not exist</div>";

				 		redirectHome($theMsg);
				 	}

			 	echo "</div>";
			 
			}  elseif ($do == 'Approve') { //for approve items
			 	
			 	echo "<h1 class='text-center'> Approved Item </h1>";
			 	echo "<div class='container'>";

			 		// check if get request for userid 

				 	$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
					
					
					// check if itemID exist in DB with the function

					$check = checkItem('Item_ID', 'items', $itemid); 

					
					// if the ID is exist 
					
					if ($check > 0 ) {  

						$stmt = $conn->prepare("UPDATE  items SET Approve = 1 WHERE Item_ID = ? ");  

						$stmt->execute(array($itemid));
							
						$theMsg = "<div class='alert alert-success'>" . $stmt-> rowCount() . " Record is Activated </div>";

						redirectHome($theMsg);

				 	} else {

				 		$theMsg = "<div class='alert alert-danger'>This ID is not exist</div>";

				 		redirectHome($theMsg);
				 	}

			 	echo "</div>";	

			}
			
			include $tpl . 'footer.php'; 

		} else {
			

			header('Location: index.php'); 

			exit();
		}


	ob_end_flush();  // Release the output
 ?>
