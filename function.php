<?php
include ('db.php');


if (isset($_POST['save'])){

    $fname = $_POST['firstname'];
    $mname = $_POST['middlename'];
    $lname = $_POST['lastname'];
    $phone = $_POST['phone'];
    $residents = $_POST['residents'];
    $station = $_POST['station'];


        $query = "INSERT INTO recipients (firstname, middlename, lastname, phone_number, residents_type, station) VALUES(?, ?, ?,?,?,?)";
        $stmt = $conn->prepare($query);

        if($stmt){
            $stmt->bind_param("ssssss", $fname, $mname, $lname, $phone, $residents, $station);

         if($stmt->execute()){
            echo json_encode(["success"=> true]);
         }else{
            echo json_encode(["success"=>false, "error"=>$stmt->error]);
         }
        }

}
?>