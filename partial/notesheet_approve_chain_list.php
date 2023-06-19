<?php
$table      = 'notesheet_access_chain';
$order      = 'ASC';
$column     = 'id';
$dataType   = 'obj';
$agencyData = getTableDataByTableName($table, $order, $column, $dataType);
if (isset($agencyData) && !empty($agencyData)) {
    ?>
    <div class="table-responsive">
        <table id="rlp_chain_list" class="table table-bordered table-striped list-table-custom-style">
            <thead>
                <tr>
                    <th>SLN#</th>
                    <th>Chain Type</th>
                    <th>Division</th>
                    <th>Department</th>
                    <th>Project</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sl     =   0;
                $delUrl =   "function/notesheet_chain_process.php?process_type=notesheet_chain_delete";
                foreach ($agencyData as $adata) {
                    ?>
                    <tr id="row_id_<?php echo $adata->id; ?>">
                        <td><?php echo ++$sl; ?></td>
                        <td><?php echo $adata->chain_type; ?></td>
                        <td><?php echo (isset($adata->division_id) && !empty($adata->division_id) ? getDivisionNameById($adata->division_id) : 'No data'); ?></td>
                        <td><?php echo (isset($adata->department_id) && !empty($adata->department_id) ? getDepartmentNameById($adata->department_id) : 'No data'); ?></td>
                        <td><?php echo (isset($adata->project_id) && !empty($adata->project_id) ? getProjectNameById($adata->project_id) : 'No data'); ?></td>
                        <td>
                            <?php if(hasAccessPermission($user_id_session, 'crlp', 'edit_access')){ ?>
                            <a title="Edit User" class="btn btn-sm btn-info" href="notesheet_approve_chain_update.php?chain_id=<?php echo $adata->id; ?>">
                                <span class="fa fa-pencil"></span>
                            </a>
                            <?php } ?>
                            <?php 
                                if(hasAccessPermission($user_id_session, 'crlp', 'delete_access')){
                            ?>
                            <a title="Delete User" class="btn btn-sm btn-danger" href="javascript:void(0)" onclick="commonDeleteOperation('<?php echo $delUrl ?>', '<?php echo $adata->id ?>');">
                                <span class="fa fa-close"></span>
                            </a>
                            <?php } ?>
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