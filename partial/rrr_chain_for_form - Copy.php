<div class="row">
    <div class="col-md-7">
        <h5>Default RRR chain for <?php echo getDepartmentNameById($department_id); ?><hr></h5>
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
                                <th>Action</th>
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
                                        <input style="width: 50px;" type="text" class="form-control" name="assign_users_order[<?php echo $userId; ?>]" value="<?php echo $chainOrder; ?>">
                                    </div>
                                </td>
                                <td><a href="javascript:void(0);" onclick="deleteUserAssignTr('<?php echo $userId; ?>');" class="btn btn-danger"><i class="fa fa-times-circle"></i> &nbsp;Delete</a></td>
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
    <div class="col-md-5">
        <h5>Additional users for this RRR<hr></h5>
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sel1">Division:</label>
                            <select class="form-control" id="chain_select_branch_id" name="chain_select_branch_id" onchange="getDepartmentByBranch(this.value, 'chain_select_department_id');">
                                <option value="">Please select</option>
                                <?php
                                $table = "branch";
                                $order = "ASC";
                                $column = "name";
                                $datas = getTableDataByTableName($table, $order, $column);
                                foreach ($datas as $data) {
                                    ?>
                                    <option value="<?php echo $data->id; ?>"><?php echo $data->name; ?></option>
<?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sel1">Department:</label>
                            <select class="form-control" id="chain_select_department_id" name="chain_select_department_id" onchange="getDepartmentWiseUsers('chain_select_branch_id', 'chain_select_department_id','rlp_create_form');">
                                <option value="">Please select</option>
                                <?php
                                $table = "department";
                                $order = "ASC";
                                $column = "name";
                                $datas = getTableDataByTableName($table, $order, $column);
                                foreach ($datas as $data) {
                                    ?>
                                    <option value="<?php echo $data->id; ?>"><?php echo $data->name; ?></option>
<?php } ?>
                            </select>
                        </div>                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <span id="user_list_section"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


