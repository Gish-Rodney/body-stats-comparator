<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Workout Recommendation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
        }

        .recommendation {
            margin-top: 20px;
            border-top: 2px solid #ccc;
            padding-top: 20px;
        }

        .stat {
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Workout Recommendation</h1>
    <div class="recommendation">
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

// Define statistic ranges (lower, upper, optimum)
$statRanges = [
    'weight' => ['lower' => 70, 'upper' => 90, 'optimum' => 80],
    'height' => ['lower' => 170, 'upper' => 190, 'optimum' => 180],
    'strength' => ['lower' => 40, 'upper' => 60, 'optimum' => 50],
    'agility' => ['lower' => 4, 'upper' => 6, 'optimum' => 5],
    'endurance' => ['lower' => 90, 'upper' => 120, 'optimum' => 100],
    // Define ranges for other statistics
];

// Function to determine the lowest performing stat based on ranges
function determineLowStat($athleteData, $statRanges) {
    $lowestStat = null;
    $lowestStatDifference = PHP_INT_MAX;

    foreach ($statRanges as $stat => $range) {
        $athleteStat = $athleteData[$stat];
        $statLower = $range['lower'];

        // Compare the athlete's stat to the lower range of the stat
        $difference = $athleteStat - $statLower;

        if ($difference < $lowestStatDifference) {
            $lowestStatDifference = $difference;
            $lowestStat = $stat;
        }
    }

    return $lowestStat;
}

// Fetch athlete data from the database
$sql = "SELECT * FROM athlete_stats";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $athleteData = [
        'weight' => $row['weight'],
        'height' => $row['height'],
        'strength' => $row['strength'],
        'agility' => $row['agility'],
        'endurance' => $row['endurance'],
        // Add other stats for the athlete
    ];

    // Determine the low stat based on athlete's data and defined ranges
    $lowStat = determineLowStat($athleteData, $statRanges);

    // Select a workout targeting the low stat
    $sql = "SELECT name, targeted_stat, description
            FROM workouts
            WHERE targeted_stat = ?
            ORDER BY RAND()
            LIMIT 1";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $lowStat);

    $stmt->execute();
    $result = $stmt->get_result();
    $workout = $result->fetch_assoc();

    // Output the selected workout recommendation along with the low stat
    echo "Lowest performing stat: " . $lowStat . "<br>";
    echo "Recommended Workout:<br>";
    echo "Name: " . $workout['name'] . "<br>";
    echo "Targeted Stat: " . $workout['targeted_stat'] . "<br>";
    echo "Description: " . $workout['description'];
} else {
    echo "No athlete data found";
}

// Close the database connection
$stmt->close();
$conn->close();

?>
   </div>
</div>
</body>
</html>
