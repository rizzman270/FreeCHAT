<?php
require "config.php";
$me = $_SESSION["user"];
$other = $_GET["other"];
if(!$me || !$other) exit;
$key = [$me, $other];
sort($key, SORT_STRING);
$key = implode("|", $key);
$privates = load_private ();
$messages = $privates[$key];
foreach ($messages as &$msg) {
	if (isset($msg["text"]))
		$msg["text"] = decryptMessage($msg["text"]);
}
echo json_encode(array_slice($messages, -27));
