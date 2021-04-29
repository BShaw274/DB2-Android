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

//Get mentor that pertains to meeting
$stmt = $dbConnection->prepare("SELECT mentor_id FROM enroll2 Where meet_id = ? AND mentor_id=? ");
if(false ===$stmt){
  $response["success"] = "false";
    echo json_encode($response);
  die('prepare() failed: ' . htmlspecialchars($mysqli->error));
}
$check = $stmt->bind_param("ss", $meetingId, $validLogin[0]['id']);
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


//Remove mentor from enroll2 table for single meeting
$stmt = $dbConnection->prepare("DELETE FROM enroll2 Where meet_id = ? AND mentor_id=? ");
if(false ===$stmt){
  $response["success"] = "false";
    echo json_encode($response);
  die('prepare() failed: ' . htmlspecialchars($mysqli->error));
}
$check = $stmt->bind_param("ss", $meetingId, $mentorToBeRemoved[0]['mentor_id']);
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

//check if still mentors
$stmt = $dbConnection->prepare("SELECT mentor_id FROM enroll2 Where mentor_id=? ");
if(false ===$stmt){
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
