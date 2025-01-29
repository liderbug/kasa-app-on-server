<?php
$hostname = "localhost";
$username = "[me]";
$password = "[bigsecret]";
$database = "kasa";

$db1 = mysqli_connect($hostname, $username, $password, $database);

if (mysqli_connect_errno()) {
   echo "Connect failed\n";
   exit();
}

