<?php
require "config.php";
$me=$_SESSION["user"];
$other=$_POST["other"]??"";
$color=$_POST["color"]??"#000000";
$style=$_POST["style"]??"normal";
$users=load_users();
$msg = trim($_POST["msg"]);
if(!$me || !$other || $msg=="") exit;
$key = [$me, $other];
sort($key, SORT_STRING);
$key = implode("|", $key);
$privates = load_private ();
if(!isset($privates[$key])) $privates[$key] = [];
$msg = htmlspecialchars($msg, ENT_QUOTES, 'UTF-8');
$msg = parse_bbcode($msg);
$msg = parse_emoji($msg);
$privates[$key][] = [
    "from"=>$users[$me]["name"],
    "to"=>$other,
    "text"=>$msg,
	"color"=>$color,
	"style"=>$style,
    "time"=>date("H:i:s")
];
save_private ($privates);