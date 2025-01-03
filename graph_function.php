<?php

include('db.php');

function getStationData($stationId) {
    global $conn;

    if (!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    $data = array('labels' => array(), 'values' => array());
    $sql = "SELECT water_level, DATE_FORMAT(date_acquired, '%Y-%m-%d %H:%i:%s') AS date 
            FROM water_level_log 
            WHERE MONTH(date_acquired) = MONTH(CURDATE()) AND station = ? 
            ORDER BY date_acquired DESC";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $stationId);
        $stmt->execute();
        $stmt->bind_result($waterLevel, $date);

        while ($stmt->fetch()) {
            $data['labels'][] = $date;  
            $data['values'][] = $waterLevel; 
        }
        $stmt->close();
    } else {
        echo "SQL preparation error: " . $conn->error;
    }

    return $data;
}


$stationId = isset($_GET['station']) ? intval($_GET['station']) : 1; 
$data = getStationData($stationId);

header('Content-Type: application/json');
echo json_encode($data);

$conn->close();
?>

