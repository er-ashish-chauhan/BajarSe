﻿<?php
session_start();
require 'nagad_db.php';

$db=connect_db();
$sql="SELECT * FROM tutorial_videos WHERE status=1 && type=2";
$exe = $db->query($sql);
$results_array = $exe->fetch_all(MYSQLI_ASSOC);
echo json_encode($results_array);
?>