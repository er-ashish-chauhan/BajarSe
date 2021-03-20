
<?php
function db_connect(){
$server = 'localhost'; // this may be an ip address instead
    $user = 'root';
    $pass = '';
    $database = 'Nagad';

      // Create connection
  $conn= mysqli_connect($server,$user,$pass,$database);
  return $conn;
  if(!$conn){
  die("Connection failed: " . mysqli_connect_error());
}
}


  
?>
