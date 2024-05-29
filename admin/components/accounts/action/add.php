<?php 
include '../../../import/connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = $_POST['full_name'];
    $date_of_birth = $_POST['date_of_birth'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $role_name = $_GET['role_name'];

    $query = "INSERT INTO users (full_name, date_of_birth, gender, address, phone, email) VALUES (?, ?, ?, ?, ?, ?)";
    $params = array($full_name, $date_of_birth, $gender, $address, $phone, $email);
    $stmt = sqlsrv_query($connect, $query, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Lấy user_id của người dùng vừa thêm
    $user_id = sqlsrv_insert_id($stmt);

    // Thêm vai trò cho người dùng
    $role_query = "
        INSERT INTO user_roles (user_id, role_id)
        SELECT ?, role_id FROM roles WHERE role_name = ?";
    $role_params = array($user_id, $role_name);
    $role_stmt = sqlsrv_query($connect, $role_query, $role_params);

    if ($role_stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        // Trở về trang trước đó
        $previous_page = $_SERVER['HTTP_REFERER'];
        header("Location: $previous_page");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Add New User</h1>
    <form method="POST">
        <div class="mb-3">
            <label for="full_name" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="full_name" name="full_name" required>
        </div>
        <div class="mb-3">
            <label for="date_of_birth" class="form-label">Date of Birth</label>
            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
        </div>
        <div class="mb-3">
            <label for="gender" class="form-label">Gender</label>
            <select class="form-control" id="gender" name="gender" required>
                <option value="1">Male</option>
                <option value="0">Female</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" id="address" name="address" required>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <button type="submit" class="btn btn-primary">Add</button>
    </form>
</div>
</body>
</html>
