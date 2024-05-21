<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="components/home/header.css">
</head>

<body>
    <div class="container-fluid p-0">
        <div id="carouselExample" class="carousel slide">
            <div class="carousel-inner">
                <div class="carousel-item active p-0">
                    <img src="assets/slider_2.webp" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item p-0">
                    <img src="assets/slider_3.webp" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item p-0">
                    <img src="assets/slider_1.webp" class="d-block w-100" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    <div class="container-fluid ps-4 pe-4 pt-5">
        <div class="row">
            <div class="col-md-6 ps-5 pe-5 d-flex align-items-center">
                <div class="text">
                    <div class="line"></div>
                    <h3>Giáo dục là làm cho con người tìm thấy chính mình.</h3>
                    <p>- Socrates -</p>
                </div>
            </div>
            <div class="col-md-6 d-flex align-items-center justify-content-center   ">
                <img src=<?php echo $path . "assets/header_pic.jpg" ?> class="banner-img" alt="" srcset="">
            </div>
        </div>
    </div>
</body>

</html>