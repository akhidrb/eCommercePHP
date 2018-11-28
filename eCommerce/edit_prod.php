<?php
include('server.php');

//Edit Product Form
if (isset($_POST['edit_prod'])) {
	$username = mysqli_real_escape_string($db, $_SESSION['username']);
	$prod_id = mysqli_real_escape_string($db, $_POST['prod_id']);
	$sele = "SELECT * FROM Product WHERE PId='$prod_id'";
	$result = mysqli_query($db, $sele);
	while($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
		$p_name = mysqli_real_escape_string($db, $row[1]);
		$p_price = mysqli_real_escape_string($db, $row[2]);
		$p_status = mysqli_real_escape_string($db, $row[3]);
		$p_des = mysqli_real_escape_string($db, $row[5]);
		$p_cat = mysqli_real_escape_string($db, $row[6]);
	}
//
	$sele_s = "SELECT * FROM Store s WHERE username='$username'";
	$result_s = mysqli_query($db, $sele_s);
	$row_s = mysqli_fetch_array($result_s);
//
		$sele_sc = "SELECT * FROM Store_Category WHERE Sname='".$row_s['name']."'";
		$result_sc = mysqli_query($db, $sele_sc);
//
	 	echo '<h3>Edit Product</h3>
	 		<form method="post" action="store.php">
	 			<input type="hidden" name="pd_id" value="'.$prod_id.'" />
		     	<div class="input-group">
		      		<label>Product Name</label>
		      		<input type="text" name="pd_name" value="'.$p_name.'">
		    	</div>
		     	<div class="input-group">
		      		<label>Price</label>
		      		<input type="text" name="pd_price" value="'.$p_price.'">
		    	</div>';
?>
		    	<div class="input-group">
		    		<label>Status</label>
					<select name="pd_status">
					  <option value="new" <?php if($p_status == "new"): ?> selected="selected"<?php endif; ?>  >New</option>
					  <option value="used" <?php if($p_status == "used"): ?> selected="selected" <?php endif; ?>  >Used</option>
					</select>
				</div>
<?php 
				echo'
				<div class="input-group">
					<label>Description</label><br />
					<textarea name="pd_des" rows="5" cols="40">'.$p_des.'</textarea>
				</div>
		    	<div class="input-group">
		    		<label>Category</label>
					<select name="pd_cat">';

		while($row_sc = mysqli_fetch_array($result_sc)) {
?>
			<option value= <?php echo '"'.$row_sc['CatName'].'"'; ?> 
				<?php if($p_cat == $row_sc['CatName']): ?> selected="selected"<?php endif; ?>> 
					<?php echo $row_sc['CatName']; ?> 
			</option>';
<?php
		}
		echo '	</select>
				</div>

			    <div class="input-group">
			      <button type="submit" class="btn" name="upd_prod">Update Product</button>
			    </div>
		   </form>';
}

?>
