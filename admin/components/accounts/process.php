<?php
    include '../../config/connect.php';
 if (($_SERVER["REQUEST_METHOD"] == "POST") && isset($_POST['sbm_add'])){
        $full_name = $_POST['full_name'];
        $birth = $_POST['date_of_birth'];
        $gender = $_POST['gender'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        if(isset($_FILES['image_user']) && $_FILES['image_user']['error'] === UPLOAD_ERR_OK) {
            $image_user_tmp = $_FILES['image_user']['tmp_name'];
            $image_user = "assets/images/avatar/".$_FILES['image_user']['name'];
            move_uploaded_file($image_user_tmp, "../../".$image_user);
            $image = $image_user;
        } else {
            $image = "";
        }
        $sql_check_username = "SELECT * FROM user_accounts WHERE username='$username'";
        $result_check_username = sqlsrv_query($conn, $sql_check_username);
        if ($row_result = sqlsrv_fetch_array($result_check_username) > 0) {
            $role = ($_GET['role']!=NULL)?$_GET['role']:"";
            $_SESSION['username_exists'] = true;
            $_SESSION['form_data'] = $_POST; // Store the form data

            if($role == 1)  header("location: ../../account_admin.php");
            else if ($role == 2) header("location: ../../account_customer.php");
            else if ($role == 3) header("location: ../../account_employee.php");
        }else{
            unset($_SESSION['form_data']);
            unset($_SESSION['username_exists']);
            if ($_GET['role'] == "1") {
                $sql_new = "EXEC InsertNewUser_customer ?, ?, ?, ?, ?, ?, ?, ?, ?";
                $params = array(
                    $full_name,
                    $birth, $gender, $email, $address,
                    $phone, $image, $username, $password);
                $insert_result = sqlsrv_query($conn, $sql_new, $params);
                if( $insert_result)
                header("location: ../../account_customer.php");
            } else if ($_GET['role'] == "2") {
                $sql_new = "EXEC InsertNewUser_admin ?, ?, ?, ?, ?, ?, ?, ?, ?";
                $params = array(
                    $full_name,
                    $birth, $gender, $email, $address,
                    $phone, $image, $username, $password);
                $insert_result = sqlsrv_query($conn, $sql_new, $params);
                if( $insert_result)
                header("location: ../../account_customer.php");
            } else if ($_GET['role'] == "3") {
                $sql_new = "EXEC InsertNewUser_employee ?, ?, ?, ?, ?, ?, ?, ?, ?";
                $params = array(
                    $full_name,
                    $birth, $gender, $email, $address,
                    $phone, $image, $username, $password);
                $insert_result = sqlsrv_query($conn, $sql_new, $params);
                if( $insert_result)
                header("location: ../../account_employee.php");
            }else {
                echo "Lỗi role không tồn tại: " . sqlsrv_errors($dbconnect);
            }
        }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete_user"])) {
    $user_id = $_POST['user_id'];
    $sql_delete = "DELETE FROM users where user_id = $user_id";
    $query = sqlsrv_query($conn, $sql_delete);
    $delete = $_GET['delete'];
    if ($delete == 1) header("location: ../../account_customer.php");
    else if($delete == 2) header("location: ../../account_customer.php");
    else if($delete == 3 )  header("location: ../../account_employee.php");
    else  echo "Lỗi role không tồn tại: " . sqlsrv_errors($dbconnect);
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["sbm_edit"])) {
    $user_id = $_POST['user_id'];
    $sql_update = "SELECT *
    FROM users u
    INNER JOIN user_roles ur ON u.user_id = ur.user_id
    INNER JOIN roles r ON ur.role_id = r.role_id
    INNER JOIN user_accounts ua on ua.user_role_id = ur.user_role_id
    where u.user_id=$user_id";
    $query_update = sqlsrv_query($conn, $sql_update);
    $row_update = sqlsrv_fetch_array($query_update);
    $full_name = $_POST['full_name'];
    $birth = $_POST['date_of_birth'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    if(isset($_FILES['image_user']) && $_FILES['image_user']['error'] === UPLOAD_ERR_OK) {
        $image_user_tmp = $_FILES['image_user']['tmp_name'];
        $image_user = "assets/images/avatar/".$_FILES['image_user']['name'];
        move_uploaded_file($image_user_tmp, "../../".$image_user);
        $image = $image_user;
    } else {
        $image = ""; // Nếu không tải ảnh lên, gán giá trị rỗng cho trường ảnh
    }

    if ($image == NULL)
        $image = $row_update['image_user'];
    $sql_edit_user = "UPDATE users
    SET full_name = N'$full_name',
        date_of_birth = '$birth',
        gender = $gender,
        address = '$address',
        phone = '$phone',
        email = '$email',
        image_user = '$image'
    WHERE user_id = $user_id;";
    $query_update_user = sqlsrv_query($conn, $sql_edit_user);
    if ($query_update_user === false) {
        die( print_r( sqlsrv_errors(), true));
    } else {
        $page = $_GET['page'];
        $edit = $_GET['edit'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $sql_upadte_account = "UPDATE user_accounts
        SET username = '$username',
            password = '$password'
        WHERE user_role_id IN (SELECT user_role_id FROM user_roles WHERE user_id = $user_id);";
        $result_update_account = sqlsrv_query($conn, $sql_upadte_account);
        if ($result_update_account === false) {
            die( print_r( sqlsrv_errors(), true));
        }else{
            if ($edit == 1) header("location: ../../account_admin.php?page_layout=admin&page=$page");
            else if($edit == 2) header("location: ../../account_customer.php?page_layout=customer&page=$page");
            else if($edit == 3 )  header("location: ../../account_employee.php?page_layout=employee&page=$page");
            else  echo "Lỗi role không tồn tại: " . sqlsrv_errors($dbconnect);
        }
    }
}
?>
