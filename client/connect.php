<?php
$serverName = "VinhVeer\VINHVEER"; //serverName\instanceName

// Since UID and PWD are not specified in the $connectionInfo array,
// The connection will be attempted using Windows Authentication.
$connectionInfo = array("Database" => "BookStore");
$conn = sqlsrv_connect($serverName, $connectionInfo);

if ($conn) {
    echo "<script>console.log('Connection established.')</script>";
} else {
    echo "<script>console.log('Connection could not be established.')</script>";
}