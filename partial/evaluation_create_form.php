<?php
    $currentUserId  =   $_SESSION['logged']['user_id'];
    if(!empty($_SESSION['logged']['branch_id']) && !empty($_SESSION['logged']['department_id'])){
	if (isset($_POST['evaluation_create']) && !empty($_POST['evaluation_create'])){	
    // create employee object:
		$int_id = $_POST['int_id']; 	
	 ?>
	<div class="row">
		<div class="col-md-12">
		<h3>Candidates Evaluation Form</h3>
			<table class="table table-bordered">
				<tr>
					<td colspan="2">Interview Details : <?php echo $int_id; ?> | Interview Date : 17th April 2022</td>
				</tr>
				<tr>
					<td width="20%">Interviewer :</td>
					<td>-----</td>
				</tr>
			</table>
		</div>
		<div class="col-md-12">
				<?php
				$table = 'candidates';
				$order = 'ASC';
				$column = 'name';
				$dataType = 'obj';
				$agencyData = getTableDataByTableName($table, $order, $column, $dataType);
				if (isset($agencyData) && !empty($agencyData)) {
				?>
			<table id="rlp_list_table" class="table table-bordered table-striped list-table-custom-style">
				<thead>
					<tr>
						<th>Candidatess</th>
						<th>Expected Salary</th>
						<th>Agreed Salary</th>
						<th colspan="2">Action</th>  
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ($agencyData as $adata) {
						?>
						<tr id="row_id_<?php echo $adata->id; ?>">
							<td><?php echo (isset($adata->name) && !empty($adata->name) ? $adata->name : 'No data'); ?> | Phone:<?php echo (isset($adata->phone) && !empty($adata->phone) ? $adata->phone : 'No data'); ?></td>
							<td width="10%"><input type="text" class="form-control" value="50000"/></td>
							<td width="10%"><input type="text" class="form-control" value=""/></td>
							<td width="10%">
								<a title="Details" class="btn btn-sm btn-success"  data-toggle="modal" data-target="#myView1<?php echo $adata->id; ?>"><span class="fa fa-eye"> Details</span></a>
							</td>
							<td width="10%">
								<a title="Details" class="btn btn-sm btn-danger"  data-toggle="modal" data-target="#myView<?php echo $adata->id; ?>"><span class="fa fa-eye"> Evaluate</span></a>
							</td>
						</tr>
						<!-- Evaluate Modal View -->
						<div class="modal fade" id="myView<?php echo $adata->id; ?>" role="dialog">
							<div class="modal-dialog">
							  <!-- Modal content-->
							  <?php include('partial/evaluation_form.php'); ?>
							</div>
						</div>
					<?php } ?>
				</tbody>
			</table>
			<?php } ?>
		</div>
	</div>
    <?php }}else{ ?>
    <div class="alert alert-warning">
      <strong>Warning!</strong> Access Denied .
    </div>
    <?php } ?>