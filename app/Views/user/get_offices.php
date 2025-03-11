<?php
// Set content type to JSON
header('Content-Type: application/json');

// Add CORS headers to allow API access from Flutter app
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Database credentials
$servername = "localhost";
$username = "root";
$password = "12345";
$dbname = "cris_db";

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode([
        "success" => false, 
        "message" => "Database connection failed: " . $conn->connect_error
    ]);
    exit();
}

// Execute SQL query to fetch office data
$sql = "SELECT OfficeID, OfficeName FROM tbloffice";
$result = $conn->query($sql);

// Check for SQL query error
if ($result === false) {
    echo json_encode([
        "success" => false, 
        "message" => "Query error: " . $conn->error
    ]);
    exit();
}

// Process results
$offices = [];
while ($row = $result->fetch_assoc()) {
    $offices[] = [
        "OfficeID" => (int) $row["OfficeID"], // Ensure OfficeID is an integer
        "name" => $row["OfficeName"]
    ];
}

// Return JSON response with offices
if (!empty($offices)) {
    echo json_encode([
        "success" => true,
        "offices" => $offices
    ]);
} else {
    echo json_encode([
        "success" => false, 
        "message" => "No offices found."
    ]);
}

// Close the database connection
$conn->close();
?>
