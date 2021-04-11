<?php

//Creates new instance of the Database that Cindy gave us
$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];

$DBInit = $_POST['DB'];

// Connects to the SQL Server
if($myconnection = mysqli_connect('localhost', 'root', '') ){
    echo "Connected to Sql Server<br>";
} else  {  
    die ('Could not connect to server');

}

//Checks to see if Database already exists
if($mydb = mysqli_select_db ($myconnection, 'db2')){
    echo "Connection made to DB2<br>";
} else  {  
    echo "DB2 could not be found <br>";
    if (mysqli_query($myconnection, "CREATE DATABASE db2")) {
        echo "DB2 created successfully <br>";
        $mydb = mysqli_select_db ($myconnection, 'db2');
        } else {
        echo "Error creating DB2: " . mysqli_error($conn);
        die ('Could not connect to DB2');
      }
}

//gets DB2 sql puts it into $query
$fp = fopen("$DOCUMENT_ROOT/code/DB2PopClean.sql",'r');
if($DBInit == "Test"){
    $fp = fopen("$DOCUMENT_ROOT/code/DB2PopTest.sql",'r');
}
$query = "";
while(!feof($fp)) {
    $newLine = fgets($fp);
    // echo $newLine . "<br>";
    $query = $query . $newLine  ;
}
fclose($fp);
$query = $query . "" ;



// runs query to build DB2 database
if(mysqli_multi_query($myconnection, $query)) {
    echo $DBInit . " DB2 populated successfully";
  } else {
    echo "Error populating DB2: " . mysqli_error($myconnection);
  }

?>
