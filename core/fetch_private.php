<?php
require "config.php";
$me = $_SESSION["user"];
$other = $_GET["other"];
if(!$me || !$other) exit;
$key = [$me, $other];
sort($key, SORT_STRING);
$key = implode("|", $key);
$privates = load_private ();
$messages = $privates[$key];
echo json_encode(array_slice($messages, -27));
