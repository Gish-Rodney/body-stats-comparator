<?php
// Establish a connection to your MySQL database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "b_s_comparator";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Validate and sanitize the data
$name = isset($_POST['name']) ? filter_var($_POST['name'], FILTER_SANITIZE_STRING) : null;
$weight = isset($_POST['weight']) ? filter_var($_POST['weight'], FILTER_VALIDATE_FLOAT) : null;
$height = isset($_POST['height']) ? filter_var($_POST['height'], FILTER_VALIDATE_INT) : null;
$strength = isset($_POST['strength']) ? filter_var($_POST['strength'], FILTER_VALIDATE_FLOAT) : null;
$agility = isset($_POST['agility']) ? filter_var($_POST['agility'], FILTER_VALIDATE_FLOAT) : null;
$endurance = isset($_POST['endurance']) ? filter_var($_POST['endurance'], FILTER_VALIDATE_FLOAT) : null;

// Check for valid data
if (
    $name === null ||
    $weight === null ||
    $height === null ||
    $strength === null ||
    $agility === null ||
    $endurance === null
) {
    header('Location: index.html'); // Redirect back to the form with an error message if needed
    exit;
}

// Handle image upload
$picture = null;
if (isset($_FILES['picture']) && $_FILES['picture']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = 'uploads/'; // Specify the directory where you want to store uploaded images
    $uploadPath = $uploadDir . basename($_FILES['picture']['name']);

    // Move the uploaded file to the specified directory
    if (move_uploaded_file($_FILES['picture']['tmp_name'], $uploadPath)) {
        $picture = $uploadPath;
    } else {
        // Failed to move the file, handle the error as needed
        error_log("Failed to move uploaded file");
        header('Location: index.html'); // Redirect back to the form with an error message if needed
        exit;
    }
}

// Insert data into the database
$sql = "INSERT INTO athlete_stats (name, picture_url, weight, height, strength, agility, endurance) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssddddd", $name, $picture, $weight, $height, $strength, $agility, $endurance);

if ($stmt->execute()) {
    header('Location: index.html'); // Redirect back to the form with a success message if needed
} else {
    // Log the error securely instead of exposing it to users
    error_log("Database Error: " . $stmt->error);
    header('Location: index.html'); // Redirect back to the form with an error message if needed
}

// Close the database connection
$stmt->close();
$conn->close();
?>
