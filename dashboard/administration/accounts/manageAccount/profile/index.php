<?php
    $pagetitle = "Customer Accounts";
    $pagesubtitle = "Manage Profile";
    $pagetype = "Administration";

    include($_SERVER["DOCUMENT_ROOT"].'/components/CaliHeaders/Dashboard.php');
    echo '<title>' . $pagetitle . ' - ' . $pagesubtitle . '</title>';

    $accountnumber = $_GET['account_number'] ?? '';

    if (!$accountnumber) {
        header("location: /dashboard/administration/accounts");
        exit;
    }

    $accountnumberEsc = mysqli_real_escape_string($con, $accountnumber);

    // Fetch customer account info

    $customerAccountQuery = mysqli_query($con, "SELECT * FROM caliweb_users WHERE accountNumber = '$accountnumberEsc'");
    $customerAccountInfo = mysqli_fetch_array($customerAccountQuery);
    mysqli_free_result($customerAccountQuery);

    if (!$customerAccountInfo) {

        header("location: /dashboard/administration/accounts");
        exit;

    }

    // Account Specific Data Storage and Variable Declaration

    $legalname = $customerAccountInfo['legalName'];
    $customeremail = $customerAccountInfo['email'];
    $mobilenumber = $customerAccountInfo['mobileNumber'];
    $customerStatus = $customerAccountInfo['accountStatus'];
    $userrole = $customerAccountInfo['userrole'];
    $dbaccountnumber = $customerAccountInfo['accountNumber'];
    $statusreason = $customerAccountInfo['statusReason'];
    
    // Account Dates and Date Fomatting

    $regdate = $customerAccountInfo['registrationDate'];
    $regdateformatted = new DateTime($regdate);
    $regdateformattedfinal = $regdateformatted->format('F j, Y g:i A');

    $statusdate = $customerAccountInfo['statusDate'];
    $statusdateformatted = new DateTime($regdate);
    $statusdateformattedfinal = $statusdateformatted->format('F j, Y g:i A');

    $emailverifydate = $customerAccountInfo['emailVerifiedDate'];
    $emailverifydateformatted = new DateTime($regdate);
    $emailverifydateformattedfinal = $emailverifydateformatted->format('F j, Y g:i A');

    // Email Verification Status

    $emailverifystatus = ucfirst($customerAccountInfo['emailVerfied']);

    // Account Notes Section

    $notesResults = mysqli_query($con, "SELECT * FROM caliweb_accountnotes WHERE accountNumber='$accountnumber' ORDER BY id DESC");

    // Get the Interaction Dates Information for the Account Header

    $firstinteractiondate = isset($customerAccountInfo['firstInteractionDate']) ? $customerAccountInfo['firstInteractionDate'] : null;
    $lastinteractiondate = mysqli_fetch_assoc(mysqli_query($con, "SELECT lastInteractionDate FROM caliweb_users WHERE accountNumber='$accountnumber'"))['lastInteractionDate'] ?? null;

    // Business Sepecific Data Storage and Variable Declaration for the customers business

    $businessAccountQuery = mysqli_query($con, "SELECT * FROM caliweb_businesses WHERE email = '$customeremail'");
    $businessAccountInfo = mysqli_fetch_array($businessAccountQuery);
    mysqli_free_result($businessAccountQuery);

    $businessname = $businessAccountInfo['businessName'] ?? 'Not Assigned';
    $businessindustry = $businessAccountInfo['businessIndustry'] ?? 'Not Assigned';

    // Fetch website info

    $websiteAccountQuery = mysqli_query($con, "SELECT * FROM caliweb_websites WHERE email = '$customeremail'");
    $websiteAccountInfo = mysqli_fetch_array($websiteAccountQuery);
    mysqli_free_result($websiteAccountQuery);

    $websitedomain = $websiteAccountInfo['domainName'] ?? 'Not Assigned';


?>

    <section class="section first-dashboard-area-cards">
        <div class="container width-98">
            <div class="caliweb-one-grid special-caliweb-spacing">
                <?php include($_SERVER["DOCUMENT_ROOT"].'/components/CaliHeaders/Account.php'); ?>
                <div class="caliweb-two-grid special-caliweb-spacing profile-grid-modified">
                    <div>
                        <div class="caliweb-card dashboard-card">
                            <div class="card-header">
                                <div class="display-flex align-center" style="justify-content:space-between;">
                                    <div>
                                        <p class="no-padding">Account Teams</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <?php

                                    $sql = "SELECT * FROM `caliweb_teamslisting` WHERE accountNumber = '".$accountnumber."'";
                                    $result = mysqli_query($con, $sql);

                                    if (mysqli_num_rows($result) > 0) {

                                        while ($row = mysqli_fetch_assoc($result)) {

                                            echo '
                                              <div class="display-flex align-center" style="margin-top:10px; margin-bottom:10px;">
                                                  <div class="margin-10px-right icon-size-formatted">
                                                      ';
                                                      if ($row["teamIconFile"] == "teamsdefault.png") {
                                                        echo '<img src="/assets/img/teamsBranchLogos/'.$row["teamIconFile"].'" style="background-color:#a67fff;" alt="" class="client-business-andor-profile-logo" />';
                                                      } else {
                                                        echo '<img src="/assets/img/teamsBranchLogos/'.$row["teamIconFile"].'" alt="" class="client-business-andor-profile-logo" />';
                                                      }
                                                  echo '
                                                  </div>
                                                  <div>
                                                      <p class="font-14px no-padding">'.$row["teamName"].'</p>
                                                      <p class="font-14px no-padding">Team Role: '.$row["teamRole"].'</p>
                                                      <p class="font-14px no-padding">Title: '.$row["teamTitle"].'</p>
                                                  </div>
                                              </div>
                                            ';

                                        }

                                    } else {

                                        echo '<p class="no-padding font-14px" style="margin-top:-2% !important; margin-bottom:25px;">There are no teams for this profile.<p>';

                                    }
                                ?>
                            </div>
                        </div>
                        <div class="caliweb-card dashboard-card" style="margin-top:10px;">
                            <div class="card-header">
                                <div class="display-flex align-center" style="justify-content:space-between;">
                                    <div>
                                        <p class="no-padding">Events and Action Plan</p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <p class="font-14px no-padding" style="margin-top:10px; margin-bottom:10px;">No upcoming events</p>
                                <p class="font-14px no-padding" style="margin-top:10px; margin-bottom:10px;">No Past Conversations</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="caliweb-card dashboard-card">
                            <?php include($_SERVER["DOCUMENT_ROOT"].'/components/CaliMenus/Account.php'); ?>
                            <div class="caliweb-card dashboard-card">
                                <div class="card-header">
                                    <div class="display-flex align-center" style="justify-content:space-between;">
                                        <div>
                                            <p class="no-padding">Profile Details</p>
                                        </div>
                                        <div class="display-flex align-center">
                                            <a href="/dashboard/administration/accounts/modifyProfile/?account_number=<?php echo $accountnumber; ?>" class="caliweb-button secondary no-margin margin-10px-right" style="padding:6px 24px;">Edit Profile</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="caliweb-two-grid">
                                        <div>
                                            <p style="margin-bottom:10px; font-size:14px;">Legal Name: <?php echo $legalname; ?></p>
                                            <p style="margin-bottom:10px; font-size:14px;">Mobile Number: <?php echo $mobilenumber; ?></p>
                                            <p style="margin-bottom:10px; font-size:14px;">Email Address: <?php echo $customeremail; ?></p>
                                            <p style="margin-bottom:10px; font-size:14px;">Registration Date: <?php echo $regdateformattedfinal; ?></p>
                                            <p style="margin-bottom:10px; font-size:14px;">Last Status Update: <?php echo $statusdateformattedfinal; ?></p>
                                        </div>
                                        <div>
                                             <p style="margin-bottom:10px; font-size:14px;">Account Number: <?php echo $accountnumber; ?></p>
                                             <p style="margin-bottom:10px; font-size:14px;">Account Standing: <?php echo $customerStatus; ?></p>
                                             <p style="margin-bottom:10px; font-size:14px;">Email Verification Status: <?php echo $emailverifystatus; ?></p>
                                             <p style="margin-bottom:10px; font-size:14px;">Email Verified On: <?php echo $emailverifydateformattedfinal; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="caliweb-card dashboard-card">
                            <div class="card-header">
                                <div class="display-flex align-center" style="justify-content:space-between;">
                                    <div>
                                        <p class="no-padding">Notes and Activity</p>
                                    </div>
                                    <div class="display-flex align-center">
                                        <a href="/dashboard/administration/accounts/addActivityNote/?account_number=<?php echo $accountnumber; ?>" class="caliweb-button secondary no-margin margin-10px-right" style="padding:6px 24px;">Place Note</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <?php if (mysqli_num_rows($notesResults) == 0): ?>
                                    <p class="font-14px no-padding" style="margin-top:10px; margin-bottom:10px;">No notes have been made for this account.</p>
                                <?php endif; ?>
                                <?php if ($statusreason): ?>
                                    <div class="caliweb-card dashboard-card note-card">
                                        <div class="card-header">
                                            <div class="display-flex align-center">
                                                <div class="no-padding margin-20px-right icon-size-formatted" style="height: 40px; width: 40px;">
                                                    <img src="/assets/img/systemIcons/notesicon.png" alt="Notes Icon" style="background-color:#ffe6e2;" class="client-business-andor-profile-logo" />
                                                </div>
                                                <div>
                                                    <p class="no-padding font-12px"><strong>Account Status</strong></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <p class="no-padding font-12px"><?= $statusreason ?></p>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php 
                                    while ($row = mysqli_fetch_assoc($notesResults)): 
                                    $addedAtDateModify = DateTime::createFromFormat('d-m-Y h:i:sa', $row['added_at'])->format('Y-m-d H:i:s');
                                ?>
                                    <div class="caliweb-card dashboard-card note-card" style="margin-bottom:10px;">
                                        <div class="card-header">
                                            <div class="display-flex align-center">
                                                <div class="no-padding margin-20px-right icon-size-formatted" style="height: 40px; width: 40px;">
                                                    <img src="/assets/img/systemIcons/notesicon.png" alt="Notes Icon" style="background-color:#ffe6e2;" class="client-business-andor-profile-logo" />
                                                </div>
                                                <div>
                                                    <p class="no-padding font-12px"><strong>Note Added:</strong></p>
                                                    <p class="no-padding font-12px"><?= $addedAtDateModify ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <p class="no-padding font-12px"><?= $row['content'] ?></p>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php

    include($_SERVER["DOCUMENT_ROOT"].'/components/CaliFooters/Dashboard.php');

?>