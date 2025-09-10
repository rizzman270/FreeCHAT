<?php
require "config.php";
$user=$_SESSION["user"]??"";
if(!$user) exit;
$to = $_POST["to"] ?? "";
if (!$to) exit;
$typing = load_typing_private();
$typing[$to][$_SESSION["user"]] = time();
save_typing_private ($typing);
?>
