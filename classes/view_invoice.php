<?php
// Include necessary files (like database connection, header, etc.)
include_once('DBConnection.php');

$invoice_id = $_GET['id']; // Get the invoice ID from the URL

// Fetch the invoice details
$query = "SELECT * FROM invoices WHERE id = '$invoice_id'";
$result = $mysqli->query($query);
$invoice = $result->fetch_assoc();

// Fetch invoice items
$query_items = "SELECT * FROM invoice_items WHERE invoice_id = '$invoice_id'";
$result_items = $mysqli->query($query_items);
?>

<div class="container-fluid">
    <h1>Invoice #<?= $invoice['id'] ?></h1>
    <p>Customer: <?= $invoice['customer_name'] ?></p>
    <p>Date Created: <?= $invoice['date_created'] ?></p>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Service</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total_amount = 0;
            while ($item = $result_items->fetch_assoc()):
                $total = $item['price'] * $item['quantity'];
                $total_amount += $total;
            ?>
            <tr>
                <td><?= $item['service_name'] ?></td>
                <td><?= $item['price'] ?></td>
                <td><?= $item['quantity'] ?></td>
                <td><?= $total ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <p><strong>Total Amount: <?= $total_amount ?></strong></p>

    <a href="billing_management.php" class="btn btn-secondary">Back to Billing Management</a>
</div>
