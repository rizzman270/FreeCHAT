<?php
require "config.php";
if (!isset($_SESSION["user"])) exit;
$target = $_GET["user"] ?? "";
if (!$target) exit;
$accepted = load_accepted ();
$declined = load_declined ();
$response = ["status" => "pending"];
if (isset($accepted[$_SESSION["user"]])) {
    foreach ($accepted[$_SESSION["user"]] as $entry) {
        if ($entry["to"] === $target && time() - $entry["time"] < 30) {
            $response["status"] = "accepted";
        }
    }
}
if (isset($declined[$_SESSION["user"]])) {
    foreach ($declined[$_SESSION["user"]] as $entry) {
        if ($entry["to"] === $target && time() - $entry["time"] < 30) {
            $response["status"] = "declined";
        }
    }
}
header("Content-Type: application/json");
echo json_encode($response);
