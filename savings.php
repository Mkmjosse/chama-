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

// Function to fetch member ID
function getMemberId($conn) {
    if(isset($_SESSION['email'])){
        $email = $_SESSION['email'];
        $sql = "SELECT MemberId FROM members WHERE Email = '$email'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['MemberId'];
        }
    }
    return null;
}

// Function to retrieve savings transactions where type is savings
function getSavingsTransactions($conn, $memberId, $title) {
    $sql = "SELECT * FROM transactions WHERE MemberId = '$memberId' AND Type = 'Savings'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        echo "<h2>$title</h2>";
        echo "<div class='table-container'>";
        echo "<table border='1'>
                <tr>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Type</th>
                    <th>Payment Method</th>
                </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["TransactionDate"] . "</td>
                    <td>" . $row["Amount"] . "</td>
                    <td>" . $row["Type"] . "</td>
                    <td>" . $row["PaymentMethod"] . "</td>
                  </tr>";
        }
        echo "</table>";
        echo "</div>";
    } else {
        echo "<p>No savings available.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Account Savings</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* CSS styles for the page */
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

        .navbar {
            background: linear-gradient(to right, #87CEEB, #4682B4); /* Sky blue gradient */
            overflow: hidden;
            text-align: right; /* Align links to the right */
        }

        .navbar a {
            display: inline-block; /* Display links as blocks */
            color: #f2f2f2;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }

        .container-fluid {
            background-image: url('asset/save.jpg'); /* Background image */
            background-size: cover;
            background-position: center;
            height: 400px;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
        
        /* Add your custom styles here */
        .footer {
            background-color: black;
            color: white;
            padding: 20px 0;
            text-align: center;
        }

        /* Table styles */
        .table-container {
            overflow-x: auto; /* Enable horizontal scrolling */
        }

        table {
            width: 100%; /* Make the table take full width */
            border-collapse: collapse; /* Remove space between table cells */
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

    </style>
</head>
<body>
    <!-- Navigation bar -->
    <div class="navbar">
        <a class="nav-link" href="welcome.php"><i class="fas fa-home"></i> Home</a> 
        <a class="nav-link" href="loan.php"><i class="fas fa-money-bill"></i> Loan</a>
        <a class="nav-link" href="transactions.php"><i class="fas fa-history"></i> Transactions</a>
        <a class="nav-link" href="savings.php"><i class="fas fa-piggy-bank"></i> Savings</a>
        <a class="nav-link" href="events.php"><i class="far fa-calendar-alt"></i> Events</a>
        <a class="nav-link" href="support.php"><i class="fas fa-question-circle"></i> Support</a>
        <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <!-- Rest of the content -->
    <div class="container">
        <?php
        // Get member ID
        $memberId = getMemberId($conn);

        if ($memberId) {
            // Display member's savings transactions where type is savings
            getSavingsTransactions($conn, $memberId, "Your Account Savings");
        } else {
            echo "<p>Error: Member ID not found.</p>";
        }
        ?>
    </div>
    <div class="content mt-4">
        <p class="lead">As a Chama group, we take pride in offering innovative products and services tailored to meet the diverse needs of our valued members. As you journey towards achieving your dreams, we understand the importance of having reliable partners by your side. That's why we're here to walk alongside you every step of the way. Membership is open to all, including individuals, micro and small businesses, corporations, institutions, and other groups. Whether you're an established Chama or just starting out, we're committed to providing you with the very best in banking and investment services. Join us today and experience the difference of banking with a partner who truly understands your aspirations and is dedicated to helping you realize them.</p>
    </div>
    <h2 class="our-services-heading">about us</h2>
    <div class="card-container">
        <div class="card">
            <img src="asset/picc1.webp" alt="Safe & Secure">
            <h3>Safe & Secure</h3>
            <p>Your Chama’s information is securely stored in our servers. We also ensure your information is only visible to authorized users.</p>
        </div>
        <div class="card mb-4">
            <img src="asset/banking-2.jpg" alt="Other Services">
            <h5>Other Services</h5>
            <p>In addition to Savings and Credit, we offer the following services:- Insurance Agency, Investment Wings, Agency Services & Inua Jamii Payments, Mobile Banking Services, ATM - Visa Branded Sacco Link Cards, Benevolent Fund Scheme, Bankers and Ordinary Cheques, and many more.</p>
        </div>
        <div class="card mb-4">
            <img src="asset/save.jpg" class="card-img-top" alt="Savings Services">
            <h5 class="card-heading">Savings Services</h5>
            <p>We offer Savings Services through Personal Accounts, Institution  and Business Accounts. Other Accounts are: - Chamas and Joint Accounts, Children Account, Holiday Savings Account and All Farm Produce (Tea, Coffee, Milk, Rice, Horticulture etc.) Accounts, Investment Accounts.</p>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Email: info@bingwagroup.coop | Contact Us: 0706295324</p>
        <p>&copy; 2024 Bingwa Group. All rights reserved.</p>
    </div>

</body>
</html>
