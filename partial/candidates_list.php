<?php
$table = 'candidates';
$order = 'ASC';
$column = 'name';
$dataType = 'obj';
$agencyData = getTableDataByTableName($table, $order, $column, $dataType);
if (isset($agencyData) && !empty($agencyData)) {
    ?>
    <div class="table-responsive">
        <table id="rlp_list_table" class="table table-bordered table-striped list-table-custom-style">
            <thead>
                <tr>
                    <th>Candidate Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>CV</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $delUrl =   "function/candidates_management.php?process_type=candidate_delete";
                foreach ($agencyData as $adata) {
                    ?>
                    <tr id="row_id_<?php echo $adata->id; ?>">
						<td><?php echo (isset($adata->name) && !empty($adata->name) ? $adata->name : 'No data'); ?></td>
						<td><?php echo (isset($adata->phone) && !empty($adata->phone) ? $adata->phone : 'No data'); ?></td>
						<td><?php echo (isset($adata->email) && !empty($adata->email) ? $adata->email : 'No data'); ?></td>
						<td><a href="uploads/cv/<?php echo (isset($adata->cv) && !empty($adata->cv) ? $adata->cv : 'No data'); ?>" target="_blank">View CV</a></td>
                        <td>
                            <!-- <?php //if(hasAccessPermission($user_id_session, 'crlp', 'edit_access')){ ?>
                            <a title="Edit User" class="btn btn-sm btn-info" href="supplier_update.php?supplier_id=<?php //echo $adata->id; ?>">
                                <span class="fa fa-pencil"></span>
                            </a>
                            <?php //} ?> -->
                            <?php if(hasAccessPermission($user_id_session, 'crlp', 'delete_access')){ ?>
                            <a title="Delete Suplier" class="btn btn-sm btn-danger" href="javascript:void(0)" onclick="commonDeleteOperation('<?php echo $delUrl ?>', '<?php echo $adata->id ?>');">
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
        <strong>No Data Found!</strong>
    </div>
<?php } ?>