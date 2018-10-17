<?php  include "init.php"; ?>

<div class="container">
	<h1 class="text-center"><?php echo str_replace('-', ' ', $_GET['pagename']); ?></h1>
	<?php 
			
		        	foreach (getItems($_GET['pageid']) as $item) {
		        			
		        		// echo '<li><a href="items.php?pageid=' . $item['ID']. '&pagename=' . str_replace(' ', '-', $item['Name']) . ' ">' . $item['Name'] . '</a></li>';

				echo $item['Name'];
		        	}

	?>
</div>	
	


<?php  include $tpl . 'footer.php'; ?>
 	 

