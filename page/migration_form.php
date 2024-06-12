

<?php
session_start(); // Start the session
include('connect/connection.php'); // Include the database connection file

// Retrieve registration details from registrationdetail table using MySQLi
$sql_registration = "SELECT * FROM registrationdetails";
$result_registration = $connect->query($sql_registration);

// Fetch all results as an associative array
$registration_details = [];
if ($result_registration->num_rows > 0) {
    while ($row = $result_registration->fetch_assoc()) {
        $registration_details[] = $row;
    }
}

// Retrieve registration details from URL parameters if available
$registration_no = isset($_GET['registration_no']) ? $_GET['registration_no'] : '';
$firstname = isset($_GET['firstname']) ? $_GET['firstname'] : '';
$lastname = isset($_GET['lastname']) ? $_GET['lastname'] : '';
$college_name = isset($_GET['college_name']) ? $_GET['college_name'] : '';

$errors = [];

// Check if the form has been submitted
if (isset($_POST['submit'])) {
    // Retrieve data from the form
    $firstname = $connect->real_escape_string($_POST['firstname']);
    $lastname = $connect->real_escape_string($_POST['lastname']);
    $email = $connect->real_escape_string($_POST['email']);
    $current_address = $connect->real_escape_string($_POST['current_address']);
    $TU_registration_number = $connect->real_escape_string($_POST['TU_registration_number']);
    $college_name = $connect->real_escape_string($_POST['college_name']);
    $college_roll_number = $connect->real_escape_string($_POST['college_roll_number']);
    $payment_amount = $connect->real_escape_string($_POST['payment_amount']);
    $identity_verification = isset($_POST['identity_verification']) ? implode(', ', $_POST['identity_verification']) : '';

    // Validate input fields
    if (empty($firstname)) {
        $errors['firstname'] = "First Name is required";
    }
    if (empty($lastname)) {
        $errors['lastname'] = "Last Name is required";
    }
    if (empty($email)) {
        $errors['email'] = "Email is required";
    }
    if (empty($current_address)) {
        $errors['current_address'] = "Address is required";
    }
    if (empty($TU_registration_number)) {
        $errors['TU_registration_number'] = "TU_registration_number is required";
    }
    if (empty($college_name)) {
        $errors['college_name'] = "College name is required";
    }
    if (empty($college_roll_number)) {
        $errors['college_roll_number'] = "College Roll No is required";
    }
    if (empty($payment_amount)) {
        $errors['payment_amount'] = "Payment Amount is required";
    }

    // If there are no errors, proceed with database insertion
    if (empty($errors)) {
        $sql = "INSERT INTO studentdetails (firstname, lastname, email, current_address, TU_registration_number, college_name, college_roll_number, payment_amount, identity_verification) 
                VALUES ('$firstname', '$lastname', '$email', '$current_address', '$TU_registration_number', '$college_name', '$college_roll_number', '$payment_amount', '$identity_verification')";
        
        if ($connect->query($sql) === TRUE) {
            // Data inserted successfully
            echo "Data inserted successfully.";
            header("Location: payment.php");
            exit();
        } else {
            // Error inserting data
            echo "Error: Unable to insert data. " . $connect->error;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Form</title>
    
    <link rel="stylesheet" href="../style/migration_form.css">
</head>
<body>
    <div class="container">
        <div class="box">
            <h2>Migration Certificate Application Form</h2>
            <form method="POST">
            <?php if(!empty($errors)) { ?>
                    <div class="errors bg-red-200 text-red-700 p-4 my-4">
                        <?php foreach ($errors as $error) {
                            echo $error . "<br>";
                        } ?>
                    </div>
                <?php } ?>

                <div class="input-group input-group-outline mb-3">
                    <label class="form-label">First Name</label>
                    <input type="text" class="form-control" name="firstname" id="firstname"value="<?php echo $firstname; ?>" required>
                    <?php if(isset($errors['firstname'])) { ?>
                            <p><?php echo $errors['firstname']; ?></p>
                        <?php } ?>
                </div>

                <div class="input-group input-group-outline mb-3">
                    <label class="form-label">Last Name</label>
                    <input type="text" class="form-control" name="lastname" id="lastname" value="<?php echo $lastname;?>" required>
                    <?php if(isset($errors['lastname'])) { ?>
                            <p><?php echo $errors['lastname']; ?></p>
                        <?php } ?>
                </div>
                
                <div class="input-group input-group-outline mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                    <?php if(isset($errors['email'])) { ?>
                            <p><?php echo $errors['email']; ?></p>
                        <?php } ?>
                </div>

                <div class="input-group input-group-outline mb-3">
                    <label class="form-label">Current Address</label>
                    <input type="text" class="form-control" id="current_address" name="current_address" required>
                    <?php if(isset($errors['current_address'])) { ?>
                            <p><?php echo $errors['current_address']; ?></p>
                        <?php } ?>
                </div>

                <div class="input-group input-group-outline mb-3">
                    <label class="form-label" for="TU_registration_number">TU Registration Number</label>
                    <input type="text" class="form-control" id="TU_registration_number" name="TU_registration_number" value="<?php echo $registration_no; ?>" required>
                    <?php if(isset($errors['TU_registration_number'])) { ?>
                            <p><?php echo $errors['TU_registration_number']; ?></p>
                        <?php } ?>
                </div>

                <div class="input-group input-group-outline mb-3">
                    <label class="form-label" for="college_name">College Name</label>
                    <input type="text" class="form-control" id="college_name" name="college_name" value="<?php echo $college_name; ?>" required>
                    <?php if(isset($errors['college_name'])) { ?>
                            <p><?php echo $errors['college_name']; ?></p>
                        <?php } ?>
                </div>

                <div class="input-group input-group-outline mb-3">
                    <label class="form-label" for="college_roll_number">College Roll Number</label>
                    <input type="number" class="form-control" id="college_roll_number" name="college_roll_number" required>
                    <?php if(isset($errors['college_roll_number'])) { ?>
                            <p><?php echo $errors['college_roll_number']; ?></p>
                        <?php } ?>
                </div>

                
                
                <div class="input-group input-group-outline mb-3">
                <label class="form-label" for="verification_method">Select Verification Method</label>
                    <table>
                    <tr>
                        
                        <td><input type="checkbox" id="passportCheckbox" name="identity_verification[]" value="passport" ></td>
                        <td><label class="form-check-label" for="passportCheckbox">Passport</label></td>
                    </tr>

                    <tr>
                        
                        <td><input class="form-check-input" type="checkbox" id="drivingLicenseCheckbox" name="identity_verification[]" value="driving_license"></td>
                        <td><label class="form-check-label" for="drivingLicenseCheckbox">Driving License</label></td>
                    </tr>
                    </table>
        
    
                </div>


<div class="input-group input-group-outline mb-3">
    <label class="form-label" for="file_upload">Upload Document</label>
    <input type="file" class="form-control" id="file_upload" name="file_upload">
    <?php if(isset($errors['file_upload'])) { ?>
        <p><?php echo $errors['file_upload']; ?></p>
    <?php } ?>
</div>



                <div class="input-group input-group-outline mb-3">
                    <label class="form-label" for="payment_amount">Payment Amount</label>
                    <input type="number" class="form-control" id="payment_amount" name="payment_amount" required>
                    <?php if(isset($errors['payment_amount'])) { ?>
                            <p><?php echo $errors['payment_amount']; ?></p>
                        <?php } ?>
                </div>

                <button type="submit" class="btn btn-primary" name="submit">Submit</button>
            </form>
        </div>
    </div>
</body>
</html>
