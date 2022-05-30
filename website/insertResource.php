<?php
session_start();

if (strlen($_SESSION['userID'])==0 OR ($_SESSION['useType'] != 'librarian')) {
        header('location:logout.php');
        } else{
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Shan120 Library, Librarian</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="style/pageStyle.css">
</head>
<body onLoad="showDate(); showLogo();">
<?php include("includes/header.html"); ?>

<div class="navbar">
<a href="dashboard_librarian.php">Dashboard</a>

  <a href="logout.php">Logout</a>
  
</div>

<div class="row">
  <div class="side">
  <a href="listResource.php">List all resources</a><br />
  <a href="insertResource.php">Insert resources</a><br />
  <a href="searchResource.php">Search</a><br />
  <a href="changeStatus.php">Change status</a><br />
  <a href="borrowList.php">Borrowed resources</a><br />
  <a href="availableList.php">Availalbe resources</a><br />
  <img src="beauty.png" width="150" height="150" style="vertical-align:middle">
  <p><?php echo $_SESSION['firstName']; ?> <?php echo $_SESSION['lastName']; ?>, ID: <?php echo $_SESSION['userID']; ?> </p>

  </div>
  <div class="main">
  <h2>Welcome back, Librarian <?php echo $_SESSION['firstName']; ?> <?php echo $_SESSION['lastName']; ?> </h2>

  <?php

  $displayForm = TRUE;
    $servername = "localhost"; $username = "root"; $password = "";

    $dbname = "Shan120LibraryDB";
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    $mysqli = new mysqli($servername, $username, $password, $dbname);

// insert resources

// function to check if librarian entered all inputs
  function checkInput($data){
    global $errorCount;
    if(empty($data)){
      ++$errorCount;
      $retval = "";
    }else{
      $retval = trim($data);
      $retval = stripslashes($retval);
      
    }
    return($retval);
  }


if (isset($_POST['insert'])){
    $displayForm = FALSE;
    $isbn = checkInput($_POST['ISBN']);
    $resourceName = checkInput($_POST['resourceName']);
    $author = checkInput($_POST['author']);
    $resourceStatus = checkInput($_POST['resourceStatus']);
    $resourceType = checkInput($_POST['resourceType']);
    $maxTimeBorrow = checkInput($_POST['maxTimeBorrow']);
    $costPerDay = checkInput($_POST['costPerDay']);

    $error = 0;
    if (!is_numeric($isbn)){
        echo "ISBN must consists of digit only.<br />";
        ++$error;
    }

    if (!is_numeric($maxTimeBorrow)){
        echo "Duration must be an integer.<br />";
        ++$error;
    }

    if (!is_numeric($costPerDay)){
        echo "Cost per day must be an integer.<br />";
        ++$error;
    }


    if ($errorCount == 0){
        if ($error == 0){
            //if (is_numeric($maxTimeBorrow)){
               // if (is_numeric($costPerDay)){
    $sql = "INSERT INTO resources " . 
                "(ISBN, resourceName, author, resourceStatus, resourceType, maxTimeBorrow, costPerDay)". 
                 " VALUES ". 
                "('$isbn', '$resourceName', '$author', '$resourceStatus', '$resourceType', '$maxTimeBorrow', '$costPerDay') ";
                mysqli_query($conn, $sql);
        echo "You have added the resource successfully.";
                }else{
                    echo "Cannot add the resource. Please enter valid values. <br />";
                    $displayForm = TRUE;
                }
    }else{
        echo "Cannot add the resource. Please enter all inputs. <br />";
        $displayForm = TRUE;
    }
}


if ($displayForm){
    ?>
<form action="insertResource.php" method="post">
<table>
<tr>
<td>ISBN:</td>
<td><input type="text" name="ISBN" /></td>
</tr>
<tr>
<td>Title:</td>
<td><input type="text" name="resourceName" /></td>
</tr>
<tr>
<td>Author:</td>
<td><input type="text" name="author" /></td>
</tr>
<tr>
<td>Status:</td>
<td><input type="radio" name="resourceStatus" value="available"/>Available
<input type="radio" name="resourceStatus" value="unavailable"/>Unavailable
</td>
</tr>
<tr>
<td>Type:</td>
<td><input type="text" name="resourceType" /></td>
</tr>
<tr>
<td>Duration:</td>
<td><input type="text" name="maxTimeBorrow" /></td>
</tr>
<tr>
<td>Cost per day:</td>
<td><input type="text" name="costPerDay" /></td>
</tr>
</table>
<input type="submit" name="insert" value="Add" />
<input type="reset" value="Clear" />
</form>

    <?php
}

  
  ?>

  </div>
</div>

<?php include("includes/footer.html"); ?>
</body>
</html><?php }  ?>