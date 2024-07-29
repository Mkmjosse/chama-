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

// Function to retrieve member's transactions
function getMemberTransactions($conn, $memberId) {
    $sql = "SELECT * FROM transactions WHERE MemberId = '$memberId' AND Type = 'Loan Repayment'";
    $result = $conn->query($sql);

    $totalLoanRepayment = 0;

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $totalLoanRepayment += $row["Amount"];
        }
    }

    return $totalLoanRepayment;
}

// Function to retrieve loan requests for the current member
function getMemberLoanRequests($conn, $memberId) {
    $sql = "SELECT lr.RequestId, lr.MemberId, lr.LoanAmount, lr.RequestDate, lr.Status, m.FirstName, m.LastName, m.Email, m.Phone 
            FROM loan_requests lr
            JOIN members m ON lr.MemberId = m.MemberId
            WHERE lr.MemberId = '$memberId'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        echo "<h2 style='text-align: left;'>Requested Loans</h2>";
        echo "<table border='1'>
                <tr>
                    <th>Request ID</th>
                    <th>Loan Amount</th>
                    <th>Date Requested</th>
                    <th>Status</th>
                </tr>";
        $totalGranted = 0;
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["RequestId"] . "</td>
                    <td>" . $row["LoanAmount"] . "</td>
                    <td>" . $row["RequestDate"] . "</td>
                    <td>" . $row["Status"] . "</td>
                  </tr>";
            if ($row["Status"] == "Granted") {
                $totalGranted += $row["LoanAmount"];
            }
        }
        echo "</table>";

        $totalLoanRepayment = getMemberTransactions($conn, $memberId);

        $currentLoanBalance = $totalGranted - $totalLoanRepayment;

        echo "<p>Total Loan Amount Granted: $totalGranted</p>";
        echo "<p>Total Loan Repayment: $totalLoanRepayment</p>";
        echo "<p>Current Loan Balance: $currentLoanBalance</p>";
    } else {
        echo "<p>No loan requests available.</p>";
    }
}

// Function to submit loan request
function submitLoanRequest($conn, $memberId, $loanAmount) {
    $sql = "INSERT INTO loan_requests (MemberId, LoanAmount, Status) 
            VALUES ('$memberId', '$loanAmount', 'Pending')";
        
    if ($conn->query($sql) === TRUE) {
        echo "<p>Loan request submitted successfully!</p>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Process loan request form submission
if(isset($_POST['submitLoanRequest'])) {
    $loanAmount = $_POST['loanAmount'];
    $memberId = getMemberId($conn);
    if ($memberId) {
        submitLoanRequest($conn, $memberId, $loanAmount);
    } else {
        echo "<p class='error-message'>Error: Member ID not found.</p>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Requests</title>
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

        h2 {
            color: #333;
            text-align: left;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #dddddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .loan-form {
            margin-top: 20px;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .loan-form label {
            display: block;
            margin-bottom: 10px;
        }

        .loan-form input[type="number"],
        .loan-form input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .loan-form input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        .loan-form input[type="submit"]:hover {
            background-color: #45a049;
        }

        .error-message {
            color: #f00;
            margin-top: 10px;
        }

        .navbar {
            background: linear-gradient(to right, #87CEEB, #4682B4); /* Sky blue gradient */
            overflow: hidden;
        }

        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }

        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }

        .navbar-right {
            float: right;
        }

        .header-container {
            background-image: url('asset/images.jpeg');
            height: 200px;
            background-size: cover;
            background-position: center;
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

        .content {
            margin-top: 20px;
        }

        .lead {
            font-size: 1.25em;
        }

        .text-center {
            text-align: center;
        }

        .bg-dark {
            background-color: #333 !important;
        }

        .text-white {
            color: #fff !important;
        }

        .footer {
            padding: 10px 0;
        }

        .animated-text {
            font-size: 3em;
            color: red;
            text-align: center;
            margin: 20px 0;
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const texts = [
                "Unlock Your Financial Potential with Flexible Loans and Hassle-Free Repayment Options",
                "Empowering Your Dreams with Tailored Loan Solutions and Seamless Repayment Paths"
            ];
            let index = 0;
            const textContainer = document.getElementById('animatedText');

            function updateText() {
                textContainer.textContent = texts[index];
                index = (index + 1) % texts.length;
            }

            setInterval(updateText, 3000);
            updateText(); // Initial call to set the first text
        });
    </script>
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

<div class="header-container"></div> <!-- Added header container -->

<!-- Animated Text Container -->
<div id="animatedText" class="animated-text"></div>

<?php
// Get member ID
$memberId = getMemberId($conn);

if ($memberId) {
    // Display loan requests for the current member
    getMemberLoanRequests($conn, $memberId);
} else {
    echo "<p class='error-message'>Error: Member ID not found.</p>";
}
?>

<div class="loan-form">
    <h2>Request a New Loan</h2>
    <form method="post" action="">
        <label for="loanAmount">Loan Amount:</label>
        <input type="number" id="loanAmount" name="loanAmount" required><br>
        <input type="submit" name="submitLoanRequest" value="Submit Loan Request">
    </form>
</div>

  <!-- Footer -->
  <div class="footer">
        <p>Email: info@bingwagroup.coop | Contact Us: 0706295324</p>
        <p>&copy; 2024 Bingwa Group. All rights reserved.</p>
    </div>


</body>
</html>

<?php
// Closing the database connection
$conn->close();
?>


