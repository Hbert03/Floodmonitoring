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

if ($water_level < 50) {
    // Prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT phone_number FROM recipients WHERE station = ?");
    $stmt->bind_param("s", $station);  // Assuming $station is a string
    $stmt->execute();
    $recipients_result = $stmt->get_result();

    if ($recipients_result && $recipients_result->num_rows > 0) {
        $message = "Alert: Water level at station $station is critically low ($water_level). Please take precautionary measures."; // Define message early

        while ($recipient = $recipients_result->fetch_assoc()) {
            $phone_number = $recipient['phone_number'];

            $api_key = 'f770208e20af697387421fcf32ba90da';
            if (strpos($phone_number, '0') === 0) {
                $phone_number = '+63' . substr($phone_number, 1); 
            }

    
            $url = "https://api.semaphore.co/api/v4/messages?apikey=$api_key&number=$phone_number&message=" . urlencode($message);
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);

            if ($response) {
                echo "SMS sent to $phone_number\n";
            } else {
                echo "Failed to send SMS to $phone_number\n";
            }
        }
    } else {
        echo "No recipients found for station $station.";
    }
}


$conn->close();
?>
