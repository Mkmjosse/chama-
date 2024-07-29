<?php
// Start session
session_start();

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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Perform a query to check if the user exists in the database
    $sql = "SELECT * FROM Members WHERE Email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User found, verify password
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["Password"])) {
            // Password is correct, set session variables
            $_SESSION["firstname"] = $row["FirstName"];
            $_SESSION["lastname"] = $row["LastName"];
            $_SESSION["email"] = $row["Email"];
            $_SESSION["phone"] = $row["Phone"];
            
            // Redirect to welcome page
            header("Location: welcome.php");
            exit();
        } else {
            // Password is incorrect
            echo "Invalid email or password";
        }
    } else {
        // User not found
        echo "Invalid email or password";
    }
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font: 14px sans-serif;
            background-image: url('asset/log3.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            padding: 20px; /* Adding padding to center the form on the background */
        }
        .wrapper {
            width: 450px; /* Increased width */
            padding: 20px;
            margin: 0 auto;
            background-color: rgba(255, 255, 255, 0.8); /* Adding a semi-transparent white background for the form */
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Login</h2>
        <form id="loginForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" id="email" class="form-control">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" id="password" class="form-control">
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">Register here</a>.</p>
        </form>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            var email = document.getElementById('email').value;
            var password = document.getElementById('password').value;
            
            // Check if any field is empty
            if (!email || !password) {
                alert('Please fill in all fields.');
                event.preventDefault(); // Prevent form submission
            }
        });
    </script>
</body>
</html>