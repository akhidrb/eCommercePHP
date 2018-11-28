<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>eCommerce</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
    <h2>Register</h2>
  </div>
   
  <div class="content">
    <div class="input-group">
      <a href="register_B.php">
        <button type="submit" class="btn">Register as Buyer</button>
      </a>
    </div>
  </div>

  <form method="post" action="server.php">
    <div class="input-group">
      <button type="submit" class="btn" name="reg_seller">Register as Seller</button>
    </div>
  </form>

  
</body>
</html>