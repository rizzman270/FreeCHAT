<?php
require "config.php";
$user=$_SESSION["user"]??"";
if(!$user) exit;
$to = $_POST["to"] ?? "";
if (!$to) exit;
$typingFile = "../data/typing_private.json";
$typing = file_exists($typingFile) ? json_decode(file_get_contents($typingFile), true) : [];
$typing[$to][$_SESSION["user"]] = time();
file_put_contents($typingFile, json_encode($typing));
?>
