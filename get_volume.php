<?php
include 'db.php';
session_start();

$areas = [
    '1' => 1000, 
    '2' => 1200, 
    '3' => 1100  
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

    
$response = [
    'stations' => $data,
    'total_volume' => $totalVolume
];

header('Content-Type: application/json');
echo json_encode($response);
?>
