<?php
include ('db.php');


if (isset($_POST['save'])){

    $fname = $_POST['firstname'];
    $mname = $_POST['middlename'];
    $lname = $_POST['lastname'];
    $phone = $_POST['phone'];
    $residents = $_POST['residents'];



        $query = "INSERT INTO recipients (firstname, middlename, lastname, phone_number, residents_type) VALUES(?, ?,?,?,?)";
        $stmt = $conn->prepare($query);

        if($stmt){
            $stmt->bind_param("sssss", $fname, $mname, $lname, $phone, $residents);

         if($stmt->execute()){
            echo json_encode(["success"=> true]);
         }else{
            echo json_encode(["success"=>false, "error"=>$stmt->error]);
         }
        }

}
?>