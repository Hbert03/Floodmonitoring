<?php
$action = filter_input(INPUT_POST,"action");
$station = filter_input(INPUT_POST,"station");
include 'db.php';
session_start();

if($action == 'get_water_level_log'){
    $rooms_query=$conn->query("SELECT DISTINCT * FROM `water_level_log` WHERE `station` = '$station' GROUP BY `water_level` ORDER BY `date_acquired` LIMIT 20 ;");
    $resultObject = array();
    while( $row = $rooms_query->fetch_assoc()){
        $room_object = new stdClass();
        $room_object->ID = $row["ID"];
        $room_object->date_acquired = $row["date_acquired"];
        $room_object->raindrop = $row["raindrop"];
        $room_object->distance_cm = $row["water_level"];
        array_push($resultObject,$room_object);
    }
    echo json_encode($resultObject);
}
if($action == 'login'){
    $username = filter_input(INPUT_POST,"username");
    $password = filter_input(INPUT_POST,"password");
    $rooms_query=$conn->query("SELECT DISTINCT * FROM `users`  WHERE `username` = '$username' AND `password` = '$password';");
    $room_object = new stdClass();
    if(count($rooms_query->fetch_assoc()) != null){
        echo "OK";
    }
    else{
        echo "NO USER FOUND";
    }
}
if($action == 'logout'){
    $_SESSION["isLoggedin"] = false;
    session_destroy();
}
if($action == 'get_turbidity_and_raindrop'){
    $rooms_query=$conn->query("SELECT DISTINCT * FROM `water_level_log`  WHERE `station` = '$station' ORDER BY `date_acquired` DESC LIMIT 1;");
    $room_object = new stdClass();
    while( $row = $rooms_query->fetch_assoc()){
        $room_object->ID = $row["ID"];
        $room_object->date_acquired = $row["date_acquired"];
        $room_object->raindrop = $row["raindrop"];
        $room_object->turbidity = $row["turbidity"];
        $room_object->distance_cm = $row["water_level"];
    }
    echo json_encode($room_object);
}
if($action == 'get_yearly_history'){
    $rooms_query=$conn->query("SELECT YEAR(water_level_log.date_acquired) AS 'year', FORMAT(AVG(water_level_log.water_level),2) AS 'water_level' FROM water_level_log GROUP BY YEAR(water_level_log.date_acquired);");
    $result_array = array();
    while( $row = $rooms_query->fetch_assoc()){
        $room_object = new stdClass();
        $room_object->year = $row["year"];
        $room_object->water_level = $row["water_level"];
        array_push($result_array,$room_object);
    }
    echo json_encode($result_array);
}
if($action == 'get_monthly_history'){
    $rooms_query=$conn->query("SELECT MONTHNAME(water_level_log.date_acquired) AS 'month', FORMAT(AVG(water_level_log.water_level),2) AS 'water_level' FROM water_level_log GROUP BY MONTHNAME(water_level_log.date_acquired);");
    $result_array = array();
    while( $row = $rooms_query->fetch_assoc()){
        $room_object = new stdClass();
        $room_object->month = $row["month"];
        $room_object->water_level = $row["water_level"];
        array_push($result_array,$room_object);
    }
    echo json_encode($result_array);
}
if($action == 'get_daily_history'){
    $rooms_query=$conn->query("SELECT water_level_log.date_acquired AS 'day', FORMAT(AVG(water_level_log.water_level),2) AS 'water_level' FROM water_level_log GROUP BY water_level_log.date_acquired;");
    $result_array = array();
    while( $row = $rooms_query->fetch_assoc()){
        $room_object = new stdClass();
        $room_object->day = $row["day"];
        $room_object->water_level = $row["water_level"];
        array_push($result_array,$room_object);
    }
    echo json_encode($result_array);
}
if($action == 'get_default_location'){
    $rooms_query=$conn->query("SELECT  * FROM `location` LIMIT 1;");
    $room_object = new stdClass();
    while( $row = $rooms_query->fetch_assoc()){
        $room_object->location_name = $row["location_name"];
        $room_object->lat = $row["lat"];
        $room_object->lon = $row["lon"];
    }
    echo json_encode($room_object);
}

?>