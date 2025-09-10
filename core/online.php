<?php
require "config.php";
$room=$_GET["room"] ?? "general";
$online=load_online();
$users=load_users();
$result=[];
foreach($online as $u=>$r){
    if($r === $room && isset($users[$u])){
        $result[] = [
            "user"=>$u,
            "name"=>$users[$u]["name"],
            "invite"=>$users[$u]["invite"],
            "icon"=>$users[$u]["gender"]
        ];
    }
}
header("Content-Type: application/json");
echo json_encode($result);
