<?php 
  include('server.php');

  if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
  }
  if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: login.php");
  }
?>
<!DOCTYPE html>
<html>
<head>
  <title>eCommerce</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<div class="header">
  <h2>Seller Home Page</h2>
</div>
<div class="content">
    <!-- notification message -->
    <?php if (isset($_SESSION['success'])) : ?>
      <div class="error success" >
        <h3>
          <?php 
            echo $_SESSION['success']; 
            unset($_SESSION['success']);
          ?>
        </h3>
      </div>
    <?php endif ?>

    <!-- logged in user information -->
    <?php  if (isset($_SESSION['username'])) : ?>
      <p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>

      <?php 
        $username = mysqli_real_escape_string($db, $_SESSION['username']);
        $query = "SELECT * FROM Store WHERE username='$username'";
        $results = mysqli_query($db, $query);
        if (mysqli_num_rows($results) == 1) {
          echo '<p> <a href="store.php" style="color: blue;">Go to Store</a> </p>';
        } else {
          echo '<p> <a href="store.php" style="color: blue;">Create Store</a> </p>';
        }
      ?>

      <p> <a href="logout.php?logout=true" style="color: red;">logout</a> </p>
    <?php endif ?>
</div>
    
</body>
</html>