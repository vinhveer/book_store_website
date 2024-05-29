<?php
session_start();

$servername = "DESKTOP-EV6PS47";
$database = "BookStore";
$uid = "sa";
$pass = "18092004king";

$connection = [
    "Database" => $database,
    "Uid" => $uid,
    "PWD" => $pass,
    "CharacterSet" => "UTF-8",
];

$connect = sqlsrv_connect($servername, $connection);
if (!$connect) {
    die(print_r(sqlsrv_errors(), true));
}
?>
