<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Handle OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Your API logic here
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lastName = $_POST['LastName'] ?? '';
    $firstName = $_POST['FirstName'] ?? '';
    $middleName = $_POST['MiddleName'] ?? '';
    $username = $_POST['Username'] ?? '';
    $password = $_POST['Password'] ?? '';
    $confirmPassword = $_POST['ConfirmPassword'] ?? '';

    // Process data and respond
    $response = ['success' => true]; // Modify based on your logic
    echo json_encode($response);
}
?>
