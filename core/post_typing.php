<?php
require "config.php";
$user=$_SESSION["user"] ?? null;
if(!$user) exit;
$users=load_users();
$target=$_POST["target"]??"";
$typing=$_POST["typing"]??"0";
$file="../data/typing.json";
$data=file_exists($file) ? json_decode(file_get_contents($file), true) : [];
if($typing === "1"){
    if(!isset($data[$target])) $data[$target] = [];
    if(!in_array($users[$user]["name"], $data[$target])) $data[$target][] = $users[$user]["name"];
} else {
    if(isset($data[$target])){
        $data[$target] = array_values(array_diff($data[$target], [$users[$user]["name"]]));
        if(empty($data[$target])) unset($data[$target]);
    }
}
file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
