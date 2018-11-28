<?php 
  //include('server.php');
  session_start();

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
  <h2>Buyer Home Page</h2>
</div>

<div class="content">
    <!-- notification message -->
    <?php if (isset($_SESSION['success'])) : ?>
      <div class="error success" >
        <h3>
          <?php 
            echo $_SESSION['success']; 
            unset($_SESSION['success']);
            $_SESSION['cart'] = array();
            $_SESSION['cart'] = array_fill(1, 10, 0);
            $_SESSION['id'] = 0;
          ?>
        </h3>
      </div>
    <?php endif ?>

    <!-- logged in user information -->
    <?php  if (isset($_SESSION['username'])) : ?>
      <p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>

</div>

      <form class="search" action="products.php" method="POST">
        <center><h3>Products</h3></center>
        <center><table>
        <tr>
          <td>Search</td>
          <td><input type="text" name="name" size="100"></td>
          <td><input type="submit" name="submit" value="Browse"></td>
        </tr>
        </table></center>
      </form>

      <form class="search" action="categories.php" method="POST">
        <center><h3>Search for Categories</h3></center>
        <center><table>
        <tr>
          <td>Search</td>
          <td><input type="text" name="name" size="100"></td>
          <td><input type="submit" name="submit" value="Browse"></td>
        </tr>
        </table></center>
      </form>

      <form class="search" action="stores.php" method="POST">
        <center><h3>Search for Stores</h3></center>
        <center><table>
        <tr>
          <td>Search</td>
          <td><input type="text" name="name" size="100"></td>
          <td><input type="submit" name="submit" value="Browse"></td>
        </tr>
        </table></center>
      </form>

<!--
      <form class='search'>
        <input type="text" size="30" onkeyup="showResult(this.value)" placeholder="Search for Stores...">
        <div id="livesearch"></div>
      </form>
-->

      <div class="content">
        <p> <a href="logout.php?logout=true" style="color: red;">logout</a> </p>
      </div>
    <?php endif ?>
</div>
    
</body>
</html>