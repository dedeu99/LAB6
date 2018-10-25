<?php

header('Refresh: 5; url=index.php');

session_start();
//$_SESSION = array();
session_destroy();
?>