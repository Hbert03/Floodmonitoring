<?php
 include('db.php');
 $rooms_query = $conn->query("SELECT * FROM `location` LIMIT 1;");
 $room_object = new stdClass();
 
 if ($rooms_query && $row = $rooms_query->fetch_assoc()) {
     $room_object->location_name = $row["location_name"];
     $room_object->lat = $row["lat"];
     $room_object->lon = $row["lon"];
     
     // Return the location data for use by JavaScript
     echo json_encode($room_object);
 } else {
     echo json_encode(["error" => "Location data not found."]);
 }
 
 $conn->close();
?>
