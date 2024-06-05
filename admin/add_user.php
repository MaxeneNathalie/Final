<?php
require('essentials.php');
adminLogin();
session_regenerate_id(true);

function addNewUser($name, $email, $phone, $address, $pin, $dob, $password) {
    $conn = new mysqli('localhost', 'root', '', 'resortwebsite');
    if ($conn->connect_error) {
        echo "Connection failed: " . $conn->connect_error;
        die();
    }

    // Escape user inputs to prevent SQL injection
    $name = $conn->real_escape_string($name);
    $email = $conn->real_escape_string($email);
    $phone = $conn->real_escape_string($phone);
    $address = $conn->real_escape_string($address);
    $pin = $conn->real_escape_string($pin);
    $dob = $conn->real_escape_string($dob);
    $password = $conn->real_escape_string($password);

    // Your SQL query to insert a new user
    $query = "INSERT INTO `registration` (Name, Email, PhoneNumber, Address, Pin, dateOfBirth, Password) VALUES ('$name', '$email', '$phone', '$address', '$pin', '$dob', '$password')";

    // Execute query
    if ($conn->query($query) === TRUE) {
        return true;
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
        return false;
    }

    $conn->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_user'])) {
    // Handle form submission to add a new user
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $pin = $_POST['pin'];
    $dob = $_POST['dob'];
    $password = $_POST['password'];

    if (addNewUser($name, $email, $phone, $address, $pin, $dob, $password)) {
        // Redirect to users.php or display a success message
        header("Location: users.php?msg=User added successfully");
        exit();
    } else {
        // Handle adding user failure
        $error_message = "Failed to add user. Please try again.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN PANEL- EDIT USERS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Slackside+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="common.css">
    <style>
        .custom-alert{
            position: fixed;
            top: 80px;
            right: 25px;
            z-index: 1111;
        }
    </style>
</head>
<body>

<div class="container-fluid bg-dark text-light p-3 d-flex align-items-center justify-content-between sticky-top">
        <h3 class="mb-0">ADD NEW USERS</h3>
    </div>

    <form method="POST">
    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Phone Number</label>
                    <input type="tel" class="form-control" name="phone" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary" name="add_user">ADD</button>
        <a href="users.php" class="btn btn-danger">Cancel</a>
    </div>
</form>





<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
</body>
</html>