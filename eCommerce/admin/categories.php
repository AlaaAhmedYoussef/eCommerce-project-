<?php 

/*
   Category page
*/
   	ob_start();   // Output buffering start .. wait for header to be sent first 

	session_start();
	
	$pageTitle ='Categories';

		if (isset($_SESSION['Username'])) {

			
			include 'init.php';

			//here all things go 

			$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';


			//start manage page 

			if ($do == 'Manage'){ // for manage page
				
				$sort = 'ASC';

				$sort_array = array('ASC', 'DESC');

				if (isset($_GET['sort'])  && in_array($_GET['sort'], $sort_array))  {

					$sort = $_GET['sort'] ;
				}

				$stmt2 = $conn->prepare("SELECT * FROM categories ORDER BY Ordering $sort");

				$stmt2->execute();

				$cats = $stmt2->fetchAll();  

				if(! empty($cats))  {
				?>

				<h1 class="text-center">Manage Categories</h1>
				<div class="container categories">
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class='fa fa-edit'></i> Manage Categories
							<div class="option pull-right">
								<i class='fa fa-sort'></i> Ordering: [
								<a class="<?php if ($sort == 'ASC') { echo 'active'; }?>" href="?sort=ASC">Asc</a>  |
								<a class="<?php if ($sort == 'DESC') { echo 'active'; }?>" href="?sort=DESC">Desc</a>  ]
								<i class='fa fa-eye'></i> View: [
								<span class="active" data-view="full">Full</span>  |
								<span data-view=classic>Classic</span>  ]
							</div>
						</div>
						<div class="panel-body">
							<?php 
								foreach ($cats as $cat) {
									echo "<div class='cat'>";
										echo "<div class='hidden-buttons'>";
											echo "<a href='categories.php?do=Edit&catid=" . $cat['ID'] . "  ' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i>  Edit</a>";
											echo "<a href='categories.php?do=Delete&catid=" . $cat['ID'] . " ' class='confirm btn btn-xs btn-danger'><i class='fa fa-close'></i>  Delete</a>";
										echo "</div>";	
										echo "<h3>" . $cat['Name'] . '</h3>';
										echo "<div class='full-view'>";
											echo "<p>"; if($cat['Description'] ==  '') { echo "This Category has No Description"; } else { echo $cat['Description'];  } echo "</p>";

											if($cat['Visibility'] == 0) { echo "<span class='visibility shape_nots'><i class='fa fa-eye'></i> Hidden</span>"; }

											if($cat['Allow_Comment'] == 0) { echo "<span class='commenting shape_nots'><i class='fa fa-close'></i> Comment Disabled</span>"; }
											// echo '<span>Allow Comment is ' . $cat['Allow_Comment'] . '</span>';

											if($cat['Allow_Ads'] == 0) { echo "<span class='advertises shape_nots'><i class='fa fa-close'></i> Ads Disabled</span>"; }
										echo "</div>";
									echo "</div>";	
									echo "<hr>";
								}
							 ?>
						</div>
					</div>
					<a href="categories.php?do=Add" class="add-category btn btn-primary"><i class="fa fa-plus"></i>Add New Category</a>
				</div>
				
				<?php } else {
					echo '<div class="container">';
						echo '<div class="nice-message">There\'s No Categories To Show</div>';
						echo '<a href="categories.php?do=Add" class="btn btn-primary">
								<i class="fa fa-plus"></i> New Category</a>';
					echo '</div>';
				} ?>



				<?php  
			}  elseif ($do == 'Add') {  //Add members page ?>
			 	
			 <div class="container">
				 	<h1 class="text-center" >Add New Category</h1>
				 	<form class="form-horizontal" method="POST" action="?do=Insert" > 
						
					
				 		<!-- Start name field-->
				 		<div class="form-group form-group-lg">
				 			<label class="col-sm-2 control-label">Name</label>
				 			<div class="col-sm-10 col-md-6">
				 				<input type="text" name="name" class="form-control"  autocomplete="off" required= "required" placeholder="Name of the Category">
				 			</div>	
				 		</div>
				 		<!-- End name field-->

						<!-- Start Description field-->
						<div class="form-group form-group-lg">
				 			<label class="col-sm-2 control-label">Description</label>
				 			<div class="col-sm-10 col-md-6">
				 			<input type="text" name="description" class="form-control"  placeholder="Describe the Category">
				 			</div>	
				 		</div>
				 		<!-- End Description field-->

				 		<!-- start ordering field-->
				 		<div class="form-group form-group-lg">
				 			<label class="col-sm-2 control-label">Ordering</label>
				 			<div class="col-sm-10 col-md-6">
				 				<input type="text" name="ordering" class="form-control"  placeholder="Number to Arrange the Categories">
				 			</div>	
				 		</div>
				 		<!-- End ordering field-->

						<!-- start visibility field-->
				 		<div class="form-group form-group-lg">
				 			<label class="col-sm-2 control-label">Visible</label>
				 			<div class="col-sm-10 col-md-6">
				 				<div>
				 					<input id="vis-yes" type="radio" name="visibility" value="1" checked /> 
				 					<label for="vis-yes">Yes</label>
				 				</div>
				 				<div>
				 					<input id="vis-no" type="radio" name="visibility" value="0" /> 
				 					<label for="vis-no">No</label>
				 				</div>
				 			</div>	
				 		</div>
				 		<!-- End visibility field-->	

						<!-- start Commenting field-->
				 		<div class="form-group form-group-lg">
				 			<label class="col-sm-2 control-label">Allow Commenting</label>
				 			<div class="col-sm-10 col-md-6">
				 				<div>
				 					<input id="com-yes" type="radio" name="commenting" value="1" checked /> 
				 					<label for="com-yes">Yes</label>
				 				</div>
				 				<div>
				 					<input id="com-no" type="radio" name="commenting" value="0" /> 
				 					<label for="com-no">No</label>
				 				</div>
				 			</div>	
				 		</div>
				 		<!-- End commenting field-->
 
						<!-- start Ads field-->
				 		<div class="form-group form-group-lg">
				 			<label class="col-sm-2 control-label">Allow Ads</label>
				 			<div class="col-sm-10 col-md-6">
				 				<div>
				 					<input id="ads-yes" type="radio" name="ads" value="1" checked /> 
				 					<label for="ads-yes">Yes</label>
				 				</div>
				 				<div>
				 					<input id="ads-no" type="radio" name="ads" value="0" /> 
				 					<label for="ads-no">No</label>
				 				</div>
				 			</div>	
				 		</div>
				 		<!-- End Ads field-->

				 		<!-- Start submit field-->
				 		<div class="form-group form-group-lg">
				 			<div class="col-sm-offset-2 col-sm-10">
				 				<input type="submit" value="Add Category" class="btn btn-primary btn-lg">
				 			</div>	
				 		</div>
				 		<!-- End submit field-->

				 	</form>
				 </div>




			<?php  
			}  elseif ($do == 'Insert') {   // for insert

				
				
				if ($_SERVER["REQUEST_METHOD"] == "POST") {

			 		echo "<h1 class='text-center'> Insert categories </h1>";
			 		echo "<div class='container'>";
				 	
				 	// get variables from the Form 
				 	$name = $_POST['name'];	
				 	$description = $_POST['description'];	
				 	$ordering = $_POST['ordering'];	
				 	$visible = $_POST['visibility'];	
				 	$comment = $_POST['commenting'];
			 		$ads =  $_POST['ads'];
		
			 		 // check if category exist 
				 	$check = checkItem("Name", "categories", $name);

				 	if ($check == 1)  {

				 	 	$theMsg = "<div class='alert alert-danger'> Sorry This Category is Exist </div>";

				 	 	redirectHome($theMsg, 'back');

				 	} else {
					 	 	// insert the categories in DB with this info
					 	 $stmt = $conn->prepare("INSERT INTO  categories (Name, Description, Ordering, Visibility, Allow_Comment, Allow_Ads) 
					 	 		VALUES (:zname, :zdesc, :zorder, :zvisible, :zcomment, :zads) "); 

					 	 $stmt->execute(array(

		 					'zname'     		=> 	$name,
							'zdesc' 			=> 	$description, 
							'zorder'			=> 	$ordering, 
							'zvisible' 		=>	$visible,
							'zcomment'		=>	$comment,
							'zads'			=>	$ads
						));

					 	 $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " record is Inserted </div>";

					 	 redirectHome($theMsg, 'back');
					 }
				
								
				} else {

					echo "<div class='container'>";

					$theMsg = "<div class='alert alert-danger'> Sorry you can't browser this page directly </div>" ; 

					redirectHome($theMsg, 'back');

					echo "</div>";
				}

				echo "</div>";

			}  elseif ($do == 'Edit') {  //edit member page 

				$catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;
				

				//check if UserID exist in DB

				$stmt = $conn->prepare("SELECT *  FROM  categories  WHERE  ID = ? ");  

				$stmt->execute(array($catid));

				$cat = $stmt->fetch();   //to get data from DB and put it in $cat which is an array 

				$count = $stmt->rowCount();

								
				if ($count > 0 ) {  ?>
					<div class="container">
					 	<h1 class="text-center" >Edit Category</h1>
					 	<form class="form-horizontal" method="POST" action="?do=Update" > 
							
							<!-- send also id -->
							<input type="hidden" name="catid" value="<?php echo $catid; ?>">

					 		<!-- Start name field-->
					 		<div class="form-group form-group-lg">
					 			<label class="col-sm-2 control-label">Name</label>
					 			<div class="col-sm-10 col-md-6">
					 				<input type="text" name="name" class="form-control"   required= "required" placeholder="Name of the Category" value="<?php echo $cat['Name']; ?>">
					 			</div>	
					 		</div>
					 		<!-- End name field-->

							<!-- Start Description field-->
							<div class="form-group form-group-lg">
					 			<label class="col-sm-2 control-label">Description</label>
					 			<div class="col-sm-10 col-md-6">
					 			<input type="text" name="description" class="form-control"  placeholder="Describe the Category"  value="<?php echo $cat['Description']; ?>">
					 			</div>	
					 		</div>
					 		<!-- End Description field-->

					 		<!-- start ordering field-->
					 		<div class="form-group form-group-lg">
					 			<label class="col-sm-2 control-label">Ordering</label>
					 			<div class="col-sm-10 col-md-6">
					 				<input type="text" name="ordering" class="form-control"  placeholder="Number to Arrange the Categories" value="<?php echo $cat['Ordering']; ?>">
					 			</div>	
					 		</div>
					 		<!-- End ordering field-->

							<!-- start visibility field-->
					 		<div class="form-group form-group-lg">
					 			<label class="col-sm-2 control-label">Visible</label>
					 			<div class="col-sm-10 col-md-6">
					 				<div>
					 					<input id="vis-yes" type="radio" name="visibility" value="1" <?php if ($cat['Visibility'] == 1) { echo "checked"; } ?> /> 
					 					<label for="vis-yes">Yes</label>
					 				</div>
					 				<div>
					 					<input id="vis-no" type="radio" name="visibility" value="0" <?php if ($cat['Visibility'] == 0) { echo "checked"; } ?> /> 
					 					<label for="vis-no">No</label>
					 				</div>
					 			</div>	
					 		</div>
					 		<!-- End visibility field-->	

							<!-- start Commenting field-->
					 		<div class="form-group form-group-lg">
					 			<label class="col-sm-2 control-label">Allow Commenting</label>
					 			<div class="col-sm-10 col-md-6">
					 				<div>
					 					<input id="com-yes" type="radio" name="commenting" value="1" <?php if ($cat['Allow_Comment'] == 1) { echo "checked"; } ?> /> 
					 					<label for="com-yes">Yes</label>
					 				</div>
					 				<div>
					 					<input id="com-no" type="radio" name="commenting" value="0" <?php if ($cat['Allow_Comment'] == 0) { echo "checked"; } ?>/> 
					 					<label for="com-no">No</label>
					 				</div>
					 			</div>	
					 		</div>
					 		<!-- End commenting field-->
	 
							<!-- start Ads field-->
					 		<div class="form-group form-group-lg">
					 			<label class="col-sm-2 control-label">Allow Ads</label>
					 			<div class="col-sm-10 col-md-6">
					 				<div>
					 					<input id="ads-yes" type="radio" name="ads" value="1" <?php if ($cat['Allow_Ads'] == 1) { echo "checked"; } ?> /> 
					 					<label for="ads-yes">Yes</label>
					 				</div>
					 				<div>
					 					<input id="ads-no" type="radio" name="ads" value="0" <?php if ($cat['Allow_Ads'] == 0) { echo "checked"; } ?> /> 
					 					<label for="ads-no">No</label>
					 				</div>
					 			</div>	
					 		</div>
					 		<!-- End Ads field-->

					 		<!-- Start submit field-->
					 		<div class="form-group form-group-lg">
					 			<div class="col-sm-offset-2 col-sm-10">
					 				<input type="submit" value="Save" class="btn btn-primary btn-lg">
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

			 }  elseif ($do == 'Update') { 

			 	echo "<h1 class='text-center'> Update Categories </h1>";
			 	echo "<div class='container'>";

				 	if ($_SERVER["REQUEST_METHOD"] == "POST") {

				 		
					 	$catid = $_POST['catid'];	
					 	$name = $_POST['name'];	
					 	$description = $_POST['description'];	
					 	$ordering = $_POST['ordering'];	
					 	$visibility = $_POST['visibility'];
					 	$commenting = $_POST['commenting'];
					 	$ads = $_POST['ads'];
					 	

					 
					 	// validation for the form 

					 	// if there is no error update to DB

				
					 		//update the DB with this info

						 $stmt = $conn->prepare("UPDATE  categories  SET  Name = ?, Description = ?, Ordering = ?, Visibility = ?, Allow_Comment = ?, Allow_Ads = ?  WHERE ID = ? ");  

						$stmt->execute(array($name, $description, $ordering, $visibility, $commenting, $ads, $catid));
							
						$theMsg = "<div class='alert alert-success'>" . $stmt-> rowCount() . " record is updated </div>";

						redirectHome($theMsg, 'back');

				

					} else {

						
						$theMsg = "<div class='alert alert-danger'>you can't browser this page directly</div>" ; 

						redirectHome($theMsg, 'back');

						
					}

				echo "</div>";

			 	
			 }  elseif ($do == 'Delete') { //Delete member page

			 echo "<h1 class='text-center'> Deleted members </h1>";
			 	echo "<div class='container'>";

				 	$catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;
					
					
					// check if category ID exist in DB with the function

					$check = checkItem('ID', 'categories', $catid); 

										
					// if the ID is exist 
					if ($check > 0 ) {  

						$stmt = $conn->prepare("DELETE FROM categories WHERE ID = :zcat"); 

						$stmt->bindParam(":zcat", $catid);

						$stmt->execute();
							
						$theMsg = "<div class='alert alert-success'>" . $stmt-> rowCount() . " record is deleted </div>";

						redirectHome($theMsg, 'back');

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
