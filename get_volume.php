<?php
include 'db.php';
session_start();

// Cross-sectional areas (in cm²) for each station
$areas = [
    '1' => 1000, // Example area for station 1
    '2' => 1200, // Example area for station 2
    '3' => 1100  // Example area for station 3
];

function fetchLastInsertedData($conn, $station) {
    $stmt = $conn->prepare("SELECT * FROM `water_level_log` WHERE `station` = ? ORDER BY `date_acquired` DESC LIMIT 1");
    $stmt->bind_param("s", $station);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}


$data = [];
$totalVolume = 0;

foreach (['1', '2', '3'] as $station) {
    $record = fetchLastInsertedData($conn, $station);
    if ($record) {
        $volume = $areas[$station] * $record['water_level'];
        $record['volume_cm3'] = $volume; 
        $totalVolume += $volume; 
        $data["station_$station"] = $record; 
    }
}

// Prepare the response
$response = [
    'stations' => $data,
    'total_volume' => $totalVolume
];

header('Content-Type: application/json');
echo json_encode($response);
?>
