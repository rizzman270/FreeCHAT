<?php
require "config.php";
$user=$_SESSION["user"]??"";
if(!$user) exit;
$target=$_GET["target"]??"";
$data=load_typing();
$typers=$data[$target] ?? [];
$typers=array_values(array_diff($typers, [$user]));
header("Content-Type: application/json");
echo json_encode($typers);
