<?php 

require('../db_config.php');
require('../essentials.php');



if(isset($_POST['get_general'])){
    $q = "SELECT * FROM `setiings` WHERE `sr_no` = ?";
    $values = [1];
    $res = select($q,$values,"i");
    $data = mysqli_fetch_assoc($res);
    $json_data = json_encode($data);
    echo $json_data;
}



if(isset($_POST['upd_general'])){
    $frm_data = filtration($_POST); 

    $q = "UPDATE `setiings` SET `site_title`=?, `site_about`=? WHERE `sr_no`=?";
    $values = [$frm_data['site_title'], $frm_data['site_about'],1];
    $res = update($q,$values,'ssi');
    echo $res;
}

if(isset($_POST['upd_shutdown'])){
    $frm_data = ($_POST['upd_shutdown']==0) ? 1 : 0; 

    $q = "UPDATE `setiings` SET `shutdown`=? WHERE `sr_no`=?";
    $values = [$frm_data,1];
    $res = update($q,$values,'ii');
    echo $res;
}

if(isset($_POST['get_contacts'])){
    $q = "SELECT * FROM `contact_details` WHERE `sr_no` = ?";
    $values = [1];
    $res = select($q,$values,"i");
    $data = mysqli_fetch_assoc($res);
    $json_data = json_encode($data);
    echo $json_data;
}


if(isset($_POST['upd_contacts'])){
    $frm_data = filtration($_POST); 

    $q = "UPDATE `contact_details` SET `address`=?, `gmap`=?, `pn1`=?,`pn2`=?, `email`=?, `fb`=?, `ig`=?, `iframe`=? WHERE `sr_no`=?";
    $values = [$frm_data['address'], $frm_data['gmap'], $frm_data['pn1'], $frm_data['pn2'], $frm_data['email'], $frm_data['fb'], $frm_data['ig'], $frm_data['iframe'],1];
    $res = update($q,$values,'ssssssssi');
    echo $res;
}

if(isset($_POST['add_member'])){
    $frm_data = filtration($_POST); 

   $img_r = uploadImage($_FILES['picture'], ABOUT_FOLDER);

   if($img_r == 'inv_img')
   {
    echo $img_r;
   }
   else if($img_r == 'inv_size')
   {
    echo $img_r;
   }
   else if($img_r == 'upd_failed')
   {
    echo $img_r;
   }
   else
   {
    $q = "INSERT INTO `staff_details`(`name`, `picture`) VALUES (?,?)";
    $values = [$frm_data['name'], $img_r];
    $res = insert($q,$values, 'ss');
    echo $res;
   }
}


if(isset($_POST['get_members'])){
    $res = selectAll('staff_details');

    while($row = mysqli_fetch_assoc($res))
    {   
        $path = ABOUT_IMG_PATH;
        echo <<<data
        <div class="col-md-2 mb-3">
            <div class="card bg-dark text-white">
                <img src="$path$row[picture]" class="card-img">
                <div class="card-img-overlay text-end">
                    <button type="button" onclick="rem_member($row[sr_no])" class="btn btn-danger btn-sm shadow-none"><i class="bi bi-trash"></i></button>
                </div>
                <p class="card-text text-center px-3 py-2"><small>$row[name]</small></p>
            </div>
        </div>
    
    data;
    }

}

if(isset($_POST['rem_member'])){
    $frm_data = filtration($_POST);
    $values = [$frm_data['rem_member']];

    $pre_q = "SELECT * FROM `staff_details` WHERE `sr_no`=?";
    $res = select($pre_q,$values,'i');
    $img = mysqli_fetch_assoc($res);

    if(deleteImage($img['picture'],ABOUT_FOLDER))
    {
        $q = "DELETE FROM `staff_details` WHERE `sr_no` =?";
        $res = delete($q,$values,'i');
        echo $res;
    }
    else
    {
        echo 0;
    }
}



?>