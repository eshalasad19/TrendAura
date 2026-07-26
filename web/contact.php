<?php
include('config/db.php'); 
include('auth_check.php'); 
$page_title = 'Contact Us';
$page_description = 'Get in touch with the TrendAura team — questions, order support, and feedback.';
include('include/header.php');
 include('include/navbar.php');
// session_start(); ?>
<script>
    window.TOAST_REDIRECT_SUCCESS = 'view-cart.php';
    window.TOAST_REDIRECT_ERROR = 'login.php';
</script>

        <!-- page-title -->
        <div class="tf-page-title style-2">
            <div class="container-full">
                <div class="heading text-center">Contact Us</div>
            </div>
        </div>
        <!-- /page-title -->
        <!-- map -->
        <section class="flat-spacing-9">
            <div class="container">
                <div class="tf-grid-layout gap-0 lg-col-2">
                    <div class="w-100">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d317859.6089702069!2d-0.075949!3d51.508112!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x48760349331f38dd%3A0xa8bf49dde1d56467!2sTower%20of%20London!5e0!3m2!1sen!2sus!4v1719221598456!5m2!1sen!2sus" width="100%" height="894" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                    <div class="tf-content-left has-mt">
                        <div class="sticky-top">
                            <h5 class="mb_20">Visit Our Store</h5>
                            <?php
                                                                $sql = "SELECT * FROM contact_details";
                                                                $result = mysqli_query($conn, $sql);
                                                                while($row = mysqli_fetch_assoc($result)){
                            ?>
                            <div class="mb_20">
                                <p class="mb_15"><strong><?php echo $row['heading'] ?></strong></p>
                                <p><?php echo $row['description'] ?></p>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /map -->
        <!-- form -->
        <section class="bg_grey-7 flat-spacing-9">
            <div class="container">
                <div class="flat-title">
                    <span class="title">Get in Touch</span>
                    <p class="sub-title text_black-2">If you’ve got great products your making or looking to work with us then drop us a line.</p>
                </div>
                <div>
                <?php
include('config/db.php'); // Database connection

// Handle form submission
if (isset($_POST['submit'])) {
    // Get logged-in user details (if available)
    $user_id = isset($_SESSION['user']) ? $_SESSION['user']['user_id'] : NULL;
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    // Insert the message into the database
    $sql = "INSERT INTO contact_messages (user_id, name, email, message, created_at) 
            VALUES (?, ?, ?, ?, NOW())";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "isss", $user_id, $name, $email, $message);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>showToast('Message sent successfully!', 'success');</script>";
    } else {
        echo "<script>showToast('Failed to send message. Please try again later.', 'error');</script>";
    }
}
?>
    <?php
    // Get logged-in user's name and email
    $name = isset($_SESSION['user']) ? $_SESSION['user']['username'] : '';
    $email = isset($_SESSION['user']) ? $_SESSION['user']['email'] : '';
    ?>
    <form class="mw-705 mx-auto text-center form-contact" id="contactform" action="" method="post">
        <div class="d-flex gap-15 mb_15">
            <fieldset class="w-100">
                <input type="text" name="name" id="name" required placeholder="Name *" 
                    value="<?= htmlspecialchars($name); ?>" <?= $name ? 'readonly' : ''; ?> />
            </fieldset>
            <fieldset class="w-100">
                <input type="email" name="email" id="email" required placeholder="Email *" 
                    value="<?= htmlspecialchars($email); ?>" <?= $email ? 'readonly' : ''; ?> />
            </fieldset>
        </div>
        <div class="mb_15">
            <textarea placeholder="Message" name="message" id="message" required cols="30" rows="10"></textarea>
        </div>
        <div class="send-wrap">
            <button type="submit" name="submit" class="tf-btn radius-3 btn-fill animate-hover-btn justify-content-center">Send</button>
        </div>
    </form>
                </div>
            </div>
        </section>
        <!-- /form -->
    <?php include('include/footer.php') ?>