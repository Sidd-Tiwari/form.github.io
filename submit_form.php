<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <title>Enquiry Form</title>
    <!-- <link rel="stylesheet" href="/Form/css/styles.css"> -->
</head>
<body class="mx-5">
    <h1 class="mt-3">Contact me</h1>
    <form class="form-validation" action="submit_form.php" method="POST" onsubmit="return validateForm();">
        <fieldset class="mx-1">
            <label for="toName">Name:</label>
            <input type="text" id="toName" name="toName" required class="form-control mt-1">

            <label for="dob">DOB:</label>
            <input type="date" name="dob" id="dob" class="form-control mt-1" required>

            <label for="fromName">Email id:</label>
            <input type="email" id="fromName" name="fromName" required class="form-control mt-1">

            <label for="phone">Contact:</label>
            <input type="tel" name="phone" id="phone" size="10" maxlength="10" class="form-control mt-1" required>

            <label for="message">Message:</label>
            <textarea id="message" name="message" required class="form-control mt-1"></textarea><br>

            <button type="submit" class="form-control bg-success mb-2">Send Query</button>
        </fieldset>
    </form>

    <script>
        function validateForm() {
            const name = document.getElementById("toName").value;
            const dob = document.getElementById("dob").value;
            const email = document.getElementById("fromName").value;
            const phone = document.getElementById("phone").value;
            const message = document.getElementById("message").value;

            // Validate name (must start with a capital letter and not contain any special character)
            const nameRegex = /^[A-Z][a-zA-Z]*$/;
            if (!nameRegex.test(name)) {
                alert("Name must start with a capital letter and contain no special characters.");
                return false;
            }
            if (name.length < 4) {
                alert("Please enter a name with at least 4 letters.");
                return false;
            }

            if (!/^\S{3,}$/.test(name)) {
                alert('Name cannot contain whitespace.');
                return false;
            }

            if (!/^(?:(\w)(?!\1\1))+$/.test(name)) {
                alert("Per 3 alphabets allowed.");
                return false;
            }

            // Validate DOB (must be greater than 13 years)
            const today = new Date();
            const birthDate = new Date(dob);
            const ageDiff = today.getFullYear() - birthDate.getFullYear();
            const monthDiff = today.getMonth() - birthDate.getMonth();
            const dayDiff = today.getDate() - birthDate.getDate();

            let age = ageDiff;
            if (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) {
                age--;
            }

            if (age < 13) {
                alert("You must be at least 13 years old.");
                return false;
            }

            // Validate phone number (must not start with zero or contain any special character)
            const phoneRegex = /^[1-9][0-9]{9}$/;
            if (!phoneRegex.test(phone)) {
                alert("Contact number must be 10 digits long, start with a digit between 1-9, and contain no special characters.");
                return false;
            }

            // Validate message (must not be empty)
            if (message.trim() === "") {
                alert("Message cannot be empty.");
                return false;
            }

            return true;
        }

        // Disable Right Click
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
        });

        // Text Selection and Copy Disabled
        document.addEventListener('DOMContentLoaded', (event) => {
            document.body.addEventListener('selectstart', (e) => e.preventDefault());
            document.body.addEventListener('copy', (e) => e.preventDefault());
            document.body.addEventListener('cut', (e) => e.preventDefault());
            document.body.addEventListener('paste', (e) => e.preventDefault());
        });
    </script>
</body>
</html>


<?php
// Database credentials
$servername = "localhost"; // Change this to your server's address
$username = "root"; // Change this to your MySQL username
$password = ""; // Change this to your MySQL password
$dbname = "enquiry_form_db"; // The name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['toName']);
    $dob = $conn->real_escape_string($_POST['dob']);
    $email = $conn->real_escape_string($_POST['fromName']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $message = $conn->real_escape_string($_POST['message']);

    // Insert data into the database
    $sql = "INSERT INTO enquiries (name, dob, email, phone, message) VALUES ('$name', '$dob', '$email', '$phone', '$message')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
