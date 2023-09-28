<?php
session_start();
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection details
include "connection.php";
// Create a connection

// MAC address exists, execute the Python script
$command = "python check_connection.py";
$output = shell_exec($command);

// Get the MAC address and regno from the form
$macAddress = $_POST['mac'];
$regno = $_POST['regno'];

//get originally registered mac address

$get_data = "SELECT * from user WHERE device_id='$macAddress'";
$query_exe = $conn->query($get_data);

$get_regno = "SELECT * FROM user WHERE regno='$regno'";
$regno_result = $conn->query($get_regno);

$check_mac= "SELECT * FROM mac_test WHERE mac = $macAddress";
$mac_result = $conn->query($check_mac);

if($mac_result->num_rows > 0){
    $_SESSION['already_marked'] = "You have already Marked attendance!";
    header("location: login.php");
}else{
    if($regno_result->num_rows > 0){

        if($query_exe->num_rows > 0){
        // Query to check if the MAC address exists in the database of connected devices
        $sql = "SELECT * FROM mac_test WHERE mac = '$macAddress'";
        $result = $conn->query($sql);
            
            
        if ($result->num_rows > 0) {
            // MAC address exists, execute the Python script
            $command = "python check_connection.py";
            $output = shell_exec($command);

            // Process the output if needed
           // header('location: login.php');
           $_SESSION['marked_success'] = "Attendance marked successfully!";
            header("location: login.php");
        } else {
            // MAC address does not exist
            $_SESSION['not_connected'] = "Please connect to the Host WIFI !";
            header("location: login.php");
        }

        // Close the database connection
        $conn->close();
        }else{
            $_SESSION['use_original_mac'] = "use your original MAC address to mark attendance";
            header("location: login.php");
        }
}else{
    $_SESSION['not_registered'] = "Reg No is not registred! Contact Admin ";
    header("location: login.php");
}

}

?>
