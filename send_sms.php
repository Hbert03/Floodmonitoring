<?php
include 'db.php';  // Database connection

// Get the station number from POST data
$station = filter_input(INPUT_POST, "station", FILTER_SANITIZE_NUMBER_INT);

// Fetch the latest water level data from the database
$query = "SELECT water_level, station, date_acquired FROM water_level_log WHERE station = ? ORDER BY date_acquired DESC LIMIT 1";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $station);
$stmt->execute();
$result = $stmt->get_result();

$response = array('status' => 'no_action', 'message' => 'No action taken');

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $water_level = $row['water_level'];
    $station = $row['station'];

    if ($water_level >= 51 && $water_level < 70) { 
        $message = "Warning: Water level at station $station is at $water_level cm. Please monitor closely.";
        $response['status'] = 'warning';
        $response['message'] = $message;
    } elseif ($water_level < 51) {
        $message = "Critical Alert: Water level at station $station is dangerously low at $water_level cm. Immediate action required!";
        $response['status'] = 'critical';
        $response['message'] = $message;
    }

    if ($response['status'] !== 'no_action') {

        $recipients_query = $conn->prepare("SELECT phone_number FROM recipients WHERE station = ?");
        $recipients_query->bind_param("i", $station);
        $recipients_query->execute();
        $recipients_result = $recipients_query->get_result();

        if ($recipients_result->num_rows > 0) {
            $api_key = 'f770208e20af697387421fcf32ba90da';  // Your Semaphore API key
            $sender_name = 'BNHSAdmin';  // Sender name

            while ($recipient = $recipients_result->fetch_assoc()) {
                $phone_number = $recipient['phone_number'];

                // Ensure the phone number is in international format
                if (strpos($phone_number, '0') === 0) {
                    $phone_number = '+63' . substr($phone_number, 1); // For Philippines: '+63' is the country code
                }

                // Send SMS using Semaphore API (via POST method)
                $ch = curl_init();
                $parameters = array(
                    'apikey' => $api_key,
                    'number' => $phone_number,
                    'message' => $message,
                    'sendername' => $sender_name
                );
                curl_setopt($ch, CURLOPT_URL, 'https://semaphore.co/api/v4/messages');
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $output = curl_exec($ch);
                curl_close($ch);

                // Check response
                if ($output) {
                    $response['status'] = 'sms_sent';
                    $response['message'] = "SMS sent to $phone_number.";
                } else {
                    $response['status'] = 'sms_failed';
                    $response['message'] = "Failed to send SMS to $phone_number.";
                }
            }
        } else {
            $response['status'] = 'no_recipients';
            $response['message'] = "No recipients found for station $station.";
        }
    }
} else {
    $response['status'] = 'no_data';
    $response['message'] = "No water level data found for station $station.";
}

// Return response as JSON
echo json_encode($response);
?>
