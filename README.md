# Highway-Bus-Reservation 🎫
A full-featured ticket and seat reservation system for passengers and administrators. This web-based application allows users to view schedules, book seats, receive payment confirmations, and manage reservations with ease.

## 🌟 Project Overview
This project offers a seamless ticket booking experience, suitable for unregistered and registered passengers, along with admin capabilities for managing reservations and bus schedules.

## Key Features  
Passenger Capabilities:

View available bus schedules.  
Book and reserve seats based on real-time availability.  
Receive payment confirmations and reservation details via email.  
Cancel bookings as needed.  
Access and view booking history.  
Admin Capabilities:  

Manage reservations and oversee the booking process.  
Add, edit, or remove bus listings and schedules.  
Track bookings and monitor system usage to improve customer service.    
## 💻 Tech Stack  
Frontend: HTML, CSS, JavaScript, Bootstrap  
Backend: PHP  
Database: MySQL  
Email Notifications: SendinBlue API for automated reservation and payment confirmations.  
Payments: Stripe integration for secure payment processing.  
🚀 Getting Started  
To get a local copy of the project up and running, follow these steps.  

Prerequisites  
PHP >= 7.4  
MySQL (phpMyAdmin)  
Stripe account for payment processing  
SendinBlue account for email services  

## Installation
1.Clone the Repository:  
git clone https://github.com/your-username/your-repo-name.git  
cd your-repo-name

2.Setup Database:    
Import the SQL file (provided in the repository) into phpMyAdmin to set up the database tables.
Configure database settings in the PHP files, such as db_connection.php.

3.Configure Stripe and SendinBlue:  
Add your Stripe API keys to the relevant PHP files for payment processing.
Add your SendinBlue API key to enable email notifications for bookings.

4.Run the Project:  
Start a local PHP server:
php -S localhost:8000
Open http://localhost:8000 in your browser to access the application.

## 🛠 Usage  
Booking a Ticket  
Register or log in as a passenger.  
View available schedules and select your preferred seat(s).  
Complete the booking and make a payment using Stripe.  
Receive an email confirmation with your reservation details.  

Admin Management
Log in as an admin to access the admin dashboard.
Manage schedules, buses, and reservations from the dashboard.
Track and oversee all reservations.

## ⚖ License  
This project is licensed under the MIT License. See the LICENSE file for more details.


