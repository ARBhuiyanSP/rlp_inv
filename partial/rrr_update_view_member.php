<div class="row">
    <div class="col-md-4">
        <?php
            if(has_rrr_approved($rrr_id)){
        ?>
            <div style="margin: 30% 5% 5% 5%;">
                <img style="margin-left: 30%" src="images/icon/approved_small.png" class="img img-responsive" />                
            </div>
        <?php }elseif($rrr_info->rrr_status == 5){ ?>
            <div style="margin: 30% 5% 5% 5%;">
                <img style="margin-left: 30%" src="images/icon/pending_small.png" class="img img-responsive" />
            </div>
        <?php }else{ ?>
            <div style="margin: 30% 5% 5% 5%;">
                <img style="margin-left: 30%" src="images/icon/processing_small.png" class="img img-responsive" />
            </div>
        <?php } ?>
    </div>
    <?php include 'rrr_remarks_and_acknowledgement_ingeneral.php'; ?>    
</div>