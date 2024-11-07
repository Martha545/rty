<?php
require_once('../config.php');

// Fetch children for the dropdown
// Fetch confirmed children for the dropdown

$children = [];
$qry = $conn->query("SELECT id, child_fullname FROM enrollment_list WHERE status = 1");
while ($row = $qry->fetch_assoc()) {
    $children[$row['id']] = $row['child_fullname'];
}



// Prepare data for updating
if (isset($_GET['id'])) {
    $qry = $conn->query("SELECT * FROM `attendance` WHERE id ='{$_GET['id']}'");
    if ($qry->num_rows > 0) {
        $res = $qry->fetch_array();
        foreach ($res as $k => $v) {
            if (!is_numeric($k)) {
                $$k = $v;
            }
        }
    }
}
?>

<div class="content py-3">
    <div class="container-fluid">
        <div class="card card-outline card-info shadow rounded-0">
            <div class="card-header">
                <h4 class="card-title"><?= isset($id) ? "Update Attendance Record" : "Add New Attendance Record" ?></h4>
            </div>
            <div class="card-body">
                <div class="container-fluid">
                    <form action="" id="attendance-form">
                        <input type="hidden" name="id" value="<?= isset($id) ? $id : '' ?>">
                        <fieldset>
                            <legend class="text-navy">Attendance Information</legend>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="enrollment_id" class="control-label text-primary">Child</label>
                                    <select name="enrollment_id" id="enrollment_id" class="form-control form-control-border" required>
                                        <option value="">Select Child</option>
                                        <?php
                                        // Fetch all confirmed children from the enrollment_list table
                                        $qry = $conn->query("SELECT id, child_fullname FROM enrollment_list WHERE status = 1"); // Only confirmed children
                                        while ($row = $qry->fetch_assoc()) {
                                            echo "<option value=\"{$row['id']}\" " . (isset($enrollment_id) && $enrollment_id == $row['id'] ? "selected" : "") . ">";
                                            echo $row['child_fullname'];
                                            echo "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="date" class="control-label text-primary">Date</label>
                                    <input type="date" class="form-control form-control-border" name="date" id="date" required value="<?= isset($date) ? $date : date('Y-m-d') ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="status" class="control-label text-primary">Status</label>
                                    <select name="status" id="status" class="form-control form-control-border" required>
                                        <option value="Present" <?= isset($status) && $status == 'Present' ? "selected" : "" ?>>Present</option>
                                        <option value="Absent" <?= isset($status) && $status == 'Absent' ? "selected" : "" ?>>Absent</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="notes" class="control-label text-primary">Notes</label>
                                    <textarea name="notes" id="notes" class="form-control form-control-border" rows="2"><?= isset($notes) ? $notes : "" ?></textarea>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-center">
                    <button class="btn btn-flat btn-primary" form="attendance-form"><i class="fa fa-save"></i> Save</button>
                    <a href="./?page=attendance" class="btn btn-flat btn-light border"><i class="fa fa-angle-left"></i> Cancel</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function(){
        $('#attendance-form').submit(function(e){
            e.preventDefault();
            var _this = $(this);
            $('.pop-msg').remove();
            var el = $('<div>').addClass("pop-msg alert").hide();
            start_loader();
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_attendance",
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                dataType: 'json',
                error: err => {
                    console.log(err);
                    alert_toast("An error occurred", 'error');
                    end_loader();
                },
                success: function(resp) {
                    if (resp.status == 'success') {
                        location.href = "./?page=attendance";
                    } else if (!!resp.msg) {
                        el.addClass("alert-danger").text(resp.msg);
                        _this.prepend(el);
                    } else {
                        el.addClass("alert-danger").text("An error occurred due to an unknown reason.");
                        _this.prepend(el);
                    }
                    el.show('slow');
                    $('html, body').animate({scrollTop: 0}, 'fast');
                    end_loader();
                }
            });
        });
    });
</script>
