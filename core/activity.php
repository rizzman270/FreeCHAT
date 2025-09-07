<?php
require "config.php";
$user=$_SESSION["user"]??"";
if(!$user) exit;
$online=load_online();
$rooms=load_rooms();
$room_names=$counts=[];
$room_count=0;
$result=[];
foreach($rooms as $roomName=>$r) {
	$room_names[$room_count]=$roomName;
	$counts[$roomName]=0;
	$room_count++;
}
foreach($online as $u=>$r)
	if(isset($counts[$r]))
		$counts[$r]++;
foreach($rooms as $roomName=>$r)
	if ($counts[$roomName] > 0) {
		$result[] = [
			"activity"=>$roomName,
			"count"=>$counts[$roomName]
		];
	}
header("Content-Type: application/json");
echo json_encode($result);
?>
