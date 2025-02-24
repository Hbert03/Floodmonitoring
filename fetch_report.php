<?php
include('db.php');
$timeRange = isset($_GET['time_range']) ? $_GET['time_range'] : 'hour';
$station = isset($_GET['station']) ? $_GET['station'] : '';

$stationFilter = $station ? "AND station = '$station'" : '';

switch ($timeRange) {
    case 'minute':
        $sql = "SELECT station, water_level, DATE_FORMAT(date_acquired, '%H:%i:%s') AS date 
                FROM water_level_log 
                WHERE date_acquired >= NOW() - INTERVAL 1 HOUR 
                $stationFilter
                ORDER BY date_acquired DESC";
        break;
    case 'hour':
        $sql = "SELECT station, water_level, DATE_FORMAT(date_acquired, '%Y-%m-%d %H:%i') AS date 
                FROM water_level_log 
                WHERE date_acquired >= NOW() - INTERVAL 24 HOUR 
                $stationFilter
                ORDER BY date_acquired DESC";
        break;
    case 'day':
        $sql = "SELECT station, water_level, DATE_FORMAT(date_acquired, '%Y-%m-%d') AS date 
                FROM water_level_log 
                WHERE date_acquired >= NOW() - INTERVAL 7 DAY 
                $stationFilter
                ORDER BY date_acquired DESC";
        break;
    case 'month':
        $sql = "SELECT station, water_level, DATE_FORMAT(date_acquired, '%Y-%m') AS date 
                FROM water_level_log 
                WHERE date_acquired >= NOW() - INTERVAL 12 MONTH 
                $stationFilter
                ORDER BY date_acquired DESC";
        break;
    default:
        $sql = "SELECT station, water_level, DATE_FORMAT(date_acquired, '%Y-%m-%d %H:%i:%s') AS date 
                FROM water_level_log 
                $stationFilter
                ORDER BY date_acquired DESC";
        break;
}

$result = $conn->query($sql);

$data = " <h2 class='text-center'>DATA REPORT</h2>
<table class='table table-bordered print'>
            <thead>
                <tr>
                    <th style='width:500px'>Date</th>
                    <th>Station</th>
                    <th style='width:300px'>Water Level (cm)</th>
                </tr>
            </thead>
            <tbody>";

while ($row = $result->fetch_assoc()) {
    $data .= "<tr>
                <td>{$row['date']}</td>
                <td>Station {$row['station']}</td>
                <td>{$row['water_level']} cm</td>
              </tr>";
}

$data .= "</tbody></table>";

echo $data;

$conn->close();
?>
