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
    <?php
    $displayForm = TRUE;
    $servername = "localhost"; $username = "root"; $password = "";

    $dbname = "Shan120LibraryDB";
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    $mysqli = new mysqli($servername, $username, $password, $dbname);

if(isset($_POST['register'])){
    $displayForm = FALSE;

    function displayRequired($fieldName){
  echo "The field \"$fieldName\" is required.<br />\n";
}


function validateInput($data, $fieldName){
global $errorCount;

  if(empty($data)){
    displayRequired($fieldName);
    ++$errorCount;
    $retval = "";
  }else{
    $retval = trim($data);
    $retval = stripslashes($retval);
  }
  return($retval);
}


$errorCount = 0;

$userID = validateInput($_POST['userID'], "User ID");
$firstName = validateInput($_POST['firstName'], "Firstname");
$lastName = validateInput($_POST['lastName'], "Lastname");
$phone = validateInput($_POST['phone'], "Phone number");
$email = validateInput($_POST['email'], "Email");
$userPassword = $_POST['userPassword'];
$userType= validateInput($_POST['userType'], "User Type");



if($errorCount > 0){
  
  if(empty($_POST['userPassword'])){
    echo "The field \"Password\" is required.<br />\n";
  }

  echo "Cannot register.<br />";
}else{
    // userID partern   "/^([0-9]{5})$/"
    $pattern3 = "/^([1-9]{1})([0-9]{4})$/";
    if (preg_match($pattern3, $userID) != 1){
      echo "You have entered an invalid user ID.<br />";
    }
  
    $sql1= "SELECT userID FROM user";
    $result1 = $mysqli -> query($sql1);
    $array = $result1->fetch_assoc();

    if (in_array($userID, $array)){
      echo "The user ID is already used.<br />";
    }
    
    // phone number partern
    $pattern1 = "/^([0]{1})([0-9]{9})$/";
    if (preg_match($pattern1, $phone) != 1){
      echo "You have entered an invalid phone.<br />";
    }

    // email partern
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
      echo "You have entered an invalid email.<br />";
    }

    // if everything is satisfied
  if (preg_match($pattern1, $phone) == 1){
    if (filter_var($email, FILTER_VALIDATE_EMAIL)){
      if (preg_match($pattern3, $userID) == 1){
        if (!in_array($userID, $array)){
        
          $sql2 = "INSERT INTO user " . 
                "(userID, firstName, lastName, email, phone, userType, userPassword)". 
                 " VALUES ". 
                "('$userID', '$firstName', '$lastName', '$email', '$phone', '$userType', " . " '" . md5($userPassword) . "') ";
                mysqli_query($conn, $sql2);

        echo "Congratulation! Register successfully.<br />";

        }else{
          echo "Cannot register.<br />";
          
        }
      }else{
        echo "Cannot save the information.<br />";
        
      }
    }else{
      echo "Cannot save the information.<br />";
      
    }
  }else{
      echo "Cannot save the information.<br />";
      
    }

}


}

if($displayForm){
    ?>

  <form action="registration.php" method="post">
    User ID: <input type="text" name="userID" /> <i>(Must contain 5 digits not starting from 0)</i><br /><br />
    Firstname:
    <input type="text" name="firstName" /><br /><br />
    Lastname:
    <input type="text" name="lastName" /><br /><br />
    Email:
    <input type="text" name="email" /><br /><br />
    Phone Number:
    <input type="text" name="phone" /> <i>(Must contain 10 digits starting from 0)</i><br /><br />
    Password: <input type="password" name="userPassword" /><br /><br />
    User Type: <input type="radio" name="userType" value="borrower" />Borrower
    <input type="radio" name="userType" value="librarian" />Librarian
    <br /><br />
    <input type="submit" name="register" value="Register" />
    <input type="reset" value="Clear" />
    </form>
    <?php
}

  
  ?>
  </div>
</div>

<?php  include("includes/footer.html"); ?>
</body>
</html>
