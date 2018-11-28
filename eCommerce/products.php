<head>
  <title>eCommerce</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	
</body>

<div class="search">
	<p> <a href="index_B.php" style="color: blue;">Go To Search</a> </p>
	<?php
	include('server.php');

	if(isset($_REQUEST['submit'])){
		$name = $_POST['name'];
		$_SESSION['s_name'] = $name;
	} else {
		$name = $_SESSION['s_name']; 
	}
		
		$sele = "SELECT * FROM Product WHERE Pname LIKE '%$name%'";
		$result = mysqli_query($db, $sele);
		$count = 0;
		if($make = mysqli_num_rows($result) > 0){

			echo "<table border='1'>
			<tr>
			<th>Product ID</th>
			<th>Product Name</th>
			<th>Price</th>
			<th>Status</th>
			<th>Description</th>
			<th>Category</th>
			<th></th>
			</tr>";

			while($row = mysqli_fetch_array($result))
			{
				echo "<tr>";
				echo "<td>" . $row[0] . "</td>";
				echo "<td>" . $row[1] . "</td>";
				echo "<td>" . $row[2] . "</td>";
				echo "<td>" . $row[3] . "</td>";
				//echo "<td>" . $row_p[4] . "</td>";
				echo "<td>" . $row[5] . "</td>";
				echo "<td>" . $row[6] . "</td>";
				echo "<td>";
				if ($_SESSION['cart'][$row['PId']] > 0) {
					echo "<b style='color:blue'>In Cart</b>";
				} else {
					echo "<form method='post' action='products.php'>";
						//$_SESSION['id'] = $row['PId'];
						echo "<input type='hidden' name='p_id' value=".$row['PId']." />";
						echo "<button type='submit' class='btn' name='add_cart'>Add to Cart</button>";
					echo "</form>";	
				}				
				echo "</td>";
				echo "</tr>";
				$count += 1;
			}

			echo "</table>";

		} else {
			$make = '<h4>No match found!</h4>';
		}

		//echo'<h3> Search Result</h3>';
		if ($make == 1 ){ print("Number of Entries: ". $count); }
		else {print ($make);}
	//}

	?>

<p> <a href="cart.php" style="color: blue;">Go To Cart</a> </p>
<p> <a href="logout.php?logout='1'" style="color: red;">logout</a> </p>
</div>
	
</body>