<?php
$Email = $_POST['email'];

$dbConnection = new mysqli('localhost', 'root', '', 'db2');
if ($dbConnection->connect_error) {
  die("Connection failed: " . $dbConnection->connect_error);
}

$response["success"] = "true";

// get the parent Id based off the email
$stmt = $dbConnection->prepare("SELECT id FROM users Where email = ?");
if(false ===$stmt){
  $response["success"] = "false";
    echo json_encode($response);
}
$check = $stmt->bind_param("s", $Email);
if(false ===$check){
  $response["success"] = "false";
    echo json_encode($response);
}
$check = $stmt->execute();
if(false ===$check){
    $response["success"] = "false";
      echo json_encode($response);
}
$ParentID = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);



//get all student_ids with parent id
$stmt = $dbConnection->prepare("SELECT student_id FROM students Where parent_id = ?");
if(false ===$stmt){
  $response["success"] = "false";
    echo json_encode($response);
}
$check = $stmt->bind_param("s", $ParentID[0]['id']);
if(false ===$check){
  $response["success"] = "false";
    echo json_encode($response);
}
$check = $stmt->execute();
if(false ===$check){
    $response["success"] = "false";
    echo json_encode($response);
}

$StudentIDs = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();


$response = array();
  //get all info of users with id with for loop
  for ($i=0; $i<count($StudentIDs);$i++){

$stmt = $dbConnection->prepare("SELECT * FROM users Where id = ?");
if(false ===$stmt){
  $response["success"] = "false";
    echo json_encode($response);
}
$check = $stmt->bind_param("s", $StudentIDs[$i]['student_id']);
if(false ===$check){
  $response["success"] = "false";
    echo json_encode($response);
}
$check = $stmt->execute();
if(false ===$check){
    $response["success"] = "false";
      echo json_encode($response);
}
$StudentsInfo = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// get the child info that correspond to the student id's
$response[strval($i) . "cid"] = $StudentsInfo[0]['id'];
$response[strval($i) . "cName"] = $StudentsInfo[0]['name'];
$response[strval($i) . "cEmail"] = $StudentsInfo[0]['email'];
$response[strval($i) . "cPhone"] = $StudentsInfo[0]['phone'];
}// for close
echo json_encode($response);
?>
