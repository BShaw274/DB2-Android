<?php
$Email = $_POST['email'];

$dbConnection = new mysqli('localhost', 'root', '', 'db2');
if ($dbConnection->connect_error) {
  die("Connection failed: " . $dbConnection->connect_error);
}

$response["success"] = "true";

//Get the Id of the user based off the email
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
$stmt->close();


//get all meetings the user is a mentor in
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
$MeetIdResult = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();


//Meeting ids for all the meetings the user is a mentor of
 if(!(empty($MeetIdResult))){
  $response = array();
  $LI = 0; // Loop Iteration
for($j=0; $j<count($MeetIdResult);$j++){
  //For loop will go through and print out mentors and mentees information for 1 specific meetings
  // before incrementing and checknig the next meeting untill there are no more meet_id's in $MeetIdResult

  $stmt = $dbConnection->prepare("SELECT mentor_id, meet_id FROM enroll2 Where meet_id = ? AND mentor_id != ?");
  if(false ===$stmt){
    die('prepare() failed: ' . htmlspecialchars($mysqli->error));
  }
  $check = $stmt->bind_param("ss", $MeetIdResult[$j]["meet_id"], $UserID[0]['id']);
  if(false ===$check){
    die('bind_param() failed: ' . htmlspecialchars($stmt->error));
  }
  $check = $stmt->execute();
  if(false ===$check){
    die('execute() failed: ' . htmlspecialchars($stmt->error));
  }
  $MentorIdResult = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
  $stmt->close();

 //MentorID then MeetID they are in

  //Gets mentor ID's for meeting we are checking so we can then query the info of those mentors
  if(!(empty($MentorIdResult))){

    for($i=0; $i<count($MentorIdResult); $i++){

      $stmt = $dbConnection->prepare("SELECT name, email  FROM users Where id= ?");
      if(false ===$stmt){
        die('prepare() failed: ' . htmlspecialchars($mysqli->error));
      }
      $check = $stmt->bind_param("s", $MentorIdResult[$i]["mentor_id"]);
      if(false ===$check){
        die('bind_param() failed: ' . htmlspecialchars($stmt->error));
      }
      $check = $stmt->execute();
      if(false ===$check){
        die('execute() failed: ' . htmlspecialchars($stmt->error));
      }
      $MentorInfoResult = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
      $stmt->close();
      $response[strval($LI) . "cid"] = $MentorIdResult[$i]["mentor_id"];;
      $response[strval($LI) . "Name"] = $MentorInfoResult[0]['name'];
      $response[strval($LI) . "Email"] = $MentorInfoResult[0]['email'];
      $response[strval($LI) . "Meeting"] = $MentorIdResult[0]["meet_id"];
      $response[strval($LI) . "Status"] = "Mentor of ";
      $LI++;
    }//for $MentorIdResult close
  }//Mentor ID Result isempty Close
  //Mentor Info all stored


  //Doing the same as before but for the mentees
  $stmt = $dbConnection->prepare("SELECT mentee_id, meet_id FROM enroll Where meet_id = ?");
  if(false ===$stmt){
    die('prepare() failed: ' . htmlspecialchars($mysqli->error));
  }
  $check = $stmt->bind_param("s", $MeetIdResult[$j]["meet_id"]);
  if(false ===$check){
    die('bind_param() failed: ' . htmlspecialchars($stmt->error));
  }
  $check = $stmt->execute();
  if(false ===$check){
    die('execute() failed: ' . htmlspecialchars($stmt->error));
  }
  $MenteeIdResult = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
  $stmt->close();
 //var_dump($MenteeIdResult);
//Get mentee Info
 if(!(empty($MenteeIdResult))){

   for($i=0; $i<count($MenteeIdResult); $i++){
     $stmt = $dbConnection->prepare("SELECT name, email  FROM users Where id= ?");
     if(false ===$stmt){
       die('prepare() failed: ' . htmlspecialchars($mysqli->error));
     }
     $check = $stmt->bind_param("s", $MenteeIdResult[$i]["mentee_id"]);
     if(false ===$check){
       die('bind_param() failed: ' . htmlspecialchars($stmt->error));
     }
     $check = $stmt->execute();
     if(false ===$check){
       die('execute() failed: ' . htmlspecialchars($stmt->error));
     }
     $MenteeInfoResult = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
     $stmt->close();
     $response[strval($LI) . "cid"] = $MenteeIdResult[$i]["mentee_id"];
     $response[strval($LI) . "Name"] = $MenteeInfoResult[0]['name'];
     $response[strval($LI) . "Email"] = $MenteeInfoResult[0]['email'];
     $response[strval($LI) . "Meeting"] = $MenteeIdResult[0]["meet_id"];
     $response[strval($LI) . "Status"] = "Mentee of ";
     $LI++;
   }
 }//Mentee ID Result isempty Close
}//meetID Close
}//If!empty meetID Close

echo json_encode($response);
?>
