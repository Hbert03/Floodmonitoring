<?php
include('db.php');

$response = ["status" => "ok", "stations" => []];

$stations = [1, 2, 3];

foreach ($stations as $station) {
    $query = "SELECT station, water_level, date_acquired 
              FROM water_level_log 
              WHERE station = ? 
              ORDER BY date_acquired DESC 
              LIMIT 1";

    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $station);
        $stmt->execute();
        $stmt->bind_result($stationId, $waterLevel, $dateAcquired);
        
        if ($stmt->fetch()) {
            $lastTimestamp = strtotime($dateAcquired);
            $currentTime = time();
            $timeDifference = ($currentTime - $lastTimestamp) / 60; 
            
            if ($timeDifference > 15) {
                $response["status"] = "warning";
                $response["stations"][] = [
                    "station" => $stationId,
                    "message" => "No data received in the last 15 minutes at station $stationId"
                ];
            }
        } else {
            $response["status"] = "error";
            $response["stations"][] = [
                "station" => $station,
                "message" => "No data found for this station"
            ];
        }

        $stmt->close();
    }
}

header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
?>
