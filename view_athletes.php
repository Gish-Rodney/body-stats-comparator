<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sports Stats</title>
    <style>
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
            border: 1px solid #ddd;
            margin: 10px;
            padding: 10px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px; /* Set a fixed width for each athlete card */
            text-align: center;
        }

        img {
            max-width: 100%;
            height: auto;
            border-radius: 8px; /* Make the border radius equal to half of the max-width/height */
            margin-bottom: 10px;
        }

        .horizontal-line {
            border-top: 1px solid #ddd;
            margin: 10px 0;
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
    $totalWeight = 0;
    $totalHeight = 0;
    $totalStrength = 0;
    $totalAgility = 0;
    $totalEndurance = 0;

    while ($row = $result->fetch_assoc()) {
        $totalWeight += $row['weight'];
        $totalHeight += $row['height'];
        $totalStrength += $row['strength'];
        $totalAgility += $row['agility'];
        $totalEndurance += $row['endurance'];
    }

    $finalAverage = ($totalWeight + $totalHeight + $totalStrength + $totalAgility + $totalEndurance) / ($result->num_rows * 5);

    // Reset the result set pointer to the beginning
    $result->data_seek(0);

    while ($row = $result->fetch_assoc()) {
        echo "<div class='athlete-card'>
                <div>
                    <strong>OVR:</strong> " . round($finalAverage, 2) . "%
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
                </div>
              </div>";
    }
} else {
    echo "No athletes found";
}

// Close the database connection
$conn->close();
?>
<a href="get_workout_recommendation.php">View Recommendations</a>
</body>
</html>
