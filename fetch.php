<?php
include('db.php');
if (isset($_POST['history'])) {
    function getDataTable($draw, $start, $length, $search) {
        global $conn;

        $sortBy = isset($_POST['sortby']) ? $_POST['sortby'] : '';
        $groupBy = '';
        $selectDate = 'date_acquired AS grouped_date';
        

        if ($sortBy == 'day') {
            $groupBy = "DATE(date_acquired)";
            $selectDate = "DATE(date_acquired) AS grouped_date";
        } elseif ($sortBy == 'month') {
            $groupBy = "YEAR(date_acquired), MONTH(date_acquired)";
            $selectDate = "CONCAT(YEAR(date_acquired), '-', LPAD(MONTH(date_acquired), 2, '0')) AS grouped_date";
        } elseif ($sortBy == 'year') {
            $groupBy = "YEAR(date_acquired)";
            $selectDate = "YEAR(date_acquired) AS grouped_date";
        }

        $query1 = "SELECT $selectDate, AVG(water_level) AS average_water_level 
                   FROM water_level_log WHERE 1=1";

        if (!empty($search)) {
            $escapedSearch = $conn->real_escape_string($search);
            $query1 .= " AND (date_acquired LIKE '%$escapedSearch%' OR water_level LIKE '%$escapedSearch%')";
        }

        if (!empty($groupBy)) {
            $query1 .= " GROUP BY $groupBy";
        }

        $query1 .= " LIMIT " . intval($start) . ", " . intval($length);

        $result1 = $conn->query($query1);
        if (!$result1) {
            die("Query failed: " . $conn->error);
        }

        $data = array();
        while ($row = $result1->fetch_assoc()) {
            $data[] = $row;
        }

        $output = array(
            "draw" => intval($draw),
            "recordsTotal" => count($data),
            "recordsFiltered" => count($data),
            "data" => $data
        );

        return json_encode($output);
    }

    $draw = $_POST["draw"];
    $start = $_POST["start"];
    $length = $_POST["length"];
    $search = $_POST["search"]["value"];

    echo getDataTable($draw, $start, $length, $search);
    exit();
}




?>