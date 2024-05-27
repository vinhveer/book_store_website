<?php include'sql_account/account_admin.php';
?>
<head>
    <link rel="stylesheet" href="components/accounts/account.css">
</head>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <h4 class="mb-3">Danh sách tài khoản</h4>
        </div>
        <div class="col-md-6">
            <form class="d-flex col-10" action="account_admin.php" method="POST">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search"
                    name="tukhoa" value="">
                    <button class="btn btn-outline-primary" type="submit" name="timkiem" value="find">Search</button>
            </form>
            <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['timkiem'])) { ?>
            <div class="row mt-2">
                <div class="col">
                    <?php
                        $tukhoa = $_POST['tukhoa'];
                        echo "<p>&nbspSearch with keyword: '<strong>$tukhoa</strong>'</p>";
                    ?>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="col-md-2">
            <button id="addAccountButton" class="btn btn-primary">Thêm tài khoản</button>
        </div>
    </div>
</div>

<div class="container-fluid mt-2">
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th scope="col" class="text-center">STT</th>
                <th scope="col" class="text-center">Profile</th>
                <th scope="col">User Name</th>
                <th scope="col">Account Name</th>
                <th scope="col">Password</th>
                <th scope="col" class="text-center">Operation</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $i = ($currentPage - 1) * $recordsPerPage;
                while ($row_account_admin = sqlsrv_fetch_array($result_account_admin)) {
                    ?>
                    <tr>
                        <td scope="row" class="text-center"><?php $i++; echo $i ?></td>
                        <td class="d-flex justify-content-center"><img src="<?php echo $row_account_admin['image_user'] ?>" alt="Avatar" class="rounded-circle" width="30" height="30"></td>
                        <td><?php echo $row_account_admin['full_name'] ?></td>
                        <td><?php echo $row_account_admin['username'] ?></td>
                        <td><?php echo $row_account_admin['password'] ?></td>
                        <td>
                        <div class="action-buttons d-flex justify-content-center">
                            <button class="btn btn-sm btn-warning me-1 d-flex align-items-center edit-account-button" data-user='<?php
                                    $dateOfBirth = $row_account_admin['date_of_birth'];
                                    $data = array(
                                        'user_id' => $row_account_admin['user_id'],
                                        'full_name' => $row_account_admin['full_name'],
                                        'username' => $row_account_admin['username'],
                                        'date_of_birth' => $dateOfBirth->format('Y-m-d'),
                                        'email'=> $row_account_admin['email'],
                                        'image_user'=> $row_account_admin['image_user'],
                                        'role_name'=> $row_account_admin['role_name'],
                                        'role_id'=> $row_account_admin['role_id'],
                                        'password'=> $row_account_admin['password'],
                                        'address'=> $row_account_admin['address'],
                                        'gender'=> $row_account_admin['gender'],
                                        'phone'=> $row_account_admin['phone']
                                    );
                                    echo json_encode($data);?>
                                    '><i class='bx bx-edit bx-sm me-1'></i>Edit</button>
                            <button type="button" class="btn btn-sm btn-danger me-1 d-flex align-items-center delete-account-button" data-user-id="<?php echo $row_account_admin['user_id']; ?>" data-bs-toggle="modal" data-bs-target="#deleteUserModal"><i class='bx bx-sm bx-trash me-1'></i>Delete</button>
                            <button class="btn btn-sm btn-success me-1 d-flex align-items-center show-account-button" data-user='<?php
                                    $dateOfBirth = $row_account_admin['date_of_birth'];
                                    $data = array(
                                        'user_id' => $row_account_admin['user_id'],
                                        'full_name' => $row_account_admin['full_name'],
                                        'username' => $row_account_admin['username'],
                                        'date_of_birth' => $dateOfBirth->format('Y-m-d'),
                                        'email'=> $row_account_admin['email'],
                                        'image_user'=> $row_account_admin['image_user'],
                                        'role_name'=> $row_account_admin['role_name'],
                                        'role_id'=> $row_account_admin['role_id'],
                                        'password'=> $row_account_admin['password'],
                                        'address'=> $row_account_admin['address'],
                                        'gender'=> $row_account_admin['gender'],
                                        'phone'=> $row_account_admin['phone']
                                    );
                                    echo json_encode($data);?>'><i class='bx bxs-show bx-sm me-1'></i>Show</button>
                        </div>
                        </td>
                    </tr>
                <?php } ?>
        </tbody>
    </table>
    <div class="d-flex align-items-center justify-content-center">
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item btn-outline-primary">
                <?php if($currentPage > 1): ?>
                        <a class="page-link" href="?page_layout=admin&page=<?php echo $currentPage-1; ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                <?php endif; ?>
                </li>
                <?php for ($page = $startPage; $page <= $endPage; $page++): ?>
                    <li class="page-item <?php if($page == $currentPage) echo 'active'; ?>"><a class="page-link" href="?page_layout=admin&page=<?php echo $page; ?>"><?php echo $page; ?></a></li>
                <?php endfor; ?>
                <li class="page-item btn-outline-primary">
                    <?php if($currentPage < $totalPages): ?>
                        <a class="page-link" href="?page_layout=admin&page=<?php echo $currentPage+1; ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                     </a>
                <?php endif; ?>
                </li>
            </ul>
        </nav>
    </div>
</div>

<!-- Add Account Modal -->
<div id="addAccountForm" class="modal fade" tabindex="-1" aria-labelledby="addAccountFormLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="addAccountFormData" action="components/accounts/process.php?role=2" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                <div class="modal-header">
                    <h5 class="modal-title" id="addAccountFormLabel">Thêm tài khoản</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 avatar-container">
                        <label for="image_user" class="form-label avatar-label">Avatar</label>
                        <input type="file" class="form-control visually-hidden" id="image_user" name="image_user" required>
                        <label for="image_user" class="avatar-label position-relative">
                            <img src="#" alt="" class="avatar-img rounded-circle">
                        </label>
                        <div class="invalid-feedback text-center">
                            Please choose a profile picture.
                        </div>
                    </div>
                   <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="fullName" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="fullName" name="full_name" value="<?= isset($_SESSION['form_data']['full_name']) ? htmlspecialchars($_SESSION['form_data']['full_name']) : '' ?>" required placeholder="Enter Full Name">
                            <div class="invalid-feedback">
                                Full Name cannot be empty.
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="username" class="form-label">Username</label>
                            <div class="input-group">
                                <span class="input-group-text">@</span>
                                <input type="text" class="form-control" id="username" name="username" pattern="[a-zA-Z0-9_]+" title="Invalid username. Only accept letters, numbers, and underscores." value="<?= isset($_SESSION['form_data']['username']) ? htmlspecialchars($_SESSION['form_data']['username']) : '' ?>" required>
                                <div class="invalid-feedback">
                                    Invalid username.
                                </div>
                            </div>
                        </div>
                   </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="dob" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" id="dob" name="date_of_birth" value="<?= isset($_SESSION['form_data']['date_of_birth']) ? htmlspecialchars($_SESSION['form_data']['date_of_birth']) : '' ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password" value="<?= isset($_SESSION['form_data']['password']) ? htmlspecialchars($_SESSION['form_data']['password']) : '' ?>" required>
                                <span class="input-group-text" id="password-toggle"><i class="bx bxs-hide"></i></span>
                                <div class="invalid-feedback">
                                    Password cannot be empty.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-select" id="gender" name="gender" required>
                                <option value="" disabled <?= !isset($_SESSION['form_data']['gender']) ? 'selected' : '' ?>>Select Gender</option>
                                <option value="1" <?= (isset($_SESSION['form_data']['gender']) && $_SESSION['form_data']['gender'] == '1') ? 'selected' : '' ?>>Male</option>
                                <option value="0" <?= (isset($_SESSION['form_data']['gender']) && $_SESSION['form_data']['gender'] == '0') ? 'selected' : '' ?>>Female</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="phone" name="phone" value="<?= isset($_SESSION['form_data']['phone']) ? htmlspecialchars($_SESSION['form_data']['phone']) : '' ?>" required placeholder="Enter Phone Number">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= isset($_SESSION['form_data']['email']) ? htmlspecialchars($_SESSION['form_data']['email']) : '' ?>" required placeholder="Enter Email">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address" value="<?= isset($_SESSION['form_data']['address']) ? htmlspecialchars($_SESSION['form_data']['address']) : '' ?>" required placeholder="Enter Address">
                        </div>
                    </div>
                </div>
                <div class="alert alert-danger <?= (!isset($_SESSION['username_exists']) || !$_SESSION['username_exists']) ? 'hidden' : '' ?>" role="alert">
                    <p id="log">Account already exists.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary" name="sbm_add">Thêm</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Edit Account Modal -->
<div id="editAccountForm" class="modal fade" tabindex="-1" aria-labelledby="editAccountFormLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editAccountFormData" action="components/accounts/process.php?edit=2&page=<?php echo (isset($_GET['page']))?$_GET['page']:"1";?>" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                <div class="modal-header">
                    <h5 class="modal-title" id="editAccountFormLabel">Chỉnh sửa tài khoản</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-end mb-3 position-absolute" style="top: 20px; right: 15px;">
                        <button type="button" class="btn btn-secondary">Đổi vai trò</button>
                    </div>
                    <input type="hidden" id="edit_user_id" name="user_id">
                    <div class="mb-3 avatar-container">
                        <label for="edit_image_user" class="form-label avatar-label">Avatar</label>
                        <input type="file" class="form-control visually-hidden" id="edit_image_user" name="image_user">
                        <label for="edit_image_user" class="avatar-label position-relative">
                            <img src="#" alt="" class="avatar-img rounded-circle">
                        </label>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="editFullName" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="editFullName" name="full_name" required>
                            <div class="invalid-feedback">
                                Full Name cannot be empty.
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editUsername" class="form-label">Username</label>
                            <div class="input-group">
                                <span class="input-group-text">@</span>
                                <input type="text" class="form-control" id="editUsername" name="username" pattern="[a-zA-Z0-9_]+" title="Invalid username. Only accept letters, numbers, and underscores." required>
                                <div class="invalid-feedback">
                                    Invalid username.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="editDob" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" id="editDob" name="date_of_birth" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editPassword" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="editPassword" name="password" required>
                                <span class="input-group-text" id="edit-password-toggle"><i class="bx bxs-hide"></i></span>
                                <div class="invalid-feedback">
                                    Password cannot be empty.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="editGender" class="form-label">Gender</label>
                            <select class="form-select" id="editGender" name="gender" required>
                                <option value="" disabled selected>Select Gender</option>
                                <option value="1">Male</option>
                                <option value="0">Female</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editPhone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="editPhone" name="phone" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="editEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="editEmail" name="email" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editAddress" class="form-label">Address</label>
                            <input type="text" class="form-control" id="editAddress" name="address" required>
                        </div>
                    </div>
                </div>
                <div class="alert alert-danger <?= (!isset($_SESSION['username_exists']) || !$_SESSION['username_exists']) ? 'hidden' : '' ?>" role="alert">
                    <p id="editLog"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary" name="sbm_edit">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteUserModalLabel">Xác nhận xóa tài khoản</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa tài khoản này?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                <form id="deletePostForm" action="components/accounts/process.php?delete=2" method="post">
                    <input type="hidden" name="user_id" id="deleteUserId">
                    <button type="submit" class="btn btn-danger" name="delete_user">Xóa</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- View Account Modal -->
<div id="viewAccountForm" class="modal fade" tabindex="-1" aria-labelledby="viewAccountFormLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewAccountFormLabel">Thông tin tài khoản</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="view_user_id" name="user_id">
                    <div class="mb-3 avatar-container">
                        <label for="view_image_user" class="form-label avatar-label">Avatar</label>
                        <input type="file" class="form-control visually-hidden" id="view_image_user" name="image_user" readonly>
                        <label for="view_image_user" class="avatar-label position-relative">
                            <img src="#" alt="" class="avatar-img rounded-circle">
                        </label>
                    </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="viewFullName" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="viewFullName" name="full_name" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="viewUsername" class="form-label">Username</label>
                        <input type="text" class="form-control" id="viewUsername" name="username" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="viewDob" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control" id="viewDob" name="date_of_birth" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="viewGender" class="form-label">Gender</label>
                        <input type="text" class="form-control" id="viewGender" name="gender" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="viewPhone" class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" id="viewPhone" name="phone" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="viewEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="viewEmail" name="email" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="viewAddress" class="form-label">Address</label>
                        <input type="text" class="form-control" id="viewAddress" name="address" readonly>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    var deleteUserModal = document.getElementById('deleteUserModal');
    var deleteUserForm = document.getElementById('deletePostForm');
    var deleteUserIdInput = document.getElementById('deleteUserId');

    deleteUserModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget; // Button that triggered the modal
        var userId = button.getAttribute('data-user-id'); // Extract info from data-* attributes

        // Update the form action with the user_id
        deleteUserIdInput.value = userId;
    });


        const editButtons = document.querySelectorAll('.edit-account-button');
        const editModal = new bootstrap.Modal(document.getElementById('editAccountForm'));
        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const userData = JSON.parse(this.getAttribute('data-user'));
                document.getElementById('edit_user_id').value = userData.user_id;
                document.getElementById('editFullName').value = userData.full_name;
                document.getElementById('editUsername').value = userData.username;
                document.getElementById('editDob').value = userData.date_of_birth;
                document.getElementById('editPassword').value = userData.password;
                document.getElementById('editGender').value = userData.gender;
                document.getElementById('editPhone').value = userData.phone;
                document.getElementById('editEmail').value = userData.email;
                document.getElementById('editAddress').value = userData.address;
                document.querySelector('#edit_image_user + .avatar-label img').src = userData.image_user;
                editModal.show();
            });
        });
        const showButtons = document.querySelectorAll('.show-account-button');
        const viewModal = new bootstrap.Modal(document.getElementById('viewAccountForm'));
        showButtons.forEach(button => {
            button.addEventListener('click', function() {
                const userData = JSON.parse(this.getAttribute('data-user'));
                document.getElementById('viewFullName').value = userData.full_name;
                document.getElementById('viewUsername').value = userData.username;
                document.getElementById('viewDob').value = userData.date_of_birth;
                document.getElementById('viewGender').value = userData.gender === '1' ? 'Male' : 'Female';
                document.getElementById('viewPhone').value = userData.phone;
                document.getElementById('viewEmail').value = userData.email;
                document.getElementById('viewAddress').value = userData.address;
                document.querySelector('#view_image_user + .avatar-label img').src = userData.image_user;
                viewModal.show();
            });
        });
        const addAccountButton = document.querySelector('#addAccountButton');
        addAccountButton.addEventListener('click', function() {
            const addAccountForm = new bootstrap.Modal(document.getElementById('addAccountForm'));
            addAccountForm.show();
        });

        const avatarInput = document.getElementById('image_user');
        const avatarImg = document.querySelector('.avatar-img');

        avatarInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function() {
                    avatarImg.src = reader.result;
                };
                reader.readAsDataURL(file);
            }
        });

        const editAvatarInput = document.getElementById('edit_image_user');
        const editAvatarImg = document.querySelector('#edit_image_user + .avatar-label img');

        editAvatarInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function() {
                    editAvatarImg.src = reader.result;
                };
                reader.readAsDataURL(file);
            }
        });

        const passwordToggle = document.getElementById('password-toggle');
        const passwordInput = document.getElementById('password');
        passwordToggle.addEventListener('click', function () {
            togglePasswordVisibility(passwordInput, passwordToggle);
        });

        const editPasswordToggle = document.getElementById('edit-password-toggle');
        const editPasswordInput = document.getElementById('editPassword');
        editPasswordToggle.addEventListener('click', function () {
            togglePasswordVisibility(editPasswordInput, editPasswordToggle);
        });

        function togglePasswordVisibility(input, toggle) {
            if (input.type === 'password') {
                input.type = 'text';
                toggle.innerHTML = '<i class="bx bxs-show"></i>';
            } else {
                input.type = 'password';
                toggle.innerHTML = '<i class="bx bxs-hide"></i>';
            }
        }

        var form = document.getElementById('addAccountFormData');
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);

        var editForm = document.getElementById('editAccountFormData');
        editForm.addEventListener('submit', function(event) {
            if (!editForm.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            editForm.classList.add('was-validated');
        }, false);
    });

    document.addEventListener('DOMContentLoaded', function () {
        const addAccountForm = new bootstrap.Modal(document.getElementById('addAccountForm'));

        <?php if (isset($_SESSION['username_exists']) && $_SESSION['username_exists']): ?>
            addAccountForm.show();
            <?php unset($_SESSION['form_data']);
            unset($_SESSION['username_exists']);?>
        <?php endif; ?>

        const avatarInput = document.getElementById('image_user');
        const avatarImg = document.querySelector('.avatar-img');

        avatarInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function() {
                    avatarImg.src = reader.result;
                };
                reader.readAsDataURL(file);
            }
        });
    });

</script>
