<?php
error_reporting (0);
session_start();
define("DATA_DIR", __DIR__."/../data");
define("ONLINE_WINDOW", 60);
define("TITLE", "FreeCHAT");
define("DESCRIPTION", " - Chat for free and find new friends!");
define("KEYWORDS", "Chat, Friends, People, Meet, Communication, Online, Party, Erotic");
define("UPLOAD", 4096 * 1024);
function load_json($file){ $path = DATA_DIR."/".$file; return file_exists($path) ? json_decode(file_get_contents($path), true) : []; }
function save_json($file,$data){ file_put_contents(DATA_DIR."/".$file,json_encode($data)); }
function load_users(){ return load_json("users.json"); }
function save_users($data){ save_json("users.json",$data); }
function load_rooms(){ return load_json("rooms.json"); }
function save_rooms($data){ save_json("rooms.json",$data); }
function load_messages(){ return load_json("messages.json"); }
function save_messages($data){ save_json("messages.json",$data); }
function load_bans(){ return load_json("bans.json"); }
function save_bans($data){ save_json("bans.json",$data); }
function load_online(){ return load_json("online.json"); }
function save_online($data){ save_json("online.json",$data); }

if (!isset($_SESSION['lang'])) $_SESSION['lang']="en_us";
include "language-". $_SESSION['lang'] .".php";

include "function.php";
?>
