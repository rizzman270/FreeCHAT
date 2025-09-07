<?php
require "config.php";
if(!isset($_SESSION["user"])) exit;
$user=$_SESSION["user"];
$users=load_users();
if(!($users[$user]["is_admin"] == false)) exit($lang["message"]["is_admin"]);

$action=$_POST["action"];
$target=$_POST["user"];
$bans=load_bans();
if($action=="del" && isset($users[$target])){
	unset($users[$target]);
	save_users($users);
    echo $lang["message"]["user"] ." ". $target ." ". $lang["message"]["deleted"];
}elseif($action=="ban" && isset($users[$target])){
    $bans[$target]=true;
    save_bans($bans);
    echo $lang["message"]["user"] ." ". $target ." ". $lang["message"]["bans_banned"];
}elseif($action=="unban" && isset($bans[$target])){
    unset($bans[$target]);
    save_bans($bans);
    echo $lang["message"]["user"] ." ". $target ." ". $lang["message"]["bans_unbanned"];
}else{ echo $lang["message"]["invalid_action"]; }
