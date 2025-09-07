<?php
require "config.php";
$me = $_SESSION["user"];
$other = $_GET["other"];
if(!$me || !$other) exit;
$key = [$me, $other];
sort($key, SORT_STRING);
$key = implode("|", $key);
$privates = file_exists("../data/private.json") ? json_decode(file_get_contents("../data/private.json"), true) : [];
$messages = $privates[$key];
echo json_encode(array_slice($messages, -27));
