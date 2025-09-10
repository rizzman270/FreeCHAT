<?php
session_start();
if (!isset($_SESSION["user"])) exit;
$invitesFile = "../data/invites.json";
$invites = file_exists($invitesFile) ? json_decode(file_get_contents($invitesFile), true) : [];
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
file_put_contents($invitesFile, json_encode($invites));
header("Content-Type: application/json");
echo json_encode($response);
