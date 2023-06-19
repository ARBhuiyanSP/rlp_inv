<?php 
    $userId     =   $data->id;
?>
<div class="checkbox" id="assign_user_checkbox_<?php echo $userId; ?>">
    <label>
        <i class="fa fa-check-circle user_assign_common_check" id="user_assign_common_check_<?php echo $userId; ?>"></i>&nbsp;
        <span id="assign_user_label_<?php echo $userId; ?>">
            <?php if($formType == 'chain_create_form'){ ?>
                <input onclick="assignThisUserToChain('<?php echo $userId; ?>');" type="checkbox" id="assign_user_id_<?php echo $userId ?>" value="<?php echo $data->id ?>">
            <?php }elseif($formType  ==  'rlp_create_form'){ ?>
                <input onclick="assignThisUserToDefaultChain('<?php echo $userId; ?>');" type="checkbox" id="assign_user_id_<?php echo $userId ?>" value="<?php echo $data->id ?>">
            <?php } ?>
            <span id="assign_user_name_<?php echo $userId ?>">
                <?php echo $data->name.'('. getDesignationByUserId($userId).')'; ?>
            </span>
        </span>
    </label>
</div>