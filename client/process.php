<?php
include("../../../import/connect.php");

if (isset($_POST['update_auth']))
{
    $user_id = $_SESSION['user_id'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Kiểm tra username và password mới
    $new_username = (strlen($username) >= 4 && $username !== '') ? $username : null;
    $new_password = ($password !== '') ? $password : null;

    // Chỉ thực hiện cập nhật nếu ít nhất một giá trị hợp lệ được cung cấp
    if ($new_username !== null || $new_password !== null)
    {
        // Tạo câu lệnh UPDATE dựa trên giá trị mới
        $sql = "UPDATE user_accounts
                SET 
                    username = ISNULL(?, username),
                    password = ISNULL(?, password)
                WHERE user_role_id IN (
                    SELECT user_role_id
                    FROM user_roles
                    WHERE user_id = ?
                )";

        $stmt = sqlsrv_prepare($conn, $sql, array(&$new_username, &$new_password, &$user_id));
        if ($stmt && sqlsrv_execute($stmt))
        {
            header("Location: authenciation.php");
            exit();
        }
        else
        {
            echo "Update failed";
        }
    }
    else
    {
        echo "No valid data provided for update.";
    }
}

if (isset($_POST['update_profile'])) {
    // Nhận các giá trị từ form
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];

    // Xử lý avatar nếu được tải lên
    if ($_FILES['avatar_image']['error'] === 0) {
        $avatar_image = $_FILES['avatar_image']['name'];
        $avatar_temp = $_FILES['avatar_image']['tmp_name'];
        move_uploaded_file($avatar_temp, "../assets/images/$avatar_image");
    }

    // Câu lệnh SQL UPDATE
    $sql = "UPDATE users 
            SET 
                ".(!empty($full_name) ? "last_name = '$full_name'," : "")."
                ".(!empty($email) ? "email = '$email'," : "")."
                ".(!empty($phone) ? "phone = '$phone'," : "")."
                ".(!empty($dob) ? "date_of_birth = '$dob'," : "")."
                ".(!empty($gender) ? "gender = '$gender'," : "")."
                ".(!empty($address) ? "address = '$address'," : "")."
                ".(isset($avatar_image) ? "image_user = '$avatar_image'," : "")."
            WHERE user_id = ".$_SESSION['user_id'];

    // Thực thi câu lệnh SQL
    if (sqlsrv_query($conn, $sql)) {
        // Chuyển hướng người dùng đến trang "authenciation.php" và kèm theo tham số `success=1` để hiển thị modal
        header("Location: authenciation.php?success=1");
        exit();
    } else {
        echo "Update failed";
    }
}
