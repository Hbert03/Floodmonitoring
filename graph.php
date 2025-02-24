<?php
include('db.php');

function getAllStationsData1($timeRange) {
    global $conn;


    $fixedHeight = 304;

    if (!$conn) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    $data = [
        'labels' => [],
        'stations' => [
            'station1' => ['values' => [], 'label' => 'Station 1'],
            'station2' => ['values' => [], 'label' => 'Station 2'],
            'station3' => ['values' => [], 'label' => 'Station 3'],
        ],
        'fixed_lines' => [
            'eight_ft' => [],
            'warning' => [],
            'critical' => []
        ]
    ];

    switch ($timeRange) {
        case 'minute':
            $sql = "SELECT station, water_level, DATE_FORMAT(date_acquired, '%H:%i:%s') AS date 
                    FROM water_level_log 
                    WHERE date_acquired >= NOW() - INTERVAL 1 HOUR 
                    ORDER BY date_acquired ASC";
            break;
        case 'hour':
            $sql = "SELECT station, water_level, DATE_FORMAT(date_acquired, '%H:%i') AS date 
                    FROM water_level_log 
                    WHERE date_acquired >= NOW() - INTERVAL 24 HOUR 
                    ORDER BY date_acquired ASC";
            break;
        case 'day':
            $sql = "SELECT station, water_level, DATE_FORMAT(date_acquired, '%Y-%m-%d') AS date 
                    FROM water_level_log 
                    WHERE date_acquired >= NOW() - INTERVAL 7 DAY 
                    ORDER BY date_acquired ASC";
            break;
        case 'month':
            $sql = "SELECT station, water_level, DATE_FORMAT(date_acquired, '%Y-%m') AS date 
                    FROM water_level_log 
                    WHERE date_acquired >= NOW() - INTERVAL 12 MONTH 
                    ORDER BY date_acquired ASC";
            break;
        default:
            $sql = "SELECT station, water_level, DATE_FORMAT(date_acquired, '%Y-%m-%d %H:%i:%s') AS date 
                    FROM water_level_log 
                    ORDER BY date_acquired ASC";
            break;
    }

    $result = $conn->query($sql);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            // Remove outliers (e.g., ignoring values greater than 400 cm)
            if ($row['water_level'] > 300) {
                continue;
            }

            if (!in_array($row['date'], $data['labels'])) {
                $data['labels'][] = $row['date'];
                
                // Add fixed values for reference lines
          
                $data['fixed_lines']['warning'][] = 210;
                $data['fixed_lines']['critical'][] = 304;
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

$timeRange = isset($_GET['time_range']) ? $_GET['time_range'] : 'hour'; 
getAllStationsData1($timeRange);
?>
