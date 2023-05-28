<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$connection = new mysqli("localhost", "root", "", "TourSystemDB");

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}


// Check if the form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data
    $tourId = $_POST['tour_id'];
    $city = $_POST['city'];
    $activityName = $_POST['activity_name'];
    $activitySeason = $_POST['activity_season'];
    $hotelName = $_POST['hotel_name'];
    $street = $_POST['street'];
    $price = $_POST['price'];
    $phone = $_POST['phone'];

    // Insert the data into the booking table
    $insertQuery = "INSERT INTO booking (tour_id, city, activity_name, activity_season, hotel_name, street, price, phone)
                    VALUES ('$tourId', '$city', '$activityName', '$activitySeason', '$hotelName', '$street', '$price', '$phone')";

    if (mysqli_query($connection, $insertQuery)) {
        // Retrieve the newly inserted booking record
        $bookingId = mysqli_insert_id($connection);
        $bookingQuery = "SELECT * FROM booking WHERE booking_id = $bookingId";
        $bookingResult = mysqli_query($connection, $bookingQuery);

        if (mysqli_num_rows($bookingResult) > 0) {
            $bookingData = mysqli_fetch_assoc($bookingResult);

            // Display the booking information
            echo '<!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <title>Booking Confirmation</title>
                    <link rel="stylesheet" href="app.css">
                </head>
                <body>
                    <div class="containerr">
                        <div class="main">
                            <div class="wrapper">
                                <h2>Booking Confirmation</h2><br>
                                <div class="booking-info">
                                    <ol>
                                        <li><strong>Booking ID:</strong> ' . $bookingData['booking_id'] . '</li>
                                        <li><strong>Your City:</strong> ' . $bookingData['city'] . '</li>
                                        <li><strong>Activity Name:</strong> ' . $bookingData['activity_name'] . '</li>
                                        <li><strong>Activity Season:</strong> ' . $bookingData['activity_season'] . '</li>
                                        <li><strong>Hotel Name:</strong> ' . $bookingData['hotel_name'] . '</li>
                                        <li><strong>Street:</strong> ' . $bookingData['street'] . '</li>
                                        <li><strong>Total Price:</strong> ' . $bookingData['price'] . '$</li>
                                        <li><strong>Current Date:</strong> ' . $bookingData['booking_date'] . '</li>
                                    </ol>
                                </div>
                                <br>Your booking has been confirmed. <br>
                                Thank you for choosing our tour system! <br>
                                <button onclick="window.location.href=\'tours.php\'">Back to Tours</button>
                            </div>
                        </div>
                        <footer class="footer">
                <div>
                    Did you find our website helpful?
                </div>
                <div class="social">
                    <i class="fa fa-th umbs-o-up"></i>
                <i class="fa fa-thumbs-o-down"></i>
                </div>
            </footer>
                    </div>
                </body>
                </html>';
        } else {
            echo "Error: Unable to retrieve booking information.";
        }
    } else {
        echo "Error: " . mysqli_error($connection);
    }

    mysqli_close($connection);
}
?>
