<?php
require "config.php";
if (!isset($_SESSION["user"])) exit;
$invites = load_invite();
$user = $_SESSION["user"];
$response = [];
if (isset($invites[$user])) {
    foreach ($invites[$user] as $invite) {
        if (time() - $invite["time"] < 10) {
            $response[] = $invite;
        }
    }
}
$invites[$user] = array_filter($invites[$user] ?? [], function($i) {
    return time() - $i["time"] < 10;
});
save_invite ($invites);
header("Content-Type: application/json");
echo json_encode($response);
