<?php
include 'db.php';
session_start();

$W = 10;   // Width of the river (meters)
$D12 = 25; // Distance between station 1 and 2 (meters)
$D23 = 25; // Distance between station 2 and 3 (meters)
$B1 = 10;  // Riverbed level for station 1 (meters)
$B2 = 10;  // Riverbed level for station 2 (meters)
$B3 = 10;  // Riverbed level for station 3 (meters)

// Function to fetch the highest water level for today
function fetchHighestWaterLevel($conn, $station) {
    $stmt = $conn->prepare("SELECT water_level, UNIX_TIMESTAMP(date_acquired) AS timestamp FROM water_level_log WHERE station = ? AND DATE(date_acquired) = CURDATE() ORDER BY water_level DESC LIMIT 1");
    $stmt->bind_param("s", $station);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    return [
        'water_level' => $row['water_level'] ?? 0,
        'timestamp' => $row['timestamp'] ?? 0
    ];
}


$station1 = fetchHighestWaterLevel($conn, '1');
$station2 = fetchHighestWaterLevel($conn, '2');
$station3 = fetchHighestWaterLevel($conn, '3');

// Convert water levels (subtract riverbed height and convert to meters)
$h1 = max(0, ($station1['water_level'] - $B1) / 100);
$h2 = max(0, ($station2['water_level'] - $B2) / 100);
$h3 = max(0, ($station3['water_level'] - $B3) / 100);

// Get timestamps
$t1 = $station1['timestamp'];       
$t2 = $station2['timestamp'];
$t3 = $station3['timestamp'];

// Compute volume using the highest values for the day
$V12 = max(0, (1 / 2) * $W * (($h1 + $h2) / 2) * $D12);
$V23 = max(0, (1 / 2) * $W * (($h2 + $h3) / 2) * $D23);
$V_total = $V12 + $V23;

// Compute water speed (velocity) using time difference
$velocity12 = ($t2 > $t1) ? $D12 / ($t2 - $t1) : 0;
$velocity23 = ($t3 > $t2) ? $D23 / ($t3 - $t2) : 0;

// Return response as JSON
$response = [
    'highest_levels' => [
        'station_1' => $h1 * 100,  // Convert back to cm
        'station_2' => $h2 * 100,
        'station_3' => $h3 * 100
    ],
    'total_volume' => $V_total * 1000000,  // Convert to cm³
    'velocity' => [
        'station_1_to_2' => $velocity12,
        'station_2_to_3' => $velocity23
    ]
];

header('Content-Type: application/json');
echo json_encode($response);
?>
