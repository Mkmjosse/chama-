<?php
// Database connection
$servername = "localhost";
$username = "chama";
$password = "@chama";
$dbname = "chama";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if request_id parameter is set
if(isset($_GET['request_id'])) {
    $requestId = $_GET['request_id'];

    // Update the status of the loan request to "Granted"
    $sql = "UPDATE loan_requests SET Status = 'Granted' WHERE RequestId = '$requestId'";
    if ($conn->query($sql) === TRUE) {
        echo "Loan request granted successfully!";
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    echo "Request ID parameter is missing.";
}

// Closing the database connection
$conn->close();
?>