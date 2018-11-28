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
  
  <form method="post" action="register.php">
    <?php include('errors.php'); ?>
    <div class="input-group">
      <label>Username</label>
      <input type="text" name="username" value="<?php echo $username; ?>">
    </div>
    <div class="input-group">
      <label>Email</label>
      <input type="email" name="emailAd" value="<?php echo $emailAd; ?>">
    </div>
    <div class="input-group">
      <label>Password</label>
      <input type="password" name="password_1">
    </div>
    <div class="input-group">
      <label>Confirm password</label>
      <input type="password" name="password_2">
    </div>

    <div class="input-group">
      <label>Phone Number</label>
      <input type="text" name="phoneNo" value="<?php echo $phoneNo; ?>">
    </div>

    <div class="input-group">
      <label>Birth Date</label>
      <input type="Date" name="Bdate" value="<?php echo $Bdate; ?>">
    </div>

    <div class="input-group">
      <label>First Name</label>
      <input type="text" name="Fname" value="<?php echo $Fname; ?>">
    </div>

    <div class="input-group">
      <label>Last Name</label>
      <input type="text" name="Lname" value="<?php echo $Lname; ?>">
    </div>

    <div class="input-group">
      <label>Postal Code</label>
      <input type="text" name="postalCode" value="<?php echo $postalCode; ?>">
    </div>

    <div class="input-group">
      <label>City</label>
      <input type="text" name="city" value="<?php echo $city; ?>">
    </div>

    <div class="input-group">
      <label>Country</label>
      <input type="text" name="country" value="<?php echo $country; ?>">
    </div>

    <div class="input-group">
      <label>Address Line 1</label>
      <input type="text" name="adLine1" value="<?php echo $adLine1; ?>">
    </div>

    <div class="input-group">
      <label>Address Line 2</label>
      <input type="text" name="adLine2" value="<?php echo $adLine2; ?>">
    </div>

    <div class="input-group">
      <label>State/Province/Region</label>
      <input type="text" name="SPR" value="<?php echo $SPR; ?>">
    </div>

    <div class="input-group">
      <button type="submit" class="btn" name="reg_user">Register</button>
    </div>

    <p>
      Already a member? <a href="login.php">Sign in</a>
    </p>
  </form>
</body>
</html>