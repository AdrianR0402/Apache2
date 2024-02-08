<?php
session_start();
unset($_SESSION);
session_destroy();
setcookie("PHPSESSID", "", time() - 1, "/");
header("Location: index.php");
?>