<?php
session_start();
if($_SERVER['REMOTE_ADDR'] != "24.54.7.6" // evo 2
AND $_SERVER['REMOTE_ADDR'] != "135.19.54.42" // Evosis
AND $_SERVER['REMOTE_ADDR'] != "88.178.250.105" // Lucina
AND $_SERVER['REMOTE_ADDR'] != "90.32.1.238" // Lefa
AND $_SERVER['REMOTE_ADDR'] != "89.224.9.201" // ???
AND $_SERVER['REMOTE_ADDR'] != "89.93.229.35" // ???
AND $_SERVER['REMOTE_ADDR'] != "213.245.79.36" // ???
AND $_SERVER['REMOTE_ADDR'] != "89.85.211.178" // ???
AND $_SERVER['REMOTE_ADDR'] != "213.245.79.36" // Happy
AND $_SERVER['REMOTE_ADDR'] != "77.134.14.138" // Noelliste
AND $_SERVER['REMOTE_ADDR'] != "82.240.59.38") // TimeR
{
	session_destroy();
	exit();
}

include('logs_sql.php');
?>