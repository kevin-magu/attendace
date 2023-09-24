<?php
// Database connection details
$host = "localhost";
$username = "root";
$password = "root";
$database = "attendance";

// Create a connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the MAC address from the form
$macAddress = $_POST['mac'];

// Query to check if the MAC address exists in the database
$sql = "SELECT * FROM mac_test WHERE mac = '$macAddress'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // MAC address exists, execute the Python script
    $command = "python check_connection.py";
    $output = shell_exec($command);
    
    // Process the output if needed
    echo "Attendance marked successfully!";
} else {
    // MAC address does not exist
    echo "Invalid MAC address.";
}

// Close the database connection
$conn->close();
?>
