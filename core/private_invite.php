<?php
session_start();
if (!isset($_SESSION["user"])) exit;
$to=$_POST["to"]??"";
$name=$_POST["name"]??"";
if (!$to) exit;
$invitesFile = "../data/invites.json";
$invites = file_exists($invitesFile) ? json_decode(file_get_contents($invitesFile), true) : [];
$invites[$to][] = [
    "name" => $name,
    "from" => $_SESSION["user"],
    "time" => time()
];
file_put_contents($invitesFile, json_encode($invites));
?>
