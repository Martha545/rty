<style>
    .img-avatar {
        width: 45px;
        height: 45px;
        object-fit: cover;
        object-position: center center;
        border-radius: 100%;
    }
</style>
<div class="card card-outline card-info rounded-0">
    <div class="card-header">
        <h3 class="card-title">List of Billing Records</h3>
        <div class="card-tools">
            <a href="./?page=billing/manage_billing" class="btn btn-flat btn-primary btn-sm"><i class="fa fa-plus"></i> Add New</a>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
        <table class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Date</th>
                    <th>Child Name</th>
                    <th>Parent Name</th>
                    <th>Service</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $i = 1;
                    $qry = $conn->query("SELECT b.*, 
                        el.child_fullname,
                        el.parent_fullname,
                        s.name AS service_name
                        FROM billing b
                        INNER JOIN enrollment_list el ON b.enrollment_id = el.id
                        LEFT JOIN service_list s ON b.service_id = s.id
                        ORDER BY b.date_created DESC");


                    while ($row = $qry->fetch_assoc()): 
                ?>
                    <tr>
                        <td class="text-center"><?php echo $i++; ?></td>
                        <td><?php echo date('Y-m-d', strtotime($row['date_created'])); ?></td>
                        <td><?php echo ucwords($row['child_fullname']); ?></td>
                        <td><?php echo ucwords($row['parent_fullname']); ?></td>
                        <td><?php echo isset($row['service_name']) ? ucwords($row['service_name']) : 'N/A'; ?></td>
                        <td class="text-right"><?php echo number_format($row['amount'], 2); ?></td>
                        <td class="text-center">
                            <?php if ($row['status'] == '1'): ?>
                                <span class="badge badge-pill badge-success">Paid</span>
                            <?php else: ?>
                                <span class="badge badge-pill badge-warning">Pending</span>
                            <?php endif; ?>
                        </td>
                        <td align="center">
                            <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                Action
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu">
                                <a class="dropdown-item" href="billing/view_details.php?id=<?= $row['id']; ?>"><span class="fa fa-eye text-dark"></span> Invoice</a>

                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="./?page=billing/manage_billing&id=<?= $row['id']; ?>" data-id="<?php echo $row['id']; ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id']; ?>" data-name="<?php echo $row['child_fullname']; ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>


        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $('.delete_data').click(function(){
            _conf("Are you sure to delete <b>"+$(this).attr('data-name')+"</b> from billing records permanently?", "delete_billing", [$(this).attr('data-id')]);
        });

        $('.view_details').click(function(){
            // Implement view details functionality if needed
            alert("View details for ID: " + $(this).attr('data-id'));
        });

        $('.table').dataTable();
    });

    function delete_billing($id) {
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=delete_billing",
            method: "POST",
            data: {id: $id},
            dataType: "json",
            error: err => {
                console.log(err);
                alert_toast("An error occurred.", 'error');
                end_loader();
            },
            success: function(resp) {
                if (typeof resp == 'object' && resp.status == 'success') {
                    location.reload();
                } else {
                    alert_toast("An error occurred.", 'error');
                    end_loader();
                }
            }
        });
    }
</script>
