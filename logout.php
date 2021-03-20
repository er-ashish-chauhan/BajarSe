<?php
   session_start();
   unset($_SESSION["mobile"]);
   unset($_SESSION["user_id"]);
  	echo "<script> window.location = 'index.html'</script>";
?>