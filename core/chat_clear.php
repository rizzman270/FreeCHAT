<?php
require "config.php";
if(!isset($_SESSION["user"])) exit;
$user=$_SESSION["user"];
$users=load_users();
if(!($users[$user]["is_admin"] == false)) die($lang["message"]["is_admin"]);
$room=$_GET["room"];
$messages = load_messages();
$messages[$room]=[];
save_messages($messages);
header("Location: ../admin_rooms.php");
exit;
