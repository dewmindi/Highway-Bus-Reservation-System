<?php 
session_start();

require 'vendor/autoload.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


use SendinBlue\Client\Configuration;
use SendinBlue\Client\Api\TransactionalEmailsApi;
use SendinBlue\Client\Model\SendSmtpEmail;

include 'db_connect.php';
extract($_POST);

date_default_timezone_set('Asia/Kolkata');

$booked_placed_at = date('Y-m-d H:i:s');

$selected_seats = isset($_POST['selected_seats']) ? explode(',', $_POST['selected_seats']) : [];

if(isset($_SESSION['username'])){
$username = $_SESSION['username'];
$get_email_query = "SELECT email FROM passengers WHERE username = '$username'";
$result = $conn->query($get_email_query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $booking_email = $row['email'];
} else {
    // Handle case where email is not found (this should ideally not occur if username is valid)
    $booking_email = ''; // Set default or handle error
}
     $data = ' schedule_id = '.$sid.' ';
     $data .= ', name = "'.$name.'" ';
     $data .= ', qty ="'.$qty.'" ';
     $data .= ', booked_for ="'.$booked_for.'" '; 
     $data .= ', email = "'.$email.'" ';
     $data .= ', nic = "'.$nic.'" ';
     $data .= ', bus_number = "'.$bus_number.'" ';
     $data .= ', from_location = "'.$from_location.'" ';
     $data .= ', to_location = "'.$to_location.'" ';
     $data .= ', booking_username = "'.$_SESSION['username'].'" '; // Add logged-in username
     $data .= ', booking_email = "'.$booking_email.'" '; // Add fetched booking email
     $data .= ', booked_placed_at = "'.$booked_placed_at.'" ';
    //  $data .= ", total_price = '$total_price' ";
    } else {
        $data = ' schedule_id = '.$sid.' ';
        $data .= ', name = "'.$name.'" ';
        $data .= ', qty ="'.$qty.'" ';
        $data .= ', booked_for ="'.$booked_for.'" '; 
        $data .= ', email = "'.$email.'" ';
        $data .= ', nic = "'.$nic.'" ';
        $data .= ', bus_number = "'.$bus_number.'" ';
        $data .= ', from_location = "'.$from_location.'" ';
        $data .= ', to_location = "'.$to_location.'" ';
        $data .= ', booking_username = NULL '; // Set to NULL for guest user
        $data .= ', booking_email = NULL '; // Set to NULL for guest user
        $data .= ', booked_placed_at = "'.$booked_placed_at.'" '; // Add booked_placed_at date
        // $data .= ", total_price = '$total_price' ";
    }
if(!empty($bid)){
	$data .= ', status ="'.$status.'" ';
	$update = $conn->query("UPDATE booked set ".$data." where id =".$bid);
	if($update){
		echo json_encode(array('status'=> 1));
	}
	exit;
}
$i = 1;
$ref = '';
while($i == 1){
	$ref = date('Ymd').mt_rand(1,9999);
	$data .= ', ref_no = "'.$ref.'" ';
	$chk = $conn->query("SELECT * FROM booked where ref_no=".$ref)->num_rows;
	if($chk <=0)
		$i = 0;
}

// echo "INSERT INTO booked set ".$data;
	$insert = $conn->query("INSERT INTO booked set ".$data);

    // foreach ($selected_seats as $seat_id) {
    //     $update_seat = $conn->prepare("UPDATE SFH7777 SET availability = 0 WHERE seat_id = ? AND schedule_id = ?");
    //     $update_seat->bind_param("ii", $seat_id, $sid);
    //     $update_seat->execute();
    // }

    $bus_table = $bus_number; // This assumes the bus table name is the bus number

    foreach ($selected_seats as $seat_id) {
        $update_seat = $conn->prepare("UPDATE $bus_table SET availability = 0 WHERE seat_id = ? AND schedule_id = ?");
        $update_seat->bind_param("ii", $seat_id, $sid);
        $update_seat->execute();
    }

	if($insert){

    $seat_numbers = implode(', ', $selected_seats);
		    // Sendinblue email sending

    // Set your Sendinblue API key here
    $apiKey = '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'; // Replace with your actual Sendinblue API key

    // Configure API key authorization: api-key
    $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', $apiKey);

    $apiInstance = new TransactionalEmailsApi(
        new GuzzleHttp\Client(),
        $config
    );

    // Prepare email content
    $email = new SendSmtpEmail([
        'subject' => 'Booking Confirmation',
        'sender' => ['name' => 'SLTB', 'email' => 'sltb@gmail.com'], // Replace with your sender info
        'to' => [['email' => $email, 'name' => $name]], // Recipient info
        'htmlContent' => '<html><body><h1>Booking Confirmation</h1>
		<div style="display:flex"> 
        <p>Your booking reference number is:</p>
        <p style="font-weight: bold">'.$ref.'</p>
        </div>
        <div style="display:flex"> 
        <p>Passenger Name: </p>
        <p style="font-weight: bold">'.$name.'</p>
        </div>
        <div style="display:flex"> 
        <p>Reserved No of Seats: </p>
        <p style="font-weight: bold">'.$qty.'</p>
        </div>
        <div style="display:flex"> 
        <p>Seat Numbers: </p>
        <p style="font-weight: bold">'.$seat_numbers.'</p>
        </div>
        </body></html>',
        'textContent' => 'Booking Confirmation - Your booking reference number is '.$ref
    ]);

    try {
        $result = $apiInstance->sendTransacEmail($email);
        echo json_encode(array('status'=> 1,'ref'=>$ref, 'email_status' => 'Email sent successfully'));
    } catch (Exception $e) {
        echo json_encode(array('status'=> 1,'ref'=>$ref, 'email_status' => 'Email sending failed: ' . $e->getMessage()));
    }
}
?>
