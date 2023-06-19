<?php
$table = 'branch';
$order = 'ASC';
$column = 'name';
$dataType = 'obj';
$divisionData = getTableDataByTableName($table, $order, $column, $dataType);
if (isset($divisionData) && !empty($divisionData)) {
    ?>
    <div class="table-responsive">
        <table id="rlp_list_table" class="table table-bordered table-striped list-table-custom-style">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sl = 0;
                $delUrl =   "function/user_management.php?process_type=division_delete";
                foreach ($divisionData as $adata) {
                    ?>
                    <tr id="row_id_<?php echo $adata->id; ?>">
                        <td><?php echo ++$sl; ?></td>
                        <td><?php echo (isset($adata->name) && !empty($adata->name) ? $adata->name : 'No data'); ?></td>
                        <td>
                            <?php if(hasAccessPermission($user_id_session, 'crlp', 'edit_access')){ ?>
                            <a title="Edit User" class="btn btn-sm btn-info" href="division_update.php?division_id=<?php echo $adata->id; ?>">
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