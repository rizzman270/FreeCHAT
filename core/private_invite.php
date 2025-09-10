<?php
require "config.php";
if (!isset($_SESSION["user"])) exit;
$to=$_POST["to"]??"";
$name=$_POST["name"]??"";
if (!$to) exit;
$invites = load_invite();
$invites[$to][] = [
    "name" => $name,
    "from" => $_SESSION["user"],
    "time" => time()
];
save_invite ($invites);
?>
