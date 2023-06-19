<div class="row">
    <div class="col-md-4">
        <?php
            if(has_rlp_approved($rlp_id)){
        ?>
            <div style="margin: 30% 5% 5% 5%;">
                <img style="margin-left: 30%" src="images/icon/approved_small.png" class="img img-responsive" />                
            </div>
        <?php }elseif($rlp_info->rlp_status == 5){ ?>
            <div style="margin: 30% 5% 5% 5%;">
                <img style="margin-left: 30%" src="images/icon/pending_small.png" class="img img-responsive" />
            </div>
        <?php }else{ ?>
            <div style="margin: 30% 5% 5% 5%;">
                <img style="margin-left: 30%" src="images/icon/processing_small.png" class="img img-responsive" />
            </div>
        <?php } ?>
    </div>
    <?php include 'rlp_remarks_and_acknowledgement_ingeneral.php'; ?>    
</div>