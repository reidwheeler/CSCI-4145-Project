<?php
$servername = "csci4145project.cffjtzdcv8ol.us-east-2.rds.amazonaws.com";
$username = "csci4145project";
$password = "csci4145project";
$dbname = "csci4145project";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT FirstName, LastName FROM Employee";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo " - Name: " . $row["FirstName"]. " " . $row["LastName"]. "<br>";
    }
} else {
    echo "0 results";
}
$conn->close();
?>