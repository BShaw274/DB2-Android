<?php

//Info passed from remove meetings page
$meetingId = $_POST['meet_id'];
$Email= $_POST['email'];

$response["success"] = "true";


//Opening Connection to database and testing connection
$dbConnection = new mysqli('localhost', 'root', '', 'db2');
if ($dbConnection->connect_error) {
  die("Connection failed: " . $dbConnection->connect_error);
}



//Verifies logged in user
$stmt = $dbConnection->prepare("SELECT id FROM users Where email = ?");
if(false ===$stmt){
  $response["success"] = "false";
  echo json_encode($response);
  die('prepare() failed: ' . htmlspecialchars($mysqli->error));
}
$check = $stmt->bind_param("s", $Email);
if(false ===$check){
  $response["success"] = "false";
  echo json_encode($response);
  die('bind_param() failed: ' . htmlspecialchars($stmt->error));
}
$check = $stmt->execute();
if(false ===$check){
  $response["success"] = "false";
  echo json_encode($response);
  die('execute() failed: ' . htmlspecialchars($stmt->error));
}

$validLogin = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

//Selects all meet_id with the same meetname
$stmt = $dbConnection->prepare("SELECT meet_name FROM meetings Where meet_id = ?");
if(false ===$stmt){
  $response["success"] = "false";
  echo json_encode($response);
  die('prepare() failed: ' . htmlspecialchars($mysqli->error));
}
$check = $stmt->bind_param("s", $meetingId);
if(false ===$check){
  $response["success"] = "false";
  echo json_encode($response);
  die('bind_param() failed: ' . htmlspecialchars($stmt->error));
}
$check = $stmt->execute();
if(false ===$check){
  $response["success"] = "false";
  echo json_encode($response);
  die('execute() failed: ' . htmlspecialchars($stmt->error));
}

$nameOfRecurringMeeting = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);


//Selects meet_id of all meetings with same name
$stmt = $dbConnection->prepare("SELECT meet_id FROM meetings Where meet_name = ?");
if(false ===$stmt){
  $response["success"] = "false";
  echo json_encode($response);
  die('prepare() failed: ' . htmlspecialchars($mysqli->error));
}
$check = $stmt->bind_param("s", $nameOfRecurringMeeting[0]['meet_name']);
if(false ===$check){
  $response["success"] = "false";
  echo json_encode($response);
  die('bind_param() failed: ' . htmlspecialchars($stmt->error));
}
$check = $stmt->execute();
if(false ===$check){
  $response["success"] = "false";
  echo json_encode($response);
  die('execute() failed: ' . htmlspecialchars($stmt->error));
}

$idOfRecurringMeeting = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);



//Get mentor that pertains to meeting
$stmt = $dbConnection->prepare("SELECT mentor_id FROM enroll2 where mentor_id=? ");
if(false ===$stmt){
  $response["success"] = "false";
  echo json_encode($response);
  die('prepare() failed: ' . htmlspecialchars($mysqli->error));
}
$check = $stmt->bind_param("s",  $validLogin[0]['id']);
if(false ===$check){
  $response["success"] = "false";
  echo json_encode($response);
  die('bind_param() failed: ' . htmlspecialchars($stmt->error));
}
$check = $stmt->execute();
if(false ===$check){
  $response["success"] = "false";
  echo json_encode($response);
  die('execute() failed: ' . htmlspecialchars($stmt->error));
}

$mentorToBeRemoved=$stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// loops through files to remove mentorship from meetings
for ($i=0; $i<count($mentorToBeRemoved); $i++){
//Remove mentor from enroll2 table for single meeting
$stmt = $dbConnection->prepare("DELETE FROM enroll2 Where meet_id = ? AND mentor_id=? ");
if(false ===$stmt){
  $response["success"] = "false";
  echo json_encode($response);
  die('prepare() failed: ' . htmlspecialchars($mysqli->error));
}
$check = $stmt->bind_param("ss", $idOfRecurringMeeting[$i]['meet_id'], $mentorToBeRemoved[0]['mentor_id']);
if(false ===$check){
  $response["success"] = "false";
  echo json_encode($response);
  die('bind_param() failed: ' . htmlspecialchars($stmt->error));
}
$check = $stmt->execute();
if(false ===$check){
  $response["success"] = "false";
  echo json_encode($response);
  die('execute() failed: ' . htmlspecialchars($stmt->error));
}
}

//CHeck to see if student is still a mentor
$stmt = $dbConnection->prepare("SELECT mentor_id FROM enroll2 Where mentor_id=? ");
if(false ===$stmt){
    //die('prepare() failed: ' . htmlspecialchars($mysqli->error));
    $response["success"] = "false";
      echo json_encode($response);
}
$check = $stmt->bind_param("s", $mentorToBeRemoved[0]['mentor_id']);
if(false ===$check){
  $response["success"] = "false";
    echo json_encode($response);
}
$check = $stmt->execute();
if(false ===$check){
  $response["success"] = "false";
    echo json_encode($response);
}
$MentorCheck=$stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// if student is no longer a mentor in any meetings then remove them from the mentor list
if(empty($MentorCheck)){
    $stmt = $dbConnection->prepare("DELETE from mentors  WHERE  mentor_id = (?)");
    if(false ===$stmt){
        die('prepare() failed: ' . htmlspecialchars($mysqli->error));
    }
    $check = $stmt->bind_param("s", $mentorToBeRemoved[0]['mentor_id']);
    if(false ===$check){
      die('bind_param() failed: ' . htmlspecialchars($stmt->error));
    }
    $check = $stmt->execute();
    if(false ===$check){
      die('execute() failed: ' . htmlspecialchars($stmt->error));
    }
    $stmt->close();
  }
// close connection and return confirmation
$dbConnection->close();
echo json_encode($response);
?>
