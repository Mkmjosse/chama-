<?php
// Database connection details
$servername = "localhost";
$username = "chama";
$password = "@chama";
$dbname = "chama";

// Create connection
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Define variables and initialize with empty values
    $firstName = $lastName = $email = $phone = $password = "";
    
    // Processing form data when form is submitted
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash password
    
    // Check if email already exists
    $check_email_sql = "SELECT MemberID FROM Members WHERE Email = ?";
    $check_email_stmt = $mysqli->prepare($check_email_sql);
    $check_email_stmt->bind_param("s", $email);
    $check_email_stmt->execute();
    $check_email_stmt->store_result();
    if ($check_email_stmt->num_rows > 0) {
        echo "This email is already registered.";
        exit();
    }
    
    // Prepare an insert statement
    $insert_sql = "INSERT INTO Members (FirstName, LastName, Email, Phone, Password) VALUES (?, ?, ?, ?, ?)";
    $insert_stmt = $mysqli->prepare($insert_sql);
    $insert_stmt->bind_param("sssis", $firstName, $lastName, $email, $phone, $password);
    
    // Attempt to execute the prepared statement
    if ($insert_stmt->execute()) {
        // Redirect to login page after successful registration
        header("location: login.php");
        exit();
    } else {
        echo "Something went wrong. Please try again later.";
    }
    
    // Close statements
    $insert_stmt->close();
    $check_email_stmt->close();
    
    // Close connection
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font: 14px sans-serif;
            background: url('asset/log3.jpg') repeat;
        }
        .wrapper {
            width: 360px;
            padding: 20px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Register</h2>
        <form id="registerForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="return validateForm()">
        <div class="form-group">
    <label>First Name</label>
    <input type="text" pattern="[A-Za-z]+" name="firstName" id="firstName" class="form-control">
    <small class="form-text text-muted"></small>
</div>
<div class="form-group">
    <label>Last Name</label>
    <input type="text" pattern="[A-Za-z]+" name="lastName" id="lastName" class="form-control">
    <small class="form-text text-muted"></small>
</div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" id="email" class="form-control">
            </div>   
            <div class="form-group">
    <label>Phone</label>
    <input type="tel" pattern="[0-9]{1,13}" name="phone" id="phone" class="form-control" maxlength="13">
    <small class="form-text text-muted">.</small>
</div>
<div class="form-group">
    <label>Password</label>
    <input type="password" pattern="(?=.*\d)(?=.*[a-zA-Z])(?=.*\W).{8,}" title="Password must contain at least 8 characters, including one number, one special character, and alphabetic characters." name="password" id="password" class="form-control">
    <small class="form-text text-muted"></small>
</div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Register">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>

    <script>
        function validateForm() {
            var firstName = document.getElementById("firstName").value;
            var lastName = document.getElementById("lastName").value;
            var email = document.getElementById("email").value;
            var phone = document.getElementById("phone").value;
            var password = document.getElementById("password").value;

            if (firstName == "" || lastName == "" || email == "" || phone == "" || password == "") {
                alert("All fields are required.");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>