<!doctype html>
<html lang="en" data-bs-theme="auto">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Sign Out</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        html,
        body {
            height: 100%;
        }

        .form-signin {
            width: 500px;
            padding: 1rem;
        }

        .btn {
            background-color: #c62e46;
        }

        .btn:hover {
            background-color: #f7ca00;
        }
    </style>

</head>

<body class="d-flex align-items-center py-4 bg-body-tertiary">
    <?php
    session_start();
    session_destroy();
    ?>

    <main class="form-signin m-auto">
        <form>
            <img class="mb-4" src="client/assets/light_theme_logo.png" alt="" width="100px">
            <h1 class="h3 mb-3 fw-normal">Goodbye!</h1>

            <p>You have been signed out successfully.</p>
            <a class="btn text-white w-100 py-2" href="index.php">Về trang chủ</a>
            <p class="mt-5 mb-3 text-body-secondary">&copy; 2017–2024</p>
        </form>
    </main>
</body>

</html>
