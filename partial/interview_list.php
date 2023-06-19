<?php
$table = 'interviews';
$order = 'ASC';
$column = 'code';
$dataType = 'obj';
$agencyData = getTableDataByTableName($table, $order, $column, $dataType);
if (isset($agencyData) && !empty($agencyData)) {
    ?>
    <div class="table-responsive">
        <table id="material_receive_list" class="table table-bordered table-striped list-table-custom-style">
            <thead>
                <tr>
                    <th>Interview ID</th>
                    <th>Date</th>
                    <th>Location</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $delUrl =   "function/interview_register_form_process.php?process_type=interview_delete";
                foreach ($agencyData as $adata) {
                    ?>
                    <tr id="row_id_<?php echo $adata->id; ?>">
						<td><?php echo (isset($adata->code) && !empty($adata->code) ? $adata->code : 'No data'); ?></td>
						<td>
						<?php echo (isset($adata->date) && !empty($adata->date) ? human_format_date($adata->date) : 'No data'); ?>
						</td>
						<td><?php echo (isset($adata->location) && !empty($adata->location) ? $adata->location : 'No data'); ?></td>
						
                        <td style="text-align:right;">
							<a title="Details" class="btn btn-sm btn-success"  data-toggle="modal" data-target="#myView<?php echo $adata->id; ?>">
                                <span class="fa fa-eye"> Details</span>
                            </a>
                            <?php if(hasAccessPermission($user_id_session, 'crlp', 'edit_access')){ ?>
                            <a title="Edit User" class="btn btn-sm btn-info" href="javascript:void(0)"><span class="fa fa-pencil"> Edit</span></a>
                            <?php } ?>
                            <?php if(hasAccessPermission($user_id_session, 'crlp', 'delete_access')){ ?>
                            <a title="Delete Suplier" class="btn btn-sm btn-danger" href="javascript:void(0)">
                                <span class="fa fa-close"></span>
                            </a>
                                <?php } ?>
                            
                        </td>
                    </tr>
					<!-- Modal View -->
					<div class="modal fade" id="myView<?php echo $adata->id; ?>" role="dialog">
						<div class="modal-dialog">
						  <!-- Modal content-->
						  <?php include('partial/interview-details.php'); ?>
						</div>
					</div>
                <?php } ?>
            </tbody>
        </table>
    </div>
<?php } else { ?>
    <div class="alert alert-warning">
        <strong>No Data Found!</strong>
    </div>
<?php } ?>