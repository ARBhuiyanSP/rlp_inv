
	<?php
		$currentUserId  =   $_SESSION['logged']['user_id'];
		if(!empty($_SESSION['logged']['branch_id']) && !empty($_SESSION['logged']['department_id'])){
    ?>
<div class="box-body">
	<?php

    ?>
	<table id="example" class="table table-bordered table-striped list-table-custom-style">
		<thead>
			<tr>
				<th>#</th>
				<!-- <th>Requisition No</th> -->
				<th>Interview ID</th>
				<th>Candidate</th>
				<th>Status</th>
				<th style="background-color: #3C8DBC;color: #fff;">Action</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$sl = 0;
			$delUrl =   "function/notesheet_processing.php?process_type=notesheet_delete";
					$rrrListData = getNotesheetListFromEvaluation();
					if (isset($rrrListData) && !empty($rrrListData)) {
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
					<td><?php echo (isset($adata->request_date) && !empty($adata->request_date) ? human_format_date($adata->created_at) : 'No data'); ?></td>   -->
					<td> 
						<center><a title="Requester" class="btn btn-sm btn-info"><b><?php echo (isset($adata->int_id) && !empty($adata->int_id) ? $adata->int_id : 'No data'); ?></b></a></center>
					</td>
					<td> 
						<center><a title="Requester" class="btn btn-sm btn-info"><b><?php echo getCandidateNameById(isset($adata->can_id) && !empty($adata->can_id) ? $adata->can_id : 'No data'); ?></b></a></center>
					</td>
					 <!--- <td class="text-center"><?php echo getDivisionNameById(isset($adata->request_division) && !empty($adata->request_division) ? $adata->request_division : 'No data'); ?></td>
					
					<td class="text-center"><?php echo getDesignationNameById($adata->req_designation) ?></td>
					
					<td class="text-center"><?php echo getPriorityNameDiv(isset($adata->priority) && !empty($adata->priority) ? $adata->priority : 'No data'); ?></td>   -->
					<td class="text-center">
						<div style="padding: 2% 5%; font-weight: bold; background-color: <?php echo get_status_color($adata->final_recommendation); ?>">
							<?php echo get_status_name($adata->final_recommendation); ?>
						</div>
					</td>
					<td class="text-right">
						<?php if(hasAccessPermission($user_id_session, 'crlp', 'edit_access')){
							if($adata->final_recommendation == '7'){
								$link='rrr_draft.php?draft_id';
							}else{
								$link='rrr_update.php?rrr_id';
							}
							?>
						<a title="Approve RRR" class="btn btn-sm btn-info" href="<?php echo $link;?>=<?php echo $adata->id; ?>">
							<span class="fa fa-crosshairs"> <b>Details</b></span>
						</a>
						<?php } ?>
						
						
						<?php if(hasAccessPermission($user_id_session, 'crlp', 'edit_access')){ ?>
						<a title="Approve RRR" class="btn btn-sm btn-primary" onclick="notesheet_quick_view('<?php echo $adata->id ?>');">
							<span class="fa fa-comments"> Comments</span>
						</a>
						<?php } ?> 
						
						<!--- <?php if(hasAccessPermission($user_id_session, 'crlp', 'edit_access')){ ?>
						<a title="View" class="btn btn-sm btn-info bg-olive" href="rrr_view.php?rrr_id=<?php echo $adata->id; ?>">
							<span class="fa fa-print"> Print</span>
						</a>
						<?php } ?>  
						
						<?php if(hasAccessPermission($user_id_session, 'crlp', 'edit_access')){ ?>
						<a title="Approve RRR" class="btn btn-sm btn-primary" onclick="rrr_quick_view('<?php echo $adata->id ?>');">
							<span class="fa fa-comments"> Comments</span>
						</a>
						<?php } ?>
						
						<?php if(hasAccessPermission($user_id_session, 'crlp', 'edit_access')){ ?>
						<a title="Approve RRR" class="btn btn-sm btn-success" href="javascript:void(0)" onclick="commonApproveOperation('<?php echo $approveUrl ?>', '<?php echo $adata->id ?>');">
							<span class="fa fa-hand-pointer-o"> Approve</span>
						</a>
						<?php } ?>
						
						<?php if(hasAccessPermission($user_id_session, 'crlp', 'edit_access')){ ?>
						<a title="Approve RRR" class="btn btn-sm btn-danger" href="#">
							<span class="fa fa-times-circle"> Reject</span>
						</a>
						<?php } ?> --->

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
<?php }} ?>
		</tbody>
	</table>
</div>
    <?php }else{ ?>
<div class="alert alert-warning">
	<strong>Warning!</strong> Undefine Access .
</div>
    <?php } ?>
