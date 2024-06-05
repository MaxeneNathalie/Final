<?php
require('../admin/db_config.php');
require('../admin/essentials.php');

date_default_timezone_set("Asia/Manila");

if (isset($_POST['check_availability'])) {
    $frm_data = filtration($_POST);
    $status = "";
    $result = "";

    $today_date = new DateTime(date("Y-m-d"));
    $checkin_date = new DateTime($frm_data["check_in"]); // Changed parentheses to square brackets
    $checkout_date = new DateTime($frm_data["check_out"]); // Changed parentheses to square brackets

    if ($checkin_date == $checkout_date) {
        $status = 'check_in_out_equal';
        $result = json_encode(["status"=>$status]);
    } else if ($checkout_date < $checkin_date) {
        $status = 'check_out_earlier';
        $result = json_encode(["status"=>$status]);
    } else if ($checkin_date < $today_date) {
        $status = 'check_in_earlier';
        $result = json_encode(["status"=>$status]);
    } 

    if($status != '')
    {
        echo $result;
    } else
    {
        session_start(); // Ensure session is started

        // Check if room price is stored in session
        $room_price = $_SESSION['room_price'] ?? 0;
        $room_price = floatval($room_price);

        // Check if room price is retrieved successfully
        if ($room_price > 0) {
            $count_days = date_diff($checkin_date, $checkout_date)->days;
            $payment = $room_price * $count_days;

            // Update session with payment and availability information
            $_SESSION['room'] = [
                'payment' => $payment,
                'available' => true
            ];

            $result = json_encode([
                "status" => 'available',
                "days" => $count_days,
                "payment" => $payment
            ]);
        } else {
            // Handle case where room price is not available
            $result = json_encode(["status" => 'unavailable']);
        }

        echo $result;

    }
}
?>
