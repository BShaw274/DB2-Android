<?php

$email = $_POST['email'];
$password = $_POST['password'];
$name = $_POST['name'];
$phone = $_POST['phone'];

//Opening Connection to database and testing connection
$dbConnection = new mysqli('localhost', 'root', '', 'db2');
if ($dbConnection->connect_error) {
  die("Connection failed: " . $dbConnection->connect_error);
}

$failurecheck="false";
//Uses Prepared Statements to prepare Query String, Uses bind_param to insert variables into the Query String e
//then pushes the query to the Database with Execute()
//Inserts information into the users table that was entered
$stmt = $dbConnection->prepare("INSERT INTO users (email, password, name, phone) VALUES (?, ?, ?, ?)");
if(false ===$stmt){
  die('prepare() failed: ' . htmlspecialchars($mysqli->error));
}
$check = $stmt->bind_param("ssss", $email, $password, $name,$phone);
if(false ===$check){
  die('bind_param() failed: ' . htmlspecialchars($stmt->error));
}
$check = $stmt->execute();
if(false ===$check){
  //die('execute() failed: ' . htmlspecialchars($stmt->error));
  $response["success"] = "false";
  $failurecheck="true";
}
//Here im getting the ID of the User account previously created
//This allows me to open another connection and push the ID into Parent/Student/Admin table as necessary
$lastId = $stmt->insert_id;
//Closes stmt and connection

$stmt->close();
$dbConnection->close();


if ($failurecheck=="false"){
//Inserting ID into parents
//Doing the above but just the ID into parent table, parent_id
//Connection opened and Tested
$dbConnection = new mysqli('localhost', 'root', '', 'db2');
if ($dbConnection->connect_error) {
  die("Connection failed: " . $dbConnection->connect_error);
}
$stmt = $dbConnection->prepare("INSERT INTO parents (parent_id) VALUES (?)");
if(false ===$stmt){
  die('prepare() failed: ' . htmlspecialchars($mysqli->error));
}
$check = $stmt->bind_param("s", $lastId);
if(false ===$check){
  die('bind_param() failed: ' . htmlspecialchars($stmt->error));
}

$check = $stmt->execute();
if(false ===$check){
  die('execute() failed: ' . htmlspecialchars($stmt->error));
}
$response["success"] = "true";
$stmt->close();
$dbConnection->close();
}
echo json_encode($response);
?>
