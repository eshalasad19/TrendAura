<?php
include('../config/db.php');
session_start();

// Ensure only logged-in admins can access this page
if (!isset($_SESSION['admin']) || ($_SESSION['admin']['role_name'] != 'Admin' && $_SESSION['admin']['role_name'] != 'Product Manager' && $_SESSION['admin']['role_name'] != 'Order Dispatcher')) {
    header("Location: login.php"); // Redirect to admin login
    exit();
}
$admin = $_SESSION['admin'];
?>

<header class="header-main">
    <div class="container-fluid">
        <div class="row">
            <div class="col-6 col-sm-4 d-flex align-items-center header-left p-0">
                <!-- Sidebar Toggle Button -->
                <span class="header-toggle me-3">
                    <i class="ph ph-circles-four"></i>
                </span>
            </div>

            <div class="col-6 col-sm-8 d-flex align-items-center justify-content-end header-right p-0">
                <ul class="d-flex align-items-center">

                    <!-- Dark Mode Toggle -->
                    <li class="header-dark">
                        <div class="sun-logo head-icon">
                            <i class="ph ph-moon-stars"></i>
                        </div>
                        <div class="moon-logo head-icon">
                            <i class="ph ph-sun-dim"></i>
                        </div>
                    </li>
                    <li class="header-notification">
    <a href="#" class="d-block head-icon position-relative" role="button" data-bs-toggle="offcanvas"
        data-bs-target="#notificationcanvasRight" aria-controls="notificationcanvasRight">
        <i class="ph ph-bell"></i>
        <?php
        include('../config/db.php');
        $unread_count_query = "SELECT COUNT(*) AS unread_count FROM contact_messages";
        $unread_count_result = mysqli_query($conn, $unread_count_query);
        $unread_count = mysqli_fetch_assoc($unread_count_result)['unread_count'];
        ?>
        <span class="position-absolute translate-middle p-1 bg-success border border-light rounded-circle <?= $unread_count > 0 ? 'animate__animated animate__fadeIn animate__infinite animate__slower' : ''; ?>"></span>
    </a>
    <div class="offcanvas offcanvas-end header-notification-canvas" tabindex="-1"
        id="notificationcanvasRight" aria-labelledby="notificationcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="notificationcanvasRightLabel">Messages</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        <div class="offcanvas-body app-scroll p-0">
            <div class="head-container">
                <?php
                // Join contact_messages with register table to fetch user details
                $message_query = "
                    SELECT cm.name, cm.message, 
                           DATE_FORMAT(cm.created_at, '%b %d, %Y') AS formatted_date, 
                           r.profile_pic 
                    FROM contact_messages cm
                    LEFT JOIN register r ON cm.user_id = r.id
                    ORDER BY cm.created_at DESC";
                $message_result = mysqli_query($conn, $message_query);

                if (mysqli_num_rows($message_result) > 0) {
                    while ($row = mysqli_fetch_assoc($message_result)) {
                        $profile_pic = $row['profile_pic'] ? '../image/' . htmlspecialchars($row['profile_pic']) : '../assets/images/default-avatar.png'; // Default image
                ?>
                <div class="notification-message head-box">
                    <div class="message-images">
                        <span class="bg-secondary h-35 w-35 d-flex-center b-r-10 position-relative">
                            <img src="<?= $profile_pic; ?>" alt="User Picture"
                                class="img-fluid b-r-10">
                        </span>
                    </div>
                    <div class="message-content-box flex-grow-1 ps-2">
                        <a class="f-s-15 text-secondary mb-0">
                            <span class="f-w-500 text-secondary"><?= htmlspecialchars($row['name']); ?></span>: <?= htmlspecialchars($row['message']); ?>
                        </a>
                        <span class="badge text-light-secondary mt-2"><?= $row['formatted_date']; ?></span>
                    </div>
                </div>
                <?php
                    }
                } else {
                ?>
                <div class="hidden-massage py-4 px-3 text-center">
                    <img src="../assets/images/icons/bell.png" class="w-50 h-50 mb-3 mt-2" alt="No Notifications">
                    <div>
                        <h6 class="mb-0">Notification Not Found</h6>
                        <p class="text-secondary">When you have any notifications added here, they will appear here.</p>
                    </div>
                </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>
</li>

                    <!-- Profile Section -->
                    <li class="header-profile">
                        <a href="#" class="d-block head-icon" role="button" data-bs-toggle="offcanvas" data-bs-target="#profileCanvasRight" aria-controls="profileCanvasRight">
                            <img src="../image/<?php echo htmlspecialchars($admin['profile_pic']); ?>" alt="avatar" class="b-r-10 h-35 w-35">
                        </a>
                        <div class="offcanvas offcanvas-end header-profile-canvas" tabindex="-1" id="profileCanvasRight" aria-labelledby="profileCanvasRight">
                            <div class="offcanvas-body app-scroll">
                                <ul>
                                    <!-- Profile Info -->
                                    <li>
                                        <div class="d-flex-center">
                                            <span class="h-45 w-45 d-flex-center b-r-20">
                                                <img src="../image/<?php echo htmlspecialchars($admin['profile_pic']); ?>" alt="Profile Picture" class="img-fluid" style="width: 80px; height: 55px;">
                                            </span>
                                        </div>
                                        <div class="text-center mt-2">
                                            <h6 class="mb-0"><?php echo htmlspecialchars($admin['username']); ?></h6>
                                            <p class="f-s-12 mb-0 text-secondary"><?php echo htmlspecialchars($admin['role_name']); ?></p>
                                        </div>
                                    </li>

                                    <!-- Settings Link -->
                                    <!-- <li class="app-divider-v dotted py-1"></li>
                                    <li>
                                        <a class="f-w-500" href="setting.html">
                                            <i class="ph-duotone ph-gear pe-1 f-s-20"></i> Settings
                                        </a>
                                    </li> -->

                                    <!-- Logout Button -->
                                    <li class="app-divider-v dotted py-1"></li>
                                    <li>
                                        <a class="mb-0 text-danger" href="login.php">
                                            <i class="ph-duotone ph-sign-out pe-1 f-s-20"></i> Log Out
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</header>
