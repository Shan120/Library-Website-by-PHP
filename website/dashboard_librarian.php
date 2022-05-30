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
  <p>The side menu offers multiple functionalites</p>
  <ul>
  <li>List all resources</li>
  <li>Insert resources</li>
  <li>Search resources</li>
  <li>Change status of resources</li>
  <li>Check borrowed resources</li>
  <li>List all available resources</li>
  </ul>
  <?php
  /*
    $servername = "localhost"; $username = "root"; $password = "";

    $dbname = "Shan120LibraryDB";
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    $mysqli = new mysqli($servername, $username, $password, $dbname);

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

    // insert resources

    // search for a resource

    // change status

    // list all borrowed resources
    $sql1 = "SELECT * FROM borrowing ";

    $result1 = $mysqli -> query($sql1);

    //resourceName, author, borrowedTime, totalCost, userID, resourceID

    echo "<p>List all borrowed resources</p>";
    echo "<table >";
        echo "<tr>";
        echo "<th>ID</th>";
        echo "<th>Tile</th>";
        echo "<th>Author</th>";
        echo "<th>Borrower</th>";
        echo "<th style='text-align:center;'>Time borrowed
        <br />Weeks</th>";
        echo "<th style='text-align:center;'>Total fees
        <br />AUD</th>";
        echo "<th>Time remains</th>";
        echo "</tr>";
       
    while ($row1 = $result1->fetch_assoc()) {
        
        echo "<tr>";
        echo "<td>";
        echo $row1['resourceID'];
        echo "</td>";
        echo "<td>";
        echo $row1['resourceName'];
        echo "</td>";
        echo "<td>";
        echo $row1['author'];
        echo "</td>";
        echo "<td>";
        echo $row1['userID'];
        echo "</td>";
        echo "<td style='text-align:center;'>";
        echo $row1['borrowedTime'];
        echo "</td>";
        echo "<td style='text-align:center;'>";
        echo $row1['totalCost'];
        echo "</td>";
        echo "</td>";
        echo "<td style='text-align:center;'>";
        echo $row1['totalCost'];
        echo "</td>";
        echo "</tr>";
        
    }
    
    echo "</table>";
    // list all available resources
  */
  ?>

  </div>
</div>

<?php include("includes/footer.html"); ?>
</body>
</html><?php }  ?>