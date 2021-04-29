<?php
$Email = $_POST['email'];
//$Email = "teststudent1@gmail.com";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$dbConnection = new mysqli('localhost', 'root', '', 'db2');
if ($dbConnection->connect_error) {
  die("Connection failed: " . $dbConnection->connect_error);
}

$response["success"] = "true";
  // get the user ID from the email
$stmt = $dbConnection->prepare("SELECT id FROM users Where email = ?");
if(false ===$stmt){
  $response["success"] = "false";
    echo json_encode($response);
}
$check = $stmt->bind_param("s", $Email);
if(false ===$check){
  $response["success"] = "false";
    echo json_encode($response);
}
$check = $stmt->execute();
if(false ===$check){
    $response["success"] = "false";
      echo json_encode($response);
}
$UserID = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);


/*

Gets the meeting ids from mentees

*/

$stmt = $dbConnection->prepare("SELECT meet_id FROM enroll Where mentee_id = ?");
if(false ===$stmt){
  $response["success"] = "false";
    echo json_encode($response);
}
$check = $stmt->bind_param("s", $UserID[0]['id']);
if(false ===$check){
  $response["success"] = "false";
    echo json_encode($response);
}
$check = $stmt->execute();
if(false ===$check){
    $response["success"] = "false";
    echo json_encode($response);
}

$MenteesIds = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

/*

Gets the meeting ids from mentors

*/

$stmt = $dbConnection->prepare("SELECT meet_id FROM enroll2 Where mentor_id = ?");
if(false ===$stmt){
  $response["success"] = "false";
    echo json_encode($response);
}
$check = $stmt->bind_param("s", $UserID[0]['id']);
if(false ===$check){
  $response["success"] = "false";
    echo json_encode($response);
}
$check = $stmt->execute();
if(false ===$check){
    $response["success"] = "false";
    echo json_encode($response);
}

$MentorIds = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
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
$materialIds = [];

//this is  the query to get the material ids from the mentee meetings
if(count($MenteesIds) > 0){
  for($i = 0; $i<count($MenteesIds);$i++){
    $query  = "SELECT material_id FROM assign
    INNER JOIN meetings ON assign.meet_id = {$MenteesIds[$i]['meet_id']}
    WHERE meetings.date >= '{$previousWeek->format('Y-m-d')}' AND meetings.date <= '{$currentWeek->format('Y-m-d')}'";
    $results = mysqli_query($dbConnection, $query);
    //var_dump($results);
   $row = mysqli_fetch_array ($results, MYSQLI_ASSOC);

      //var_dump($materialIds);
      //echo"|||||";
    //  var_dump($row['material_id']);
      array_push($materialIds, $row['material_id']);
    }
}
//this is the query to get the material ids from the mentor meetings
if(count($MentorIds) > 0){
  for($i = 0; $i<count($MentorIds);$i++){
    $query  = "SELECT material_id FROM assign
    INNER JOIN meetings ON assign.meet_id = {$MentorIds[$i]['meet_id']}
    WHERE meetings.date >= '{$previousWeek->format('Y-m-d')}' AND meetings.date <= '{$currentWeek->format('Y-m-d')}'";
    $results = mysqli_query($dbConnection, $query);
    $row = mysqli_fetch_array ($results, MYSQLI_ASSOC);
      array_push($materialIds, $row['material_id']);

  }
}

$stmt->close();

$response = array();
  //gets all the study material information
    for ($i = 0; $i < count($materialIds); $i++){
      $query = "SELECT * FROM material WHERE material_id = {$materialIds[$i]}";
      $result = mysqli_query($dbConnection, $query);
      while($row = mysqli_fetch_assoc($result)){
        $response[strval($i) . "cid"] = $row['material_id'];
        $response[strval($i) . "cTitle"] = $row['title'];
        $response[strval($i) . "cAuthor"] = $row['author'];
        $response[strval($i) . "cType"] = $row['type'];
        $response[strval($i) . "cUrl"] = $row['url'];
        $response[strval($i) . "cAssigned_date"] = $row['assigned_date'];
        $response[strval($i) . "cNotes"] = $row['notes'];
      }
    }

echo json_encode($response);
?>
