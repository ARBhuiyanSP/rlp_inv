<?php
    $chainId        =   $_GET['chain_id'];
    $chainDetails   = getDataRowByTableAndId('rlp_access_chain', $chainId);
    $chainUsers     = json_decode($chainDetails->users);
    
?>
<form role="form" method="post" action="">
    <div class="box-body">
        <div class="row">
            <div class="col-md-4">
                <h4>Default chain for<hr></h4>
                <div class="box box-info">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="sel1">Division:</label>
                                    <select class="form-control" id="branch_id" name="branch_id" onchange="getDepartmentByBranch(this.value);">
                                        <option value="">Please select</option>
                                        <?php
                                        $table = "branch";
                                        $order = "ASC";
                                        $column = "name";
                                        $datas = getTableDataByTableName($table, $order, $column);
                                        foreach ($datas as $data) {
                                            ?>
                                            <option value="<?php echo $data->id; ?>" <?php if(isset($chainDetails->division_id) && $chainDetails->division_id == $data->id){ echo 'selected'; } ?>><?php echo $data->name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="sel1">Department:</label>
                                    <select class="form-control" id="department_id" name="department_id">
                                        <option value="">Please select</option>
                                        <?php
                                        $table = "department";
                                        $order = "ASC";
                                        $column = "name";
                                        $datas = getTableDataByTableName($table, $order, $column);
                                        foreach ($datas as $data) {
                                            ?>
                                            <option value="<?php echo $data->id; ?>" <?php if(isset($chainDetails->department_id) && $chainDetails->department_id == $data->id){ echo 'selected'; } ?>><?php echo $data->name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="sel1">Project:</label>
                                    <select class="form-control" id="project_id" name="project_id">
                                        <option value="">Please select</option>
                                        <?php
                                        $table = "projects";
                                        $order = "ASC";
                                        $column = "project_name";
                                        $datas = getTableDataByTableName($table, $order, $column);
                                        foreach ($datas as $data) {
                                            ?>
                                            <option value="<?php echo $data->id; ?>" <?php if(isset($chainDetails->project_id) && $chainDetails->project_id == $data->id){ echo 'selected'; } ?>><?php echo $data->project_name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>                   
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <ul>
                                <?php
                                    if(isset($chainUsers) && !empty($chainUsers)){
                                        foreach($chainUsers as $uKey=>$uval){ ?>
                                            <li>
                                                <?php echo getUserNameByUserId($uKey).'<br/>( '. getDesignationByUserId($uKey).' ) And Order '.$uval; ?></li>
                                        <?php
                                        }                                        
                                    }
                                ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <h4>Select chain Users<hr></h4>
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="sel1">Division:</label>
                                    <select class="form-control" id="chain_select_branch_id" name="chain_select_branch_id" onchange="getDepartmentByBranch(this.value,'chain_select_department_id');">
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="sel1">Department:</label>
                                    <select class="form-control" id="chain_select_department_id" name="chain_select_department_id" onchange="getDepartmentWiseUsers('chain_select_branch_id','chain_select_department_id');">
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="sel1">Project:</label>
                                    <select class="form-control" id="chain_select_project_id" name="chain_select_project_id">
                                        <option value="">Please select</option>
                                        <?php
                                        $table = "projects";
                                        $order = "ASC";
                                        $column = "project_name";
                                        $datas = getTableDataByTableName($table, $order, $column);
                                        foreach ($datas as $data) {
                                            ?>
                                            <option value="<?php echo $data->id; ?>"><?php echo $data->project_name; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>                        
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <h5>Approval Body<hr></h5>
                                <?php
                                    $approvalUsers  =   getAllApprovalBodies();
                                    $formType = 'chain_create_form';
                                    if(isset($approvalUsers) && !empty($approvalUsers)){
                                        foreach($approvalUsers as $data){
                                            include 'partial/rlp_chain_assign_user_common_checkbox_view.php';
                                        }
                                    }else{ ?>
                                        <div class="alert alert-warning">
                                            <strong>Warning!</strong> Approvalbody users not found.
                                      </div>
                                    <?php } ?>
                                <span id="user_list_section"></span>
                            </div>
                            <div class="col-md-7">
                                <div class="table-responsive">          
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th style="width: 60%">Name</th>
                                                <th style="width: 25%">Approval Order</th>
                                                <th style="width: 15%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="user_chain_section">
                                            <?php
                                                if(isset($chainUsers) && !empty($chainUsers)){
                                                    foreach($chainUsers as $uKey=>$uval){
                                                        $user_id    =   $uKey;
                                                        $user_name  =   getUserNameByUserId($uKey);
                                                        $user_desig =   getDesignationByUserId($uKey);
                                                        ?>
                                                        <tr id="user_assign_tr_<?php echo $user_id; ?>">
                                                            <td><?php echo $user_name; ?></td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <input style="width: 50px;" type="text" class="form-control" name="assign_users_order[<?php echo $user_id; ?>]" value="<?php echo $uval; ?>">
                                                                </div>
                                                            </td>
                                                            <td><a href="javascript:void(0);" onclick="deleteUserAssignTr('<?php echo $user_id; ?>');" class="btn btn-danger"><i class="fa fa-times-circle"></i></a></td>
                                                        </tr>
                                                    <?php
                                                    }                                        
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.box-body -->

    <div class="box-footer">
        <input type="submit" name="rlp_chain_create" class="btn btn-primary btn-block" value="Update">
    </div>
</form>