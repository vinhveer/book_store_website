<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Include file kết nối cơ sở dữ liệu
    include 'connect.php';

    // Nhận dữ liệu từ form và lọc đầu vào để tránh tấn công XSS
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    // Sử dụng hàm LoginUser để kiểm tra đăng nhập
    $sql = "SELECT * FROM LoginUser(?, ?)";
    $params = array($username, $password);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(json_encode(['status' => 'error', 'message' => 'Có lỗi xảy ra khi thực hiện truy vấn cơ sở dữ liệu.']));
    }

    if (sqlsrv_fetch($stmt)) {
        // Lấy thông tin người dùng
        $login_status = sqlsrv_get_field($stmt, 0);
        $login_note = sqlsrv_get_field($stmt, 1);
        $user_id = sqlsrv_get_field($stmt, 2);
        $full_name = sqlsrv_get_field($stmt, 3);
        $role_name = sqlsrv_get_field($stmt, 4);
        $image_user = sqlsrv_get_field($stmt, 5);

        // Kiểm tra nếu $image_user không có giá trị, gán đường dẫn mặc định
        if (empty($image_user)) {
            $image_user = 'assets/images/avatar/noavatar.jpg';
        }

        if ($login_status) {
            // Đăng nhập thành công
            $_SESSION['login_success'] = true;
            $_SESSION['user_id'] = $user_id;
            $_SESSION['full_name'] = $full_name;
            $_SESSION['role_name'] = $role_name;
            $_SESSION['image_user'] = $image_user;

            $redirect_url = ($role_name == 'admin') ? '../admin/index.php' : '../client/index.php';

            echo json_encode(['status' => 'success', 'message' => 'Đăng nhập thành công', 'redirect_url' => $redirect_url]);
        } else {
            // Đăng nhập thất bại
            echo json_encode(['status' => 'error', 'message' => $login_note]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Tên đăng nhập hoặc mật khẩu không đúng']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Yêu cầu không hợp lệ']);
}
