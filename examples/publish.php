<?php

require("../phpMQTT.php");

$server = "hairdresser.cloudmqtt.com";     // change if necessary
$port = 16093;                     // change if necessary
$username = "qtjwedau";                   // set your username
$password = "pSYbwv9cIIWS";                   // set your password
$client_id = "publisher MQTT by K"; // make sure this is unique for connecting to sever - you could use uniqid()

$mqtt = new phpMQTT($server, $port, $client_id);

if ($mqtt->connect(true, NULL, $username, $password)) {
	$mqtt->publish("/ESP32", "Hello World! at " . date("r"), 0);
	$mqtt->close();
} else {
    echo "Time out!\n";
}
