<?php
session_start();

session_unset();
session_destroy();

header("Location: ../controllers/login.php");
exit;
?>