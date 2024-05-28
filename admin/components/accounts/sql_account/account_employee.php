<?php
$recordsPerPage = 9;
$sql_count = "SELECT COUNT(*) AS total_records FROM users u
INNER JOIN user_roles ur ON u.user_id = ur.user_id
INNER JOIN roles r ON ur.role_id = r.role_id
WHERE r.role_id=3";
$result_count = sqlsrv_query($conn, $sql_count);
$row_count = sqlsrv_fetch_array($result_count);
$totalRecords = $row_count['total_records'];
$totalPages = ceil($totalRecords / $recordsPerPage);
if (!isset($_GET['page'])) {
$currentPage = 1;
} else {
$currentPage = $_GET['page'];
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['timkiem'])) {
    $tukhoa = $_POST['tukhoa'];
    $sql_account_employee  ="SearchAccount_employee N'$tukhoa'";
    $result_account_employee = sqlsrv_query($conn, $sql_account_employee );
} else {

$sql_account_employee = "GetUserInformation_employee $currentPage";
$result_account_employee = sqlsrv_query($conn, $sql_account_employee);
}
$startPage = max(1, $currentPage - 1);
$endPage = min($totalPages, $currentPage + 1);
?>
