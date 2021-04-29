<?php
$bool = false;
$mysqli = new mysqli('localhost', 'root', '', 'DB2');
$NewPassword = $_POST['NewPassword'];
$Email = $_POST['Email'];

/* Test Purposes only
$newPassword = 'EditPassword@gmail.com';
$oldPassword = 'parent3@Gmail.com';
*/

//Connect to database
$dbConnection = new mysqli('localhost', 'root', '', 'db2');
if ($dbConnection->connect_error) {
  die("Connection failed: " . $dbConnection->connect_error);
}

// Do the SQL value Update and update password
$stmt = $dbConnection->prepare("UPDATE users SET password = ? Where Email = ?");
if(false ===$stmt){
  die('prepare() failed: ' . htmlspecialchars($mysqli->error));
}
//bind password and email
$check = $stmt->bind_param("ss", $NewPassword, $Email);
if(false ===$check){
  die('bind_param() failed: ' . htmlspecialchars($stmt->error));
}
$check = $stmt->execute();
if(false ===$check){
  die('execute() failed: ' . htmlspecialchars($stmt->error));
}
  $stmt->close();

 ?>
