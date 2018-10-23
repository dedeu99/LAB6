<?php

header('Refresh: 5; url=index.php');

$referer = $_SERVER['HTTP_REFERER']; 
$domain = parse_url($referer);
/*
echo $referer.PHP_EOL;
echo "-----".PHP_EOL;
print_r($domain);

echo PHP_EOL.basename($domain[path]).PHP_EOL*/

if(strcmp(basename($domain[path]),"register.php")==0)
	echo "SUCCESSFULLY CREATED";
else
	echo "how did you get here again?";

?>