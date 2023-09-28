<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="login.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KUCSA Attendance</title>
</head>
<body>
    <div class="login-card">
        <div class="title">KUCSA Attendance</div>
        <form action="check_mac.php" method="post">
            <div class="input-fields">
                <label for="mac">Reg No</label>
                <input id="mac" type="text" name="regno" placeholder="Enter your Reg no">
                <label for="mac">MAC Address</label>
                <input id="mac" type="text" name="mac" placeholder="Enter your MAC address">
            </div>
            <button type="submit">Mark Attendance</button>
        </form>
    </div>
</body>
</html>
