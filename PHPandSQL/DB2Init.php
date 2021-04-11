<?php
//Creates new instance of the Database that Cindy gave us
$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];

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
$fp = fopen("$DOCUMENT_ROOT/code/DB2.sql",'r');
$query = "";
while(!feof($fp)) {
    $newLine = fgets($fp);
    // echo $newLine . "<br>";
    $query .= $newLine  ;
}
fclose($fp);
$query .= "" ;



// runs query to build DB2 database
if(mysqli_multi_query($myconnection, $query)) {
    echo "DB2 built successfully";
  } else {
    echo "Error building DB2: " . mysqli_error($myconnection);
  }

?>
