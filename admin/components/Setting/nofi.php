<?php
    include_once 'config/connect.php';
    $sql_notif="SELECT * FROM notiffication";
    $result_notif = sqlsrv_query($conn,$sql_notif);
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <h3><a style="color:black;" href="index.php"><i class='bx bxs-cog me-3' ></i></a>Notifications</h3>
        </div>
        <div class="col-md-6 text-right">
            <button class="btn btn-success float-end" >Add notification</button>
        </div>
    </div>
    <hr>
                    <div class="card">
                        <div class="card-body">
                            <h6 class="card-title">Latest Notifications</h6>
                            <p class="card-text">View a list of the latest notifications from the system.</p>
                            <div class="list-group">
                            <?php
                                $i=0;
                            while ($row_notif = sqlsrv_fetch_array($result_notif)) {?>
                                <a href="#" class="list-group-item list-group-item-action" aria-current="true">
                                    <div class="d-flex justify-content-between">
                                        <h5 class="mb-1"><?php echo $row_notif['notif_title'] ?></h5>
                                        <?php $created = $row_notif['notif_date'];
                                            $formatted_created = $created->format('Y-m-d H:i:s');?>
                                        <small><?php echo  $formatted_created; ?></small>
                                        <small><span class="badge bg-primary rounded-pill">New</span></small>
                                        <div class=>
                                            <button type="button" class="btn btn-primary">Edit</button>
                                            <button type="button" class="btn btn-danger">Delete</button>
                                        </div>
                                    </div>
                                    <p class="mb-1">Notification <?php $i++; echo $i ?></p>
                                    <input type="hidden" class="notification" value="<?php echo $row_notif['notif_content']; ?>">
                                    <input type="hidden" class="notification-id" value="<?php echo $row_notif['notif_id']; ?>">
                                </a>
                            <?php } ?>
                            </div>
                        </div>
                </div>
            </div>
    <div id="notificationInfoModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Notification Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="notificationInfoForm">
                        <div class="mb-3">
                            <label for="notificationTitle" class="form-label">Title:</label>
                            <input type="text" class="form-control" id="notificationTitle" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="notificationContent" class="form-label">Content:</label>
                            <textarea class="form-control" id="notificationContent" readonly></textarea>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Form -->
    <div id="deleteConfirmationModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <form id="deleteConfirmationForm" action="components/Setting/process.php?delete=1" method="POST">
            <input type="hidden" id="deleteNotificationId" name="notif_id">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirm Deletion</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete this notification?</p>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" id="confirmDeleteBtn" name="sbm_delete_notif">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Edit Notification Form -->
    <div id="editNotificationModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Notification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editNotificationForm" action ="components/Setting/process.php?edit=1" method="POST">
                    <input type="hidden" id="editNotificationId" name="notif_id">
                        <div class="mb-3">
                            <label for="editNotificationTitle" class="form-label">Title:</label>
                            <input type="text" class="form-control" id="editNotificationTitle" required name="title_notif">
                        </div>
                        <div class="mb-3">
                            <label for="editNotificationContent" class="form-label">Content:</label>
                            <textarea class="form-control" id="editNotificationContent" required name ="content_notif"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" id="confirmEditBtn"  name="sbm_edit_notif">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Notification Form -->
    <div id="addNotificationModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Notification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addNotificationForm" action ="components/Setting/process.php?add=1" method="POST">
                        <div class="mb-3">
                            <label for="newNotificationTitle" class="form-label">Title:</label>
                            <input type="text" class="form-control" id="newNotificationTitle" required name="title_notif">
                        </div>
                        <div class="mb-3">
                            <label for="newNotificationContent" class="form-label">Content:</label>
                            <textarea class="form-control" id="newNotificationContent" required name ="content_notif"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" name="sbm_add_notif">Add</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script>
   document.addEventListener("DOMContentLoaded", function () {
    const notificationLinks = document.querySelectorAll('.list-group-item-action');
    notificationLinks.forEach(link => {
        link.addEventListener('click', function (event) {
            event.preventDefault();
            // Check if it's not the "Edit" button being clicked
            if (!event.target.classList.contains('btn-primary') && !event.target.classList.contains('btn-danger')) {
                const notificationTitle = link.querySelector('h5').textContent;
                const notificationContent = link.querySelector('.notification').value;

                document.getElementById('notificationTitle').value = notificationTitle;
                document.getElementById('notificationContent').value = notificationContent;
                $('#notificationInfoModal').modal('show');
            }
        });
    });
});

    document.addEventListener("DOMContentLoaded", function () {
    // Event handling when clicking on "Edit" button
    const editButtons = document.querySelectorAll('.btn.btn-primary');
    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const notificationItem = button.closest('.list-group-item');
            const notificationId = notificationItem.querySelector('.notification-id').value;
            const notificationTitle = notificationItem.querySelector('h5').textContent;
            const notificationContent = notificationItem.querySelector('.notification').value;

            // Show edit form and populate information
            document.getElementById('editNotificationTitle').value = notificationTitle;
            document.getElementById('editNotificationContent').value = notificationContent;
            $('#editNotificationModal').modal('show');

            // Close information form
            $('#notificationInfoModal').modal('hide');

            // Pass notif_id through hidden input
            document.getElementById('editNotificationId').value = notificationId;
        });
    });

    // Event handling when clicking on "Delete" button
    const deleteButtons = document.querySelectorAll('.btn.btn-danger');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const notificationItem = button.closest('.list-group-item');
            const notificationId = notificationItem.querySelector('.notification-id').value;

            // Show delete form and pass notif_id
            $('#deleteConfirmationModal').modal('show');
            document.getElementById('deleteNotificationId').value = notificationId;

            // Close information form
            $('#notificationInfoModal').modal('hide');
        });
    });
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    confirmDeleteBtn.addEventListener('click', function () {
        // Submit delete confirmation form
        document.getElementById('deleteConfirmationForm').submit();
    });
});

document.addEventListener("DOMContentLoaded", function () {
    // Event handling when clicking on "Add notification" button
    const addNotificationButton = document.querySelector('.btn.btn-success');
    addNotificationButton.addEventListener('click', function () {
        // Show add notification modal
        $('#addNotificationModal').modal('show');
    });
});

</script>
