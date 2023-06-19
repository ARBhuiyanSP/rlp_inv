<style>
table.list-table-custom-style tr th{
	font-size:10px;
}
table.list-table-custom-style tr td{
	font-size:10px;
}
.btn-group-sm>.btn, .btn-sm{
	font-size:10px;
}
</style>
<?php
$rrrListData = getEquipmentListData();
if (isset($rrrListData) && !empty($rrrListData)) {
    ?>
    <div class="table-responsive">
        <table id="example2" class="table table-bordered table-striped list-table-custom-style">
            <thead>
                <tr>
                    <th>#</th>
                    <!-- <th>Requisition No</th> -->
                    <th>Name</th>
                    <th>EEL Code</th>
                    <th>Capacity</th>
                    <th>Brand</th>
                    <th>Model</th>
                    <th>Project</th>
                    <th>Present Location</th>
                    <th>Present Condition</th>
                    <th style="background-color: #3C8DBC;color: #fff;" width="25%">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sl = 0;
                $delUrl =   "function/equipment_processing.php?process_type=rrr_delete";
				
				$role       =   get_role_group_short_name();
                foreach ($rrrListData as $adata) {
                    ?>
                    <tr id="row_id_<?php echo $adata->id; ?>">
                        <td><?php echo ++$sl; ?></td>
                        <!-- <td>
                            <!-- <div title="RRR quick view" onclick="rlp_quick_view('<?php echo $adata->id ?>');" style="cursor: pointer;padding: 2% 2%; font-weight: bold; background-color: <?php echo get_status_color($adata->rrr_status); ?>">
                                <span>
                                    <?php echo (isset($adata->rrr_no) && !empty($adata->rrr_no) ? $adata->rrr_no : 'No data'); ?>
                                </span>
                            </div> 
							<div title="RRR quick view" style="cursor: pointer;padding: 2% 2%; font-weight: bold; background-color: <?php echo get_status_color($adata->rrr_status); ?>">
                                <span>
                                    <?php echo (isset($adata->rrr_no) && !empty($adata->rrr_no) ? $adata->rrr_no : 'No data'); ?>
                                </span>
                            </div>
                        </td> 
                        <td><?php echo (isset($adata->request_date) && !empty($adata->request_date) ? human_format_date($adata->created_at) : 'No data'); ?></td>
                        <td><?php echo getDivisionNameById(isset($adata->request_division) && !empty($adata->request_division) ? $adata->request_division : 'No data'); ?></td>
						<td>
                            <div style="padding: 2% 5%; font-weight: bold; background-color: <?php echo get_status_color($adata->rrr_status); ?>">
                                <?php echo get_status_name($adata->rrr_status); ?>
                            </div>
                        </td>
						-->
						
                        <td>
							<center><a title="Requester" class="btn btn-sm btn-info"><b><?php echo (isset($adata->name) && !empty($adata->name) ? $adata->name : 'No data'); ?></b></a></center>
						</td>
						<td>
							<center><a title="Requester" class="btn btn-sm btn-info"><b><?php echo (isset($adata->eel_code) && !empty($adata->eel_code) ? $adata->eel_code : 'No data'); ?></b></a></center>
						</td>
						<td>
							<center><b><?php echo (isset($adata->capacity) && !empty($adata->capacity) ? $adata->capacity : 'No data'); ?></b></center>
						</td>
						<td>
							<center><b><?php echo (isset($adata->makeby) && !empty($adata->makeby) ? $adata->makeby : 'No data'); ?></b></center>
						</td>
						<td>
							<center><b><?php echo (isset($adata->model) && !empty($adata->model) ? $adata->model : 'No data'); ?></b></center>
						</td>
						<td>
							<center><b><?php 
									$dataresult =   getDataRowByTableAndId('projects', $adata->project_id);
									echo (isset($dataresult) && !empty($dataresult) ? $dataresult->project_name : '');
							?></b></center>
						</td>
						<td>
							<center><b><?php echo (isset($adata->present_location) && !empty($adata->present_location) ? $adata->present_location : 'No data'); ?></b></center>
						</td>
						<td>
							<center><b><?php echo (isset($adata->present_condition) && !empty($adata->present_condition) ? $adata->present_condition : 'No data'); ?></b></center>
						</td>
						
						
                        
                        <td style="text-align:center">
                            
							
							<?php if(hasAccessPermission($user_id_session, 'crlp', 'edit_access')){ ?>
                            <a title="Details View" class="btn btn-sm btn-info" href="equipment_shifting.php?id=<?php echo $adata->id; ?>">
                                <span class="fa fa-exchange"> <b>Take Action</b></span>
                            </a>
                            <?php } ?>
							
							

							<!-- <?php if(hasAccessPermission($user_id_session, 'crlp', 'edit_access')){ ?>
                            <a title="Print RLP" class="btn btn-sm btn-info bg-blue" href="javascript:void(0)">
                                <span class="fa fa-print"></span>
                            </a>
                            <?php } ?>	 


                           <?php if(hasAccessPermission($user_id_session, 'crlp', 'delete_access')){ ?>
                            <a title="Delete RRR" class="btn btn-sm btn-danger" href="javascript:void(0)" onclick="commonDeleteOperation('<?php echo $delUrl ?>', '<?php echo $adata->id ?>');">
                                <span class="fa fa-close"> Delete</span>
                            </a>
                            <?php } ?>	 -->						
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