<?php 
require_once('../../config.php');

if(isset($_GET['id'])){
    $qry = $conn->query("SELECT * FROM `attendance` WHERE id ='{$_GET['id']}'");
    if($qry->num_rows > 0){
        $res = $qry->fetch_array();
        foreach($res as $k => $v){
            if(!is_numeric($k)){
                $$k = $v;
            }
        }
    }
}
?>

<style>
    #uni_modal .modal-footer{
        display:none !important;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h4 class="text-primary">Attendance Record Details</h4>
            <dl>
                <dt class="text-primary">Babysitter ID</dt>
                <dd class="pl-4"><?= isset($babysitter_id) ? $babysitter_id : "" ?></dd>
                <dt class="text-primary">Date</dt>
                <dd class="pl-4"><?= isset($date) ? date("Y-m-d", strtotime($date)) : "" ?></dd>
                <dt class="text-primary">Status</dt>
                <dd class="pl-4"><?= isset($status) ? ($status == 1 ? 'Present' : 'Absent') : "" ?></dd>
                <dt class="text-primary">Notes</dt>
                <dd class="pl-4"><?= isset($notes) ? $notes : "" ?></dd>
            </dl>
        </div>
    </div>
    <div class="row">
        <div class="col-12 text-right">
            <button class="btn btn-flat btn-sm btn-dark" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
        </div>
    </div>
</div>
