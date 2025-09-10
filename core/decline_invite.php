<?php
require "config.php";
if (!isset($_SESSION["user"])) exit;
$from = $_POST["from"] ?? "";
if (!$from) exit;
$declined = load_declined ();
$declined[$from][] = [
    "to" => $_SESSION["user"],
    "time" => time()
];
save_declined ($declined);
?>
