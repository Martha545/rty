<?php 
require_once('../../config.php');
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h4 class="text-primary">Attendance Records</h4>
            <button class="btn btn-primary" onclick="location.href='./?page=manage_attendance'"><i class="fa fa-plus"></i> Add New Attendance</button>
            <table class="table table-bordered" id="attendance-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Babysitter ID</th>
                        <th>Status</th>
                        <th>Notes</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $qry = $conn->query("SELECT * FROM `attendance` ORDER BY date DESC");
                    while($row = $qry->fetch_assoc()):
                    ?>
                        <tr>
                            <td><?= date("Y-m-d", strtotime($row['date'])) ?></td>
                            <td><?= $row['babysitter_id'] ?></td>
                            <td><?= $row['status'] == 1 ? 'Present' : 'Absent' ?></td>
                            <td><?= isset($row['notes']) ? $row['notes'] : '' ?></td>
                            <td>
                                <button class="btn btn-sm btn-info" onclick="viewAttendance(<?= $row['id'] ?>)"><i class="fa fa-eye"></i> View</button>
                                <button class="btn btn-sm btn-warning" onclick="editAttendance(<?= $row['id'] ?>)"><i class="fa fa-edit"></i> Edit</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function viewAttendance(id) {
    $.ajax({
        url: './view_attendance_details.php?id=' + id,
        success: function(response) {
            $('#uni_modal .modal-content').html(response);
            $('#uni_modal').modal('show');
        }
    });
}

function editAttendance(id) {
    $.ajax({
        url: './manage_attendance.php?id=' + id,
        success: function(response) {
            $('#uni_modal .modal-content').html(response);
            $('#uni_modal').modal('show');
        }
    });
}
</script>
