<?php
require "config.php";
$user=$_SESSION["user"] ?? null;
if(!$user) exit;
$users=load_users();
$target=$_POST["target"]??"";
$typing=$_POST["typing"]??"0";
$data=load_typing();
if($typing === "1"){
    if(!isset($data[$target])) $data[$target] = [];
    if(!in_array($users[$user]["name"], $data[$target])) $data[$target][] = $users[$user]["name"];
} else {
    if(isset($data[$target])){
        $data[$target] = array_values(array_diff($data[$target], [$users[$user]["name"]]));
        if(empty($data[$target])) unset($data[$target]);
    }
}
save_typing ($data);
