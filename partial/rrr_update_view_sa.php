<div class="row">
    <div class="col-md-4">
        <?php
            if(!has_rrr_approved($rrr_id)){
        ?>
        <form id="rrr_dh_update_form">
            <div class="common_individual_section department_heads_section_style">
                <h4>Department Heads<hr></h4>
                <?php
                $department_id = $rrr_info->request_department;
                $departmentHeads = getAllDepartmentHeads($department_id);
                if (isset($departmentHeads) && !empty($departmentHeads)) {
                    foreach ($departmentHeads as $dat) {
                        ?>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="<?php echo $dat->id; ?>" name="department_heads[]"><?php echo $dat->name; ?>
                            </label>
                        </div>
                    <?php
                    }
                }
                ?>
            </div>
            <div class="common_individual_section approval_body_section_style">
                <h4>Approval Bodies<hr></h4>
                <?php
                $approvalBodies = getAllApprovalBodies();
                if (isset($approvalBodies) && !empty($approvalBodies)) {
                    foreach ($approvalBodies as $dat) {
                        ?>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="<?php echo $dat->id; ?>" name="approval_bodies[]"><?php echo $dat->name; ?>
                            </label>
                        </div>
    <?php
    }
}
?>
            </div>
            <div class="common_individual_section approval_body_section_style">
                <h4>Acknowledgement<hr></h4>
                <div class="radio">
                    <label><input type="radio" name="acknowledgement" value="2" <?php if (isset($rrr_info->rrr_status) && $rrr_info->rrr_status == 2) {
    echo "checked";
} ?>>Acknowledge</label>
                </div>
                <div class="radio">
                    <label><input type="radio" name="acknowledgement" value="4"  <?php if (isset($rrr_info->rrr_status) && $rrr_info->rrr_status == 4) {
    echo "checked";
} ?>>Onheld</label>
                </div>
            </div>
            <div class="form-group">
                <label for="comment">Remarks:</label>
                <textarea class="form-control" rows="5" id="remarks" name="remarks"></textarea>
            </div>
            <input type="hidden" name="rrr_info_id" value="<?php echo $rrr_id; ?>">
            <input type="hidden" name="created_by" value="<?php echo $currentUserId; ?>">
            <button type="button" class="btn btn-primary btn-block" onclick="execute_rrr_dh_update_form('rrr_dh_update_form', 'rrr_dh_update_execute');">Update RRR</button>
        </form>
        <?php }else{ ?>
                <div style="margin: 30% 5% 5% 5%;">
                    <img style="margin-left: 30%" src="images/icon/approved_small.png" class="img img-responsive" />
                </div>
            <?php } ?>
    </div>
    <?php include 'rrr_remarks_and_acknowledgement_ingeneral.php'; ?>
</div>