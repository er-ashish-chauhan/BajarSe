<?php 
require 'dbconfig.php';

$db=db_connect();
$sql = "SELECT * FROM `Admin_Info`";

	$exe = $db->query($sql);
    $data = $exe->fetch_all(MYSQLI_ASSOC);
    $db = null;

    //print_r($data);

    $AdminFirstName=$data[0]['First_Name'];
    $AdminLastName=$data[0]['Last_Name'];
    $AdminEmail=$data[0]['Email'];
    $AdminPhone=$data[0]['Phone'];
    $AdminUsername=$data[0]['Username'];

?>