<?php
    $pagetitle = "Client";
    $pagesubtitle = "Overview";

    include($_SERVER["DOCUMENT_ROOT"].'/assets/php/dashboardHeader.php');

    if ($userrole == "Authorized User" || $userrole == "authorized user") {
        header("location:/dashboard/customers/authorizedUserView");
    } else if ($userrole == "Partner" || $userrole == "partner") {
        header("location:/dashboard/partnerships");
    } else if ($userrole == "Administrator" || $userrole == "administrator") {
        header("location:/dashboard/administration");
    }

    $businessAccountQuery = mysqli_query($con, "SELECT * FROM caliweb_businesses WHERE email = '".$caliemail."'");
    $businessAccountInfo = mysqli_fetch_array($businessAccountQuery);
    mysqli_free_result($businessAccountQuery);

    $businessname = ($businessAccountInfo !== null) ? $businessAccountInfo['businessName'] : null;

    $accountnumber = $userinfo['accountNumber'];
    $customerStatus = $userinfo['accountStatus'];

    echo '<title>'.$pagetitle.' - '.$pagesubtitle.'</title>';
?>

        <section class="first-dashboard-area-cards">

            <section class="section caliweb-section customer-dashboard-greeting-section">
                <div class="container caliweb-container">
                    <h4 class="text-bold font-size-20 no-padding"><span id="greetingMessage"></span>, <?php echo $fullname; ?></h4>
                </div>
            </section>

            <section class="section caliweb-section customer-dashboard-section">
                <div class="container caliweb-container">
                    <div class="caliweb-two-grid" style="grid-template-columns: 1.2fr .7fr; grid-column-gap: 20px !important;">
                        <div class="accounts-overview">
                            <div class="caliweb-card dashboard-card" style="padding:0;">
                                <div class="card-header no-padding no-margin customer-card-header" style="padding:20px;">
                                    <h6 class="no-padding" style="font-size:16px; font-weight:600;">
                                        <?php echo $orgShortName.' '.$LANG_CUSTOMER_HOME_ACCOUNTS_TITLE; ?>
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <h6 class="no-padding customer-business-card-bar" style="font-size:14px; font-weight:600;">
                                        <?php
                                            if ($businessname !== null) {
                                                echo strtoupper($businessname);
                                            } else {
                                                echo strtoupper($fullname);
                                            }
                                        ?>
                                    </h6>
                                    <div class="display-flex align-center no-padding no-margin customer-account-title" style="padding:20px; justify-content:space-between;">
                                        <h6 class="no-padding no-margin" style="font-size:16px; font-weight:600;">
                                            <?php echo $orgShortName; ?> Standard (<?php echo $accountnumber; ?>)
                                        </h6>
                                        <span>
                                            <a href="/dashboard/customers/viewAccount/?account_number=<?php echo $accountnumber; ?>" class="caliweb-button secondary">View Account</a>
                                        </span>
                                    </div>
                                    <div class="caliweb-three-grid" style="padding:20px;">
                                        <div class="customer-balance">
                                            <h5 style="font-weight:600; font-size:40px;" class="no-padding no-margin">$0.00</h5>
                                            <p style="font-size:12px; padding-top:5px;" class="no-padding no-margin">Owed Balance</p>
                                        </div>
                                        <div class="customer-duedate" style="padding-top:7%">
                                            <h5 style="font-weight:700; font-size:18px;" class="no-padding no-margin">July 12, 2024</h5>
                                            <p style="font-size:12px; padding-top:5px;" class="no-padding no-margin">Due Date</p>
                                        </div>
                                        <div class="customer-duedate" style="padding-top:5.5%">
                                            <h5 style="font-weight:700; font-size:18px;" class="no-padding no-margin">
                                                <?php
                                                    if ($customerStatus == "Active" || $customerStatus == "active") {
                                                        echo "<span class='account-status-badge green' style='margin-left:0;'>Active</span>";
                                                    } else if ($customerStatus == "Suspended" || $customerStatus == "suspended") {
                                                       echo "<span class='account-status-badge red' style='margin-left:0;'>Suspended</span>";
                                                    } else if ($customerStatus == "Terminated" || $customerStatus == "terminated") {
                                                       echo "<span class='account-status-badge red-dark' style='margin-left:0;'>Terminated</span>";
                                                    } else if ($customerStatus == "Under Review" || $customerStatus == "under review") {
                                                       echo "<span class='account-status-badge yellow' style='margin-left:0;'>Under Review</span>";
                                                    } else if ($customerStatus == "Closed" || $customerStatus == "closed") {
                                                       echo "<span class='account-status-badge passive' style='margin-left:0;'>Closed</span>";
                                                    }
                                                ?>
                                            </h5>
                                            <p style="font-size:12px; padding-top:10px;" class="no-padding no-margin">Account Standing</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="quick-actions">
                            <div class="caliweb-card dashboard-card" style="padding-bottom:30px;">
                                <div class="card-body">
                                    <h4 class="text-bold no-padding" style="font-size:16px;">Quick Actions</h4>
                                    <div class="caliweb-three-grid mt-5-per customer-grid-quick-actions">
                                        <div>
                                            <img class="customer-quick-actions-img" src="/assets/img/systemIcons/website-builder.png" />
                                            <p class="text-bold no-padding no-margin font-14px">Edit Websites</p>
                                            <p class="no-padding no-margin" style="padding-top:6%; font-size:12px;">Edit your website on the fly with an easy to use drag and drop interface.</p>
                                        </div>
                                        <div>
                                            <img class="customer-quick-actions-img" src="/assets/img/systemIcons/page-speed.png" />
                                            <p class="text-bold no-padding no-margin font-14px">Run Speed Test</p>
                                            <p class="no-padding no-margin" style="padding-top:6%; font-size:12px;">Wondering how fast your site is? Run a speed test to find out.</p>
                                        </div>
                                        <div>
                                            <img class="customer-quick-actions-img" src="/assets/img/systemIcons/synchronize.png" />
                                            <p class="text-bold no-padding no-margin font-14px">Backups</p>
                                            <p class="no-padding no-margin" style="padding-top:6%; font-size:12px;">Run scheduled backups and restore backups right within your portal.</p>
                                        </div>
                                        <div>
                                            <img class="customer-quick-actions-img" src="/assets/img/systemIcons/log-file.png" />
                                            <p class="text-bold no-padding no-margin font-14px">Log Files</p>
                                            <p class="no-padding no-margin" style="padding-top:6%; font-size:12px;">View your websites logs, account logs and what your users are doing.</p>
                                        </div>
                                        <div>
                                            <img class="customer-quick-actions-img" src="/assets/img/systemIcons/integrity.png" />
                                            <p class="text-bold no-padding no-margin font-14px">Code Integrity</p>
                                            <p class="no-padding no-margin" style="padding-top:6%; font-size:12px;"><?php echo $orgShortName; ?> Code Integrity allows you to protect your website.</p>
                                        </div>
                                        <div>
                                            <img class="customer-quick-actions-img" src="/assets/img/systemIcons/monitoring.png" />
                                            <p class="text-bold no-padding no-margin font-14px">Monitoring</p>
                                            <p class="no-padding no-margin" style="padding-top:6%; font-size:12px;">Have us monitor your website for any suspicious activity.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="caliweb-card dashboard-card" style="margin-top:2%;">
                                <div class="card-body">
                                    <h4 class="text-bold no-padding" style="font-size:16px;">Plan for your next business</h4>
                                    <p class="no-margin no-padding" style="padding-top:4%; font-size:12px;">There are currently no pre-approved offers.</p>
                                </div>
                            </div>
                            <div class="caliweb-card dashboard-card" style="margin-top:2%;">
                                <div class="card-body">
                                    <h4 class="text-bold no-padding" style="font-size:16px;">Explore Documentation</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </section>

<?php

    include($_SERVER["DOCUMENT_ROOT"].'/assets/php/dashboardFooter.php');

?>