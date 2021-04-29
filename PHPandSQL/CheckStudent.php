<?php
$bool = false;
$mysqli = new mysqli('localhost', 'root', '', 'DB2');
$SEmail = $_POST['SEmail'];
$PEmail = $_POST['PEmail'];

$response["success"] = "false";
$dbConnection = new mysqli('localhost', 'root', '', 'db2');
if ($dbConnection->connect_error) {
  die("Connection failed: " . $dbConnection->connect_error);
}
// Get Parent ID from the email
$stmt = $dbConnection->prepare("SELECT id FROM users Where email = ?");
if(false ===$stmt){
  $response["success"] = "false";
    echo json_encode($response);
}
$check = $stmt->bind_param("s", $PEmail);
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


// Get student ID
$stmt = $dbConnection->prepare("SELECT id FROM users Where email = ?");
if(false ===$stmt){
  $response["success"] = "false";
    echo json_encode($response);
}
$check = $stmt->bind_param("s", $SEmail);
if(false ===$check){
  $response["success"] = "false";
    echo json_encode($response);
}
$check = $stmt->execute();
if(false ===$check){
    $response["success"] = "false";
      echo json_encode($response);
}
$StudentID = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);


//Check if sutdent id exist in students with parent_id = parent ID
$stmt = $dbConnection->prepare("SELECT student_id FROM students Where parent_id = ? AND student_id = ?");
if(false ===$stmt){
  $response["success"] = "false";
    echo json_encode($response);
}
$check = $stmt->bind_param("ss", $ParentID[0]["id"], $StudentID[0]["id"]);
if(false ===$check){
  $response["success"] = "false";
    echo json_encode($response);
}
$check = $stmt->execute();
if(false ===$check){
    $response["success"] = "false";
      echo json_encode($response);
}
$Result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
if(!(empty($Result))){
  $response["success"] = "true";
}
//var_dump($Result);

echo json_encode($response);

?>
