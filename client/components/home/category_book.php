<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="components/home/category.css">
    <style>
        .sticky-element {
            top: 35px;
            z-index: 999;
        }
        html {
            scroll-behavior: smooth;
        }
    </style>
</head>

<body>
    <ul id="category-nav" class="nav nav-underline container-fluid ps-4 pe-4 sticky-top sticky-element bg-body-tertiary">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#entertainment-education">Giải trí và Giáo dục</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#science-society">Khoa học và Xã hội</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#literature-art">Văn học và Nghệ thuật</a>
        </li>
    </ul>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navbarLinks = document.querySelectorAll('#category-nav .nav-link');
            navbarLinks.forEach(link => {
                link.addEventListener('click', function(event) {
                    event.preventDefault();
                    navbarLinks.forEach(nav => nav.classList.remove('active'));
                    this.classList.add('active');
                    const targetId = this.getAttribute('href').substring(1);
                    const targetElement = document.getElementById(targetId);
                    if (targetElement) {
                        targetElement.scrollIntoView({ behavior: 'smooth' });
                    }
                });
            });
        });
    </script>
</body>

</html>
