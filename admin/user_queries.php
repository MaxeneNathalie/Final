<?php
require('essentials.php');
adminLogin();
session_regenerate_id(true);

// Function to fetch all users from the database
function fetchAllUsers() {
    $conn = new mysqli('localhost', 'root', '', 'resortwebsite');
    if ($conn->connect_error) {
        echo "Connection failed: " . $conn->connect_error;
        die();
    }

    $query = "SELECT * FROM `user_queries`";
    $result = $conn->query($query);

    if (!$result) {
        die("Error: " . $conn->error);
    }

    return $result;
}

// Function to display user data in a table
function displayUsersQTable() {
    $users = fetchAllUsers();

    echo '<table class="table table-hover border text-center" style="min-width: 1300px">';
    echo '<thead>';
    echo '<tr class="bg-dark text-light">';
    echo '<th scope="col">#</th>';
    echo '<th scope="col">Name</th>';
    echo '<th scope="col">Email</th>';
    echo '<th scope="col">Subject</th>';
    echo '<th scope="col">Message</th>';
    echo '<th scope="col">Date</th>';
    echo '<th scope="col">Action</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    while ($row = $users->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row['id'] . '</td>';
        echo '<td>' . $row['name'] . '</td>';
        echo '<td>' . $row['email'] . '</td>';
        echo '<td>' . $row['subject'] . '</td>';
        echo '<td>' . $row['message'] . '</td>';
        echo '<td>' . $row['date'] . '</td>';
        echo '<td>';
        echo '<div class="d-inline">';
        echo '<form method="POST" class="d-inline">';
        echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
        echo '<button type="submit" class="btn btn-danger btn-sm" name="delete"><i class="bi bi-trash"></i></button>';
        echo '</form>';
        echo '</div>';
        echo '</td>';
        echo '</tr>';
        
    }

    echo '</tbody>';
    echo '</table>';
    
}

function deleteUser($id) {
    $conn = new mysqli('localhost', 'root', '', 'resortwebsite');
    if ($conn->connect_error) {
        echo "Connection failed: " . $conn->connect_error;
        die();
    }

    $id = $conn->real_escape_string($id);

    $query = "DELETE FROM `user_queries` WHERE `id` = $id";

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
    $query = "SELECT * FROM `user_queries` WHERE id = $id LIMIT 1";
    $result = $conn->query($query);
    $user = mysqli_fetch_assoc($result);
    
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    if(isset($_POST['id'])) {
        $id = $_POST['id'];
        if (deleteUser($id)) {
            header("Location: user_queries.php");
            exit();
        } else {
            // Handle delete failure
        }
    } else {
        // Handle case where ID is not set
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - User Queries</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Slackside+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="common.css">
    <style>
        #dashboard-menu{
            position: fixed;
            height: 100%;
        }
        @media screen and (max-width: 992px){
            #dashboard-menu{
                height: auto;
                width: 100%;
                z-index: 11;
            }
            #main-content{
                margin-top: 60px;
            }
        }
    </style>
</head>
<body class = "bg-light">

<div class="container-fluid bg-dark text-light p-3 d-flex align-items-center justify-content-between sticky-top">
        <h3 class="mb-0">NAGCARLAN FOREST RESORT</h3>
        <a href="logout.php"  class="btn btn-light btn-sm">LOG OUT</a>
    </div>

    <div class="col-lg-2 bg-dark border-top border-3 border-secondary" id="dashboard-menu">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid flex-lg-column align-items-stretch">
                <h4 class="mt-2 text-light">ADMIN PANEL</h4>
                <button class="navbar-toggler shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#adminDropdown" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse flex-column align-items-stretch" id="adminDropdown">
                <ul class="nav nav-pills flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="#">Rooms</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="user_queries.php">User Queries</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="users.php">Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white" href="settings.php">Settings</a>
                    </li>
                </ul>

                </div>
          </div>
        </nav>
    </div>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">USER QUERIES</h3>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <?php displayUsersQTable(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
</body>
</html>