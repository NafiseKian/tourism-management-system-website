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
    $tourId = $_POST['tour'];
    $city = $_POST['city'];
    $activityName = $_POST['activity'];
    $activitySeason = $_POST['season'];
    $hotelName = $_POST['hotel'];
    $street = $_POST['street'];
    $price = $_POST['price'];
    $phone = $_POST['phone'];

    if ($btn === "Update The Information") {
        // Prepare the update statement
        $updateQuery = "UPDATE tours t
                        JOIN hotels h ON t.hotel_id = h.hotel_id
                        JOIN activity a ON t.activity_id = a.activity_id
                        SET t.city = ?, t.price = ?,
                            h.hotel_name = ?, h.street = ?, h.phone = ?,
                            a.activity_name = ?, a.activity_season = ?
                        WHERE t.tour_id = ?";
        $stmt = $connection->prepare($updateQuery);

        // Bind the parameters
        $stmt->bind_param("sssssssi", $city, $price, $hotelName, $street, $phone, $activityName, $activitySeason, $tourId);

        // Execute the update query
        $stmt->execute();

        // Redirect to the supervisor page after updating the information
        header('Location: admin.php');
        exit();
    }
}

?>

<!-- Rest of your HTML code -->


<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Employee </title>
    <link rel="stylesheet" href="app.css">
</head>

<body>
    <div class="wrapper">

        <h1>Administration</h1>
        <br>

        <form name="form2" class="form2" action="" method="POST" target="_self">
        <h2>Enter the information</h2><br>
            <label>Tour id:</label><br>
                <input type="text" name="tour" placeholder="Enter the tour id" required><br>
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
            
            
                <input name="btn" type="submit" id="edit" value="Update The Information" ></br></br>

                <div class="not-member">
                    <a href="index.html" class="linkbtn">Back to home</a>
                </div>
        </form>
    </div>
</body>
</html>