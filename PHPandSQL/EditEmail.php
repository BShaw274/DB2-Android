<?php
$bool = false;
$mysqli = new mysqli('localhost', 'root', '', 'DB2');
$oldEmail = $_POST['OldEmail'];
$newEmail = $_POST['NewEmail'];

// Test Purposes only
/*
$newEmail = 'student1@gmail.com';
$oldEmail = 'student1@Gmail.com';
*/

$dbConnection = new mysqli('localhost', 'root', '', 'db2');
if ($dbConnection->connect_error) {
  die("Connection failed: " . $dbConnection->connect_error);
}

// Do the SQL value Update which updates the older email to become the new email entered
$stmt = $dbConnection->prepare("UPDATE users SET email = ? Where email = ?");
if(false ===$stmt){
  //die('prepare() failed: ' . htmlspecialchars($mysqli->error));
  $response["success"] = "false";
    echo json_encode($response);
//echo " Echoing Email update: ".$response["success"];
}
//bind old and new email for execute
$check = $stmt->bind_param("ss", $newEmail, $oldEmail);
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
//return true
else {
  $response["success"] = "true";
  echo json_encode($response);
}


  $stmt->close();
  //Update Error Checking to function Properly

  //echo " Echoing Email update: ".$response["success"]
//Email Update Done




 ?>
