<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login'])) {
        loginUser($conn);
    } elseif (isset($_POST['register'])) {
        registerUser($conn);
    }
}

function loginUser($conn) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT ua.account_id, ua.username, ua.password, ur.user_role_id, u.full_name
                            FROM user_accounts ua
                            JOIN user_roles ur ON ua.user_role_id = ur.user_role_id
                            JOIN users u ON ur.user_id = u.user_id
                            WHERE ua.username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($account_id, $username, $hashed_password, $user_role_id, $full_name);
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            $_SESSION["login_success"] = true;
            $_SESSION["username"] = $full_name;
            header("Location: index.php");
        } else {
            echo "Sai mật khẩu.";
        }
    } else {
        echo "Tên đăng nhập không tồn tại.";
    }
    $stmt->close();
}

function registerUser($conn) {
    $full_name = $_POST['full_name'];
    $date_of_birth = $_POST['date_of_birth'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Start a transaction
    $conn->begin_transaction();

    try {
        $stmt = $conn->prepare("INSERT INTO users (full_name, date_of_birth, gender, address, phone, email) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssisss", $full_name, $date_of_birth, $gender, $address, $phone, $email);
        $stmt->execute();
        $user_id = $stmt->insert_id;
        $stmt->close();

        $stmt = $conn->prepare("INSERT INTO user_roles (user_id, role_id) VALUES (?, ?)");
        $default_role_id = 1; // Giả sử vai trò mặc định cho người dùng mới là 1
        $stmt->bind_param("ii", $user_id, $default_role_id);
        $stmt->execute();
        $user_role_id = $stmt->insert_id;
        $stmt->close();

        $stmt = $conn->prepare("INSERT INTO user_accounts (username, password, user_role_id) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $username, $password, $user_role_id);
        $stmt->execute();
        $stmt->close();

        // Commit transaction
        $conn->commit();
        echo "Đăng ký thành công. Bạn có thể đăng nhập ngay bây giờ.";
    } catch (Exception $e) {
        $conn->rollback();
        echo "Đăng ký thất bại: " . $e->getMessage();
    }
}

$conn->close();
