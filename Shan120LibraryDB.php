<!DOCTYPE html>
<html>
<head>
<title>Shan120 Library</title>

</head>
<body>
<?php
$servername = "localhost"; $username = "root"; $password = "";

// Create connection
$conn = mysqli_connect($servername, $username, $password);

// Delete database if the database name already exist
$notFound = 0;
try{
    $sql = "DROP DATABASE Shan120LibraryDB";
    mysqli_query($conn, $sql);
}catch(mysqli_sql_exception $e){
    ++$notFound;
}

try{
// Create database
$sql = "CREATE DATABASE Shan120LibraryDB";
mysqli_query($conn, $sql); 

$dbname = "Shan120LibraryDB";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Table for user
$sql= "CREATE TABLE user (
    userID VARCHAR(5) PRIMARY KEY,
    firstName VARCHAR(30) NOT NULL,
    lastName VARCHAR(30) NOT NULL,
    email VARCHAR(30) NOT NULL,
    phone VARCHAR(10) NOT NULL,
    userType VARCHAR(20) NOT NULL,
    userPassword VARCHAR(100) NOT NULL)";

mysqli_query($conn, $sql);

$sql= "INSERT INTO user " .  
    "(userID, firstName, lastName, email, phone, userType, userPassword)" .
    " VALUES " .
    "(12345, 'Anh', 'Nguyen', 'anhnguyen@gmail.com', '0450123456', 'borrower',  'b710b378de7ef5133b97bd2c9464ffe3'), " .
    "(12347, 'Tonny', 'Stark', 'tonnystark@gmail.com', '0450123457', 'borrower',  'dd1f58853921027a22f47710f025cf20'), " .
    "(12346, 'Jenny', 'Bobbie', 'jennybobbie@gmail.com', '0450654321', 'librarian', '067fccb09c1d91f4f0c5d6d21d5355d9')";

mysqli_query($conn, $sql);

// Table for resources
$sql= "CREATE TABLE resources (
    resourceID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ISBN INT NOT NULL,
    resourceName VARCHAR(200) NOT NULL,
    author VARCHAR(100) NOT NULL,
    resourceStatus VARCHAR(30) NOT NULL,
    resourceType VARCHAR(30) NOT NULl,
    maxTimeBorrow INT NOT NULL,
    costPerDay INT NOT NULL)";

mysqli_query($conn, $sql);

$sql= "INSERT INTO resources " .  
    "(ISBN, resourceName, author, resourceStatus, resourceType, maxTimeBorrow, costPerDay)" .
    " VALUES " .
    "(100000000, 'Atomic Lifestyle', 'David Tild', 'unavailable', 'Book', 30, 1),".
    "(100000001, 'Where the crawdads sing', 'Delia Owens', 'available', 'Book', 15, 2),".
    "(100000002, 'The Boy in the Striped Pyjamas', 'John Boyne', 'available', 'Book', 30, 1),".
    "(100000003, 'Eleanor Oliphant is Completely Fine', 'Gail Honeyman', 'unavailable', 'Book', 10, 2),".
    "(100000004, 'The GoldFintch', 'Donna Tart', 'available', 'Book', 30, 1)";

mysqli_query($conn, $sql);

// Table for borrowing
$sql= "CREATE TABLE borrowing (
    borrowID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    resourceName VARCHAR(200) NOT NULL,
    author VARCHAR(100) NOT NULL,
    borrowedTime timestamp NULL DEFAULT current_timestamp(),
    duration INT NOT NULL,
    userID INT NOT NULL,
    resourceID INT NOT NULL)";

mysqli_query($conn, $sql);

$sql= "INSERT INTO borrowing " .  
    "(resourceName, author, borrowedTime, duration, userID, resourceID)" .
    " VALUES " .
    "('Eleanor Oliphant is Completely Fine', 'Gail Honeyman', '2022-05-27 10:43:24', 6, 12347, 4),".
    "('Atomic Lifestyle', 'David Tild', '2022-05-25 11:25:17', 10, 12345, 1)";

mysqli_query($conn, $sql);

echo "Created the database and tables successfully.";

}catch(mysqli_sql_exception $e){
    echo "Error. Try again.";
}
?>

</body>

</html>