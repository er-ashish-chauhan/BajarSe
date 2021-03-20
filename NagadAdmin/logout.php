<?php
   session_start();
   unset($_SESSION["username"]);
   unset($_SESSION["password"]);

  	echo "<script> window.location = 'login.php'</script>";
?>