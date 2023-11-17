<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sports Stats</title>
    <style>
        /* Your existing CSS styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-evenly;
        }

        .athlete-card {
            display: flex;
            flex-direction: column;
            border: 2px solid #0077ff;
            margin: 10px;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 280px;
            text-align: center;
        }

        img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        h2 {
            margin: 5px 0;
            color: #0077ff;
        }

        .stats {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
        }

        .stats p {
            margin: 0;
        }

        .ovr {
            background-color: #0077ff;
            color: white;
            border-radius: 20px;
            padding: 2px 10px;
            margin-bottom: 10px;
        }

        .recommendation-link {
            margin-top: auto;
            text-decoration: none;
            color: #0077ff;
            font-weight: bold;
        }

        .recommendation-link:hover {
            text-decoration: underline;
        }

        .club-logo {
            max-width: 50px;
            height: auto;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
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

// Fetch all athletes data from the database
$sql = "SELECT * FROM athlete_stats";
$result = $conn->query($sql);

// Check if there are any rows in the result
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Calculate individual OVR for each athlete
        $individualOVR = round(($row['weight'] + $row['height'] + $row['strength'] + $row['agility'] + $row['endurance']) / 5, 2);

        // Display individual athlete data along with recommendation link
        echo "<div class='athlete-card'>
                <div>
                    <strong>OVR:</strong> " . $individualOVR . "%
                </div>
                <img src='{$row['picture_url']}'>
                <h2>{$row['name']}</h2>
                <hr class='horizontal-line'>
                <div>
                    <p><strong>Weight:</strong> {$row['weight']} kg</p>
                    <p><strong>Height:</strong> {$row['height']} cm</p>
                    <p><strong>Strength:</strong> {$row['strength']} lbs</p>
                    <p><strong>Agility:</strong> {$row['agility']} s</p>
                    <p><strong>Endurance:</strong> {$row['endurance']} min</p>
                    <a href='get_workout_recommendation.php?id={$row['id']}'>View Recommendation</a>
                </div>
              </div>";
    }
} else {
    echo "No athletes found";
}

// Close the database connection
$conn->close();
?>

</body>
</html>
