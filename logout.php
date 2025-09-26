<?php
require "core/config.php";
if(isset($_SESSION["user"])){
    $user = $_SESSION["user"];
    $online = load_online();
	$users=load_users();
    $room = $online[$user];
    unset($online[$user]);
    save_online($online);
    $messages = load_messages();
    $messages[$room][] = [
		"name"=>CHATBOT,
        "text"=>encryptMessage("<small>". $users[$user]['name'] ." ". $lang["message"]["logout"] ."</small>"),
        "color"=>"#C08856",
        "style"=>"italic",
        "icon"=>"fa-genderless",
        "time"=>date("H:i:s")
    ];
    save_messages($messages);
}
session_destroy();
header("Location: login.php");
exit;
