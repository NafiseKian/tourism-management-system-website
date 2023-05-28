<?php

    $connection = new mysqli("localhost","root","","TourSystemDB");

    if(mysqli_connect_errno()){
        printf("Connect failed: %s \n",mysqli_connect_error());
    }
    if (isset($_POST['btn'])){

        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $phonenumber = $_POST['phone'];
        $address = $_POST['location'];

    
        $sqlusername = "SELECT * FROM users WHERE username='$username'";
        $sqlemail = "SELECT * FROM users WHERE email='$email'";
        $sqlphonenum = "SELECT * FROM users WHERE phonenum='$phonenumber'";
 

        $resUsername = mysqli_query($connection,$sqlusername);
        $resEmail = mysqli_query($connection,$sqlemail);
        $resPhonenum = mysqli_query($connection,$sqlphonenum);

        if (mysqli_num_rows($resUsername)>0)
            echo "<script>alert('The Username is already taken, Please choose a different username.');</script>";
        else if (mysqli_num_rows($resEmail)>0)
            echo "<script>alert('The Email is already used, Please choose a different email.');</script>";
        else if (mysqli_num_rows($resPhonenum)>0)
            echo "<script>alert('The Phone number is already used, Please choose a different phone number.');</script>";
        else{

        $name = $_POST['name'];
        $surname = $_POST['surname'];
        $password = $_POST['password'];
        $address = $_POST['location'];

        $enteredPassword = hash('sha256', $password);

        $sql = "INSERT INTO users(name,surname,username,email,phonenum,address,password) VALUES('$name','$surname',
            '$username','$email','$phonenumber','$address','$enteredPassword')";
        
        $result = mysqli_query($connection,$sql);

        if ($result == TRUE)
       { 
        header("location:login.php");
            echo "<script>alert('your signup complete now, please login');</script>";}
        else 
            echo "<script>alert('something went wrong! try to signup again');</script>";
        }

        while($newArray = mysqli_fetch_array($resUsername,MYSQLI_ASSOC))
            {
                $passWord = $newArray['password']; 
            }
        if($enteredPassword == $passWord)
            header("location: tours.php");
}
?>

<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Signup </title>
    <link rel="stylesheet" href="app.css">
</head>

<body>
    <div class="wrapper">

        <h1>Welcome new user!</h1>
        <br>

        <form name="form2" class="form2" action="" method="POST" target="_self">
            <h2>Signup</h2><br>
            <label>Name</label><br>
                <input type="text" name="name" placeholder="Enter your name" required><br>
            <label>Surname</label>
                <input type="text" name="surname" placeholder="Enter your surname" required><br>
            <label>Username</label>
                <input type="text" name="username" placeholder="Enter your username" required><br>
            <label>Email</label><br>
                <input type="text" name="email" placeholder="Enter your email" required><br>
            <label>Password</label>
                <input type="password" name="password" placeholder="Enter your password" required><br>
            <label>Phone Number</label>
                <input type="text" name="phone" placeholder="Enter your phone number" required><br>
            <label>Location</label>
                <input type="text" name="location" placeholder="Enter your location" required><br><br/>
            
                <input name="btn" type="submit" id="signup" value="Sign Up"></br></br>

                <div class="not-member">
                    Already a member? <a href="login.php" class="linkbtn">Login</a><br><br>
                    <a href="index.html" class="linkbtn">Back to home</a>
                </div>
        </form>
    </div>
</body>
</html>