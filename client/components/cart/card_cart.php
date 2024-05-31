<?php
$user_id = $_SESSION['user_id'];
$sql = "SELECT p.product_id, p.product_image, p.product_price, c.quantity
        FROM carts c
        JOIN products p ON c.product_id = p.product_id
        WHERE c.user_id = ? AND c.status = 1";

$params = array($user_id);
$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

$cart_items = array();
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $cart_items[] = $row;
}
sqlsrv_close($conn);
?>

<div class="container-fluid ms-4 me-4">
    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <?php foreach ($cart_items as $item): ?>
                    <div class="card mb-4" data-id="<?php echo $item['product_id']; ?>" onclick="toggleCheckbox(<?php echo $item['product_id']; ?>)">
                        <div class="row no-gutters">
                            <div class="col-md-2">
                                <img src="<?php echo $item['product_image']; ?>" class="card-img" alt="Product Image">
                            </div>
                            <div class="col-md-10">
                                <div class="card-body row">
                                    <div class="col-md-1">
                                        <input type="checkbox" name="selected_products[]" value="<?php echo $item['product_id']; ?>" id="checkbox-<?php echo $item['product_id']; ?>">
                                    </div>
                                    <div class="col-md-9">
                                        <h5 class="card-title"><?php echo $item['product_id']; ?></h5>
                                        <p class="card-text"><?php echo $item['quantity']; ?></p>
                                        <p class="card-text"><?php echo number_format($item['product_price'], 2); ?></p>
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-success"><i class='bx bx-edit'></i></button>
                                        <button class="btn btn-warning"><i class='bx bx-trash'></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="col-md-4">
            <!-- You can add other content here -->
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this item from your cart?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
      </div>
    </div>
  </div>
</div>

<!-- Edit Quantity Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Quantity</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editForm" action="components/cart/process.php" method="post">
          <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" class="form-control" id="quantity" name="quantity" required>
          </div>
          <input type="hidden" id="editProductId" name="product_id">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary" id="confirmEditBtn">Save changes</button>
      </div>
    </div>
  </div>
</div>


<script>
function toggleCheckbox(productId) {
    const checkbox = document.getElementById('checkbox-' + productId);
    checkbox.checked = !checkbox.checked;
}

// Prevent event from bubbling to card when clicking on checkbox
document.querySelectorAll('input[type="checkbox"]').forEach(function(checkbox) {
    checkbox.addEventListener('click', function(event) {
        event.stopPropagation();
    });
});

let productIdToDelete;
let productIdToEdit;

document.querySelectorAll('.btn-warning').forEach(button => {
    button.addEventListener('click', function(event) {
        event.stopPropagation();
        productIdToDelete = this.closest('.card').dataset.id;
        new bootstrap.Modal(document.getElementById('deleteModal')).show();
    });
});

document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
    window.location.href = `components/cart/process.php?product_id=${productIdToDelete}&delete=1`;
});

document.querySelectorAll('.btn-success').forEach(button => {
    button.addEventListener('click', function(event) {
        event.stopPropagation();
        productIdToEdit = this.closest('.card').dataset.id;
        const quantity = this.closest('.card').querySelector('.card-text').innerText.split(': ')[1];
        document.getElementById('quantity').value = quantity;
        document.getElementById('editProductId').value = productIdToEdit;
        new bootstrap.Modal(document.getElementById('editModal')).show();
    });
});

document.getElementById('confirmEditBtn').addEventListener('click', function() {
    document.getElementById('editForm').submit();
});
</script>
