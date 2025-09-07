<?php
require "config.php";
$me=$_SESSION["user"];
$other=$_POST["other"]??"";
$color=$_POST["color"]??"#000000";
$style=$_POST["style"]??"normal";
$msg = trim($_POST["msg"]);
if(!$me || !$other || $msg=="") exit;
$key = [$me, $other];
sort($key, SORT_STRING);
$key = implode("|", $key);
$privates = file_exists("../data/private.json") ? json_decode(file_get_contents("../data/private.json"), true) : [];
if(!isset($privates[$key])) $privates[$key] = [];
$msg = htmlspecialchars($msg, ENT_QUOTES, 'UTF-8');
$msg = parse_bbcode($msg);
$privates[$key][] = [
    "from"=>$me,
    "to"=>$other,
    "text"=>$msg,
	"color"=>$color,
	"style"=>$style,
    "time"=>date("H:i:s")
];
file_put_contents("../data/private.json", json_encode($privates, JSON_PRETTY_PRINT));
