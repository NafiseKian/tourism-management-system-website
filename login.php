<?php
    session_start();
    if(isset($_SESSION['user_id'])){
        header('location:tours.php');
        exit();
    }
    
    if(!empty($_POST)){
        $dataBaseCon = new mysqli("localhost","root","","TourSystemDB");

        if(mysqli_connect_errno()){
            printf("Connect failed: %s\n", mysqli_connect_errno());
        }

        $username = $_POST['user'];

        $sql = "SELECT * From users WHERE username = '$username'";
        $result = mysqli_query($dataBaseCon,$sql);

        if (mysqli_affected_rows($dataBaseCon)>0){
            while($arr = mysqli_fetch_array($result,MYSQLI_ASSOC)){
                $userid = $arr['user_id'];
                $uname = $arr['name'];
                $surname = $arr['surname'];
                $password = $arr['password'];
            }

            $entered_Password = hash('sha256',$_POST['password']);

            mysqli_free_result($result);
            mysqli_close($dataBaseCon);

            if($entered_Password == $password){
                if($userid == 1){
                    $_SESSION['user_id'] = $userid;
                    $_SESSION['user_name'] = $uname;
                    $_SESSION['surName'] = $surname;
                    $_SESSION['admin'] = true;
                    header('location: admin.php');
                } elseif($userid == 2){
                    $_SESSION['user_id'] = $userid;
                    $_SESSION['user_name'] = $uname;
                    $_SESSION['surName'] = $surname;
                    $_SESSION['admin'] = false;
                    header('location: supvisor.php');
                }
                 else{
                    $_SESSION['user_id'] = $userid;
                    $_SESSION['user_name'] = $uname;
                    $_SESSION['surName'] = $surname;
                    $_SESSION['admin'] = false;
                    header('location: tours.php');
                }
            }
                else{
                    echo "<script>alert('Incorrect password. Please try again.');</script>";
                    header('Refresh: login.php');
                }
             } 
             else 
             {
                    echo "<script>alert('No such user found. Please try again.');</script>";
                    mysqli_free_result($result);
                    mysqli_close($dataBaseCon);
                    header('Refresh: login.php');
             }
        }
        

?>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>login</title>
        <link rel="stylesheet" href="app.css">
    </head>

<body>
    <div class="wrapper">

        <h1>Hello Again!</h1>
        

        <form name="form1" action="" method="POST" target="_self">
            <h1><b>Login</b></h1><br>
            <input type="text" name="user" placeholder="Enter Username" required>
           
            <input type="password" name="password" placeholder="Enter Password" required>
            
            <input type="submit" value="Login" class="inputbtn"><br><br>
        

        <div class="not-member">
            Not a member? <a href="signup.php" class="linkbtn">Register Now</a><br><br>
            <a href="index.html" class="linkbtn">Back to home</a>

        </div>
    </form>
    </div>
</body>
</html>

