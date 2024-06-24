<?php
    session_start();

    require($_SERVER["DOCUMENT_ROOT"].'/configuration/index.php');

    // When form submitted, check and create user session.

    if (isset($_SESSION['caliid'])) {
        header("Location: /dashboard");
        exit;
    }

    if (isset($_POST['emailaddress'])) {

        $cali_id = stripslashes($_REQUEST['emailaddress']);
        $cali_id = mysqli_real_escape_string($con, $cali_id);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con, $password);

        // Check user is exist in the database
        $query    = "SELECT * FROM `caliweb_users` WHERE `email` = '$cali_id' AND `password` = '".md5($password)."'";
        $result = mysqli_query($con, $query) or die(mysql_error());
        $rows = mysqli_num_rows($result);
        if ($rows == 1) {

            $_SESSION['caliid'] = $cali_id;

            header("Location: /dashboard");

        } else {
            header("Location /error/genericSystemError");
        }
    } else {
?>
<!-- Universal Rounded Floating Cali Web Design Header Bar start -->
<?php
    session_start();

    include($_SERVER["DOCUMENT_ROOT"]."/assets/php/loginHeader.php");

    ob_start();

    include($_SERVER["DOCUMENT_ROOT"]."/lang/en_US.php");
?>
<!-- Universal Rounded Floating Cali Web Design Header Bar End -->

    <!--
        Unique Website Title Tag Start
        The Page Title specified what page the user is on in
        the browser tab and should be included for SEO
    -->
        <title><?php echo $orgshortname; ?> - Unfied Portal</title>
    <!-- Unique Website Title Tag End -->

        <section class="login-container">
            <div class="container caliweb-container" style="width:42%; margin-top:4%;">
                <div class="caliweb-login-box-header mb-5-per" style="text-align:left;">
                    <h3 class="caliweb-login-heading"><?php echo $orgshortname; ?> <span style="font-weight:700">Self Registration</span></h3>
                    <p style="font-size:12px; margin-top:-2%;">Welcome! We are excited to have you. Please fill out a few questions to setup your account with us.</p>
                </div>
                <div class="caliweb-login-box-body">
                    <form action="" method="POST" id="caliweb-form-plugin" class="caliweb-ix-form-login">
                        <div class="form-control">
                            <label for="legalname" class="text-gray-label">Legal Name</label>
                            <input type="text" class="form-input" name="legalname" id="legalname" placeholder="" required="" />
                        </div>
                        <div class="form-control">
                            <label for="phonenumber" class="text-gray-label">Phone Number</label>
                            <input type="text" class="form-input" name="phonenumber" id="phonenumber" placeholder="" required="" />
                        </div>
                        <div class="form-control">
                            <label for="emailaddress" class="text-gray-label">Email Address</label>
                            <input type="email" class="form-input" name="emailaddress" id="emailaddress" placeholder="" required="" />
                        </div>
                        <div class="form-control">
                            <label for="password" class="text-gray-label">Password</label>
                            <input type="password" class="form-input" name="password" id="password" placeholder="" />
                        </div>
                        <div class="mt-10-per" style="display:flex; align-items:center; justify-content:space-between;">
                            <div class="form-control width-50">
                                <p style="font-size:14px; padding:0; margin:0;">We're required by law to ask your name, address, date of birth and other information to help us identify you. We may require additional verification if we cant verify you using public record.</p>
                            </div>
                            <div class="form-control width-25">
                                <button class="caliweb-button primary" style="text-align:left; display:flex; align-center; justify-content:space-between;" type="submit" name="submit"><?php echo $LANG_LOGIN_BUTTON; ?><span class="lnr lnr-arrow-right" style=""></span></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <div class="caliweb-login-footer">
            <div class="container caliweb-container">
                <div class="caliweb-grid-2">
                    <!-- DO NOT REMOVE THE CALI WEB DESIGN COPYRIGHT TEXT -->
                    <!--
                        THIS TEXT IS TO GIVE CREDIT TO THE AUTHORS AND REMOVING IT
                        MAY CAUSE YOUR LICENSE TO BE REVOKED.
                    -->
                    <div class="">
                        <p class="caliweb-login-footer-text">&copy; 2024 - Cali Web Design Corporation - All rights reserved. It is illegal to copy this website.</p>
                    </div>
                    <!-- DO NOT REMOVE THE CALI WEB DESIGN COPYRIGHT TEXT -->
                    <div class="list-links-footer">
                        <a href="<?php echo $paneldomain; ?>/terms">Terms of Service</a>
                        <a href="<?php echo $paneldomain; ?>/privacy">Privacy Policy</a>
                    </div>
                </div>
            </div>
        </div>
    <?php include($_SERVER["DOCUMENT_ROOT"]."/assets/php/loginFooter.php"); ?>
<?php
    }
?>