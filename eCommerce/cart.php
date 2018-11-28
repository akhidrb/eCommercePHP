<?php

print '<h1>Your Shopping Cart:</h1>';
?>

<div class="content">
	<p> <a href="index_B.php" style="color: blue;">Go To Search</a> </p>

	<?php
	include('server.php');

		$sele = "SELECT c.PId, p.Pname FROM Cart c, Product p WHERE username='".$_SESSION['username']."' AND c.PId=p.PId";
		$result = mysqli_query($db, $sele);
		$count = 0;
		if($make = mysqli_num_rows($result) > 0){

			echo "<table border='1'>
			<tr>
			<th>Product Id</th>
			<th>Product Name</th>
			</tr>";

			while($row = mysqli_fetch_array($result, MYSQLI_NUM))
			{
				//echo "<form method='post' action='products.php'>";
					echo "<tr>";
						echo "<td>" . $row[0] . "</td>";
						echo "<td>" . $row[1] . "</td>";
						echo "<td>";
						//if ($_SESSION['cart'][$row[0]] > 0) {
							echo "<form method='post' action='cart.php'>";
								//$_SESSION['id'] = $row['PId'];
								echo "<input type='hidden' name='p_id' value=".$row[0]." />";
								echo "<button type='submit' class='btn' name='del_cart'>Delete</button>";
							echo "</form>";	
						//}				
						echo "</td>";
					echo "</tr>";
				//echo "</form>";
				$count += 1;
			}
			echo "</table>";

		} else {
			$make = '<h4>Empty Cart!</h4>';
		}

		//echo'<h3> Search Result</h3>';
		if ($make == 1 ){ print("Number of Entries: ". $count); }
		else {print ($make);}
	//}

	?>
<p> <a href="products.php" style="color: blue;">Back</a> </p>
<p> <a href="logout.php?logout='1'" style="color: red;">logout</a> </p>
</div>
	
