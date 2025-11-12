<?php 
session_start();
session_destroy();
header("Location: ../VIEW/loginn.php");
exit();
?>