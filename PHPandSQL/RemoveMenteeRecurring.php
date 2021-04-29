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



//Get mentee that pertains to meeting
$stmt = $dbConnection->prepare("SELECT mentee_id FROM enroll where mentee_id=? ");
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

$menteeToBeRemoved=$stmt->get_result()->fetch_all(MYSQLI_ASSOC);


for ($i=0; $i<count($menteeToBeRemoved); $i++){
//Remove mentee from enroll table for single meeting
$stmt = $dbConnection->prepare("DELETE FROM enroll Where meet_id = ? AND mentee_id=? ");
if(false ===$stmt){
  $response["success"] = "false";
  echo json_encode($response);
  die('prepare() failed: ' . htmlspecialchars($mysqli->error));
}
$check = $stmt->bind_param("ss", $idOfRecurringMeeting[$i]['meet_id'], $menteeToBeRemoved[0]['mentee_id']);
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
