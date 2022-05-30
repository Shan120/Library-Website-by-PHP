<!DOCTYPE html>
<html lang="en">
<head>
<title>Shan120 Library Login</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="style/pageStyle.css">
</head>
<body onLoad="showDate(); showLogo();">
<?php include("includes/header.html"); ?>

<div class="navbar">
  <a href="home.php">Home</a>
  <a href="registration.php">Register</a>
  <a href="login.php">Login</a>
  
</div>

<div class="row">
  <div class="main">
  <form action="verifyLogin.php" method="post">
    User ID: <input type="text" name="userID" /><br /><br />
    Password: <input type="password" name="userPassword" /><br /><br />
    <input type="submit" name="submit" value="Login" />
    <input type="reset" value="Clear" />

  </div>
</div>

<?php include("includes/footer.html"); ?>
</body>
</html>
