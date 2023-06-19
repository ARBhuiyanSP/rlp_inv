<?php
$table = 'users';
$order = 'ASC';
$column = 'name';
$dataType = 'obj';
$agencyData = getTableDataByTableName($table, $order, $column, $dataType);
if (isset($agencyData) && !empty($agencyData)) {
    ?>
    <div class="table-responsive">
        <table id="user_list_table" class="table table-bordered table-striped list-table-custom-style">
            <thead>
                <tr>
                    <th>SLN#</th>
                    <th>Group</th>
                    <th>Division</th>
                    <th>Department</th>
                    <th>Employee ID</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sl = 0;
                $delUrl =   "function/user_management.php?process_type=user_delete";
                foreach ($agencyData as $adata) {
                    ?>
                    <tr id="row_id_<?php echo $adata->id; ?>">
                        <td><?php echo ++$sl; ?></td>
                        <td><?php echo (isset($adata->role_id) && !empty($adata->role_id) ? getRoleNameByRoleId($adata->role_id) : 'No data'); ?></td>
                        <td><?php echo (isset($adata->branch_id) && !empty($adata->branch_id) ? getDivisionNameById($adata->branch_id) : 'No data'); ?></td>
                        <td><?php echo (isset($adata->department_id) && !empty($adata->department_id) ? getDepartmentNameById($adata->department_id) : 'No data'); ?></td>
                        <td><?php echo (isset($adata->office_id) && !empty($adata->office_id) ? $adata->office_id : 'No data'); ?></td>
                        <td><?php echo (isset($adata->name) && !empty($adata->name) ? $adata->name : 'No data'); ?></td>
                        <td>
                            <?php if(hasAccessPermission($user_id_session, 'crlp', 'edit_access')){ ?>
                            <a title="Edit User" class="btn btn-sm btn-info" href="user_update.php?user_id=<?php echo $adata->id; ?>">
                                <span class="fa fa-pencil"></span>
                            </a>
                            <?php } ?>
                            <?php 
                                if(hasAccessPermission($user_id_session, 'crlp', 'delete_access')){
                                    if($user_id_session!=$adata->id){
                                ?>
                            <a title="Delete User" class="btn btn-sm btn-danger" href="javascript:void(0)" onclick="commonDeleteOperation('<?php echo $delUrl ?>', '<?php echo $adata->id ?>');">
                                <span class="fa fa-close"></span>
                            </a>
                                <?php }} ?>
                            <?php 
                                if(is_super_admin($user_id_session)){
                                    if($user_id_session!=$adata->id){
                            ?>
                            <a title="Login As" class="btn btn-sm btn-warning" href="javascript:void(0)" onclick="loginAsAnotherUser('<?php echo $adata->id ?>', '<?php echo $user_id_session; ?>');">
                                <span class="fa fa-user-secret"></span>
                            </a>
                                <?php }} ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
<?php } else { ?>
    <div class="alert alert-warning">
        <strong>Sorry there is no data!</strong>
    </div>
<?php } ?>