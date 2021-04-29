<?php

//Info passed from remove meetings page
$meetingId = $_POST['meet_id'];
$Email= $_POST['email'];



//Opening Connection to database and testing connection
$dbConnection = new mysqli('localhost', 'root', '', 'db2');
if ($dbConnection->connect_error) {
  die("Connection failed: " . $dbConnection->connect_error);
}

$response["success"] = "false";
//Verifies logged in user
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
$validLogin = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);



//Get mentee that pertains to meeting
$stmt = $dbConnection->prepare("SELECT mentee_id FROM enroll Where meet_id = ? AND mentee_id=? ");
if(false ===$stmt){
  $response["success"] = "false";
    echo json_encode($response);
}
$check = $stmt->bind_param("ss", $meetingId, $validLogin[0]['id']);
if(false ===$check){
  $response["success"] = "false";
    echo json_encode($response);
}
$check = $stmt->execute();
if(false ===$check){
  $response["success"] = "false";
    echo json_encode($response);
}

$menteeToBeRemoved=$stmt->get_result()->fetch_all(MYSQLI_ASSOC);

//Remove mentee from enroll table for single meeting
$stmt = $dbConnection->prepare("DELETE FROM enroll Where meet_id = ? AND mentee_id=? ");
if(false ===$stmt){
  $response["success"] = "false";
    echo json_encode($response);
}
$check = $stmt->bind_param("ss", $meetingId, $menteeToBeRemoved[0]['mentee_id']);
if(false ===$check){
  $response["success"] = "false";
    echo json_encode($response);
}
$check = $stmt->execute();
if(false ===$check){
  $response["success"] = "false";
    echo json_encode($response);
}
else {
  $response["success"] = "true";
}



//Query To check if they are a mentee of another meeting

$stmt = $dbConnection->prepare("SELECT mentee_id FROM enroll Where mentee_id=? ");
if(false ===$stmt){
    $response["success"] = "false";
      echo json_encode($response);
}
$check = $stmt->bind_param("s", $menteeToBeRemoved[0]['mentee_id']);
if(false ===$check){
  $response["success"] = "false";
    echo json_encode($response);
}
$check = $stmt->execute();
if(false ===$check){
  $response["success"] = "false";
    echo json_encode($response);
}
$MenteeCheck=$stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// if student is no longer a mentee in any meetings then remove them from the mentee list
if(empty($MenteeCheck)){

    $stmt = $dbConnection->prepare("DELETE from mentees  WHERE mentee_id = (?)");
    if(false ===$stmt){
        $response["success"] = "false";
          echo json_encode($response);
    }
    $check = $stmt->bind_param("s", $menteeToBeRemoved[0]['mentee_id']);
    if(false ===$check){
      $response["success"] = "false";
        echo json_encode($response);
    }
    $check = $stmt->execute();
    if(false ===$check){
      $response["success"] = "false";
        echo json_encode($response);
    }
    $stmt->close();

}
// close connection and return confirmation
$dbConnection->close();

echo json_encode($response);
?>
