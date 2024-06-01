<aside id="sidebar">
    <ul class="sidebar-nav">
        <li class="sidebar-item">
            <a href="index.php?page_layout=home" class="sidebar-link">
                <i class="bi bi-house-door"></i>
                <span>Trang chủ</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse" data-bs-target="#auth"
                aria-expanded="false" aria-controls="auth">
                <i class="bi bi-person-circle"></i>
                <span>Tài khoản</span>
            </a>
            <ul id="auth" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                <li class="sidebar-item">
                    <a href="account_customer.php" class="sidebar-link">
                        <i class="bi bi-people mx-2"></i>
                        <span>Khách hàng</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="account_employee.php?page_layout=employee" class="sidebar-link">
                        <i class="bi bi-person-badge mx-2"></i>
                        <span>Nhân viên</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="account_admin.php?page_layout=admin" class="sidebar-link">
                        <i class="bi bi-person-check mx-2"></i>
                        <span>Admin</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="sidebar-item">
            <a href="book.php?page_layout=product" class="sidebar-link">
                <i class="bi bi-box"></i>
                <span>Product</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="order.php?page_layout=order" class="sidebar-link">
                <i class="bi bi-receipt"></i>
                <span>Order</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a href="#" class="sidebar-link">
                <i class="bi bi-box-arrow-left"></i>
                <span>Logout</span>
            </a>
        </li>
    </ul>
</aside>
