<?php
// Start session
session_start();

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

// Function to fetch event details
function getEvents($conn) {
    $sql = "SELECT * FROM event_planning";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        return $result->fetch_all(MYSQLI_ASSOC);
    } else {
        return [];
    }
}

// Fetch events
$events = getEvents($conn);

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Planning</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
         body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, rgba(255,0,0,0.3) 0%, rgba(255,154,0,0.3) 17%, rgba(208,222,33,0.3) 33%, rgba(79,220,74,0.3) 50%, rgba(63,218,216,0.3) 67%, rgba(47,201,226,0.3) 83%, rgba(28,127,238,0.3) 100%);
            background-size: 200% 200%;
            animation: gradientAnimation 15s ease infinite;
        }
        
        @keyframes gradientAnimation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        li strong {
            color: #555;
        }

        p.no-events {
            color: #999;
            font-style: italic;
        }

        /* CSS for navigation bar links */
        .navbar {
    background: linear-gradient(to right, #87CEEB, #4682B4); /* Sky blue gradient */
    overflow: hidden;
            display: flex;
            justify-content: flex-end; /* Align links to the right */
        }

        .navbar a {
            display: block;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }
        .card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-top: 20px;
        }

        .card {
            width: 23%;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .card h3 {
            color: #333;
        }

        .card p {
            color: #666;
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
<div class="navbar">
        <a class="nav-link" href="welcome.php"><i class="fas fa-home"></i> Home</a> 
        <a class="nav-link" href="loan.php"><i class="fas fa-money-bill"></i> Loan</a>
        <a class="nav-link" href="transactions.php"><i class="fas fa-history"></i> Transactions</a>
        <a class="nav-link" href="savings.php"><i class="fas fa-piggy-bank"></i> Savings</a>
        <a class="nav-link" href="events.php"><i class="far fa-calendar-alt"></i> Events</a>
        <a class="nav-link" href="support.php"><i class="fas fa-question-circle"></i> Support</a>
        <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <div class="container">
        <h2>Upcoming Events</h2>
        <?php if (!empty($events)) : ?>
            <ul>
                <?php foreach ($events as $event) : ?>
                    <li>
                        <strong>Title:</strong> <?php echo $event['title']; ?><br>
                        <strong>Description:</strong> <?php echo $event['description']; ?><br>
                        <strong>Date:</strong> <?php echo $event['date']; ?><br>
                        <strong>Location:</strong> <?php echo $event['location']; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else : ?>
            <p class="no-events">No events found.</p>
        <?php endif; ?>
    </div>
    <div class="content mt-4">
        <p class="lead">As a Chama group, we take pride in offering innovative products and services tailored to meet the diverse needs of our valued members. As you journey towards achieving your dreams, we understand the importance of having reliable partners by your side. That's why we're here to walk alongside you every step of the way. Membership is open to all, including individuals, micro and small businesses, corporations, institutions, and other groups. Whether you're an established Chama or just starting out, we're committed to providing you with the very best in banking and investment services. Join us today and experience the difference of banking with a partner who truly understands your aspirations and is dedicated to helping you realize them.</p>
    </div>
    <h2 class="our-services-heading">OUR SERVICES</h2>
    <div class="card-container">
        <div class="card">
            <img src="asset/picc1.webp" alt="Safe & Secure">
            <h3>Safe & Secure</h3>
            <p>Your Chama’s information is securely stored in our servers. We also ensure your information is only visible to authorized users.</p>
        </div>
        <div class="card">
            <img src="asset/picc2.webp" alt="Accurate & Reliable">
            <h3>Accurate & Reliable</h3>
            <p>Our platform has an uptime of 99.9%, your Chama’s data can be accessed anytime. We also guarantee you 100% accuracy on all reports.</p>
        </div>
        <div class="card">
            <img src="asset/picc3.webp" alt="Dedicated Support">
            <h3>Dedicated Support</h3>
            <p>Your Chama benefits from our dedicated support team. We are ready to support your members through our support channels.</p>
        </div>
        <div class="card">
        <img src="asset/credit1.jpg" alt="Credit Services">
            <h3>Credit Services</h3>
            <p>Our Credit offering ranges from a wide range of products which include:- Development Loan, Emergency Loan, Crop Advance Loans, Salary Advances, Mortgage Loans, Asset Financing, Micro-Finance Loans. These loans are offered on reducing balance with no hidden charges.</p>
        </div>
        <div class="card mb-4">
          <img src="asset/banking-2.jpg" alt="Other Services">
            <h5>Other Services</h5>
            <p>In addition to Savings and Credit, we offer the following services:- Insurance Agency, Investment Wings, Agency Services & Inua Jamii Payments, Mobile Banking Services, ATM - Visa Branded Sacco Link Cards, Benevolent Fund Scheme, Bankers and Ordinary Cheques, and many more.</p>
          </>
    </div>
    <div class="card mb-4">
    <img src="asset/save.jpg" class="card-img-top" alt="Savings Services">
            <h5 class="card-heading">Savings Services</h5>
            <p>We offer Savings Services through Personal Accounts, Institution and Business Accounts. Other Accounts are: - Chamas and Joint Accounts, Children Account, Holiday Savings Account and All Farm Produce (Tea, Coffee, Milk, Rice, Horticulture e.t.c) Accounts, Investment Accounts</p>
          </div>
</div>
     <!-- Footer -->
     <div class="footer">
        <p>Email: info@bingwagroup.coop | Contact Us: 0706295324</p>
        <p>&copy; 2024 Bingwa Group. All rights reserved.</p>
    </div>

</body>
</html>
