<?php
$bool = false;
$mysqli = new mysqli('localhost', 'root', '', 'DB2');
$oldEmail = $_POST['OldEmail'];
$newEmail = $_POST['NewEmail'];

/* Test Purposes only
$newEmail = 'EditEmail@gmail.com';
$oldEmail = 'parent3@Gmail.com';
*/
$dbConnection = new mysqli('localhost', 'root', '', 'db2');
if ($dbConnection->connect_error) {
  die("Connection failed: " . $dbConnection->connect_error);
}

// Do the SQL value Update
$stmt = $dbConnection->prepare("UPDATE users SET email = ? Where email = ?");
if(false ===$stmt){
  die('prepare() failed: ' . htmlspecialchars($mysqli->error));
}
$check = $stmt->bind_param("ss", $newEmail, $oldEmail);
if(false ===$check){
  die('bind_param() failed: ' . htmlspecialchars($stmt->error));
}
$check = $stmt->execute();
if(false ===$check){
  die('execute() failed: ' . htmlspecialchars($stmt->error));
}
  $stmt->close();
  //Update Error Checking to function Properly
  $response["success"] = "true";
  echo json_encode($response);
  //echo " Echoing Email update: ".$newEmail;
//Email Update Done




 ?>
