
<head>
	
	<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
	<script type="text/javascript"> 
		
		$(document).ready(function(){
		    $("select").change(function(){
		        $(this).find("option:selected").each(function(){
		            var optionValue = $(this).attr("value");
		            if(optionValue == "other"){
		                $("#st_cat").show();
		            } else{
		                $("#st_cat").hide();
		            }
		        });
		    }).change();
		});
		
	</script> 
</head>
<body>
<?php
include('server.php');

// if($_REQUEST['submit']){
// 	$name = $_POST['name'];
	$username = mysqli_real_escape_string($db, $_SESSION['username']);

	$sele = "SELECT * FROM Store s WHERE username='$username'";
	$result = mysqli_query($db, $sele);

	$count = 0;

	if($make = mysqli_num_rows($result) > 0){
		if($row = mysqli_fetch_array($result))
		{
			echo '<h1>Welcome to ' . $row['name'] .'</h1>';
			$sele_p = "SELECT * FROM Product WHERE Sname='".$row['name']."'";
			$result_p = mysqli_query($db, $sele_p);

			if($make_p = mysqli_num_rows($result_p) > 0){
				echo "<table border='1'>
				<tr>
				<th>Product ID</th>
				<th>Product Name</th>
				<th>Price</th>
				<th>Status</th>
				<th>Description</th>
				<th>Category</th>
				<th></th>
				<th></th>
				</tr>";
				while($row_p = mysqli_fetch_array($result_p, MYSQLI_NUM)) {
					echo "<tr>";
					echo "<td>" . $row_p[0] . "</td>";
					echo "<td>" . $row_p[1] . "</td>";
					echo "<td>" . $row_p[2] . "</td>";
					echo "<td>" . $row_p[3] . "</td>";
					//echo "<td>" . $row_p[4] . "</td>";
					echo "<td>" . $row_p[5] . "</td>";
					echo "<td>" . $row_p[6] . "</td>";
					echo "<td>" . 
					'<form method="post" action="edit_prod.php">
						<div class="input-group">
						  <input type="hidden" name="prod_id" value="'.$row_p[0].'" />
					      <button type="submit" class="btn" name="edit_prod">Edit</button>
					    </div>
				    </form>'
					."</td>";
					echo "<td>" . 
					'<form method="post" action="store.php">
						<div class="input-group">
						  <input type="hidden" name="prod_id" value="'.$row_p[0].'" />
					      <button type="submit" class="btn" name="del_prod">Delete</button>
					    </div>
				    </form>'
					. "</td>";
					echo "</tr>";
					$count += 1;
				}
				echo "</table>";
			} else {
				echo '<h4>No Products in Your Store!</h4>';
			}
			if ($make_p == 1 ){ print("Number of Entries: ". $count); }
			else {print ($make_p);}

			$sele_sc = "SELECT * FROM Store_Category WHERE Sname='".$row['name']."'";
			$result_sc = mysqli_query($db, $sele_sc);

			if($make_sc = mysqli_num_rows($result_sc) > 0){
				//Add Product (if there is no product)
			 	echo '<h3>Add a Product</h3>
			 		<form method="post" action="store.php">
				     	<div class="input-group">
				      		<label>Product Name</label>
				      		<input type="text" name="pd_name">
				    	</div>
				     	<div class="input-group">
				      		<label>Price</label>
				      		<input type="text" name="pd_price">
				    	</div>
				    	<div class="input-group">
				    		<label>Status</label>
							<select name="pd_status">
							  <option value="new">New</option>
							  <option value="used">Used</option>
							</select>
						</div>
						<div class="input-group">
							<label>Description</label><br />
							<textarea name="pd_des" rows="5" cols="40"></textarea>
						</div>
				    	<div class="input-group">
				    		<label>Category</label>
							<select name="pd_cat">';

				while($row_sc = mysqli_fetch_array($result_sc)) {
					echo '<option value="' . $row_sc['CatName'] . '">' . $row_sc['CatName'] . '</option>';
				}
				echo '	</select>
						</div>

					    <div class="input-group">
					      <button type="submit" class="btn" name="add_prod">Add Product</button>
					    </div>
				   </form>';

				//Delete Category (if there exists)
   				$sele_sc2 = "SELECT * FROM Store_Category WHERE Sname='".$row['name']."'";
				$result_sc2 = mysqli_query($db, $sele_sc2);
			 	echo '<h3>Delete Category from Store</h3>
			 		<form method="post" action="store.php">
				     	<div class="input-group">
				    		<label>Category</label>
							<select name="cat_opt">';

							while($row_sc2 = mysqli_fetch_array($result_sc2)) {
								echo '<option value="' . $row_sc2['CatName'] . '">' . $row_sc2['CatName'] . '</option>';
							}
							echo '	
							</select>
						</div>
					    <div class="input-group">
					      <button type="submit" class="btn" name="del_cat">Delete Category</button>
					    </div>
				   </form>';

			} else {
				echo '<h4>No Categories in Your Store!</h4>';
			}				
			//Add Category (whether there already exists or not)
			$sele_c = "SELECT * FROM Category WHERE 1";
			$result_c = mysqli_query($db, $sele_c);
		 	echo '<h3>Add a Category</h3>
		 		<form method="post" action="store.php">
			     	<div class="input-group">
			    		<label>Category</label>
						<select name="cat_opt">';

						while($row_c = mysqli_fetch_array($result_c)) {
							echo '<option value="' . $row_c['name'] . '">' . $row_c['name'] . '</option>';
						}
						echo '<option value="other">Other</option>	
						</select>
					</div>
			     	<div class="input-group" id="st_cat">
			      		<label>Other</label>
			      		<input type="text" name="other">
			    	</div>
				    <div class="input-group">
				      <button type="submit" class="btn" name="add_cat">Add Category</button>
				    </div>
			   </form>';
		}

		echo '<h4>Change Store Name</h4>';
	 	echo '<form method="post" action="store.php">
		     	<div class="input-group">
		      		<label>New Store Name</label>
		      		<input type="text" name="st_name">
		    	</div>
			    <div class="input-group">
			      <button type="submit" class="btn" name="upd_store">Update</button>
			    </div>
			   </form>';

		echo '<h4>Delete Store</h4>';
	 	echo '<form method="post" action="store.php">
		     	<input type="hidden" name="store_name" value="" />
			    <div class="input-group">
			      <button type="submit" class="btn" name="del_store">Delete</button>
			    </div>
			   </form>';

	} else {
		echo '<h4>No Store!</h4>';
	 	echo '<form method="post" action="store.php">
		     	<div class="input-group">
		      		<label>Store Name</label>
		      		<input type="text" name="st_name">
		    	</div>
			    <div class="input-group">
			      <button type="submit" class="btn" name="cr_store">Creat Store</button>
			    </div>
			   </form>';

	}

// }

?>

<p> <a href="index_S.php" style="color: blue;">Home Page</a> </p>
</body>