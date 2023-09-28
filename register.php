<?php 
session_start();
include 'connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="register.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <div class="register-card">
        <div class="title"><u>KUCSA REGISTRATION</u></div>
        <div class="input-fields">
            <form action="" method="POST">
                <label for="name">Name</label>
                <input id="name" type="text" name="namee" placeholder="enter your name" required>

                <label for="regno">Email</label>
                <input id="email" type="email" name="email" placeholder="enter your email" required>
                
                <label for="regno">Reg No</label>
                <input id="regno" type="text" name="regno" placeholder="enter your Reg No" required>
                
                <label for="phone">Phone</label>
                <input id="phone" type="number" name="phone" placeholder="enter your phone no" required>
                
                <label for="mac">MAC</label>
                <input id="mac" type="text" name="mac" placeholder="enter your MAC address" required>

                <input type="hidden" name="status" value="1">
                
                <div class="button"><button type="submit" name="register">Register</button></div>
            </form>
        </div>
    </div>
</body>
</html>

<?php 
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//take form data and use prepared statements
if($_SERVER['REQUEST_METHOD'] === 'POST'){
if(isset($_POST['register'])){
    $name = $_POST['namee'];
    $email = $_POST['email'];
    $regno = $_POST['regno'];
    $phone = $_POST['phone'];
    $mac = $_POST['mac'];
    $status = $_POST['status'];

    //check if user is allready registered
    $get_data = "SELECT * FROM user WHERE regno='$regno' OR email='$email' OR phone='$phone' OR device_id='$mac';";
    $result = mysqli_query($conn,$get_data);
    if($result->num_rows>0){
        echo "<p class='error'>You are already registered! please contact the admin</p>";
    }else{

    //prepared_statements
    $sql = "INSERT INTO user(namee,email,regno,phone,device_id,attendance_status) VALUES(?,?,?,?,?,?);";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssss", $name,$email,$regno,$phone,$mac,$status);

    //execute prepared stements
    if(mysqli_stmt_execute($stmt)){
        echo 'User registered successfully';
    }else{
        echo "failed to upload data";
    }

    //close prepared statements and database connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
}
}
?>