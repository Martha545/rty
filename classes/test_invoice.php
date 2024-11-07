<?php
// Assuming Master.php contains the logic for the class and function
include 'Master.php';  // Adjust the path if necessary

// Create an instance of the Master class
$Master = new Master();

// Sample data for testing
$enrollment_id = 5;  // Replace with a real enrollment ID from your enrollment_list table
$service_ids = [1, 3];  // Replace with real service IDs from your service_list table

// Call the create_invoice function
$response = $Master->create_invoice($enrollment_id, $service_ids);

// Output the response
echo json_encode($response);
?>
