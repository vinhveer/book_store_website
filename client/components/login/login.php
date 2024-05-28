<head>
    <link rel="stylesheet" href="components/login/login.css">
</head>

<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="loginModalLabel">Đăng nhập</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="components\login\process.php" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Tên đăng nhập</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3 form-check">
                        <input class="form-check-input" type="checkbox" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
                    </div>
                    <button type="submit" class="btn btn-primary" name="login">Đăng nhập</button>
                    <div class="mt-3">
                        Chưa có tài khoản? <a href="#registerModal" class="text-decoration-none" data-bs-dismiss="modal"
                            data-bs-toggle="modal" data-bs-target="#registerModal">Đăng ký ngay.</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="registerModalLabel">Đăng ký</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="components/login/process.php" method="post">
                    <p>Hoàn thành một số thông tin cơ bản sau</p>
                    <div class="mb-3">
                        <label for="full_name" class="form-label">Họ và tên</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="date_of_birth" class="form-label">Ngày sinh</label>
                        <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
                    </div>
                    <div class="mb-3">
                        <label for="gender" class="form-label">Giới tính</label>
                        <select class="form-select" id="gender" name="gender" required>
                            <option value="">Chọn giới tính</option>
                            <option value="1">Nam</option>
                            <option value="0">Nữ</option>
                            <option value="other">Khác</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="tel" class="form-control" id="phone" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Địa chỉ</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Tên đăng nhập</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu (Tối thiểu 8 ký tự)</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="register">Đăng ký</button>
                    <div class="mt-3">
                        Đã có tài khoản? <a href="#loginModal" class="text-decoration-none" data-bs-dismiss="modal"
                            data-bs-toggle="modal" data-bs-target="#loginModal">Đăng nhập ngay.</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        document.querySelectorAll('.switch-modal').forEach((element) => {
            element.addEventListener('click', function (e) {
                e.preventDefault();
                const targetModal = document.querySelector(this.getAttribute('href'));

                // Hide the current modal
                const currentModal = this.closest('.modal');
                const currentModalInstance = bootstrap.Modal.getInstance(currentModal);
                currentModalInstance.hide();

                // Show the target modal
                const targetModalInstance = new bootstrap.Modal(targetModal);
                targetModalInstance.show();
            });
        });
    });

</script>