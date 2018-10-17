<?php  include "init.php"; ?>

<div class="container">
	<h1 class="text-center"><?php echo str_replace('-', ' ', $_GET['pagename']); ?></h1>
	<?php 
			
		        	foreach (getItems($_GET['pageid']) as $item) {
		        			
		        		// echo '<li><a href="items.php?pageid=' . $item['ID']. '&pagename=' . str_replace(' ', '-', $item['Name']) . ' ">' . $item['Name'] . '</a></li>';
		        		echo '<div class="col-sm-6 col-md-3">';
					echo '<div class="thumbnail item-box">';
						echo '<span class="price-tag">' . $item['Price'] . '</span>';
						echo '<img class="img-responsive" src="img.png" alt="" />';
						echo '<div class="caption">';
							echo '<h3><a href="items.php?itemid='. $item['Item_ID'] .'">' . $item['Name'] .'</a></h3>';
							echo '<p>' . $item['Description'] . '</p>';
							echo '<div class="date">' . $item['Add_Date'] . '</div>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
				
		        	}

	?>
</div>	
	


<?php  include $tpl . 'footer.php'; ?>
 	 

