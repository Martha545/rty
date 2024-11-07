<?php
require_once('../config.php');

// Fetch children for the dropdown
$children = [];
$qry = $conn->query("SELECT id, child_fullname FROM enrollment_list WHERE status = 1");
while ($row = $qry->fetch_assoc()) {
    $children[$row['id']] = $row['child_fullname'];
}

// Fetch available services for the dropdown
$services = [];
$service_query = $conn->query("SELECT id, name FROM service_list ORDER BY name");
while ($row = $service_query->fetch_assoc()) {
    $services[$row['id']] = $row['name'];
}

// Prepare data for updating
if (isset($_GET['id'])) {
    $qry = $conn->query("SELECT * FROM `billing` WHERE id ='{$_GET['id']}'");
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
                <h4 class="card-title"><?= isset($id) ? "Update Billing Record" : "Add New Billing Record" ?></h4>
            </div>
            <div class="card-body">
                <div class="container-fluid">
                    <form action="" id="billing-form">
                        <input type="hidden" name="id" value="<?= isset($id) ? $id : '' ?>">
                        <fieldset>
                            <legend class="text-navy">Billing Information</legend>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="enrollment_id" class="control-label text-primary">Child</label>
                                    <select name="enrollment_id" id="enrollment_id" class="form-control form-control-border" required>
                                        <option value="">Select Child</option>
                                        <?php foreach ($children as $id => $names): ?>
                                            <option value="<?= $id ?>" <?= isset($enrollment_id) && $enrollment_id == $id ? "selected" : "" ?>>
                                                <?= $names ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="date" class="control-label text-primary">Date</label>
                                    <input type="date" class="form-control form-control-border" name="date" id="date" required value="<?= isset($date) ? $date : date('Y-m-d') ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="service_id" class="control-label text-primary">Service</label>
                                    <select name="service_id" id="service_id" class="form-control form-control-border" required>
                                        <option value="">Select Service</option>
                                        <?php foreach ($services as $id => $name): ?>
                                            <option value="<?= $id ?>" <?= isset($service_id) && $service_id == $id ? "selected" : "" ?>>
                                                <?= $name ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="amount" class="control-label text-primary">Amount</label>
                                    <input type="number" step="0.01" class="form-control form-control-border" name="amount" id="amount" value="<?= isset($amount) ? $amount : '' ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="status" class="control-label text-primary">Status</label>
                                    <select name="status" id="status" class="form-control form-control-border" required>
                                        <option value="0" <?= isset($status) && $status == '0' ? "selected" : "" ?>>Pending</option>
                                        <option value="1" <?= isset($status) && $status == '1' ? "selected" : "" ?>>Paid</option>
                                    </select>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="card-footer">
                <div class="text-center">
                    <button class="btn btn-flat btn-primary" form="billing-form"><i class="fa fa-save"></i> Save</button>
                    <a href="./?page=billing" class="btn btn-flat btn-light border"><i class="fa fa-angle-left"></i> Cancel</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function(){
        // Toggle required attribute for amount based on status
        $('#status').on('change', function() {
            if ($(this).val() === '1') { // Paid
                $('#amount').attr('required', 'required');
            } else { // Pending
                $('#amount').removeAttr('required');
            }
        });

        // Initialize required attribute based on current status value on load
        $('#status').trigger('change');

        $('#billing-form').submit(function(e){
            e.preventDefault();
            var _this = $(this);
            $('.pop-msg').remove();
            var el = $('<div>').addClass('pop-msg alert alert-danger').hide();
            _this.find('.form-control').each(function(){
                if($(this).val() == '' && $(this).attr('required')){
                    var label = $(this).closest('.form-group').find('label').text();
                    el.append('<p>' + label + ' field is required.</p>');
                }
            });

            if(el.text() != ''){
                _this.prepend(el);
                el.show('slow');
                return false;
            }

            start_loader();
            $.ajax({
                url: _base_url_ + 'classes/Master.php?f=save_billing',
                method: 'POST',
                data: _this.serialize(),
                dataType: 'json',
                error: function(err){
                    console.log(err);
                    alert_toast("An error occurred.", 'error');
                    end_loader();
                },
                success: function(resp){
                    if (resp.status == 'success'){
                        location.href = './?page=billing';
                    } else {
                        alert_toast("An error occurred.", 'error');
                        end_loader();
                    }
                }
            });
        });
    });
</script>
