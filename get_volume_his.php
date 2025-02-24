<?php
include 'db.php';

$filter = $_GET['filter'] ?? 'day';  
$stations = [1, 2, 3];

switch ($filter) {
    case 'month':
        $groupBy = "DATE_FORMAT(date_acquired, '%Y-%m')";  
        break;
    case 'year':
        $groupBy = "YEAR(date_acquired)";  
        break;
    default:
        $groupBy = "DATE(date_acquired)";  
        break;
}


$query = " SELECT 
        station,
        $groupBy AS period, 
        SUM((1 / 2) * 10 * ((water_level) / 2) * 25) AS volume,
        COUNT(*) AS readings
    FROM water_level_log 
    GROUP BY station, period 
    ORDER BY period DESC, station ASC
";

$result = $conn->query($query);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = [
        'station' => "Station " . $row['station'],
        'period' => $row['period'],
        'volume' => number_format($row['volume'], 2),
        'readings' => $row['readings']
    ];
}

header('Content-Type: application/json');
echo json_encode(['data' => $data]);
?>
