<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            background-image: url(./assets/img/roads.jpg);
            height: 100%;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .about-us-section {
            background-color: #333; /* Dark background color */
            color: #fff; /* Text color */
            padding: 30px 0; /* Reduced padding */
        }

        .container {
            width: 80%;
            margin: 0 auto;
            text-align: center;
        }

        .about-us-section h2 {
            font-size: 30px; /* Reduced font size */
            margin-bottom: 20px;
        }

        .about-us-section p {
            font-size: 16px; /* Reduced font size */
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .team {
            margin-top: 30px; /* Reduced margin top */
        }

        .team h3 {
            font-size: 24px; /* Reduced font size */
            margin-bottom: 20px; /* Reduced margin bottom */
        }

        .team-member {
            display: inline-block;
            width: 200px;
            margin: 0 20px;
            text-align: center;
        }

        .team-member img {
            width: 100%;
            border-radius: 50%;
        }

        .team-member h4 {
            font-size: 20px; /* Reduced font size */
            margin: 10px 0 5px 0;
        }

        .team-member p {
            font-size: 16px; /* Reduced font size */
            color: #aaa; /* Lighter text color */
        }

        /* Footer styling */
        footer {
            background-color: rgba(255, 255, 255, 0.8); /* Transparent white background */
            color: #333;
            padding: 20px 0; /* Medium padding for a medium footer */
            text-align: center;
            width: 100%;
        }

        footer .container {
            display: flex;
            width: 100%;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        footer .container div {
            margin: 10px;
        }

        footer .quick-links, footer .contact-info, footer .social-media {
            flex: 1;
            min-width: 150px;
        }

        footer .quick-links ul, footer .contact-info ul, footer .social-media ul {
            list-style: none;
            padding: 0;
        }

        footer .quick-links li, footer .contact-info li, footer .social-media li {
            margin-bottom: 10px;
        }

        footer a {
            color: #333;
            text-decoration: none;
        }

        footer a:hover {
            color: #000;
        }

        footer .social-media img {
            margin: 0 5px;
            width: 24px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <section id="" class="d-flex align-items-center">
        <div class="container">
            <div style="margin-top: 200px;">
                <h1>Welcome!!</h1>
            </div>
            <div>
                <h3 style="color: black; font-weight: bold;">Online Highway<br> Bus Reservation</h3>
                <?php if(!isset($_SESSION['login_id'])): ?>
                    <button class="btn btn-danger btn-lg" type="button" id="book_now" style="margin-top: 20px;">Reserve Your Tickets Now</button>
                <?php else: ?>
                    <center><br><br><br><h2 class="highlight2">Welcome, </h2></center>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="about-us-section">
        <div class="container">
            <h2>About Us</h2>
            <p>Welcome to SLTB, the forefront of online highway bus management. Our platform revolutionizes the way you travel by offering seamless, efficient, and reliable bus reservations. With a deep understanding of the transportation industry's needs, we aim to provide exceptional service to all our customers.</p>
            <p>Our mission is to ensure safe, timely, and comfortable journeys for all passengers. We leverage cutting-edge technology to offer real-time bus schedules, seat availability, and easy booking processes. Our dedicated team works tirelessly to maintain the highest standards of safety and customer satisfaction.</p>
            <p>At SLTB, we believe in transparency, efficiency, and excellence. Our commitment to innovation and quality service makes us the preferred choice for highway travel. Thank you for choosing SLTB, where your journey is our priority. We look forward to serving you and making your travel experience unparalleled.</p>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="quick-links">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
            <div class="contact-info">
                <h4>Contact Us</h4>
                <ul>
                    <li>Email: info@sltb.com</li>
                    <li>Phone: +9471 456 7890</li>
                    <li>Address: 123 Main St, Kohuwala, Nugegoda</li>
                </ul>
            </div>
            <div class="social-media">
                <h4>Follow Us</h4>
                <ul>
                    <li><a href="#"><img src="https://image.shutterstock.com/image-vector/facebook-icon-260nw-1040637334.jpg" alt="Facebook"></a></li>
                    <li><a href="#"><img src="https://image.shutterstock.com/image-vector/instagram-icon-260nw-1040637333.jpg" alt="Instagram"></a></li>
                    <li><a href="#"><img src="https://image.shutterstock.com/image-vector/twitter-icon-260nw-1040637332.jpg" alt="Twitter"></a></li>
                </ul>
            </div>
        </div>
    </footer>

    <script>
        $('#book_now').click(function(){
            uni_modal('Find Schedule','book_filter.php');
        })
    </script>
</body>
</html>