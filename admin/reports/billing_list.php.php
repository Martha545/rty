<?php 
require_once('../../config.php');
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h4 class="text-primary">Billing Records</h4>
            <button class="btn btn-primary" onclick="location.href='./?page=manage_billing'"><i class="fa fa-plus"></i> Add New Billing</button>
            <table class="table table-bordered" id="billing-table">
                <thead>
                    <tr>
                        <th>Billing Date</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Notes</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $qry = $conn->query("SELECT * FROM `billing` ORDER BY billing_date DESC");
                    while($row = $qry->fetch_assoc()):
                    ?>
                        <tr>
                            <td><?= date("Y-m-d", strtotime($row['billing_date'])) ?></td>
                            <td><?= number_format($row['amount'], 2) ?></td>
                            <td><?= $row['status'] == 1 ? 'Paid' : 'Unpaid' ?></td>
                            <td><?= isset($row['notes']) ? $row['notes'] : '' ?></td>
                            <td>
                                <button class="btn btn-sm btn-info" onclick="viewBilling(<?= $row['id'] ?>)"><i class="fa fa-eye"></i> View</button>
                                <button class="btn btn-sm btn-warning" onclick="editBilling(<?= $row['id'] ?>)"><i class="fa fa-edit"></i> Edit</button>
                                <button class="btn btn-sm btn-danger" onclick="deleteBilling(<?= $row['id'] ?>)"><i class="fa fa-trash"></i> Delete</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function viewBilling(id) {
    $.ajax({
        url: './view_billing_details.php?id=' + id,
        success: function(response) {
            $('#uni_modal .modal-content').html(response);
            $('#uni_modal').modal('show');
        }
    });
}

function editBilling(id) {
    $.ajax({
        url: './manage_billing.php?id=' + id,
        success: function(response) {
            $('#uni_modal .modal-content').html(response);
            $('#uni_modal').modal('show');
        }
    });
}

function deleteBilling(id) {
    if (confirm('Are you sure you want to delete this billing record?')) {
        $.ajax({
            url: './delete_billing.php',
            method: 'POST',
            data: { id: id },
            success: function(response) {
                let res = JSON.parse(response);
                if (res.status == 'success') {
                    alert(res.msg);
                    location.reload(); // Reload the page to update the list
                } else {
                    alert(res.msg);
                }
            }
        });
    }
}
</script>
