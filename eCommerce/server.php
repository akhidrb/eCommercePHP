<?php
session_start();

// initializing user variables
$username = "";
$emailAd = "";
$phoneNo = "";
$Bdate = "";
$Fname = "";
$Lname = "";
$postalCode = "";
$city = "";
$country = "";
$adLine1 = "";
$adLine2 = "";
$SPR = "";
//initializing buyer variables
$payment_type = "";
$CCNo = "";
$secuirtyNo = "";
//
$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'eCommerce');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $emailAd = mysqli_real_escape_string($db, $_POST['emailAd']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
  $phoneNo = mysqli_real_escape_string($db, $_POST['phoneNo']);
  $Bdate = mysqli_real_escape_string($db, $_POST['Bdate']);
  $Fname = mysqli_real_escape_string($db, $_POST['Fname']);
  $Lname = mysqli_real_escape_string($db, $_POST['Lname']);
  $postalCode = mysqli_real_escape_string($db, $_POST['postalCode']);
  $city = mysqli_real_escape_string($db, $_POST['city']);
  $country = mysqli_real_escape_string($db, $_POST['country']);
  $adLine1 = mysqli_real_escape_string($db, $_POST['adLine1']);
  $adLine2 = mysqli_real_escape_string($db, $_POST['adLine2']);
  $SPR = mysqli_real_escape_string($db, $_POST['SPR']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($emailAd)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
    array_push($errors, "The two passwords do not match");
  }

  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE username='$username' OR emailAd='$emailAd' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
    $password = md5($password_1);//encrypt the password before saving in the database

    $query = "INSERT INTO User (username, password, emailAd, phoneNo, Bdate, Fname, Lname, postalCode, city, country, adLine1, adLine2, SPR) 
              VALUES('$username', '$password_1', '$emailAd', '$phoneNo', '$Bdate', '$Fname', '$Lname', '$postalCode', '$city', '$country', '$adLine1', '$adLine2', '$SPR')";

    mysqli_query($db, $query);
    $_SESSION['username'] = $username;
    $_SESSION['success'] = "You are now logged in";
    header('location: register_2.php');
  }
}

//Register as Seller
if (isset($_POST['reg_seller'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_SESSION['username']);

  $password = md5($password_1);//encrypt the password before saving in the database

  $query = "INSERT INTO Seller (username) VALUES('$username')";

  mysqli_query($db, $query);
  $_SESSION['username'] = $username;
  $_SESSION['success'] = "You are now logged in";
  header('location: index_S.php');
}

// REGISTER as Buyer
if (isset($_POST['reg_buyer'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_SESSION['username']);
  $payment_type = mysqli_real_escape_string($db, $_POST['payment_type']);
  $CCNo = mysqli_real_escape_string($db, $_POST['CCNo']);
  $secuirtyNo = mysqli_real_escape_string($db, $_POST['secuirtyNo']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($CCNo)) { array_push($errors, "Credit Card Number is required"); }
  if (empty($secuirtyNo)) { array_push($errors, "Security Number is required"); }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {

    $query = "INSERT INTO Buyer (username, payment_type, CCNo, secuirtyNo) 
              VALUES('$username', '$payment_type', '$CCNo', '$secuirtyNo')";

    mysqli_query($db, $query);
    $_SESSION['username'] = $username;
    $_SESSION['success'] = "You are now logged in";
    header('location: index_B.php');
  }
}

// LOGIN USER
if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($username)) {
    array_push($errors, "Username is required");
  }
  if (empty($password)) {
    array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
    //$password = md5($password);
    $query = "SELECT * FROM User WHERE username='$username' AND password='$password'";
    $results = mysqli_query($db, $query);
    if (mysqli_num_rows($results) == 1) {
      $_SESSION['username'] = $username;
      $_SESSION['success'] = "You are now logged in";
      $query_B = "SELECT * FROM Buyer WHERE username='$username'";
      $results_B = mysqli_query($db, $query_B);
      $query_S = "SELECT * FROM Seller WHERE username='$username'";
      $results_S = mysqli_query($db, $query_S);
      if (mysqli_num_rows($results_B) == 1) {
        header('location: index_B.php');
      } elseif (mysqli_num_rows($results_S) == 1) {
        header('location: index_S.php');
      } else {
        array_push($errors, "User is neither buyer nor seller");
      }
      
    }else {
        array_push($errors, "Wrong username/password combination");
    }
  }
}

//Add to Cart
if (isset($_POST['add_cart'])) {
  $username = mysqli_real_escape_string($db, $_SESSION['username']);
  $p_id = mysqli_real_escape_string($db, $_POST['p_id']);

  $_SESSION['cart'][$p_id] = 1;

  $query = "INSERT INTO Cart (username, PId) 
            VALUES('$username', '$p_id')";

  mysqli_query($db, $query);

}

//Delete from Cart
if (isset($_POST['del_cart'])) {
  $username = mysqli_real_escape_string($db, $_SESSION['username']);
  $p_id = mysqli_real_escape_string($db, $_POST['p_id']);
    
  $_SESSION['cart'][$p_id] = 0;
  //DELETE FROM Cart WHERE username='$username' AND PId='$p_id'
  $query = "DELETE FROM Cart WHERE username='$username' AND PId='$p_id'";

  mysqli_query($db, $query);
}

//Create Store
if (isset($_POST['cr_store'])) {
  $username = mysqli_real_escape_string($db, $_SESSION['username']);
  $st_name = mysqli_real_escape_string($db, $_POST['st_name']);

  $query = "INSERT INTO Store (name, username) 
            VALUES('$st_name', '$username')";

  if (mysqli_query($db, $query)) {
    echo "Success!! Store Created";
  } else {
    echo '<p style="color: red">Name already Exists<p>';
  }
}

//Update Store Name 
if (isset($_POST['upd_store'])) {
  $username = mysqli_real_escape_string($db, $_SESSION['username']);
  $st_name = mysqli_real_escape_string($db, $_POST['st_name']);

  $query = "UPDATE Store SET name='$st_name' WHERE username='$username'";

  if (mysqli_query($db, $query)) {
    echo "Success!! Name Changed";
  } else {
    echo '<p style="color: red">Name already Exists<p>';
  }
}

//Delete Store
if (isset($_POST['del_store'])) {
  $username = mysqli_real_escape_string($db, $_SESSION['username']);
  //$st_name = mysqli_real_escape_string($db, $_POST['st_name']);

  $query = "DELETE FROM Store Where username='$username'";

  if (mysqli_query($db, $query)) {
    echo "Success!! Store Deleted";
  } else {
    echo '<p style="color: red">Must Delete everything from Store First<p>';
  }
}

//Add Category 
if (isset($_POST['add_cat'])) {
  $username = mysqli_real_escape_string($db, $_SESSION['username']);
  $cat_opt = mysqli_real_escape_string($db, $_POST['cat_opt']);
  $other = mysqli_real_escape_string($db, $_POST['other']);

  $sele = "SELECT * FROM Store WHERE username='$username'";
  $result = mysqli_query($db, $sele);
  if($row = mysqli_fetch_array($result)) {
    $st_name = mysqli_real_escape_string($db, $row['name']);
  }

  if ($cat_opt == 'other') {
    $query_2 = "INSERT INTO Category (name) VALUES ('$other')";
    mysqli_query($db, $query_2);

    $query = "INSERT INTO Store_Category (Sname, CatName) VALUES ('$st_name', '$other')";

  } else {
    $query = "INSERT INTO Store_Category (Sname, CatName) VALUES ('$st_name', '$cat_opt')";
  }

  mysqli_query($db, $query);
}

//Delete Category from Store
if (isset($_POST['del_cat'])) {
  $username = mysqli_real_escape_string($db, $_SESSION['username']);
  $cat_opt = mysqli_real_escape_string($db, $_POST['cat_opt']);

  $sele = "SELECT * FROM Store WHERE username='$username'";
  $result = mysqli_query($db, $sele);
  if($row = mysqli_fetch_array($result)) {
    $st_name = mysqli_real_escape_string($db, $row['name']);
  }

  $query = "DELETE FROM Store_Category WHERE Sname='$st_name' AND CatName='$cat_opt'";

  mysqli_query($db, $query);
}


//Add Product 
if (isset($_POST['add_prod'])) {
  $username = mysqli_real_escape_string($db, $_SESSION['username']);
  
  $pd_name = mysqli_real_escape_string($db, $_POST['pd_name']);
  $pd_price = mysqli_real_escape_string($db, $_POST['pd_price']);
  $pd_status = mysqli_real_escape_string($db, $_POST['pd_status']);
  $pd_des = mysqli_real_escape_string($db, $_POST['pd_des']);
  $pd_cat = mysqli_real_escape_string($db, $_POST['pd_cat']);

//
  $sele = "SELECT * FROM Store WHERE username='$username'";
  $result = mysqli_query($db, $sele);
  if($row = mysqli_fetch_array($result)) {
    $st_name = mysqli_real_escape_string($db, $row['name']);
  }

  $query = "INSERT INTO Product(Pname, price, status, description, CatName, Sname) 
  VALUES ('$pd_name', '$pd_price', '$pd_status', '$pd_des', '$pd_cat', '$st_name')";

  mysqli_query($db, $query);
}

//Delete Product from Store
if (isset($_POST['del_prod'])) {
  //$username = mysqli_real_escape_string($db, $_SESSION['username']);
  $prod_id = mysqli_real_escape_string($db, $_POST['prod_id']);
  $query = "DELETE FROM Product WHERE PId='$prod_id'";
  mysqli_query($db, $query);
}

//Update Product 
if (isset($_POST['upd_prod'])) {
  //$username = mysqli_real_escape_string($db, $_SESSION['username']);

  $pd_id = mysqli_real_escape_string($db, $_POST['pd_id']);
  $pd_name = mysqli_real_escape_string($db, $_POST['pd_name']);
  $pd_price = mysqli_real_escape_string($db, $_POST['pd_price']);
  $pd_status = mysqli_real_escape_string($db, $_POST['pd_status']);
  $pd_des = mysqli_real_escape_string($db, $_POST['pd_des']);
  $pd_cat = mysqli_real_escape_string($db, $_POST['pd_cat']);

  $query = "UPDATE Product SET Pname='$pd_name', price='$pd_price', status='$pd_status', 
  description='$pd_des', CatName='$pd_cat' WHERE PId='$pd_id'";

  mysqli_query($db, $query);
}

?>