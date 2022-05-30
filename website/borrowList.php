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

  // set the timezone
  date_default_timezone_set("Australia/Sydney");
    $servername = "localhost"; $username = "root"; $password = "";

    $dbname = "Shan120LibraryDB";
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    $mysqli = new mysqli($servername, $username, $password, $dbname);

    $sql1 = "SELECT * FROM borrowing";

    $result1 = $mysqli -> query($sql1);

    //resourceName, author, borrowedTime, totalCost, userID, resourceID

    echo "<p>List all borrowed resources</p>";
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
          echo "Need to remind user to return.";
        }else{
          echo "Show the total cost with fine to user";
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