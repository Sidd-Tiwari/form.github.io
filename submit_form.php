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
