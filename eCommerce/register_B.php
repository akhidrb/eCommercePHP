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
  
  <form method="post" action="register_B.php">
    <?php include('errors.php'); ?>

    <div class="input-group">
      <label>Payment Type</label>
      <select name="payment_type">
        <option value="visa">Visa</option>
        <option value="american_express">American Express</option>
        <option value="master_card">Master Card</option>
        <option value="debit_card">Debit Card</option>
        <option value="discover_card">Discorver Card</option>
      </select>
    </div>

    <div class="input-group">
      <label>Credit Card Number</label>
      <input type="text" name="CCNo" value="<?php echo $CCNo; ?>">
    </div>
    
    <div class="input-group">
      <label>Secuirty Number</label>
      <input type="text" name="secuirtyNo" value="<?php echo $secuirtyNo; ?>">
    </div>

    <div class="input-group">
        <button type="submit" class="btn" name="reg_buyer">Register as Buyer</button>
    </div>

  </form>
</body>
</html>