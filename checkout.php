<?php

require __DIR__ . "/vendor/autoload.php";

$stripe_secret_key = "sk_test_51PrbnDHldRTyegyZgr0GnaF4bjds0EeHd7bRwlNJrK1jKEpX49VGUKn0t33B3rPWbBUi6LhjoQHCQdv2xgg4qYiu00Fgry8nr1";

\Stripe\Stripe::setApiKey($stripe_secret_key);

// Retrieve booking_id and total_price from URL parameters
//$booking_id = isset($_GET['booking_id']) ? $_GET['booking_id'] : null;
$total_price = isset($_GET['total_price']) ? floatval($_GET['total_price']) : 0;

// Convert total_price to the smallest currency unit (e.g., cents for USD)
$unit_amount = intval($total_price * 100);


// Create a Stripe Checkout session
$checkout_session = \Stripe\Checkout\Session::create([
    "mode" => "payment",
    "success_url" => "http://localhost/Highway-Bus-Reservation/payment.php",
    "cancel_url" => "http://localhost/Highway-Bus-Reservation/index.php",
    "locale" => "auto",
    "line_items" => [
        [
            "quantity" => 1,
            "price_data" => [
                "currency" => "lkr",
                "unit_amount" => $unit_amount,
                "product_data" => [
                    "name" => "Payment Details"
                ]
            ]
        ]
    ]
]);

echo "Checkout Session URL: " . htmlspecialchars($checkout_session->url) . "<br>";
http_response_code(303);
header("Location: " . $checkout_session->url);