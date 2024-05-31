<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $fullName = $_POST['full_name'];
    $dateOfBirth = $_POST['date_of_birth'];
    $gender = $_POST['gender'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password

    // Check for existing user
    $sql = "SELECT display FROM dbo.CheckUserInfoFromInput(?, ?, ?, ?, ?, ?, ?, ?)";
    $params = array($fullName, $dateOfBirth, $gender, $phone, $address, $email, $username, $password);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        echo "Error in checking user info: " . print_r(sqlsrv_errors(), true);
        exit;
    }

    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

    if ($row['display'] === 'yes') {
        echo "User already exists.";
    } else {
        // Insert new user into database
        $sql = "INSERT INTO users (full_name, date_of_birth, gender, phone, address, email) VALUES (?, ?, ?, ?, ?, ?)";
        $params = array($fullName, $dateOfBirth, $gender, $phone, $address, $email);
        $stmt = sqlsrv_query($conn, $sql, $params);

        if ($stmt === false) {
            echo "Failed to register user: " . print_r(sqlsrv_errors(), true);
            exit;
        }

        echo "Registration successful.";
    }

    if ($stmt) {
        sqlsrv_free_stmt($stmt);
    }
    sqlsrv_close($conn);
}
?>
