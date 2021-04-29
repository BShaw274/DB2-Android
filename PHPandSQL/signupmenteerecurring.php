<?php
// Recuring function that loops over individual meetings
function recur($Email, $meetingId){

$response["success"] = "true";



mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$dbConnection = new mysqli('localhost', 'root', '', 'db2');
if ($dbConnection->connect_error) {
  die("Connection failed: " . $dbConnection->connect_error);
}

//Portion of the code that gets the users ID from their email
  // get id
$stmt = $dbConnection->prepare("SELECT id FROM users Where email = ?");
if(false ===$stmt){
  $response["success"] = "false";
}
$check = $stmt->bind_param("s", $Email);
if(false ===$check){
  $response["success"] = "false";
}
$check = $stmt->execute();
if(false ===$check){
    $response["success"] = "false";
}
$studentId = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

/*
This section is fetching different values from the database in order to check multiple things

This section acquires 5 different attributes

1. Selects the student grade level
2. Selects the meetings grade level
3. Selects the capacity of the meeting
4. Selects the amount of mentees already enrolled in the meeting
5. Selects the amount of mentors already enrolled in the meeting
*/

//grabbing the student's grade level
$stmt = $dbConnection->prepare("SELECT grade FROM students WHERE student_id = ?");
if(false ===$stmt){
  $response["success"] = "false";
}
$check = $stmt->bind_param("s", $studentId[0]['id']);
if(false ===$check){
  $response["success"] = "false";
}
$check = $stmt->execute();
if(false ===$check){
    $response["success"] = "false";
}
$studentGradeLevel = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);


//getting the meeting grade level
$query = 'SELECT group_id FROM meetings WHERE meet_id=' . $meetingId;
$meetingGradeLevel = mysqli_query($dbConnection, $query);

$studentGrade = $studentGradeLevel[0]['grade'];


while ($row = mysqli_fetch_array ($meetingGradeLevel, MYSQLI_ASSOC)) {
  $meetingGrade = $row["group_id"];
}

//getting the total capacity
$query =  'SELECT capacity FROM meetings WHERE meet_id= ' . $meetingId;
$meetingCapacity = mysqli_query($dbConnection, $query);
while ($row = mysqli_fetch_array ($meetingCapacity, MYSQLI_ASSOC)) {
  $meetingCapacityNum = $row["capacity"];
}

//getting the amount of mentees
$query = 'SELECT mentee_id FROM enroll WHERE meet_id= ' . $meetingId;
$menteeAmount = mysqli_query($dbConnection, $query);
$totalMentees = mysqli_num_rows($menteeAmount);

//getting the amount of mentors
$query = 'SELECT mentor_id FROM enroll2 WHERE meet_id= ' . $meetingId;
$mentorAmount = mysqli_query($dbConnection, $query);
$totalMentors = mysqli_num_rows($mentorAmount);

/*
This is where the students are actually being assigned to the specified meeting as the specified role

3 Major Checks are done here:
  1. Is the student in the same grade level?
  2. Is there room for another student based off the meeting's capacity?
  3. Can another student be assigned to mentees, the max for mentees is 6?

If these 3 checks pass then the student will be assigned into the meeting as a mentee.
*/

//check not already signed up for meeting
$stmt = $dbConnection->prepare("SELECT mentee_id FROM enroll Where meet_id = ?");
if(false ===$stmt){
die('prepare() failed: ' . htmlspecialchars($mysqli->error));
}
$check = $stmt->bind_param("s", $meetingId);
if(false ===$check){
  die('bind_param() failed: ' . htmlspecialchars($stmt->error));
}

$check = $stmt->execute();
if(false ===$check){
  die('execute() failed: ' . htmlspecialchars($stmt->error));
}
$EnrolledCheck = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$ICheck=0;

for($i=0;$i<count($EnrolledCheck);$i++){
  if ($EnrolledCheck[$i]["mentee_id"] == $studentId[0]["id"]) {
    $response["success"] = "false";
    $ICheck=1;

    $response = array();
    $response[strval($i) . "cid"] = $studentId[0]["id"];
    $response[strval($i) . "cstatus"] = "Cannot Sign up, already signed up for the meeting";
    return FALSE;
  }
}

//Check if they are in mentees
$stmt = $dbConnection->prepare("SELECT mentee_id FROM mentees Where mentee_id = ?");
if(false ===$stmt){
die('prepare() failed: ' . htmlspecialchars($mysqli->error));
}
$check = $stmt->bind_param("s", $studentId[0]["id"]);
if(false ===$check){
  die('bind_param() failed: ' . htmlspecialchars($stmt->error));
}

$check = $stmt->execute();
if(false ===$check){
  die('execute() failed: ' . htmlspecialchars($stmt->error));
}
$InMentees = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

//Ensures that the timeslot isnt already taken
$timeError = FALSE;

$stmt = $dbConnection->prepare("SELECT time_slot_id, date from meetings where meet_id=?");
  if(false ===$stmt){
    die('prepare() failed: ' . htmlspecialchars($mysqli->error));
  }
  $check = $stmt->bind_param("s", $meetingId);
  if(false ===$check){
    die('bind_param() failed: ' . htmlspecialchars($stmt->error));
  }
  $check = $stmt->execute();
  if(false ===$check){
    die('execute() failed: ' . htmlspecialchars($stmt->error));
  }
  $timeSlotResult = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
   $stmt->close();

  //Checking time slots of other meetings student is currently in for mentee
   $stmt = $dbConnection->prepare("SELECT meet_id from enroll where mentee_id=?");
   if(false ===$stmt){
     die('prepare() failed: ' . htmlspecialchars($mysqli->error));
   }
   $check = $stmt->bind_param("s", $studentId[0]['id']);
   if(false ===$check){
     die('bind_param() failed: ' . htmlspecialchars($stmt->error));
   }
   $check = $stmt->execute();
   if(false ===$check){
     die('execute() failed: ' . htmlspecialchars($stmt->error));
   }
   $meetIdMentee = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();



    //Checking time slots of other meetings student is currently in for mentor
     $stmt = $dbConnection->prepare("SELECT meet_id from enroll2 where mentor_id=?");
     if(false ===$stmt){
       die('prepare() failed: ' . htmlspecialchars($mysqli->error));
     }
     $check = $stmt->bind_param("s", $studentId[0]['id']);
     if(false ===$check){
       die('bind_param() failed: ' . htmlspecialchars($stmt->error));
     }
     $check = $stmt->execute();
     if(false ===$check){
       die('execute() failed: ' . htmlspecialchars($stmt->error));
     }
     $meetIdMentor = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
      $stmt->close();

      //storing meetings you mentor and mentee in
     $allEnrolledId=array_merge($meetIdMentee, $meetIdMentor);

     //comparing timeslot of meeting you are trying to sign up for and meetings you are in
     for($j=0; $j<count($allEnrolledId); $j++){
       $stmt = $dbConnection->prepare("SELECT time_slot_id, date from meetings where meet_id=?");
       if(false ===$stmt){
         die('prepare() failed: ' . htmlspecialchars($mysqli->error));
       }
       $check = $stmt->bind_param("s", $allEnrolledId[$j]['meet_id']);
       if(false ===$check){
         die('bind_param() failed: ' . htmlspecialchars($stmt->error));
       }
       $check = $stmt->execute();
       if(false ===$check){
         die('execute() failed: ' . htmlspecialchars($stmt->error));
       }
       $checkTimeId = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
       $stmt->close();
       if($timeSlotResult[0]['time_slot_id']==$checkTimeId[0]['time_slot_id'] && $timeSlotResult[0]['date']==$checkTimeId[0]['date']){
        $timeError = TRUE;
       }

     }

// does final check to see if insertion is valid
if($ICheck==0){
if($studentGrade == $meetingGrade){
  if(($totalMentees + $totalMentors) < $meetingCapacityNum){
    if($totalMentees < 6){
      if(!$timeError){
      //Inserting mentee Id and meeting Id into enroll

      // insert into mentees if they are not in it
      if(empty($InMentees)){
        $stmt = $dbConnection->prepare("INSERT INTO mentees (mentee_id) VALUES (?)");
        if(false ===$stmt){
        die('prepare() failed: ' . htmlspecialchars($mysqli->error));
        }
        $check = $stmt->bind_param("s",$studentId[0]['id']);
        if(false ===$check){
          die('bind_param() failed: ' . htmlspecialchars($stmt->error));
        }

        $check = $stmt->execute();
        if(false ===$check){
          die('execute() failed: ' . htmlspecialchars($stmt->error));
        }
      //enroll them into the meeting
      }
      $stmt = $dbConnection->prepare("INSERT INTO enroll (meet_id, mentee_id) VALUES (?,?)");
      if(false ===$stmt){
      die('prepare() failed: ' . htmlspecialchars($mysqli->error));
      }
      $check = $stmt->bind_param("ss", $meetingId, $studentId[0]['id']);
      if(false ===$check){
        die('bind_param() failed: ' . htmlspecialchars($stmt->error));
      }

      $check = $stmt->execute();
      if(false ===$check){
        die('execute() failed: ' . htmlspecialchars($stmt->error));
      }
      $response = array();
      $response[strval($i) . "cid"] = $studentId;
      $response[strval($i) . "cstatus"] = "Mentor was added to meeting";
      return TRUE;

      $stmt->close();
    }else{
      $response = array();
      $response[strval($i) . "cid"] = $studentId;
      $response[strval($i) . "cstatus"] = "This meeting is in time conflict with another meeting.";
      return FALSE;
    }

    }else{
      $response = array();
      $response[strval($i) . "cid"] = $studentId;
      $response[strval($i) . "cstatus"] = "This meeting already has enough mentees";
      return FALSE;
    }

  }else {
    $response = array();
    $response[strval($i) . "cid"] = $studentId;
    $response[strval($i) . "cstatus"] = "The meeting is already full";
    return FALSE;
  }

}else{
  $response = array();
  $response[strval($i) . "cid"] = $studentId;
  $response[strval($i) . "cstatus"] = "Student is not in the same grade level as the meeting";
  return FALSE;
}
}

}


// Begining of Non loop code

// given from the parent program
$Email = $_POST['email'];
$meetingId = $_POST['meet_id'];


// connects to database
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$dbConnection = new mysqli('localhost', 'root', '', 'db2');
if ($dbConnection->connect_error) {
  die("Connection failed: " . $dbConnection->connect_error);
}

// gets all the meetingids from the meetings the user want to sign up into
$query = 'SELECT group_id FROM meetings WHERE meet_id=' . $meetingId;
$meetingGradeLevel = mysqli_query($dbConnection, $query);


while ($row = mysqli_fetch_array ($meetingGradeLevel, MYSQLI_ASSOC)) {
  $meetingGrade = $row["group_id"];
}

$query2 = 'SELECT meet_name FROM meetings WHERE meet_id=' . $meetingId;
$meetingNameResult = mysqli_query($dbConnection, $query2);

if (mysqli_num_rows($meetingNameResult) > 0) {
  while($row = mysqli_fetch_assoc($meetingNameResult)) {
    $meetingName = $row["meet_name"];
    
  }
} else {
  echo "0 results";
}
$query3 = 'SELECT meet_id FROM meetings WHERE meet_name= \'' . $meetingName . '\'';
$multiMeetingIDResult = mysqli_query($dbConnection, $query3);

$multiMeetingID=array();

if (mysqli_num_rows($multiMeetingIDResult) > 0) {
  while($row = mysqli_fetch_assoc($multiMeetingIDResult)) {
    array_push($multiMeetingID,$row["meet_id"]);
  }
} else {
  echo "0 results";
}

// loops over meeting ID's to try and sign up for all 
$allSuccsed = TRUE;
foreach ($multiMeetingID as $meetingId) {
  if(!recur($Email,$meetingId)){
    $allSuccsed = FALSE;
  }
}
// gets student id from the email
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
$studentId = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// uses Student ID to return json saying if student signed up for all meetings or if there where issues
$response = array();
$response["0cid"] = $studentId[0]['id'];
if($allSuccsed){
  $response["0cstatus"] = "Student signed up for all meetings";
}else{
  $response["0cstatus"] = "Signup failed for some meetings";
}
echo json_encode($response);

?>
