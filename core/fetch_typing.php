<?php
require "config.php";
$user=$_SESSION["user"]??"";
if(!$user) exit;
$target=$_GET["target"]??"";
$file="../data/typing.json";
$data=file_exists($file) ? json_decode(file_get_contents($file), true) : [];
$typers=$data[$target] ?? [];
$typers=array_values(array_diff($typers, [$user]));
header("Content-Type: application/json");
echo json_encode($typers);
