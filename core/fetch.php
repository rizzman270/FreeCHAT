<?php
require "config.php";
$room=$_GET["room"]??"Chill Zone";
$messages=load_messages();
$roomMessages=$messages[$room];
$lastMessages=array_slice($roomMessages, -27);
header("Content-Type: application/json");
echo json_encode($lastMessages);
