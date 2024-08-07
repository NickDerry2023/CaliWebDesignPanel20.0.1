<?php
    ob_start();

    require($_SERVER["DOCUMENT_ROOT"].'/configuration/index.php');
    
    // When form submitted, insert values into the database.

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        try {

            session_start();

            if ($_POST['langPreference']) {

                $_SESSION["lang"] = $_POST['langPreference'];
                header("location:/registration/");
                exit;

            }


            $data = array(
                'secret' => "0x1097356228F6a429882375bC5974c5a9a2631Bb3",
                'response' => $_POST['h-captcha-response']
            );

            $verify = curl_init();


            curl_setopt($verify, CURLOPT_URL, "https://hcaptcha.com/siteverify");
            curl_setopt($verify, CURLOPT_POST, true);
            curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);


            $response = curl_exec($verify);
            $responseData = json_decode($response);


            if($responseData->success) {

                $legalname = stripslashes($_REQUEST['legalname']);
                $legalname = mysqli_real_escape_string($con, $legalname);
                $caliid = stripslashes($_REQUEST['emailaddress']);
                $caliid = mysqli_real_escape_string($con, $caliid);
                $mobilenumber = stripslashes($_REQUEST['phonenumber']);
                $mobilenumber = mysqli_real_escape_string($con, $mobilenumber);
                $password = stripslashes($_REQUEST['password']);
                $password = mysqli_real_escape_string($con, $password);
                $registrationdate = date("Y-m-d H:i:s");
                $accountnumber = substr(str_shuffle("0123456789"), 0, 12);
                $dispnone = stripslashes($_REQUEST['dispnone']);
                $dispnone = mysqli_real_escape_string($con, $dispnone);

                $accountnumber_starting = $_ENV['ACCOUNTSTARTNUMBER'];
                $builtaccountnumber = $accountnumber_starting.$accountnumber;

                function generateRandomPrefix($length = 3) {

                    $characters = 'abcdefghijklmnopqrstuvwxyz';
                    $prefix = '';

                    for ($i = 0; $i < $length; $i++) {

                        $prefix .= $characters[rand(0, strlen($characters) - 1)];

                    }

                    return $prefix;

                }
                
                $randomPrefix = generateRandomPrefix(5);

                if ($dispnone == "") {

                    if (mysqli_connect_errno()) {
                        echo "Failed to connect to MySQL: " . mysqli_connect_error();
                        exit();
                    }
                
                    // Perform query

                    $result = mysqli_query($con, "SELECT * FROM caliweb_paymentconfig WHERE id = '1'");
                    $paymentgateway = mysqli_fetch_array($result);

                    // Free result set

                    mysqli_free_result($result);
                
                    $apikeysecret = $paymentgateway['secretKey'];
                    $apikeypublic = $paymentgateway['publicKey'];
                    $paymentgatewaystatus = $paymentgateway['status'];
                    $paymentProcessorName = $paymentgateway['processorName'];

                    // Checks type of payment processor.

                    if ($apikeysecret != "" && $paymentgatewaystatus == "Active" || $paymentgatewaystatus == "active") {

                        if ($paymentProcessorName == "Stripe") {

                            \Stripe\Stripe::setApiKey($apikeysecret);

                            $cu = \Stripe\Customer::create(array(
                                'name' => $legalname,
                                'email' => $caliid,
                                'phone' => $mobilenumber,
                                'description' => "Account Number: ".$builtaccountnumber, 
                            ));

                            $SS_STRIPE_ID =  $cu['id'];

                        } else {

                            header ("location: /error/genericSystemError");

                        }

                    } else {

                        header ("location: /error/genericSystemError");

                    }

                    $query    = "INSERT INTO `caliweb_users`(`email`, `password`, `legalName`, `mobileNumber`, `accountStatus`, `statusReason`, `statusDate`, `accountNotes`, `accountNumber`, `accountDBPrefix`, `emailVerfied`, `emailVerifiedDate`, `registrationDate`, `profileIMG`, `stripeID`, `discord_id`, `google_id`, `userrole`, `employeeAccessLevel`, `ownerAuthorizedEmail`, `firstInteractionDate`, `lastInteractionDate`, `lang`) VALUES ('$caliid','".hash("sha512", $password)."','$legalname','$mobilenumber','Under Review','We need more information to continuing opening an account with us.','$registrationdate','','$builtaccountnumber','$randomPrefix','false','0000-00-00 00:00:00','$registrationdate','','$SS_STRIPE_ID','','','Customer','Retail','','$registrationdate','0000-00-00 00:00:00','en-US')";
                    $result   = mysqli_query($con, $query);

                    if ($result) {

                        echo '<script type="text/javascript">window.location = "/login"</script>';

                    } else {

                        header ("location: /error/genericSystemError");

                    }

                }

            } else {

                header ("location: /error/genericSystemError");

            }

        } catch (\Throwable $exception) {
            
            \Sentry\captureException($exception);
        
        }
        
    } else {    

?>
<!-- Universal Rounded Floating Cali Web Design Header Bar start -->
<?php
    session_start();

    include($_SERVER["DOCUMENT_ROOT"]."/components/CaliHeaders/Login.php");

    ob_start();
    // ~~We cannot apply language pack here as we do not know
    // current user state.~~

    // actually yes we can
        if (isset($_SESSION["lang"])) {

            if (!file_exists($_SERVER["DOCUMENT_ROOT"].'/lang/'.$_SESSION["lang"].'.php')) {

                $_SESSION["lang"] = 'en_US';

            }
            include($_SERVER["DOCUMENT_ROOT"].'/lang/'.$_SESSION["lang"].'.php');

        } else {

            include($_SERVER["DOCUMENT_ROOT"]."/lang/en_US.php");

        }

?>
<!-- Universal Rounded Floating Cali Web Design Header Bar End -->

    <!--
        Unique Website Title Tag Start
        The Page Title specified what page the user is on in
        the browser tab and should be included for SEO
    -->
        <title><?php echo $orgshortname; ?> - Unified Portal</title>
    <!-- Unique Website Title Tag End -->

        <section class="login-container">
            <div class="container caliweb-container bigscreens-are-strange" style="width:42%; margin-top:2%;">
                <div class="caliweb-login-box-header" style="text-align:left; margin-bottom:7%;">
                    <h3 class="caliweb-login-heading"><?php echo $orgshortname; ?> <span style="font-weight:700"> <?php echo $LANG_SELF_REGISTER_TITLE; ?></h3>
                    <p style="font-size:12px; margin-top:-2%;"><?php echo $LANG_SELF_REGISTER_SUBTITLE; ?></p>
                </div>
                <div class="caliweb-login-box-body">
                    <form action="" method="POST" id="caliweb-form-plugin" class="caliweb-ix-form-login">
                        <div class="form-control" style="margin-top:-2%;">
                            <label for="legalname" class="text-gray-label"><?php echo $LANG_SELF_REGISTER_LEGAL_NAME ?></label>
                            <input type="text" class="form-input" name="legalname" id="legalname" placeholder="" required="" />
                        </div>
                        <div class="form-control" style="margin-top:-2%;">
                            <label for="phonenumber" class="text-gray-label"><?php echo $LANG_SELF_REGISTER_PHONE_NUMBER ?></label>
                            <input type="text" class="form-input" name="phonenumber" id="phonenumber" placeholder="" required="" />
                        </div>
                        <div class="form-control" style="margin-top:-2%;">
                            <label for="emailaddress" class="text-gray-label"><?php echo $LANG_SELF_REGISTER_EMAIL_ADDR ?></label>
                            <input type="email" class="form-input" name="emailaddress" id="emailaddress" placeholder="" required="" />
                        </div>
                        <div class="form-control" style="margin-top:-2%;">
                            <label for="password" class="text-gray-label"><?php echo $LANG_SELF_REGISTER_PASSWORD ?></label>
                            <input type="password" class="form-input" name="password" id="password" placeholder="" />
                        </div>
                        <div class="form-control">
                            <input type="text" class="form-input" style="display:none;" name="dispnone" id="dispnone" placeholder="" />
                        </div>
                        <div style="padding-top:2%;">
                            <div class="h-captcha" id="h-captcha" data-sitekey="509db1ec-9483-4051-aea3-8ba88d8bbc8e"></div>
                        </div>
                        <div class="mt-5-per" style="display:flex; align-items:center; justify-content:space-between;">
                            <div class="form-control width-50">
                                <p style="font-size:14px; padding:0; margin:0;"><?php echo $LANG_ID_DISCLAIMER; ?></p>
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
                        <p class="caliweb-login-footer-text">&copy; 2024 - Cali Web Design Services LLC - All rights reserved. It is illegal to copy this website.</p>
                    </div>
                    <!-- DO NOT REMOVE THE CALI WEB DESIGN COPYRIGHT TEXT -->
                    <div class="list-links-footer">
                        <a href="<?php echo $paneldomain; ?>/terms">Terms of Service</a>
                        <a href="<?php echo $paneldomain; ?>/privacy">Privacy Policy</a>
                    </div>
                </div>
            </div>
        </div>

    <?php include($_SERVER["DOCUMENT_ROOT"]."/components/CaliFooters/Login.php"); ?>

<?php

    }

?>