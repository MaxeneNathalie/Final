<?php

define('SITE_URL','http://127.0.0.1/finalwebsite/');
define('ABOUT_IMG_PATH', SITE_URL.'images/about/');

define('UPLOAD_IMAGE_PATH', $_SERVER['DOCUMENT_ROOT'].'/finalwebsite/images/');
define('ABOUT_FOLDER','about/');


function selectAllUsers() {
    $conn = new mysqli('localhost', 'root', '', 'resortwebsite');
    if ($conn->connect_error) {
        echo "Connection failed: " . $conn->connect_error;
        die();
    }

    $query = "SELECT * FROM `registration`";
    $result = $conn->query($query);

    if (!$result) {
        die("Error: " . $conn->error);
    }

    return $result;
}





function adminLogin()
{
    session_start();
    if(!(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] ==true)){
     echo"<script>window.location.href='index.php'</script>";
    }
    session_regenerate_id(true);
}

function redirect($url){
   echo"
    <script>window.location.href='$url'</script>
   ";
}




function alert($type, $msg) {
    $bs_class = ($type == "success") ? "alert-success" : "alert-danger";

    echo <<<alert
    <div class="alert $bs_class alert-dismissible fade show custom-alert" role="alert">
        <strong class="me-3">$msg</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
alert;
}


function uploadImage($image, $folder)
{
    $valid_mime = ['image/jpeg', 'image/png', 'image/webp'];
    $img_mime = $image['type'];

    if (!in_array($img_mime, $valid_mime)) {
        return 'inv_img';
    } elseif (($image['size'] / (1024 * 1024)) > 2) {
        return 'inv_size';
    } else {
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
        $rname = 'IMG_' . random_int(11111, 99999) . ".$ext";

        $img_path = UPLOAD_IMAGE_PATH . $folder . $rname;

        // Create directory if it doesn't exist
        if (!file_exists(UPLOAD_IMAGE_PATH . $folder)) {
            mkdir(UPLOAD_IMAGE_PATH . $folder, 0777, true);
        }

        if (move_uploaded_file($image['tmp_name'], $img_path)) {
            return $rname;
        } else {
            return 'upd_failed';
        }
    }
}

function deleteImage($image, $folder)
{
    if(unlink(UPLOAD_IMAGE_PATH.$folder.$image))
    {
        return true;
    }
    else
    {
        return false;
    }
}

function userLogin()
{
    session_start();
    if(!(isset($_SESSION['userLogin']) && $_SESSION['userLogin'] ==true)){
     echo"<script>window.location.href='index.php'</script>";
    }
    session_regenerate_id(true);
}


?>