<?php
require_once('../../config.php');

// Fetch the billing details
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query to fetch billing, service, and enrollment details
    $query = "
        SELECT b.*, 
               e.meta_value AS child_fullname, 
               p.meta_value AS parent_fullname,
               s.name AS service_name
        FROM billing b
        LEFT JOIN enrollment_details e ON b.enrollment_id = e.enrollment_id AND e.meta_field = 'child_fullname'
        LEFT JOIN enrollment_details p ON b.enrollment_id = p.enrollment_id AND p.meta_field = 'parent_fullname'
        LEFT JOIN service_list s ON b.service_id = s.id
        WHERE b.id = $id
    ";

    $result = $conn->query($query);
    
    if ($result->num_rows > 0) {
        $billing = $result->fetch_assoc();
    } else {
        echo "No billing record found.";
        exit;
    }
} else {
    echo "Invalid request.";
    exit;
}

// Check the status and convert it to a readable format
$status_text = ($billing['status'] == 0) ? "Pending" : "Paid";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing Invoice</title>
    <link rel="stylesheet" href="path/to/bootstrap.css"> <!-- Add Bootstrap for styling -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Add Font Awesome for icons -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            color: #333;
        }
        .invoice-container {
            margin: 30px auto;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            max-width: 800px;
            position: relative;
        }
        .invoice-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .invoice-header h2 {
            font-size: 36px;
            color: #3d3d3d;
            margin-bottom: 5px;
        }
        .invoice-header p {
            font-size: 18px;
            color: #555;
            margin: 0;
        }
        .invoice-details table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .invoice-details th, .invoice-details td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
            font-size: 18px;
        }
        .invoice-details th {
            background-color: #f7f7f7;
            color: #333;
        }
        .invoice-details td {
            background-color: #fafafa;
        }
        .invoice-footer {
            margin-top: 30px;
            text-align: right;
            font-size: 20px;
            color: #333;
        }
        .invoice-footer p {
            margin: 5px 0;
        }
        .invoice-footer .total {
            font-size: 24px;
            font-weight: bold;
            color: #1e7e34;
        }
        .invoice-footer .status {
            font-size: 20px;
            font-weight: bold;
        }

        /* Back button */
        .back-button {
            margin-top: 20px;
            text-align: center;
        }

        .back-button button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        .back-button button:hover {
            background-color: #0056b3;
        }

        /* Print Icon inside the container */
        .print-icon {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 30px;
            color: #007bff;
            cursor: pointer;
        }

        .print-icon:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>

<div class="invoice-container">
    <!-- Print Icon inside the container -->
    <i class="fas fa-print print-icon" onclick="window.print()"></i>

    <!-- Invoice Header -->
    <div class="invoice-header">
        <h2>Invoice</h2>
        <p><strong>Invoice ID:</strong> <?php echo $billing['invoice_id']; ?></p>
        <p><strong>Date:</strong> <?php echo date('F j, Y', strtotime($billing['date_created'])); ?></p>
    </div>

    <!-- Billing Details -->
    <div class="invoice-details">
        <h4>Billing Details</h4>
        <table>
            <tr>
                <th>Child's Name</th>
                <td><?php echo $billing['child_fullname']; ?></td>
            </tr>
            <tr>
                <th>Parent's Name</th>
                <td><?php echo $billing['parent_fullname']; ?></td>
            </tr>
            <tr>
                <th>Service</th>
                <td><?php echo $billing['service_name'] ? $billing['service_name'] : 'N/A'; ?></td>
            </tr>
            <tr>
                <th>Amount</th>
                <td>$<?php echo number_format($billing['amount'], 2); ?></td>
            </tr>
            <tr>
                <th>Status</th>
                <td><?php echo $status_text; ?></td>
            </tr>
            <tr>
                <th>Date Created</th>
                <td><?php echo date('F j, Y', strtotime($billing['date_created'])); ?></td>
            </tr>
        </table>
    </div>

    <!-- Footer -->
    <div class="invoice-footer">
        <p class="total"><strong>Total Amount:</strong> $<?php echo number_format($billing['amount'], 2); ?></p>
        <p class="status"><strong>Status:</strong> <?php echo $status_text; ?></p>
    </div>

    <!-- Go Back Button -->
    <div class="back-button">
        <button onclick="history.back()">Go Back</button>
    </div>
</div>

</body>
</html>
