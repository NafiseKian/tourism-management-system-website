<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$connection = new mysqli("localhost","root","","TourSystemDB");

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

$query = "SELECT t.tour_id, t.city, h.hotel_name, t.price,
                    a.activity_name, a.activity_season, h.street, h.phone
          FROM tours t
          JOIN hotels h ON t.hotel_id = h.hotel_id
          JOIN activity a ON t.activity_id = a.activity_id";

$result = mysqli_query($connection, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tours</title>
    <link rel="stylesheet" href="app.css">
</head>
<body>
    <div class="container2">
        <header class="header2">

        </header>
        <main class="main">
            <br>
            <h1>Tours of North Cyprus</h1>
            <br><br>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="boxes">
                    <a href="booking.php?tour=<?php echo $row['city']; ?>">
                        <img src="pics/<?php echo $row['city']; ?>.png" />
                    </a>
                </div>
            <?php } ?>
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
                <i class="fa fa-thumbs-o-up"></i>
                <i class="fa fa-thumbs-o-down"></i>
            </div>
        </footer>
    </div>
</body>
</html>
