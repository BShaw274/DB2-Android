<?php
//$Email = $_POST['email'];
$Email = "parent1@gmail.com";

$dbConnection = new mysqli('localhost', 'root', '', 'db2');
if ($dbConnection->connect_error) {
  die("Connection failed: " . $dbConnection->connect_error);
}

$response["success"] = "true";
  // get id
$stmt = $dbConnection->prepare("SELECT id FROM users Where email = ?");
if(false ===$stmt){
  //die('prepare() failed: ' . htmlspecialchars($mysqli->error));
  $response["success"] = "false";
    echo json_encode($response);
}
$check = $stmt->bind_param("s", $Email);
if(false ===$check){
  //die('bind_param() failed: ' . htmlspecialchars($stmt->error));
  $response["success"] = "false";
    echo json_encode($response);
}
$check = $stmt->execute();
if(false ===$check){
  //die('execute() failed: ' . htmlspecialchars($stmt->error));
    $response["success"] = "false";
      echo json_encode($response);
}
$ParentID = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
//var_dump($ParentID);


  //get all student_ids with parent id
$stmt = $dbConnection->prepare("SELECT student_id FROM students Where parent_id = ?");
if(false ===$stmt){
  //die('prepare() failed: ' . htmlspecialchars($mysqli->error));
  $response["success"] = "false";
    echo json_encode($response);
}
$check = $stmt->bind_param("s", $ParentID[0]['id']);
if(false ===$check){
  //die('bind_param() failed: ' . htmlspecialchars($stmt->error));
  $response["success"] = "false";
    echo json_encode($response);
}
$check = $stmt->execute();
if(false ===$check){
  //die('execute() failed: ' . htmlspecialchars($stmt->error));
    $response["success"] = "false";
    echo json_encode($response);
}

$StudentIDs = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();
//echo "|||||||||||Var Dump Start";
//var_dump($StudentIDs);
//echo "Var Dump over|||||||||||";

$response = array();
  //get all info of users with id with for loop
  for ($i=0; $i<count($StudentIDs);$i++){
  //  echo "Running X times: ".$i." IDs: ";
  //  echo $StudentIDs[$i]['student_id'];

$stmt = $dbConnection->prepare("SELECT * FROM users Where id = ?");
if(false ===$stmt){
  //die('prepare() failed: ' . htmlspecialchars($mysqli->error));
  $response["success"] = "false";
    echo json_encode($response);
//echo " Echoing Email update: ".$response["success"];
}
$check = $stmt->bind_param("s", $StudentIDs[$i]['student_id']);
if(false ===$check){
  //die('bind_param() failed: ' . htmlspecialchars($stmt->error));
  $response["success"] = "false";
    echo json_encode($response);
//echo " Echoing Email update: ".$response["success"];
}
$check = $stmt->execute();
if(false ===$check){
  //die('execute() failed: ' . htmlspecialchars($stmt->error));
    $response["success"] = "false";
      echo json_encode($response);
}
$StudentsInfo = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

//var_dump($StudentsInfo);
// get the child info that correspond to the student id's
//$getUserInfo = "SELECT id, name, email, phone FROM users";
//$infoRes = $mysqli->query($getUserInfo);
//echo $i."|||";

$response[strval($i) . "cid"] = $StudentsInfo[0]['id'];
$response[strval($i) . "cName"] = $StudentsInfo[0]['name'];
$response[strval($i) . "cEmail"] = $StudentsInfo[0]['email'];
$response[strval($i) . "cPhone"] = $StudentsInfo[0]['phone'];
//var_dump($response);
}// for close
//echo"||||||||||||End Result|||||||||";
echo json_encode($response);
?>
