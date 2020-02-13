<?php

require("../phpMQTT.php");


$server = "hairdresser.cloudmqtt.com";     // change if necessary
$port = 16093;                     // change if necessary
$username = "qtjwedau";                   // set your username
$password = "	pSYbwv9cIIWS";                   // set your password
$client_id = "subscriber MQTT By K"; // make sure this is unique for connecting to sever - you could use uniqid()

$mqtt = new phpMQTT($server, $port, $client_id);

if(!$mqtt->connect(true, NULL, $username, $password)) {
	exit(1);
}

$topics['/ESP32'] = array("qos" => 0, "function" => "procmsg");
$mqtt->subscribe($topics, 0);

while($mqtt->proc()){
		
}


$mqtt->close();

function procmsg($topic, $msg){
		echo "Msg Recieved: " . date("r") . "\n";
		echo "Topic: {$topic}\n\n";
		echo "\t$msg\n\n";
}
