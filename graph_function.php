<?php
include('db.php');

function getAllStationsData() {
    global $conn;

    if (!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    $fixedHeight = 304;

    $data = [
        'labels' => [],
        'stations' => [
            'station1' => ['values' => [], 'label' => 'Station 1'],
            'station2' => ['values' => [], 'label' => 'Station 2'],
            'station3' => ['values' => [], 'label' => 'Station 3'],
        ]
    ];

    $sql = "SELECT station, water_level, DATE_FORMAT(date_acquired, '%Y-%m-%d %H:%i:%s') AS date 
            FROM water_level_log 
            WHERE MONTH(date_acquired) = MONTH(CURDATE()) 
            ORDER BY date_acquired DESC";

    $result = $conn->query($sql);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            if (!in_array($row['date'], $data['labels'])) {
                $data['labels'][] = $row['date'];
            }
            if ($row['water_level'] > 300) {
                continue;
            }

            $actualWaterLevel = $fixedHeight - floatval($row['water_level']);
            
            switch ($row['station']) {
                case 1:
                    $data['stations']['station1']['values'][] = $actualWaterLevel;
                    break;
                case 2:
                    $data['stations']['station2']['values'][] = $actualWaterLevel;
                    break;
                case 3:
                    $data['stations']['station3']['values'][] = $actualWaterLevel;
                    break;
            }
        }
    }

    header('Content-Type: application/json');
    echo json_encode($data);

    $conn->close();
}

getAllStationsData();
?>
