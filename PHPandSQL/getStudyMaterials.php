<?php
$Email = $_POST['email'];
//$Email = "parent1@gmail.com";

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
$UserID = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
//var_dump($UserID);

/*

This section is for displaying study materials for the current and past meeting. It starts by getting the current date and
getting the meeting a for the current week and the previous week. After it gets those meeting Ids it then prints all of
the data within those materials.

*/
$currentDate = date('Y-m-d');
$currentWeek = new dateTime($currentDate);
$previousWeek = new dateTime($currentDate);

$currentWeek->modify('+1 week');
$previousWeek->modify('-1 week');

//this is  the query to get the material ids in the correct timeframe
$query  = "SELECT material_id FROM assign
INNER JOIN meetings ON assign.meet_id = meetings.meet_id
WHERE meetings.date >= '{$previousWeek->format('Y-m-d')}' AND meetings.date <= '{$currentWeek->format('Y-m-d')}'";
$results = mysqli_query($dbConnection, $query);

$materialIds = [];
while ($row = mysqli_fetch_array ($results, MYSQLI_ASSOC)) {
  //echo $meetingGrade;
  array_push($materialIds, $row['material_id']);
}

$stmt->close();
//echo "|||||||||||Var Dump Start";

//echo "Var Dump over|||||||||||";

$response = array();
  //get all info of users with id with for loop
  for ($i=0; $i<count($materialIds);$i++){
  

$stmt = $dbConnection->prepare("SELECT * FROM material Where id = ?");
if(false ===$stmt){
  //die('prepare() failed: ' . htmlspecialchars($mysqli->error));
  $response["success"] = "false";
    echo json_encode($response);
//echo " Echoing Email update: ".$response["success"];
}
$check = $stmt->bind_param("s", $materialIds[$i]['material_id']);
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
$MaterialsInfo = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

//var_dump($StudentsInfo);
// get the child info that correspond to the student id's
//$getUserInfo = "SELECT id, name, email, phone FROM users";
//$infoRes = $mysqli->query($getUserInfo);
//echo $i."|||";

$response[strval($i) . "cid"] = $MaterialsInfo[0]['material_id'];
$response[strval($i) . "cTitle"] = $MaterialsInfo[0]['title'];
$response[strval($i) . "cAuthor"] = $MaterialsInfo[0]['author'];
$response[strval($i) . "cType"] = $MaterialsInfo[0]['type'];
$response[strval($i) . "cUrl"] = $MaterialsInfo[0]['url'];
$response[strval($i) . "cAssigned_date"] = $MaterialsInfo[0]['assigned_date'];
//var_dump($response);
}// for close
//echo"||||||||||||End Result|||||||||";
echo json_encode($response);
?>
