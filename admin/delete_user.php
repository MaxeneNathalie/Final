<?php

require('essentials.php');
adminLogin();

function deleteUser($id) {
    $conn = new mysqli('localhost', 'root', '', 'resortwebsite');
    if ($conn->connect_error) {
        echo "Connection failed: " . $conn->connect_error;
        die();
    }

    $id = $conn->real_escape_string($id);

    $query = "DELETE FROM `registration` WHERE `id` = $id";

    if ($conn->query($query) === TRUE) {
        return true;
    } else {
        echo "Error deleting record: " . $conn->error;
        return false;
    }

    $conn->close();
}

if(isset($_GET['id'])) {
    $conn = new mysqli('localhost', 'root', '', 'resortwebsite');
    if ($conn->connect_error) {
        echo "Connection failed: " . $conn->connect_error;
        die();
    }

    $id = $_GET['id'];
    $query = "SELECT * FROM `registration` WHERE id = $id LIMIT 1";
    $result = $conn->query($query);
    $user = mysqli_fetch_assoc($result);
    
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $id = $_GET['id'];

    if (deleteUser($id)) {
        header("Location: users.php");
        exit();
    } else {
        // Handle delete failure
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
    <h3 class="mb-0">DELETE USERS</h3>
</div>



<form method="POST">
    <div class="modal-body">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control" name="Name" value="<?php echo $user['Name']; ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="Email" value="<?php echo $user['Email']; ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Phone Number</label>
                    <input type="tel" class="form-control" name="PhoneNumber" value="<?php echo $user['PhoneNumber']; ?>" required>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Address</label>
                    <input type="text" class="form-control" name="Address" value="<?php echo $user['Address']; ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">PIN</label>
                    <input type="number" class="form-control" name="Pin" value="<?php echo $user['Pin']; ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Date of Birth</label>
                    <input type="date" class="form-control" name="dateOfBirth" value="<?php echo $user['dateOfBirth']; ?>" required>
                </div>
            </div>
        </div>
    </div>

   

    <div class="modal-footer">
        <button type="submit" class="btn btn-danger">Delete</button>
        <a href="users.php" class="btn btn-danger">Cancel</a>
    </div>
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

</body>
</html>
