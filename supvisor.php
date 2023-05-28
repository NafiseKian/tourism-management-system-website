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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $btn = $_POST['btn'];
    $bookingId = $_POST['booking'];
    $tourId = $_POST['tour'];
    $city = $_POST['city'];
    $activityName = $_POST['activity'];
    $activitySeason = $_POST['season'];
    $hotelName = $_POST['hotel'];
    $street = $_POST['street'];
    $price = $_POST['price'];
    $phone = $_POST['phone'];

    if ($btn === "Update The Ticket") {
        // Prepare the update statement for booking
        $updateBookingQuery = "UPDATE booking
         SET tour_id = ?, city = ?, activity_name = ?, activity_season = ?, hotel_name = ?, street = ?, price = ?, phone = ?
         WHERE booking_id = ?";
        $stmtBooking = $connection->prepare($updateBookingQuery);
        $stmtBooking->bind_param("issssssii", $tourId, $city, $activityName, $activitySeason, $hotelName, $street, $price, $phone, $bookingId);
        $stmtBooking->execute();

        // Redirect to the administration page after updating the information
        header('Location: supvisor.php');
        exit();

        
    }  else if ($btn === "Cancel The Ticket") {
        // Check if the booking exists
        $checkBookingQuery = "SELECT * FROM booking WHERE booking_id = ?";
        $stmt = $connection->prepare($checkBookingQuery);
        $stmt->bind_param("i", $bookingId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Booking exists, proceed with deletion
            $deleteBookingQuery = "DELETE FROM booking WHERE booking_id = ?";
            $stmt = $connection->prepare($deleteBookingQuery);
            $stmt->bind_param("i", $bookingId);
            $stmt->execute();

            // Redirect to the supervisor page after deleting the booking
            header('Location: supvisor.php');
            exit();
    }
}
}

?>

<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Supervisor </title>
    <link rel="stylesheet" href="app.css">
</head>

<body>
    <div class="wrapper">

        <h1>Supervisors</h1>
        <br>

        <form name="form2" class="form2" action="" method="POST" target="_self">
            <h2>Enter the information</h2><br>
            <label>Tour id:</label><br>
                <input type="text" name="tour" placeholder="Enter the tour id" required><br>
            <label>Booking id:</label><br>
                <input type="text" name="booking" placeholder="Enter the booking id" required><br>
            <label>City:</label><br>
                <input type="text" name="city" placeholder="Enter city name" required><br>
            <label>Activity name:</label><br>
                <input type="text" name="activity" placeholder="Enter the activity name" required><br>
            <label>Activity season:</label><br>
                <input type="text" name="season" placeholder="Enter the activity season" required><br>
            <label>Hotel name:</label><br>
                <input type="text" name="hotel" placeholder="Enter the hotel name" required><br>
            <label>Street:</label><br>
                <input type="text" name="street" placeholder="Enter the street name" required><br>
            <label>Price:</label><br>
                <input type="text" name="price" placeholder="Enter the price" required><br>
            <label>Phone:</label><br>
                <input type="text" name="phone" placeholder="Enter the phone number" required><br><br>
            
            
                <input name="btn" type="submit" id="edit" value="Update The Ticket" >
                <input name="btn" type="submit" id="delete" value="Cancel The Ticket" ></br></br>

                <div class="not-member">
                    <a href="index.html" class="linkbtn">Back to home</a>
                </div>
        </form>
    </div>
</body>
</html>