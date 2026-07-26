<?php include('header.php')?>
<?php include('navbar.php')?>
<?php
if (!isset($_SESSION['admin']) || ($_SESSION['admin']['role_name'] != 'Admin' && $_SESSION['admin']['role_name'] != 'Product Manager' && $_SESSION['admin']['role_name'] != 'Order Dispatcher')) {
    header("Location: login.php"); // Redirect to admin login
    exit();
}
?>

<body>
    <div class="app-wrapper">

        <div class="loader-wrapper">
            <div class="app-loader">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        <!-- Menu Navigation starts -->
        <?php include('sidebar.php')?>
        <!-- Menu Navigation ends -->

        <div class="app-content">
            <!-- Body main section starts -->
            <main>
                <div class="container-fluid">
                    <!-- Breadcrumb start -->
                    <div class="row m-1">
                        <div class="col-12 ">
                            <h4 class="main-title">Update Category Form</h4>
                        </div>
                    </div>
                    <br>
                    <!-- Breadcrumb end -->

                    <!-- ready to use form start -->
                    <?php
       include('../config/db.php');
       $order_id = $_GET['order_id'] ?? '';
       if (!ctype_digit((string)$order_id)) { die('Invalid ID.'); }

       $valid_statuses = ['Pending', 'Processing', 'Shipped', 'Delivered', 'Cancelled'];
       // Admin can move an order forward through these stages, but cannot set it to
       // Cancelled — cancellation is customer-initiated only (from their tracking page).
       $dropdown_statuses = ['Pending', 'Processing', 'Shipped', 'Delivered'];

       if (isset($_POST['update'])) {
           $status = in_array($_POST['status'], $dropdown_statuses) ? $_POST['status'] : 'Pending';
           $note = trim($_POST['note'] ?? '');

           // When an order is marked Delivered, the payment is considered collected
           // (COD is paid on delivery) — so flip payment_status to Paid automatically.
           if ($status === 'Delivered') {
               $insert = "UPDATE orderr SET status = ?, payment_status = 'Paid' WHERE order_id = ?";
           } else {
               $insert = "UPDATE orderr SET status = ? WHERE order_id = ?";
           }
           $stmt = mysqli_prepare($conn, $insert);
           mysqli_stmt_bind_param($stmt, "si", $status, $order_id);
           $result = mysqli_stmt_execute($stmt);

           if ($result) {
               // Log this change so the customer's tracking timeline reflects it
               $history_note = $note !== '' ? $note : null;
               $history_stmt = mysqli_prepare($conn, "INSERT INTO order_status_history (order_id, status, note) VALUES (?, ?, ?)");
               mysqli_stmt_bind_param($history_stmt, "iss", $order_id, $status, $history_note);
               mysqli_stmt_execute($history_stmt);

               echo "<script>adminToast('Order status updated', 'success'); setTimeout(function(){ location.replace('show_order.php'); }, 1200);</script>";
           }
       };

       // Fetch current status so the dropdown shows what it's actually set to right now
       $current_stmt = mysqli_prepare($conn, "SELECT status FROM orderr WHERE order_id = ?");
       mysqli_stmt_bind_param($current_stmt, "i", $order_id);
       mysqli_stmt_execute($current_stmt);
       $current_row = mysqli_stmt_get_result($current_stmt)->fetch_assoc();
       $current_status = $current_row['status'] ?? 'Pending';
       ?>
                    <div class="row">
                        <!-- Book Appointment Form start -->
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Update Order #<?php echo $order_id; ?></h5>
                                </div>
                                <div class="card-body">
                                    <?php if (in_array($current_status, ['Cancelled', 'Delivered'])): ?>
                                        <div style="background:<?php echo $current_status === 'Cancelled' ? '#fdf1f1' : '#e7f7ee'; ?>;border:1px solid <?php echo $current_status === 'Cancelled' ? '#f5c2c2' : '#a3e0c1'; ?>;border-radius:6px;padding:14px 16px;color:<?php echo $current_status === 'Cancelled' ? '#db1215' : '#1a9c5b'; ?>;font-weight:600;">
                                            <?php if ($current_status === 'Cancelled'): ?>
                                                This order was cancelled by the customer. Status can no longer be changed.
                                            <?php else: ?>
                                                This order has been delivered. No further status changes are needed.
                                            <?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                    <form action="#" class="app-form" method="post" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                <label for="name">Update Status</label>
                                                <br>
                                                    <select name="status" id="status" class="form-control">
                                                        <?php foreach ($dropdown_statuses as $s): ?>
                                                            <option value="<?php echo $s; ?>" <?php echo ($current_status === $s) ? 'selected' : ''; ?>><?php echo $s; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label for="note">Note (optional — shown to customer in tracking)</label>
                                                    <input type="text" name="note" id="note" class="form-control" placeholder="e.g. Shipped via TCS, tracking #12345">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="text-end">
                                                    <button type="submit" class="btn btn-primary"
                                                        name="update">Submit</button>
                                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>


                        <!-- Book Appointment Form end -->
                    </div>
                    <!-- ready to use form and -->
                </div>
            </main>
            <!-- Body main section ends -->


            <!-- tap on top -->
            <div class="go-top">
                <span class="progress-value">
                    <i class="ph-bold ph-arrow-up"></i>
                </span>
            </div>
            <?php include('footer.php')?>