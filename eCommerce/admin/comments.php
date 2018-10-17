<?php 

/*
   template page
*/
   	ob_start();   // Output buffering start .. wait for header to be sent first 

	session_start();
	
	$pageTitle ='Comments';

		if (isset($_SESSION['Username'])) {

			

			include 'init.php';

			//here all things go 

			$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';


			//start manage page 

			if ($do == 'Manage'){ // for manage page

				$stmt = $conn->prepare("SELECT comments.*, 
					items.Name AS item_name, users.Username FROM comments

				INNER JOIN items ON items.Item_ID = comments.Item_ID

				INNER JOIN users ON users.UserID = comments.User_ID

				ORDER BY C_ID DESC"); 

				 $stmt->execute();

				 $rows = $stmt->fetchAll();

				 if(! empty($rows)) {
			?> 
				<div class="container">

				 	<h1 class="text-center" >Manage Comments</h1>
					<div class="table-reponsive">
						<table class="main-table text-center table table-bordered">
							<tr>
								<td>#ID</td>
								<td>Comment</td>
								<td>Item Name</td>
								<td>User Name</td>
								<td>Added Date</td>
								<td>Control</td>
							</tr>

							<?php 
								foreach ($rows as $row) {
									echo "<tr>";
										echo "<td>" . $row['C_ID'] . "</td>";
										echo "<td>" . $row['Comment'] . "</td>";
										echo "<td>" . $row['Username'] . "</td>";
										echo "<td>" . $row['item_name'] . "</td>";
										echo "<td>" . $row['Comment_Date']  . "</td>";
										echo "<td>
											<a href='comments.php?do=Edit&commentid=" . $row['C_ID'] . " ' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a> 
										 	<a href='comments.php?do=Delete&commentid=" . $row['C_ID'] . " ' class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";

										 	if($row['Status'] == 0)  {

										 	echo "<a href='comments.php?do=Approve&commentid=" . $row['C_ID'] . " ' class='btn btn-info activate'><i class='fa fa-check'></i> Approve</a>";

										     	}

										echo  "</td>";
										 	
									echo "</tr>";	
								}
								
							 ?>
					
						</table>
					</div>
				<!-- <a href='comments.php?do=Add' class="btn btn-primary"> <i class="fa fa-plus"></i> New Comment</a> -->
				</div>

				<?php } else {
					echo '<div class="container">';
						echo '<div class="nice-message">There\'s No Comments To Show</div>';
				
				} ?>


	<?php 	 	} elseif ($do == 'Edit') {  //edit Comment page 

				$commentid = isset($_GET['commentid']) && is_numeric($_GET['commentid']) ? intval($_GET['commentid']) : 0;
				

				//check if CommentID exist in DB

				$stmt = $conn->prepare("SELECT *  FROM  comments  WHERE  C_ID = ? ");  
				$stmt->execute(array($commentid));
				$row = $stmt->fetch();   //to get data from DB and put it in $row which is an array 
				$count = $stmt->rowCount();

				if ($count > 0 ) {  

				?>
				 
				 <div class="container">
				 	<h1 class="text-center" >Edit Comment</h1>
				 	<form class="form-horizontal" method="POST" action="?do=Update" > 
						
						<!-- send also id -->
						<input type="hidden" name="commentid" value="<?php echo $commentid; ?>">

				 	
						<!-- Start Comment field-->
				 		<div class="form-group form-group-lg">
				 			<label class="col-sm-2 control-label">Comment</label>
				 			<div class="col-sm-10 col-md-6">
				 				<textarea name="comment" class="form-control"> <?php echo $row['Comment']; ?> </textarea>
				 			</div>	
				 		</div>
				 		<!-- End Comment field-->

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




			 } // if it is " do Edit  page ''
			 elseif ($do == 'Update') {
			 	echo "<h1 class='text-center'> Update members </h1>";
			 	echo "<div class='container'>";

				 	if ($_SERVER["REQUEST_METHOD"] == "POST") {

				 		
					 	$commentid = $_POST['commentid'];	
					 	$comment = $_POST['comment'];	
					 	
					 	if(empty($comment))  {
							
							echo "<div class='alert alert-danger'>" . "Comment cant be <strong>empty</strong>" . "</div>";

						} else {	

							$stmt = $conn->prepare("UPDATE  comments  SET  Comment = ? WHERE C_ID = ?");  

							$stmt->execute(array($comment, $commentid));
								
							$theMsg = "<div class='alert alert-success'>" . $stmt-> rowCount() . " record is updated </div>";

							redirectHome($theMsg, 'back');

					 	}
	

					} else {

						
						$theMsg = "<div class='alert alert-danger'>you can't browser this page directly</div>" ; 

						redirectHome($theMsg, 'back');

						
					}

				echo "</div>";
			 } elseif ($do == 'Delete') { //Delete comments page

			 	echo "<h1 class='text-center'> Deleted Comments </h1>";
			 	echo "<div class='container'>";

				 	$commentid = isset($_GET['commentid']) && is_numeric($_GET['commentid']) ? intval($_GET['commentid']) : 0;
					
					// check if CommentID exist in DB with the function

					$check = checkItem('C_ID', 'comments', $commentid); 
					
					// if the ID is exist 
					if ($check > 0 ) {  

						$stmt = $conn->prepare("DELETE FROM comments WHERE C_ID = :zcomment");  //means 1 result

						$stmt->bindParam(":zcomment", $commentid);

						$stmt->execute();
							
						$theMsg = "<div class='alert alert-success'>" . $stmt-> rowCount() . " record is deleted </div>";

						redirectHome($theMsg, 'back');

				 	} else {

				 		$theMsg = "<div class='alert alert-danger'>This ID is not exist</div>";

				 		redirectHome($theMsg);
				 	}

			 	echo "</div>";

			 
			 }  elseif ($do == 'Approve') { //for Approved comments
			 	
			 	echo "<h1 class='text-center'> Approved member </h1>";
			 	echo "<div class='container'>";

			 		// check if get request for userid 

				 	$commentid = isset($_GET['commentid']) && is_numeric($_GET['commentid']) ? intval($_GET['commentid']) : 0;
					
					
					// check if CommentID exist in DB with the function

					$check = checkItem('C_ID', 'comments', $commentid); 

					// echo $check;
					
					// if the ID is exist 
					//if ($count > 0 )
					if ($check > 0 ) {  

						$stmt = $conn->prepare("UPDATE  comments SET Status = 1 WHERE C_ID = ? ");  

						$stmt->execute(array($commentid));
							
						$theMsg = "<div class='alert alert-success'>" . $stmt-> rowCount() . " Comment is Approved </div>";

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
