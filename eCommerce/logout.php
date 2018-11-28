
<?php 
include('server.php');

if(isset($_GET['logout']))
{
	//
	$username = mysqli_real_escape_string($db, $_SESSION['username']);
	$query = "DELETE FROM Cart Where username='$username'";
	mysqli_query($db, $query);

	//session_destroy();
	session_start();
	session_unset();
	session_destroy();	
	//
	header('location:index.php?logout=true');
	exit;
}
?>
