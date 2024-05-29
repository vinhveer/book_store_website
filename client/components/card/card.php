<?php
function card($imgSrc, $title, $price, $productId)
{
    // Giới hạn độ dài của $title ở mức 30 ký tự
    if (strlen($title) > 30) {
        $title = substr($title, 0, 30) . "...";
    }

    return '
        <div class="col-md-2 p-2">
            <div class="card">
                <img src="' . $imgSrc . '" class="card-img-top" alt="...">
                <div class="overlay d-flex p-0" style="color: white">
                    <button class="btn w-50 add-to-cart" data-product-id="' . $productId . '">
                        <i class="bi bi-cart-plus-fill"></i>
                        <p>Thêm vào giỏ hàng</p>
                    </button>
                    <button class="btn w-50">
                        <i class="bi bi-list-ul"></i>
                        <p>Xem chi tiết</p>
                    </button>
                </div>
                <div class="card-body">
                    <h5 class="card-title">' . htmlspecialchars($title) . '</h5>
                    <p class="card-text">' . number_format($price, 0, ',', '.') . ' VND</p>
                </div>
            </div>
        </div>
        
        <!-- Modal -->
        <div class="modal fade" id="quantityModal' . $productId . '" tabindex="-1" aria-labelledby="quantityModalLabel' . $productId . '" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="quantityModalLabel' . $productId . '">Chọn số lượng</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="number" id="quantity' . $productId . '" class="form-control" value="1" min="1">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-primary confirm-add-to-cart" data-product-id="' . $productId . '">Thêm vào giỏ hàng</button>
                    </div>
                </div>
            </div>
        </div>
    ';
}

// Function to display cards based on SQL query results
function card_display($sql, $title, $conn)
{
    $result = sqlsrv_query($conn, $sql);
    if ($result === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    echo "
    <head>
        <link rel='stylesheet' href='components/card/card.css'>
    </head>
    <div class='container-fluid ps-4 pe-4'>
        <div class='d-flex mt-4 justify-content-center align-items-center'>
            <h5 style='margin-bottom: 0'>$title</h5>
            <a href='#' class='ms-auto'>Xem thêm</a>
        </div>
        <div class='row mt-2'>";

    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
        echo card($row['product_image'], $row['book_name'], $row['product_price'], $row['product_id']);
    }

    echo "
        </div>
    </div>";

    sqlsrv_free_stmt($result);
    sqlsrv_close($conn);
}

?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            const modalId = '#quantityModal' + productId;
            const modal = new bootstrap.Modal(document.querySelector(modalId));
            modal.show();
        });
    });

    document.querySelectorAll('.confirm-add-to-cart').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-product-id');
            const quantity = document.querySelector('#quantity' + productId).value;

            console.log(`Product ID: ${productId}, Quantity: ${quantity}`); // Debug log

            fetch('add_to_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: quantity,
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Thêm vào giỏ hàng thành công!');
                } else {
                    console.log('Có lỗi xảy ra: ' + data.error);
                }
                const modalId = '#quantityModal' + productId;
                const modal = bootstrap.Modal.getInstance(document.querySelector(modalId));
                modal.hide();
            })
            .catch(error => console.error('Error:', error));
        });
    });
});

</script>
