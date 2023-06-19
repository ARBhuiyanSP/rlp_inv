<div class="row">
    <div class="col-md-7">
        <h5>Default RLP chain for <?php echo getDepartmentNameById($department_id); ?><hr></h5>
        <?php
            $currentUserId  =   $_SESSION['logged']['user_id'];
        if (isset($defaultChainUsers) && !empty($defaultChainUsers)) {
        ?>
                <div class="table-responsive">          
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Approval Order</th>
                            </tr>
                        </thead>
                        <tbody id="default_rlp_user_chain_section">
                            <?php
                                foreach ($defaultChainUsers as $dataKey => $dataVal) {
                                    if($currentUserId  !=   $dataKey){
                                    $userId = $dataKey;
                                    $chainOrder = $dataVal;
                            ?>
                            <tr id="user_assign_tr_<?php echo $userId; ?>">
                                <td>
                                    <?php 
                                        echo 'Name:&nbsp;'.getUserNameByUserId($userId).'<br>';
                                        echo 'Designation:&nbsp;'. getDesignationByUserId($userId);
                                        ?>
                                </td>
                                <td>
                                    <div class="form-group">
                                        <input style="width: 50px;" type="text" class="form-control" name="assign_users_order[<?php echo $userId; ?>]" value="<?php echo $chainOrder; ?>" readonly>
                                    </div>
                                </td>
                            </tr>
                                    <?php }}// end foreach ?>
                        </tbody>
                    </table>
                </div>                
        <?php } else {
            ?>
            <div class="alert alert-warning">
                <strong>Warning!</strong> No user found with the Division And Department.
            </div>
<?php } ?>
    </div>
</div>


