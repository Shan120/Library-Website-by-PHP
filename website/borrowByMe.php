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
  // set the timezone
  date_default_timezone_set("Australia/Sydney");
 $servername = "localhost"; $username = "root"; $password = "";

    $dbname = "Shan120LibraryDB";
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    $mysqli = new mysqli($servername, $username, $password, $dbname);

    $userID = $_SESSION['userID'];

$sql1 = "SELECT * FROM borrowing WHERE userID=$userID";

    $result1 = $mysqli -> query($sql1);

    //resourceName, author, borrowedTime, totalCost, userID, resourceID

    echo "<p>List all borrowed resources by me</p>";
    echo "<table >";
        echo "<tr>";
        echo "<th>ID</th>";
        echo "<th>Tile</th>";
        echo "<th>Author</th>";
        echo "<th>Borrower</th>";
        echo "<th style='text-align:center;'>Date borrowed</th>";

        echo "<th style='text-align:center;'>Due date</th>";
        echo "<th style='text-align:center;'>Time remains</th>";
        echo "<th style='text-align:center;'>Total fees</th>";
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
        // date to return
        $resourceID = $row1['resourceID'];
        $sql2 = "SELECT * FROM resources WHERE resourceID=$resourceID";
        $result2 = $mysqli -> query($sql2);
        $row2 = $result2->fetch_assoc();
        $costPerDay = $row2['costPerDay'];
        $maxTimeBorrow = $row2['maxTimeBorrow'];

        $duration = $row1['duration'];
        
        $time = "+"."$duration"." days"; // time to the date to return

        echo date('Y-m-d H:i:s',strtotime($time, strtotime($row1['borrowedTime']))) . PHP_EOL;
        echo "</td>";
        echo "<td style='text-align:center;'>";
        
        $t2 = date('Y-m-d H:i:s',strtotime($time, strtotime($row1['borrowedTime']))) . PHP_EOL;
        $t1 = date('Y-m-d H:i:s',strtotime('now')); // current time
        //echo $t1;
        $date1=date_create($t1);
        $date2=date_create($t2);
        $diff=date_diff($date1,$date2);
        echo $diff->format("%R%a days");

        $now = time(); // current time
        $dueDate = strtotime($t2);
        $datediff1 = $dueDate - $now;

        $time1 = round($datediff1 / (60 * 60 * 24));
        //echo "<br />";
        //echo $time1;

        echo "</td>";
        echo "<td style='text-align:center;'>";
        $now = time(); // current time
        $borrowedDate = strtotime($row1['borrowedTime']);

        if ($now < $dueDate){
          $datediff = $now - $borrowedDate;

          $t = round($datediff / (60 * 60 * 24));
        
          $a = $t * $costPerDay;

          echo "$"."$a";
        }else{
          $sql3= "DELETE FROM borrowing WHERE resourceID=$resourceID";
          mysqli_query($conn, $sql3);

          $sql4 = "UPDATE resources SET resourceStatus='available' WHERE resourceID=$resourceID ";
          mysqli_query($conn, $sql4);

          echo "Automatically returned.<br />";
        }

        echo "</td>";
        /*
        echo "<td>";
        
        if ($now < $dueDate){
          echo "No";
        }elseif($now == $dueDate){
          echo "No";
        }else{
          echo "Yes";
        }
        echo "</td>";
        echo "<td>";
        if ($now < $dueDate){
          echo "N/A";
        }elseif($now == $dueDate){
          echo "Please return the resource today.";
        }else{
          echo "The fine is double of the cost per day.";
        }
        echo "</td>";
        */
        echo "</tr>";
        
    }
    
    echo "</table>";
  
  ?>

  </div>
</div>

<?php include("includes/footer.html"); ?>
</body>
</html><?php }  ?>