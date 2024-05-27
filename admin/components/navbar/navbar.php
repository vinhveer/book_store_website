<nav class="navbar navbar-expand-lg bg-body-tertiary fixed-top">
    <div class="container-fluid">
        <button class="toggle-btn btn btn-outline-secondary p-0 ps-3 pe-3" type="button"
            style="font-size: 14px; color: dark">
            <i class="bi bi-list"></i>
        </button>
        <a class="navbar-brand" href="#">Admin</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <!-- <form action="components/navbar/process.php" method="post" class="ms-auto w-50">
                <div class="input-group">
                    <select class="form-select" id="find" name="find" required>
                        <option value="" disabled selected>Filter search</option>
                        <option value="1">Account</option>
                        <option value="0">Orders</option>
                    </select>
                    <input type="search" class="form-control w-50" placeholder="Tìm kiếm"
                        aria-label="Search" aria-describedby="button-addon2" name="keyword">
                        <button class="search-btn" type="submit" name="search" value="find"><i class='bx bx-search'></i></button>
                </div>
            </form> -->

            <ul class="navbar-nav ms-auto me-4 mt-1">
                <a href="#" class="notif ms-auto me-5">
                    <i class='bx bx-bell'></i>
                </a>
                <li class="nav-item dropdown me-2">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span>
                                Admin
                        </span>
                        <img src="assets/account.png" alt="Avatar" class="rounded-circle" width="30" height="30">
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="My.php">Trang cá nhân</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="../logout.php">Đăng xuất</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
