<?php
    $pagetitle = "Customer Accounts";
    $pagesubtitle = "List";

    unset($_SESSION['verification_code']);

    include($_SERVER["DOCUMENT_ROOT"].'/assets/php/dashboardHeader.php');

    if ($userrole == "Customer" || $userrole == "customer") {
        header("location:/dashboard/customers");
    } else if ($userrole == "Authorized User" || $userrole == "authorized user") {
        header("location:/dashboard/customers/authorizedUserView");
    } else if ($userrole == "Partner" || $userrole == "partner") {
        header("location:/dashboard/partnerships");
    }

    echo '<title>'.$pagetitle.' - '.$pagesubtitle.'</title>';
?>

    <section class="section first-dashboard-area-cards">
        <div class="container width-98">
            <div class="caliweb-one-grid special-caliweb-spacing">
                <div class="caliweb-card dashboard-card">
                    <div class="card-header">
                         <div class="display-flex align-center">
                            <div class="no-padding margin-10px-right icon-size-formatted">
                                <img src="/assets/img/systemIcons/accountsicon.png" alt="Client Logo and/or Business Logo" style="background-color:#f5e6fe;" class="client-business-andor-profile-logo" />
                            </div>
                            <div>
                                <p class="no-padding font-14px">Accounts</p>
                                <h4 class="text-bold font-size-20 no-padding" style="padding-bottom:0px; padding-top:5px;">List Accounts</h4>
                            </div>
                         </div>
                    </div>
                    <div class="card-body">
                        <div class="dashboard-table">
                            <table style="width:100%;">
                                <?php
                                    // Fetch data from MySQL table
                                    $sql = "SELECT * FROM caliweb_users WHERE userrole <> 'administrator'";
                                    $result = mysqli_query($con, $sql);

                                    // Check if any rows were returned
                                    if (mysqli_num_rows($result) > 0) {
                                        // Output table header
                                        echo '<table style="width:100%;">
                                                <tr>
                                                    <th style="width:20%;">Company/Account Number</th>
                                                    <th style="width:20%;">Owner</th>
                                                    <th style="width:20%;">Phone</th>
                                                    <th style="width:20%;">Type</th>
                                                    <th style="width:10%;">Status</th>
                                                    <th>Actions</th>
                                                </tr>';

                                        // Output table rows
                                        while ($row = mysqli_fetch_assoc($result)) {

                                            echo '<tr>';

                                                $accountStatusColorAssignment = $row['accountStatus'];

                                                if ($accountStatusColorAssignment == "Active" || $accountStatusColorAssignment == "active") {

                                                    echo '<td style="width:20%;">';

                                                        $businessAccountQuery = mysqli_query($con, "SELECT * FROM caliweb_businesses WHERE id = '" . $row['id'] . "'");
                                                        $businessAccountInfo = mysqli_fetch_array($businessAccountQuery);
                                                        mysqli_free_result($businessAccountQuery);

                                                        $businessname = ($businessAccountInfo !== null) ? $businessAccountInfo['businessName'] : null;

                                                        if ($businessname !== null) {
                                                            echo $businessname . ' - ' . $row['accountNumber'];
                                                        } else {
                                                            echo $row['legalName'] . ' - ' . $row['accountNumber'];
                                                        }

                                                    echo '</td>';
                                                    echo '<td style="width:20%;">' . $row['legalName'] . '</td>';
                                                    echo '<td style="width:20%;">' . $row['mobileNumber'] . '</td>';
                                                    if ($row["userrole"] == "customer" || $row["userrole"] == "Customer") {
                                                        echo '<td style="width:20%;">Customer - Direct</td>';
                                                    } else if ($row["userrole"] == "partner" || $row["userrole"] == "Partner") {
                                                        echo '<td style="width:20%;">Partner - Affiliate</td>';
                                                    } else {
                                                        echo '<td style="width:20%;">Unknown</td>';
                                                    }
                                                    echo '<td style="width:10%;"><span class="account-status-badge green" style="margin-left:0;">'.$row['accountStatus'].'</span></td>';
                                                    echo '<td>
                                                              <a href="/dashboard/administration/verification/customerVerification/?account_number='.$row['accountNumber'].'" class="caliweb-button secondary no-margin margin-10px-right" style="padding:6px 24px; margin-right:10px;">View</a><a href="/dashboard/administration/accounts/deleteAccount/?account_number='.$row['accountNumber'].'" class="caliweb-button secondary no-margin margin-10px-right" style="padding:6px 24px; margin-right:10px;">Delete</a><a href="/dashboard/administration/accounts/editAccount/?account_number='.$row['accountNumber'].'" class="caliweb-button secondary no-margin margin-10px-right" style="padding:6px 24px;">Edit</a>
                                                          </td>
                                                    ';

                                                } else if ($accountStatusColorAssignment == "Suspended" || $accountStatusColorAssignment == "suspended") {

                                                    echo '<td style="width:20%;">';

                                                       $businessAccountQuery = mysqli_query($con, "SELECT * FROM caliweb_businesses WHERE id = '" . $row['id'] . "'");
                                                       $businessAccountInfo = mysqli_fetch_array($businessAccountQuery);
                                                       mysqli_free_result($businessAccountQuery);

                                                       $businessname = ($businessAccountInfo !== null) ? $businessAccountInfo['businessName'] : null;

                                                       if ($businessname !== null) {
                                                           echo $businessname . ' - ' . $row['accountNumber'];
                                                       } else {
                                                           echo $row['legalName'] . ' - ' . $row['accountNumber'];
                                                       }

                                                   echo '</td>';
                                                   echo '<td style="width:20%;">' . $row['legalName'] . '</td>';
                                                   echo '<td style="width:20%;">' . $row['mobileNumber'] . '</td>';
                                                   if ($row["userrole"] == "customer" || $row["userrole"] == "Customer") {
                                                       echo '<td style="width:20%;">Customer - Direct</td>';
                                                   } else if ($row["userrole"] == "partner" || $row["userrole"] == "Partner") {
                                                       echo '<td style="width:20%;">Partner - Affiliate</td>';
                                                   } else {
                                                       echo '<td style="width:20%;">Unknown</td>';
                                                   }
                                                   echo '<td style="width:10%;"><span class="account-status-badge red" style="margin-left:0;">'.$row['accountStatus'].'</span></td>';
                                                   echo '<td class="">
                                                             <a href="/dashboard/administration/verification/customerVerification/?account_number='.$row['accountNumber'].'" class="caliweb-button secondary no-margin margin-10px-right" style="padding:6px 24px; margin-right:10px;">View</a><a href="/dashboard/administration/accounts/deleteAccount/?account_number='.$row['accountNumber'].'" class="caliweb-button secondary no-margin margin-10px-right" style="padding:6px 24px; margin-right:10px;">Delete</a><a href="/dashboard/administration/accounts/editAccount/?account_number='.$row['accountNumber'].'" class="caliweb-button secondary no-margin margin-10px-right" style="padding:6px 24px;">Edit</a>
                                                         </td>
                                                   ';

                                                } else if ($accountStatusColorAssignment == "Terminated" || $accountStatusColorAssignment == "terminated") {

                                                    echo '<td style="width:20%;">';

                                                       $businessAccountQuery = mysqli_query($con, "SELECT * FROM caliweb_businesses WHERE id = '" . $row['id'] . "'");
                                                       $businessAccountInfo = mysqli_fetch_array($businessAccountQuery);
                                                       mysqli_free_result($businessAccountQuery);

                                                       $businessname = ($businessAccountInfo !== null) ? $businessAccountInfo['businessName'] : null;

                                                       if ($businessname !== null) {
                                                           echo $businessname . ' - ' . $row['accountNumber'];
                                                       } else {
                                                           echo $row['legalName'] . ' - ' . $row['accountNumber'];
                                                       }

                                                   echo '</td>';
                                                   echo '<td style="width:20%;">' . $row['legalName'] . '</td>';
                                                   echo '<td style="width:20%;">' . $row['mobileNumber'] . '</td>';
                                                   if ($row["userrole"] == "customer" || $row["userrole"] == "Customer") {
                                                       echo '<td style="width:20%;">Customer - Direct</td>';
                                                   } else if ($row["userrole"] == "partner" || $row["userrole"] == "Partner") {
                                                       echo '<td style="width:20%;">Partner - Affiliate</td>';
                                                   } else {
                                                       echo '<td style="width:20%;">Unknown</td>';
                                                   }
                                                   echo '<td style="width:10%;"><span class="account-status-badge red-dark" style="margin-left:0;">'.$row['accountStatus'].'</span></td>';
                                                   echo '<td class="">
                                                             <a href="/dashboard/administration/verification/customerVerification/?account_number='.$row['accountNumber'].'" class="caliweb-button secondary no-margin margin-10px-right" style="padding:6px 24px; margin-right:10px;">View</a><a href="/dashboard/administration/accounts/deleteAccount/?account_number='.$row['accountNumber'].'" class="caliweb-button secondary no-margin margin-10px-right" style="padding:6px 24px; margin-right:10px;">Delete</a><a href="/dashboard/administration/accounts/editAccount/?account_number='.$row['accountNumber'].'" class="caliweb-button secondary no-margin margin-10px-right" style="padding:6px 24px;">Edit</a>
                                                         </td>
                                                   ';

                                                } else if ($accountStatusColorAssignment == "Under Review" || $accountStatusColorAssignment == "under review") {

                                                   echo '<td style="width:20%;">';

                                                       $businessAccountQuery = mysqli_query($con, "SELECT * FROM caliweb_businesses WHERE id = '" . $row['id'] . "'");
                                                       $businessAccountInfo = mysqli_fetch_array($businessAccountQuery);
                                                       mysqli_free_result($businessAccountQuery);

                                                       $businessname = ($businessAccountInfo !== null) ? $businessAccountInfo['businessName'] : null;

                                                       if ($businessname !== null) {
                                                           echo $businessname . ' - ' . $row['accountNumber'];
                                                       } else {
                                                           echo $row['legalName'] . ' - ' . $row['accountNumber'];
                                                       }

                                                   echo '</td>';
                                                   echo '<td style="width:20%;">' . $row['legalName'] . '</td>';
                                                   echo '<td style="width:20%;">' . $row['mobileNumber'] . '</td>';
                                                   if ($row["userrole"] == "customer" || $row["userrole"] == "Customer") {
                                                       echo '<td style="width:20%;">Customer - Direct</td>';
                                                   } else if ($row["userrole"] == "partner" || $row["userrole"] == "Partner") {
                                                       echo '<td style="width:20%;">Partner - Affiliate</td>';
                                                   } else {
                                                       echo '<td style="width:20%;">Unknown</td>';
                                                   }
                                                   echo '<td style="width:10%;"><span class="account-status-badge yellow" style="margin-left:0;">'.$row['accountStatus'].'</span></td>';
                                                   echo '<td class="">
                                                              <a href="/dashboard/administration/verification/customerVerification/?account_number='.$row['accountNumber'].'" class="caliweb-button secondary no-margin margin-10px-right" style="padding:6px 24px; margin-right:10px;">View</a><a href="/dashboard/administration/accounts/deleteAccount/?account_number='.$row['accountNumber'].'" class="caliweb-button secondary no-margin margin-10px-right" style="padding:6px 24px; margin-right:10px;">Delete</a><a href="/dashboard/administration/accounts/editAccount/?account_number='.$row['accountNumber'].'" class="caliweb-button secondary no-margin margin-10px-right" style="padding:6px 24px;">Edit</a>
                                                          </td>
                                                   ';
                                                } else if ($accountStatusColorAssignment == "Closed" || $accountStatusColorAssignment == "closed") {

                                                     echo '<td style="width:20%;">';

                                                         $businessAccountQuery = mysqli_query($con, "SELECT * FROM caliweb_businesses WHERE id = '" . $row['id'] . "'");
                                                         $businessAccountInfo = mysqli_fetch_array($businessAccountQuery);
                                                         mysqli_free_result($businessAccountQuery);

                                                         $businessname = ($businessAccountInfo !== null) ? $businessAccountInfo['businessName'] : null;

                                                         if ($businessname !== null) {
                                                             echo $businessname . ' - ' . $row['accountNumber'];
                                                         } else {
                                                             echo $row['legalName'] . ' - ' . $row['accountNumber'];
                                                         }

                                                     echo '</td>';
                                                     echo '<td style="width:20%;">' . $row['legalName'] . '</td>';
                                                     echo '<td style="width:20%;">' . $row['mobileNumber'] . '</td>';
                                                     if ($row["userrole"] == "customer" || $row["userrole"] == "Customer") {
                                                         echo '<td style="width:20%;">Customer - Direct</td>';
                                                     } else if ($row["userrole"] == "partner" || $row["userrole"] == "Partner") {
                                                         echo '<td style="width:20%;">Partner - Affiliate</td>';
                                                     } else {
                                                         echo '<td style="width:20%;">Unknown</td>';
                                                     }
                                                     echo '<td style="width:10%;"><span class="account-status-badge passive" style="margin-left:0;">'.$row['accountStatus'].'</span></td>';
                                                     echo '<td class="">
                                                                <a href="/dashboard/administration/verification/customerVerification/?account_number='.$row['accountNumber'].'" class="caliweb-button secondary no-margin margin-10px-right" style="padding:6px 24px; margin-right:10px;">View</a><a href="/dashboard/administration/accounts/deleteAccount/?account_number='.$row['accountNumber'].'" class="caliweb-button secondary no-margin margin-10px-right" style="padding:6px 24px; margin-right:10px;">Delete</a><a href="/dashboard/administration/accounts/editAccount/?account_number='.$row['accountNumber'].'" class="caliweb-button secondary no-margin margin-10px-right" style="padding:6px 24px;">Edit</a>
                                                            </td>
                                                     ';
                                                }

                                            echo '</tr>';

                                        }

                                        echo '</table>'; // Close the table
                                    }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php

    include($_SERVER["DOCUMENT_ROOT"].'/assets/php/dashboardFooter.php');

?>