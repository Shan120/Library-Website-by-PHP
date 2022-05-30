<?php
session_start();
?>

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
  <a href="logout.php">Logout</a>
  
</div>

<div class="row">
  <div class="main">
  <?php
$errors = 0;
$dbname = "Shan120LibraryDB";
try {
    $conn = mysqli_connect("localhost", "root", "",$dbname );
    
    $table = "user";
    $sql = "SELECT * FROM $table" . " where userID='" . stripslashes($_POST['userID']) ."' and userPassword='" . md5(stripslashes($_POST['userPassword'])) . "'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result)==0) {
        echo "<p>The combination of user ID, password and user type " . " is not valid. </p>\n";
        ++$errors;
    }
    else {
        $row = mysqli_fetch_assoc($result);
        $userID = $row['userID'];
        $firstName = $row['firstName'];
        $lastName = $row['lastName'];
        $userType = $row['userType'];
        echo "<p>Login successfull</p>\n";
        $_SESSION['userID'] = $userID;
        $_SESSION['firstName'] = $firstName;
        $_SESSION['lastName'] = $lastName;
        $_SESSION['useType'] = $userType;
    }
}
catch(mysqli_sql_exception $e) {
    echo "<p>Error: unable to connect to the database.</p>";
    ++$errors;
}
if ($errors > 0) {
    echo "<a href='login.php'>Try again?</a>";
    //header('location:login.php');
}
if ($errors == 0) {

    if($userType == 'borrower'){
        header('location:dashboard_borrower.php');
        
    }
    
    if($userType == 'librarian'){
        header('location:dashboard_librarian.php');
    }
}
?>

  </div>
</div>

<?php include("includes/footer.html"); ?>
</body>
</html>