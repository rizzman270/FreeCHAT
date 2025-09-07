<?php
session_start();
require "config.php";
if (!isset($_SESSION["user"])) {
    http_response_code(403);
    exit($lang["message"]["logged"]);
}
$uploadDir = DATA_DIR."/upload/";
if (!isset($_FILES["image"]))
    exit($lang["message"]["no_file"]);
$file = $_FILES["image"];
if ($file["size"] > UPLOAD)
    exit($lang["message"]["large"] ." (max ". (UPLOAD / 1024 / 1024) ." MB)");
$allowed = ["image/jpeg", "image/png", "image/gif"];
if (!in_array($file["type"], $allowed))
    exit($lang["message"]["only"] ." JPG, PNG, GIF ". $lang["message"]["allowed"]);
$ext = pathinfo($file["name"], PATHINFO_EXTENSION);
$filename = uniqid("img_") . "." . $ext;
$path = $uploadDir . $filename;
if (move_uploaded_file($file["tmp_name"], $path))
    echo "[img]". $path ."[/img]";
else
    exit($lang["message"]["failed"]);
