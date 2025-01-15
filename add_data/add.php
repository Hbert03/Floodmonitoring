<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "water_level";  

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$water_level = isset($_POST['water_level']) ? $conn->real_escape_string($_POST['water_level']) : 'NULL';
$water_turbidity = isset($_POST['turbidity']) ? $conn->real_escape_string($_POST['turbidity']) : 'NULL';
$raindrop = isset($_POST['raindrop']) ? $conn->real_escape_string($_POST['raindrop']) : 'NULL';
$station = isset($_POST['station']) ? $conn->real_escape_string($_POST['station']) : 'NULL';

$sql_check = "SELECT turbidity, water_level, raindrop 
              FROM water_level_log 
              WHERE station = '$station' 
              ORDER BY id DESC LIMIT 1";

$result = $conn->query($sql_check);

if ($result && $result->num_rows > 0) {
    $last_entry = $result->fetch_assoc();

    if (
        $last_entry['turbidity'] == $water_turbidity &&
        $last_entry['water_level'] == $water_level &&
        $last_entry['raindrop'] == $raindrop
    ) {
        echo "No change in data. Skipping insertion.";
        exit;
    }
}


$sql_insert = "INSERT INTO water_level_log (turbidity, water_level, raindrop, station)
               VALUES ('$water_turbidity', '$water_level', '$raindrop', '$station')";

if ($conn->query($sql_insert) === TRUE) {
    echo "Data inserted successfully!";
} else {
    echo "Error: " . $sql_insert . "<br>" . $conn->error;
}




$conn->close();
?>
