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
        <h3 class="card-title">List of Attendance Records</h3>
        <div class="card-tools">
            <a href="./?page=attendance/manage_attendance" class="btn btn-flat btn-primary btn-sm"><i class="fa fa-plus"></i> Add New</a>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Full Name</th>
                        <th>Parent Name</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $i = 1;
                        $qry = $conn->query(" 
                            SELECT a.*, 
                                e.child_fullname, 
                                e.parent_fullname
                            FROM attendance a
                            INNER JOIN enrollment_list e ON a.enrollment_id = e.id
                            ORDER BY a.date DESC
                        ");

                        while ($row = $qry->fetch_assoc()): 
                    ?>
                        <tr>
                            <td class="text-center"><?php echo $i++; ?></td>
                            <td><?php echo date('Y-m-d', strtotime($row['date'])); ?></td>
                            <td><?php echo ucwords($row['child_fullname']); ?></td>
                            <td><?php echo ucwords($row['parent_fullname']); ?></td>
                            <td class="text-center">
                                <?php if ($row['status'] == 'Present'): ?>
                                    <span class="badge badge-pill badge-success">Present</span>
                                <?php else: ?>
                                    <span class="badge badge-pill badge-primary">Absent</span>
                                <?php endif; ?>
                            </td>
                            <td align="center">
                                <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                    Action
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu" role="menu">
                                    <a class="dropdown-item view_details" href="javascript:void(0)" data-id="<?php echo $row['id']; ?>"><span class="fa fa-eye text-dark"></span> View</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="./?page=attendance/manage_attendance&id=<?= $row['id']; ?>" data-id="<?php echo $row['id']; ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
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

<!-- Modal for viewing attendance details -->
<div class="modal fade" id="attendanceDetailsModal" tabindex="-1" role="dialog" aria-labelledby="attendanceDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="attendanceDetailsModalLabel">Attendance Summary</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="attendanceDetailsContent">
                <!-- Details will be loaded here via AJAX -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('.delete_data').click(function(){
            _conf("Are you sure to delete <b>"+$(this).attr('data-name')+"</b> from attendance records permanently?", "delete_attendance", [$(this).attr('data-id')]);
        });

        $('.view_details').click(function(){
            var id = $(this).data('id');
            $('#attendanceDetailsModal').modal('show');
            $('#attendanceDetailsContent').html('<p>Loading...</p>'); // Show a loading message

            $.ajax({
                url: _base_url_ + "classes/Master.php?f=get_attendance_details",
                method: "POST",
                data: { id: id },
                dataType: "json",
                success: function(resp) {
                    if (resp.status == 'success') {
                        var content = `<p><strong>Child Name:</strong> ${resp.data.child_fullname}</p>
                                       <p><strong>Parent Name:</strong> ${resp.data.parent_fullname}</p>
                                       <p><strong>Date:</strong> ${resp.data.date}</p>
                                       <p><strong>Status:</strong> ${resp.data.status}</p>`;
                        $('#attendanceDetailsContent').html(content);
                    } else {
                        $('#attendanceDetailsContent').html('<p>Error loading data.</p>');
                    }
                },
                error: function(err) {
                    console.log(err);
                    $('#attendanceDetailsContent').html('<p>An error occurred while loading details.</p>');
                }
            });
        });

        $('.table').dataTable();
    });

    function delete_attendance(id) {
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=delete_attendance",
            method: "POST",
            data: {id: id},
            dataType: "json",
            error: err => {
                console.log(err);
                alert_toast("An error occurred.", 'error');
                end_loader();
            },
            success: function(resp) {
                if (resp.status == 'success') {
                    location.reload();
                } else {
                    alert_toast("An error occurred.", 'error');
                    end_loader();
                }
            }
        });
    }
</script>
