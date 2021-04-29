<?php
$OEmail = $_POST['OldEmail'];
$NEmail = $_POST['NewEmail'];
$password = $_POST['password'];
$phone = $_POST['phone'];


// Test Purposes only
/*
$OEmail = "student444@gmail.com";
$NEmail = "student4@gmail.com";
$password = "pass";
$phone = "978-555-";
*/
//json response
$response["success"] = "true";

//connect to db
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
//bind email
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

//variable that stores logged in ID
$StudentID = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
//var_dump($StudentID);

//This makes sure a new email is typed in
if (!empty($NEmail)){
  //this query updates the old email with the new email entered
$stmt = $dbConnection->prepare("UPDATE users SET email = ? Where id = ?");
if(false ===$stmt){
  //die('prepare() failed: ' . htmlspecialchars($mysqli->error));
  $response["success"] = "false";
    echo json_encode($response);
}
//Binds new email and id of student
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

//This updates password of the user
if (!empty($password)){
$stmt = $dbConnection->prepare("UPDATE users SET password = ? Where id = ?");
if(false ===$stmt){
  //die('prepare() failed: ' . htmlspecialchars($mysqli->error));
  $response["success"] = "false";
    echo json_encode($response);
}
//bind password and id of student for execute
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

//This updates phone of the user
if (!empty($phone)){
  //Update phone query
$stmt = $dbConnection->prepare("UPDATE users SET phone = ? Where id = ?");
if(false ===$stmt){
  //die('prepare() failed: ' . htmlspecialchars($mysqli->error));
  $response["success"] = "false";
    echo json_encode($response);
}
//bind phone and id of student
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
//send back json response
echo json_encode($response);


?>
