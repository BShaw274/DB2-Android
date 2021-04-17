<?php
// Getting info posted from userSignupStudent.html form action line 10
///*
$OEmail = $_POST['OldEmail'];
$NEmail = $_POST['NewEmail'];
$password = $_POST['password'];
$phone = $_POST['phone'];
//*/

// Test Purposes only
/*
$OEmail = "student444@gmail.com";
$NEmail = "student4@gmail.com";
$password = "pass";
$phone = "978-555-";
*/
$response["success"] = "true";
$dbConnection = new mysqli('localhost', 'root', '', 'db2');
if ($dbConnection->connect_error) {
  die("Connection failed: " . $dbConnection->connect_error);
}
// Get student ID
$stmt = $dbConnection->prepare("SELECT id FROM users Where email = ?");
if(false ===$stmt){
  //die('prepare() failed: ' . htmlspecialchars($mysqli->error));
  $response["success"] = "false";
    echo json_encode($response);
}
$check = $stmt->bind_param("s", $OEmail);
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
$StudentID = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
//var_dump($StudentID);

if (!empty($NEmail)){
$stmt = $dbConnection->prepare("UPDATE users SET email = ? Where id = ?");
if(false ===$stmt){
  //die('prepare() failed: ' . htmlspecialchars($mysqli->error));
  $response["success"] = "false";
    echo json_encode($response);
}
$check = $stmt->bind_param("ss", $NEmail, $StudentID[0]['id']);
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
  $stmt->close();
}

if (!empty($password)){
$stmt = $dbConnection->prepare("UPDATE users SET password = ? Where id = ?");
if(false ===$stmt){
  //die('prepare() failed: ' . htmlspecialchars($mysqli->error));
  $response["success"] = "false";
    echo json_encode($response);
}
$check = $stmt->bind_param("ss", $password, $StudentID[0]['id']);
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
  $stmt->close();
}

if (!empty($phone)){
$stmt = $dbConnection->prepare("UPDATE users SET phone = ? Where id = ?");
if(false ===$stmt){
  //die('prepare() failed: ' . htmlspecialchars($mysqli->error));
  $response["success"] = "false";
    echo json_encode($response);
}
$check = $stmt->bind_param("ss", $phone, $StudentID[0]['id']);
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
  $stmt->close();
}
echo json_encode($response);


?>
