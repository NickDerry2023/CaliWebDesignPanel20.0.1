<?php
session_start();

$connectedPaymentsResult = mysqli_query($con, "SELECT * FROM caliweb_modules WHERE moduleName = 'Connected Payments'");
$connectedPaymentsInfo = mysqli_fetch_array($connectedPaymentsResult);
mysqli_free_result($connectedPaymentsResult);

$connectedPaymentsStatus = $connectedPaymentsInfo['status'];

if ($connectedPaymentsStatus != "Active" || $connectedPaymentsStatus == NULL || $connectedPaymentsStatus == "") {
    echo 'The Conencted Payments Module is not enabled on this panel install. Please enable it to allow customers to take payments on your businesses behalf.';
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $business_name = mysqli_real_escape_string($con, $_POST['business_name']);
    $business_address = mysqli_real_escape_string($con, $_POST['business_address']);
    $business_phone = mysqli_real_escape_string($con, $_POST['business_phone']);
    $business_website = mysqli_real_escape_string($con, $_POST['business_website']);
    $business_description = mysqli_real_escape_string($con, $_POST['business_description']);
    $revenue = mysqli_real_escape_string($con, $_POST['revenue']);
    $industry = mysqli_real_escape_string($con, $_POST['industry']);
    $EIN_SSN = mysqli_real_escape_string($con, $_POST['EIN_SSN']);
    $home_address = mysqli_real_escape_string($con, $_POST['home_address']);
    $full_legal_name = mysqli_real_escape_string($con, $_POST['full_legal_name']);
    $ownership_amount = mysqli_real_escape_string($con, $_POST['ownership_amount']);

    $insert_query = "INSERT INTO merchant_processing_info (user_id, business_name, business_address, business_phone, business_website, business_description, revenue, industry, EIN_SSN, home_address, full_legal_name, ownership_amount, created_at) 
                     VALUES ('$user_id', '$business_name', '$business_address', '$business_phone', '$business_website', '$business_description', '$revenue', '$industry', '$EIN_SSN', '$home_address', '$full_legal_name', '$ownership_amount', NOW())";

    if (mysqli_query($con, $insert_query)) {
        echo '';
        exit();
    } else {
        echo '<script>alert("Error: ' . mysqli_error($con) . '"); window.location.href = "/dashboard";</script>';
        exit();
    }
}

echo '<title>'.$orgshortname.' - Enable Merchant Processing</title>';
echo '<style></style>';

echo '<section class="section">
        <div class="container">
            <h3>Enable Merchant Processing</h3>
            <form method="POST" action="/enable_merchant_processing.php">
                <label>Business Name:</label><br>
                <input type="text" name="business_name" required><br><br>
                
                <label>Business Address:</label><br>
                <input type="text" name="business_address" required><br><br>
                
                <label>Business Phone:</label><br>
                <input type="tel" name="business_phone" required><br><br>
                
                <label>Business Website:</label><br>
                <input type="url" name="business_website" required><br><br>
                
                <label>Business Description:</label><br>
                <textarea name="business_description" rows="4" required></textarea><br><br>
                
                <label>Annual Revenue:</label><br>
                <input type="text" name="revenue" required><br><br>
                
                <label>Industry:</label><br>
                <input type="text" name="industry" required><br><br>
                
                <label>EIN/SSN:</label><br>
                <input type="text" name="EIN_SSN" required><br><br>
                
                <label>Home Address:</label><br>
                <input type="text" name="home_address" required><br><br>
                
                <label>Full Legal Name:</label><br>
                <input type="text" name="full_legal_name" required><br><br>
                
                <label>Ownership Amount:</label><br>
                <input type="text" name="ownership_amount" required><br><br>
                
                <button type="submit">Submit</button>
            </form>
        </div>
    </section>';

include($_SERVER["DOCUMENT_ROOT"]."/assets/php/loginFooter.php");

?>