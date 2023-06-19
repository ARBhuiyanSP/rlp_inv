<div class="row">
    <div class="col-md-4">
        <?php
            if(!has_rlp_approved($rlp_id)){
                if($currentUserId!=$rlp_info->rlp_user_id){
        ?>
                <form id="rlp_dh_update_form">        
                    <div class="common_individual_section approval_body_section_style">
                        <h4>Acknowledgement<hr></h4>
                        <div class="radio">
                            <label><input type="radio" name="acknowledgement" value="6">Recommended</label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="acknowledgement" value="4">Withheld</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="comment">Remarks:</label>
                        <textarea class="form-control" rows="5" id="remarks" name="remarks"></textarea>
                    </div>
                    <input type="hidden" name="rlp_info_id" value="<?php echo $rlp_id; ?>">
                    <input type="hidden" name="created_by" value="<?php echo $currentUserId; ?>">
                    <button type="button" class="btn btn-primary btn-block" onclick="execute_rlp_sa_update_form('rlp_dh_update_form', 'rlp_dh_update_execute');">Update</button>
                </form>
            <?php
                } 
                if($rlp_info->rlp_status == 5){
            ?>
            <div style="margin: 30% 5% 5% 5%;">
                    <img style="margin-left: 30%" src="images/icon/pending_small.png" class="img img-responsive" />
                </div>
            <?php }else{ ?>
                <div style="margin: 30% 5% 5% 5%;">
                    <img style="margin-left: 30%" src="images/icon/processing_small.png" class="img img-responsive" />
                </div>
            <?php }
            
            }else{ ?>
                <div style="margin: 30% 5% 5% 5%;">
                    <img style="margin-left: 30%" src="images/icon/approved_small.png" class="img img-responsive" />
                </div>
            <?php } ?>
    </div>
    <?php include 'rlp_remarks_and_acknowledgement_ingeneral.php'; ?>
</div>