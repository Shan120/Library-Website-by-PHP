<?php
session_start();

if (strlen($_SESSION['userID'])==0 OR ($_SESSION['useType'] != 'borrower')) {
        header('location:logout.php');
        } else{
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Shan120 Library, Bookworm</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="style/pageStyle.css">
</head>
<body onLoad="showDate(); showLogo();">
<?php include("includes/header.html"); ?>

<div class="navbar">
<a href="dashboard_borrower.php">Dashboard</a>
  <a href="logout.php">Logout</a>
  
</div>

<div class="row">
  <div class="side">
  <a href="availableList1.php">Availalbe resources</a><br />
  <a href="borrowByMe.php">Borrowed resources</a><br />
  <a href="searchResource1.php">Search</a><br />
  <a href="borrowResource.php">Borrow a resource</a><br />

  <img src="hairstyle.png" width="150" height="150" style="vertical-align:middle">
  <p><?php 
  // create a class to display user information
  class displayUser {
    private string $firstName;
    public function __construct(string $firstName, private string $lastName = "", private float $userID){
        $this->firstName = $firstName;
    }
    
    public function getInfo():string {
           return $this->firstName . " " . $this->lastName . ", ID: " . $this->userID;
        }
    }
    $firstName = $_SESSION['firstName'];
    $lastName= $_SESSION['lastName'];
    $userID = $_SESSION['userID'];
    $display = new displayUser($firstName, $lastName, $userID);
    echo "<p>", $display->getInfo(), "</p>";
  
  ?> </p>

  </div>
  <div class="main">
  <h2>Welcome back Bookworm, <?php echo $_SESSION['firstName']; ?> <?php echo $_SESSION['lastName']; ?> </h2>

  <?php
 $servername = "localhost"; $username = "root"; $password = "";

    $dbname = "Shan120LibraryDB";
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    $mysqli = new mysqli($servername, $username, $password, $dbname);

    $displayForm = TRUE;


    if (isset($_POST['borrow'])){
        $displayForm = FALSE;
        $resourceID = $_POST['resourceID'];

        $sql1 = "SELECT * FROM resources WHERE resourceID=$resourceID";
        $result1 = mysqli_query($conn, $sql1);
        $row1 = $result1->fetch_assoc();

        $resourceName = $row1['resourceName'];
        $author = $row1['author'];
        $resourceStatus = $row1['resourceStatus'];

        $userID = $_SESSION['userID'];
        $duration = $_POST['duration'];
        $maxTimeBorrow = $row1['maxTimeBorrow'];


        if (isset($resourceID)){
    
            if($resourceStatus == 'available'){
                if($duration <= $maxTimeBorrow){
                
    try{
        // insert to the borrowing table
        $sql = "INSERT INTO borrowing " . 
        "(resourceName, author, duration, userID, resourceID)". 
         " VALUES ". 
        "('$resourceName', '$author', '$duration', '$userID', '$resourceID') ";
        mysqli_query($conn, $sql);
echo "You have borrowed the resource successfully.";
        
        // update in the database the resource status
        $sql2 = "UPDATE resources SET resourceStatus='unavailable' WHERE resourceID=$resourceID";
        mysqli_query($conn, $sql2);
        }catch(mysqli_sql_exception $e) {
            echo "Cannot borrow. <br />";
        }
    }else{
        echo "Cannot borrow. Please choose borowwing duration less than the limit.<br />";
    } 
    }else{
        echo "Cannot borrow. Please choose an available resource.<br />";
    }
    }


}

// display the form
    if($displayForm){
    ?>
<form action="borrowResource.php" method="post">
<table>
<tr>
<td>Enter Resource ID to borrow:</td>
<td><input type="text" name="resourceID" /></td>
</tr>
<tr>
<td>Enter duration:</td>
<td><input type="text" name="duration" /></td>
</tr>

</table>
<input type="submit" name="borrow" value="Borrow" />
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