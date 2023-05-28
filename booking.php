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

// Check if the tour ID is provided in the URL
if (isset($_GET['tour'])) {
    $city = $_GET['tour'];

    // Prepare the query with a parameterized statement to avoid SQL injection
    $query = "SELECT t.tour_id, t.city, h.hotel_name, t.price,
                     a.activity_name, a.activity_season, h.street, h.phone
              FROM tours t
              JOIN hotels h ON t.hotel_id = h.hotel_id
              JOIN activity a ON t.activity_id = a.activity_id
              WHERE t.city = ?";

    $stmt = $connection->prepare($query);
        // Bind the parameter
        $stmt->bind_param("s", $city);

        // Execute the query
        $stmt->execute();
    
        // Get the result
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
    } else {
        // Redirect if the tour ID is not provided
        header('Location: tours.php');
        exit();
    }
    
    ?>
    
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Booking</title>
        <link rel="stylesheet" href="app.css">
    </head>
    <body>
        <div class="container3">
        <main class="main">
    <h1>Tour Details</h1>
    <form name="form1" action="conf.php" method="POST">
        <div class="boxes">
            <img src="pics/<?php echo $row['city']; ?>.png" />
        </div>
        <div class="textBox">
            <ul>
                <li>Tour ID: <?php echo $row['tour_id']; ?></li>
                <li>City: <?php echo $row['city']; ?></li>
                <li>Activity Name: <?php echo $row['activity_name']; ?></li>
                <li>Activity Season: <?php echo $row['activity_season']; ?></li>
                <li>Hotel Name: <?php echo $row['hotel_name']; ?></li>
                <li>Street: <?php echo $row['street']; ?></li>
                <li>Price: <?php echo $row['price']; ?></li>
                <li>Phone: <?php echo $row['phone']; ?></li>
            </ul>
        </div>
        <input type="hidden" name="tour_id" value="<?php echo $row['tour_id']; ?>">
        <input type="hidden" name="city" value="<?php echo $row['city']; ?>">
        <input type="hidden" name="activity_name" value="<?php echo $row['activity_name']; ?>">
        <input type="hidden" name="activity_season" value="<?php echo $row['activity_season']; ?>">
        <input type="hidden" name="hotel_name" value="<?php echo $row['hotel_name']; ?>">
        <input type="hidden" name="street" value="<?php echo $row['street']; ?>">
        <input type="hidden" name="price" value="<?php echo $row['price']; ?>">
        <input type="hidden" name="phone" value="<?php echo $row['phone']; ?>">
        <button type="submit">Book</button>
      </form>
    </main>

            <nav class="nav">
                <ul>
                    <li><a href="index.html"><i class="fa fa-home"></i> Home</a></li>
                    <li><a href="tours.php"><i class="fa fa-calendar"></i> Tours</a></li>
                    <li><a href="#"><i class="fa fa-image"></i> Gallery</a></li>
                    <li><a href="logout.php"><i class="fa fa-user"></i> Log in</a></li>
                </ul>
            </nav>
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
</html>

    
   
