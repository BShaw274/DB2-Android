<?php
// Getting info posted from userSignupStudent.html form action line 10
$email = $_POST['email'];
$password = $_POST['password'];
$name = $_POST['name'];
$phone = $_POST['phone'];
$grade = $_POST['grade'];
$parent_email = $_POST['paEmail'];



//Opening Connection to database and testing connection
$dbConnection = new mysqli('localhost', 'root', '', 'db2');
if ($dbConnection->connect_error) {
  die("Connection failed: " . $dbConnection->connect_error);
}


//This query matches an existing parent id to the Id entered in the parent id field
$stmt = $dbConnection->prepare("SELECT id FROM users Where email = ?");
if(false ===$stmt){
  die('prepare() failed: ' . htmlspecialchars($mysqli->error));
}
$check = $stmt->bind_param("s", $parent_email);
if(false ===$check){
  die('bind_param() failed: ' . htmlspecialchars($stmt->error));
}
$check = $stmt->execute();
if(false ===$check){
  die('execute() failed: ' . htmlspecialchars($stmt->error));
}
//Array holding results of valid parents
$validParentCheck = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);


if(empty($validParentCheck)){
  $response["success"] = "false";
}
//var_dump($validParentCheck);
if(!empty($validParentCheck)){
//This query matches an existing parent id to the Id entered in the parent id field
$stmt = $dbConnection->prepare("SELECT parent_id FROM parents Where parent_id = ?");
if(false ===$stmt){
  die('prepare() failed: ' . htmlspecialchars($mysqli->error));
}
$check = $stmt->bind_param("s", $validParentCheck[0]['id']);
if(false ===$check){
  die('bind_param() failed: ' . htmlspecialchars($stmt->error));
}
$check = $stmt->execute();
if(false ===$check){
  die('execute() failed: ' . htmlspecialchars($stmt->error));
}

$validID = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);


$stmt->close();

//Checks if there is any valid parents
if(!(empty($validID))){

$failurecheck="false";

//Uses Prepared Statements to prepare Query String, Uses bind_param to insert variables into the Query String
//then pushes the query to the Database with Execute()
//This specific prepared statesment inserts information about a student into the users table
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
  $response["success"] = "false";
  $failurecheck="true";
  //die('execute() failed: ' . htmlspecialchars($stmt->error));

}
//Here im getting the ID of the User account previously created
//This allows me to open another connection and push the ID into Parent/Student/Admin table as necessary
$lastId = $stmt->insert_id;

//Closes stmt and connection
$stmt->close();
$dbConnection->close();



//Inserting ID into students
//Doing the above but just the ID into student table
//Connection opened and Tested
$dbConnection = new mysqli('localhost', 'root', '', 'db2');

if($failurecheck=="false"){
if ($dbConnection->connect_error) {
  die("Connection failed: " . $dbConnection->connect_error);
}
$stmt = $dbConnection->prepare("INSERT INTO students (student_id, grade, parent_id) VALUES (?, ? , ?)");
if(false ===$stmt){
  die('prepare() failed: ' . htmlspecialchars($mysqli->error));
}
$check = $stmt->bind_param("sss", $lastId, $grade, $validID[0]['parent_id']);
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
}
}
echo json_encode($response);
//If parent id is not valid then let user know and dont create account
if(empty($validParentCheck)){
  echo "Not valid parent cannot sign up";
}
?>
