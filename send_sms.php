<?php
include 'db.php';  


$query = "SELECT station, water_level, date_acquired FROM water_level_log ORDER BY date_acquired DESC LIMIT 1";
$stmt = $conn->prepare($query);
$stmt->execute();
$result = $stmt->get_result();

$response = array('status' => 'no_action', 'message' => 'No action taken');

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $water_level = $row['water_level'];
    $station = $row['station'];

    // Map station ID to location name
    $station_locations = [
        '1' => 'Upper Stream',
        '2' => 'Middle Stream',
        '3' => 'Down Stream'
    ];
    
    // Get the station location name (default to 'Unknown Location' if not found)
    $station_location = isset($station_locations[$station]) ? $station_locations[$station] : 'Unknown Location';

    // Construct message based on water level
    if ($water_level < 50) { 
        $message = "⚠️ Critical Alert: Water level at $station_location (Station $station) is dangerously low at $water_level cm. Immediate action required!";
        $response['status'] = 'critical';
    } elseif ($water_level >= 50 && $water_level <= 70) { 
        $message = "⚠️ Warning: Water level at $station_location (Station $station) is at $water_level cm. Please monitor closely.";
        $response['status'] = 'warning';
    } else {
        $response['status'] = 'no_action';
        $response['message'] = "Water level at $station_location (Station $station) is normal ($water_level cm). No message sent.";
    }

    // Send SMS if critical or warning
    if ($response['status'] === 'critical' || $response['status'] === 'warning') {
        $recipients_query = $conn->prepare("SELECT phone_number FROM recipients WHERE 1= 1");
        $recipients_query->execute();
        $recipients_result = $recipients_query->get_result();

        if ($recipients_result->num_rows > 0) {
            $api_key = 'f770208e20af697387421fcf32ba90da';
            $sender_name = 'BNHSAdmin';

            $sms_status = array();

            while ($recipient = $recipients_result->fetch_assoc()) {
                $phone_number = $recipient['phone_number'];

                // Convert local phone numbers to international format
                if (strpos($phone_number, '0') === 0) {
                    $phone_number = '+63' . substr($phone_number, 1);
                }

                // Send SMS via Semaphore
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
                $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);

                // Validate API response
                if ($http_status == 200 && $output) {
                    $sms_status[] = "SMS sent to $phone_number.";
                } else {
                    $sms_status[] = "Failed to send SMS to $phone_number.";
                }
            }

            $response['status'] = 'sms_sent';
            $response['message'] = implode(" | ", $sms_status);
        } else {
            $response['status'] = 'no_recipients';
            $response['message'] = "No recipients found for $station_location (Station $station).";
        }
    }
} else {
    $response['status'] = 'no_data';
    $response['message'] = "No water level data found.";
}

// Return response as JSON
echo json_encode($response);
?>
