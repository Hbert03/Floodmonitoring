<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "water_level";  

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$water_level = isset($_POST['water_level']) ? $_POST['water_level'] : 'NULL';
$water_turbidity = isset($_POST['turbidity']) ? $_POST['turbidity'] : 'NULL';
$raindrop = isset($_POST['raindrop']) ? $_POST['raindrop'] : 'NULL';
$station = isset($_POST['station']) ? $_POST['station'] : 'NULL';


$sql = "INSERT INTO water_level_log (turbidity, water_level, raindrop, station)
        VALUES ('$water_turbidity', '$water_level', '$raindrop', '$station')";

if ($conn->query($sql) === TRUE) {
    echo "Data inserted successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
