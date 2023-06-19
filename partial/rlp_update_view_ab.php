<div class="row">
    <div class="col-md-4">
        <form id="rlp_ab_update_form">
        <div class="common_individual_section approval_body_section_style">
            <h4>Acknowledgement<hr></h4>
            <div class="radio">
                <label><input type="radio" name="acknowledgement" value="1">Approve</label>
            </div>
            <div class="radio">
                <label><input type="radio" name="acknowledgement" value="3">Reject</label>
            </div>
        </div>
        <div class="form-group">
            <label for="comment">Remarks:</label>
            <textarea class="form-control" rows="5" id="remarks" name="remarks"></textarea>
        </div>
            <input type="hidden" name="rlp_info_id" value="<?php echo $rlp_id; ?>">
            <input type="hidden" name="created_by" value="<?php echo $currentUserId; ?>">
            <button type="button" class="btn btn-primary btn-block" onclick="execute_rlp_sa_update_form('rlp_ab_update_form', 'rlp_ab_update_execute');">Update</button>
        </form>
    </div>
    <?php include 'rlp_remarks_and_acknowledgement_ingeneral.php'; ?>
</div>