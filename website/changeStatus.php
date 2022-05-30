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
    $displayForm1 = TRUE;
    $servername = "localhost"; $username = "root"; $password = "";

    $dbname = "Shan120LibraryDB";
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    $mysqli = new mysqli($servername, $username, $password, $dbname);



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

    if (isset($_POST['change'])){
        $displayForm = FALSE;
        $displayForm1 = FALSE;
        $resourceStatus = checkInput($_POST['resourceStatus']);
        $resourceID = checkInput($_POST['resourceID']);

  
        $error = 0;
        if (!is_numeric($resourceID)){
            echo "Resource ID must be an integer.<br />";
        }
        
        $sql2 = "SELECT * FROM resources WHERE resourceID=$resourceID ";
        $result2 = $mysqli -> query($sql2);
        $foundMatch = 0;
        while ($row2 = $result2 -> fetch_assoc()) {
          if ($resourceID == $row2['resourceID']){
            ++$foundMatch;
          }
        }


        if ($errorCount == 0){
            if ($error == 0){
                if ($foundMatch >0 ){
                $sql1 = "UPDATE resources SET resourceStatus='$resourceStatus' WHERE resourceID=$resourceID";
                if (mysqli_query($conn, $sql1)) {
                    echo "Record updated successfully";
                  } else {
                    echo "Error updating record: " . mysqli_error($conn);
                  }
                }else{
                    echo "No record found. Cannot update the resource status. <br />";
                    $displayForm = TRUE;
                        $displayForm1 = TRUE;
                }
                    }else{
                        echo "Cannot update the resource status. Please enter valid values. <br />";
                        $displayForm = TRUE;
                        $displayForm1 = TRUE;
                    }
        }else{
            echo "Cannot add the resource. Please enter all inputs. <br />";
            $displayForm = TRUE;
            $displayForm1 = TRUE;
        }
    }

    if ($displayForm1){
        $sql = "SELECT * FROM resources ";
    
        $result = $mysqli -> query($sql);
    
      // list all resources
        echo "<p>List all resources</p>";
        echo "<table >";
            echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>ISBN</th>";
            echo "<th>Tile</th>";
            echo "<th>Author</th>";
            echo "<th>Type</th>";
            echo "<th>Status</th>";
            echo "<th style='text-align:center;'>Duration
            <br />Weeks</th>";
            echo "<th style='text-align:center;'>Cost<br />AUD/day</th>";
            echo "</tr>";
            
        while ($row = $result->fetch_assoc()) {
            
            echo "<tr>";
            echo "<td>";
            echo $row['resourceID'];
            echo "</td>";
            echo "<td>";
            echo $row['ISBN'];
            echo "</td>";
            echo "<td>";
            echo $row['resourceName'];
            echo "</td>";
            echo "<td>";
            echo $row['author'];
            echo "</td>";
            echo "<td>";
            echo $row['resourceType'];
            echo "</td>";
            echo "<td>";
            echo $row['resourceStatus'];
            echo "</td>";
            echo "<td style='text-align:center;'>";
            echo $row['maxTimeBorrow'];
            echo "</td>";
            echo "<td style='text-align:center;'>";
            echo $row['costPerDay'];
            echo "</td>";
            echo "</tr>";
            
        }
        echo "</table>";
        }
if($displayForm){
  ?>
<form action="changeStatus.php" method="post">
Enter Resource ID:
<input type="text" name="resourceID" /><br /><br />
Resouce status: 
<input type="radio" name="resourceStatus" value="available" />Available
<input type="radio" name="resourceStatus" value="unavailable" />Unavailable <br /><br />
<input type="submit" name="change" value="Update" />
<input type="reset" value="Clear" />
</form>
<?php }  ?>
  </div>
</div>

<?php include("includes/footer.html"); ?>
</body>
</html><?php }  ?>