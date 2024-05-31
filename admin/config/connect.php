<?php
// $servername = "DESKTOP-ARM6I0A\SQLEXPRESS";
// $database = "BookStore";
// $uid = "sa";
// $pass = "12345";

// $connection = [
//     "Database" => $database,
//     "Uid" => $uid,
//     "PWD" => $pass,
//     "CharacterSet" => "UTF-8",
// ];

// $conn = sqlsrv_connect($servername, $connection);
// if (!$conn) {
//     die(print_r(sqlsrv_errors(), true));
// } else {
//     echo "";
// }

session_start();

$serverName = "VINHVEER\VinhVeer"; //serverName\instanceName

// Since UID and PWD are not specified in the $connectionInfo array,
// The connection will be attempted using Windows Authentication.
$connectionInfo = array( "Database"=>"BookStore");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

// if( $conn ) {
//      echo "Connection established.<br />";
// }else{
//      echo "Connection could not be established.<br />";
//      die( print_r( sqlsrv_errors(), true));
// }