<?php
require "config.php";
if (!isset($_SESSION["user"])) exit;
$from = $_POST["from"] ?? "";
if (!$from) exit;
$accepted = load_accepted ();
$accepted[$from][] = [
    "to" => $_SESSION["user"],
    "time" => time()
];
save_accepted ($accepted);
?>
