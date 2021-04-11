<?php
$bool = false;
$mysqli = new mysqli('localhost', 'root', '', 'DB2');
$NewPhone = $_POST['NewPhone'];
$Email = $_POST['Email'];

/* Test Purposes only
$newPhone = 'EditPhone@gmail.com';
$oldPhone = 'parent3@Gmail.com';
*/
$dbConnection = new mysqli('localhost', 'root', '', 'db2');
if ($dbConnection->connect_error) {
  die("Connection failed: " . $dbConnection->connect_error);
}

// Do the SQL value Update
$stmt = $dbConnection->prepare("UPDATE users SET phone = ? Where Email = ?");
if(false ===$stmt){
  die('prepare() failed: ' . htmlspecialchars($mysqli->error));
}
$check = $stmt->bind_param("ss", $NewPhone, $Email);
if(false ===$check){
  die('bind_param() failed: ' . htmlspecialchars($stmt->error));
}
$check = $stmt->execute();
if(false ===$check){
  die('execute() failed: ' . htmlspecialchars($stmt->error));
}
  $stmt->close();

 ?>
