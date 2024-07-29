<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session only if it is not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database connection
$servername = "localhost";
$username = "chama";
$password = "@chama";
$database = "chama";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user data from the database (assuming you have a 'Members' table)
$email = isset($_SESSION["email"]) ? $_SESSION["email"] : ""; // Fetch email from session
$sql = "SELECT * FROM Members WHERE Email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION["firstname"] = $row["FirstName"];
    $_SESSION["lastname"] = $row["LastName"];
    $_SESSION["email"] = $row["Email"];
    $_SESSION["phone"] = $row["Phone"];
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Body styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2; /* Set a light background color */
            padding-top: 60px; /* Adjust padding for fixed navbar */
            overflow-x: hidden; /* Prevent horizontal scroll */
        }
        
        /* Navbar styles */
        .navbar {
            min-height: 40px; /* Adjust the height of the navigation bar */
            background: linear-gradient(90deg, rgba(135,206,235,1) 0%, rgba(70,130,180,1) 100%); /* Sky blue gradient */
        }
        .navbar-brand {
            font-size: 1.5rem; /* Adjust the font size of the brand */
        }
        
        /* Main container styles */
        .main-container {
            max-width: 100%; /* Use full width of the screen */
            margin: 0 auto; /* Center the container horizontally */
        }
        
        /* Header container styles */
        .header-container {
            background-image: url('asset/logo6.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            color: red; /* Set text color to red */
            text-align: center;
            padding: 100px 20px; /* Add padding for spacing */
            margin-bottom: 20px; /* Add margin bottom for separation */
            border-radius: 10px; /* Add border radius */
            position: relative;
            width: 100%; /* Full width */
        }
        .header-container h2 {
            font-size: 2rem; /* Adjust font size */
            font-weight: bold; /* Make font bold */
        }
        
        /* Card styles */
        .card-img-top {
            width: 100px; /* Set your desired width */
            height: auto; /* Maintain aspect ratio */
            display: block;
            margin: 0 auto; /* Center the image */
        }
        .card {
            max-width: 25rem; /* Set a maximum width for the cards */
            margin: 0 auto 10px; /* Center the cards and reduce bottom margin */
        }
        
        /* Card container styles */
        .card-container {
            background-color: rgba(0, 0, 0, 0.5); /* Dark overlay */
            padding: 20px;
            color: white;
            text-align: center;
            height: 300px; /* Increase container height */
            margin-bottom: 20px; /* Add margin bottom for separation */
            border-radius: 10px; /* Add border radius */
        }
        
        /* Content styles */
        .content {
            margin-top: 20px; /* Add margin top for separation */
        }
        .lead {
            font-size: 1.1rem; /* Increase font size of lead paragraphs */
        }
        
        /* Paragraph container styles */
        .paragraph-container {
            background-color: #fff; /* Set background color */
            border-radius: 10px; /* Add border radius */
            padding: 20px; /* Add padding */
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); /* Add box shadow */
            max-width: 100%; /* Use full width of the screen */
            margin: 0 auto; /* Center the container horizontally */
        }
        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }
        .our-services-heading {
            font-size: 4rem;
            color: green;
            text-align: center;
            margin-top: 40px;
        }
        .footer {
            background-color: black;
            color: white;
            padding: 20px 0;
            text-align: center;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top">
    <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-nav ml-auto"> <!-- Moved to the far right -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="welcome.php"><i class="fas fa-home"></i> Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="loan.php"><i class="fas fa-dollar-sign"></i> Loan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="transactions.php"><i class="fas fa-exchange-alt"></i> Transactions</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="savings.php"><i class="fas fa-piggy-bank"></i> Savings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="events.php"><i class="fas fa-calendar-alt"></i> Events</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="support.php"><i class="fas fa-life-ring"></i> Support</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

    <div class="main-container">
        <div class="header-container">
            <h2><?php echo isset($_SESSION["firstname"]) ? htmlspecialchars($_SESSION["firstname"]) : "User"; ?>, Welcome to your saving account. Together, let's build a brighter financial future for you and your community.</h2>
        </div>
    </div>
    <div class="content mt-4">
        <div class="container paragraph-container">
            <p class="lead">As a Chama group, we take pride in offering innovative products and services tailored to meet the diverse needs of our valued members. As you journey towards achieving your dreams, we understand the importance of having reliable partners by your side. That's why we're here to walk alongside you every step of the way. Membership is open to all, including individuals, micro and small businesses, corporations, institutions, and other groups. Whether you're an established Chama or just starting out, we're committed to providing you with the very best in banking and investment services. Join us today and experience the difference of banking with a partner who truly understands your aspirations and is dedicated to helping you realize them.</p>
        </div>
        <h2 class="our-services-heading">OUR SERVICES</h2>
        <!-- Cards for Chama group information -->
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card">
                    <img src="asset/picc1.webp" class="card-img-top" alt="Safe & Secure">
                    <div class="card-body">
                        <h5 class="card-title">Safe & Secure</h5>
                        <p class="card-text">Your Chama’s information is securely stored in our servers. We also ensure your information is only visible to authorized users.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="asset/picc2.webp" class="card-img-top" alt="Accurate & Reliable">
                    <div class="card-body">
                        <h5 class="card-title">Accurate & Reliable</h5>
                        <p class="card-text">Our platform has an uptime of 99.9%, your Chama’s data can be accessed anytime. We also guarantee you 100% accuracy on all reports.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="asset/picc3.webp" class="card-img-top" alt="Dedicated Support">
                    <div class="card-body">
                        <h5 class="card-title">Dedicated Support</h5>
                        <p class="card-text">Your Chama benefits from our dedicated support team. We are ready to support your members through our support channels.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
      <!-- Footer -->
      <div class="footer">
        <p>Email: info@bingwagroup.coop | Contact Us: 0706295324</p>
        <p>&copy; 2024 Bingwa Group. All rights reserved.</p>
    </div>

</body>
</html>
