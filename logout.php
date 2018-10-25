<?php

header('Refresh: 5; url=index.php');

session_start();

session_destroy();
$_SESSION = array();
?>