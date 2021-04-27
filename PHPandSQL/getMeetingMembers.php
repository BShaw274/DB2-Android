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


//get all meetings the user is a mentor in
$stmt = $dbConnection->prepare("SELECT meet_id FROM enroll2 Where mentor_id = ?");
if(false ===$stmt){
  //die('prepare() failed: ' . htmlspecialchars($mysqli->error));
  $response["success"] = "false";
    echo json_encode($response);
}
$check = $stmt->bind_param("s", $UserID[0]['id']);
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

$MeetIdResult = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
//Meeting ids for all the meetings the user is a mentor of
$MeetIdResult = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
 $stmt->close();
 if(!(empty($MeetIdResult))){


  /*

    This is code taken from studentlogin.php from phase 2. For the most part this should still work
    but I have no idea how to connect this output to android. The way this code was written gets the mentors and
    the mentees into seperate variables and then prints them. No idea how to combine these results.


  */
for($j=0; $j<count($MeetIdResult);$j++){
  //For loop will go through and print out mentors and mentees information for 1 specific meetings
  // before incrementing and checknig the next meeting untill there are no more meet_id's in $MeetIdResult
  
  //echo "Meet id: ".$MeetIdResult[$j]["meet_id"];
  $stmt = $dbConnection->prepare("SELECT mentor_id FROM enroll2 Where meet_id = ? AND mentor_id != ?");
  if(false ===$stmt){
    die('prepare() failed: ' . htmlspecialchars($mysqli->error));
  }
  $check = $stmt->bind_param("ss", $MeetIdResult[$j]["meet_id"], $gid);
  if(false ===$check){
    die('bind_param() failed: ' . htmlspecialchars($stmt->error));
  }
  $check = $stmt->execute();
  if(false ===$check){
    die('execute() failed: ' . htmlspecialchars($stmt->error));
  }
  $MentorIdResult = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
  $stmt->close();
  //Gets mentor ID's for meeting we are checking so we can then query the info of those mentors
  if(!(empty($MentorIdResult))){
      
    //echo"Mentors:";

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
      //var_dump($MentorInfoResult);
      
      for($k=0; $k<count($MentorInfoResult);$k++){
        //echo"Inside Test";
        //echo" Name: ".$MentorInfoResult[$k]["name"].", Email: ".$MentorInfoResult[$k]["email"];

      }
    }
    //The above then prints the Name and Email for the mentor id's obtained in $MentorIdResult
  }//Mentor ID Result isempty Close

$stmt->close();
//echo "|||||||||||Var Dump Start";
//var_dump($StudentIDs);
//echo "Var Dump over|||||||||||";

$response = array();
  //get all info of users with id with for loop
  for ($i=0; $i<count($MentorInfoResult);$i++){
  //  echo "Running X times: ".$i." IDs: ";
  //  echo $StudentIDs[$i]['student_id'];

$stmt = $dbConnection->prepare("SELECT * FROM users Where id = ?");
if(false ===$stmt){
  //die('prepare() failed: ' . htmlspecialchars($mysqli->error));
  $response["success"] = "false";
    echo json_encode($response);
//echo " Echoing Email update: ".$response["success"];
}
$check = $stmt->bind_param("s", $MentorInfoResult[$i]['name']);
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
$MentorInfoResult = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

//var_dump($StudentsInfo);
// get the child info that correspond to the student id's
//$getUserInfo = "SELECT id, name, email, phone FROM users";
//$infoRes = $mysqli->query($getUserInfo);
//echo $i."|||";

$response[strval($i) . "mName"] = $MentorInfoResult[0]['name'];
$response[strval($i) . "mEmail"] = $MentorInfoResult[0]['email'];
//var_dump($response);
}// for close
//echo"||||||||||||End Result|||||||||";
echo json_encode($response);
?>
