<?php
session_start();



if (strlen($_SESSION['userID'])==0 OR ($_SESSION['useType'] != 'borrower')) {
        header('location:logout.php');
//}elseif($_SESSION['useType'] == 'librarian'){
  //header('location:logout.php');

        }
         else{
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

    if (isset($_GET['search'])){
        $displayForm = FALSE;
        $inputSearch = $_GET['inputSearch'];
        $resourceStatus = $_GET['resourceStatus'];

        if (strlen($inputSearch)>0){
    
    try{
    $sql = "SELECT * FROM resources WHERE (ISBN LIKE '%$inputSearch%') OR (resourceName LIKE '%$inputSearch%') OR (author LIKE '%$inputSearch%') OR (resourceStatus='$inputSearch') ";

    $result = $mysqli -> query($sql);

  // list the search result by text input
    echo "<p>List all search results</p>";
    echo "<table >";
        echo "<tr>";
        echo "<th>ID</th>";
        echo "<th>ISBN</th>";
        echo "<th>Title</th>";
        echo "<th>Author</th>";
        echo "<th>Type</th>";
        echo "<th>Status</th>";
        echo "<th style='text-align:center;'>Duration
        <br />(Days)</th>";
        echo "<th style='text-align:center;'>Cost<br />(AUD/day)</th>";
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
        }catch(mysqli_sql_exception $e) {
            echo "Not found.";
        }
    }

 

}

// ISBN, Title, Author, or Status
// display the form
    if($displayForm){
    ?>
<form action="searchResource1.php" method="get">
<table>
<tr>
<td>Enter ISBN/ title/ author/ status:</td>
<td><input type="text" size="50" name="inputSearch" /></td>
</tr>
<!--
<tr>
<td>Status:</td>
<td><input type="radio" name="resourceStatus" value="available"/>Available
<input type="radio" name="resourceStatus" value="unavailable"/>Unavailable
</td>
</tr>
-->
</table>
<input type="submit" name="search" value="Search" />
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