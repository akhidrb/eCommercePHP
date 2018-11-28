
<p> <a href="index_B.php" style="color: blue;">Go To Search</a> </p>
<?php
include('server.php');

if(isset($_REQUEST['submit'])){
	$name = $_POST['name'];
} else {
	$name = "";
}	
	$sele = "SELECT * FROM Store WHERE name LIKE '%$name%'";
	$result = mysqli_query($db, $sele);
	$count = 0;
	if($make = mysqli_num_rows($result) > 0){

		echo "<table border='1'>
		<tr>
		<th>Category Name</th>
		</tr>";

		while($row = mysqli_fetch_array($result))
		{
			echo "<tr>";
			echo "<td>" . $row['name'] . "</td>";
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

?>
