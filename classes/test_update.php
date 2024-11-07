<?php
// test_update.php

// Add error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include the file
include 'Master.php'; // Ensure the correct path

// Simulate POST data
$_POST['id'] = 5; // Replace with a valid ID from your database
$_POST['status'] = '1'; // Change this to '0' or '1' as needed

// Call the update_status function if it exists
header('Content-Type: application/json');

if (function_exists('update_status')) {
    $response = update_status();
    echo $response;
} else {
    echo json_encode(['status' => 'error', 'msg' => 'update_status function not found.']);
}

?>
