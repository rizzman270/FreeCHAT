<?php
require "config.php";
$user=$_GET["user"] ?? "";
if (!$user) exit;
$typingFile = "../data/typing_private.json";
$typing = file_exists($typingFile) ? json_decode(file_get_contents($typingFile), true) : [];
$response = ["typing" => false];
if (isset($typing[$_SESSION["user"]])) {
    foreach ($typing[$_SESSION["user"]] as $sender => $time) {
        if (time() - $time < 3 && $sender === $user) {
            $response["typing"] = true;
        }
    }
}
header("Content-Type: application/json");
echo json_encode($response);