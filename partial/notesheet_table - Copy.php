<style>
.modal-dialog{
	width:800px !important;
}
.btn{
	padding:3px 12px !important;
}
</style>
<?php
    $currentUserId  =   $_SESSION['logged']['user_id'];
    if(!empty($_SESSION['logged']['branch_id']) && !empty($_SESSION['logged']['department_id'])){
		
    
    // create employee object:

    //$emp_ob     =   new  Employee;
    //$all_employees  =   $emp_ob->get_all_employees();
    
    ?>
	<form method="GET">
		<div class="row">
			<div class="col-sm-3">
				<div class="form-group">
					<label for="exampleId">Date</label>
					<input name="date" type="text" class="form-control" id="rlpdate" value="<?php echo date("Y-m-d"); ?>" size="30" autocomplete="off" required />
				</div>
			</div>
			<div class="col-sm-3">
				<div class="form-group">
					<label for="exampleId">Interview ID</label>
					<select class="all_emplyees form-control" name="int_id" id="int_id" required >
						<option value="">Please select</option>
						<?php
							$table = 'interviews';
							$order = 'ASC';
							$column = 'code';
							$dataType = 'obj';
							$agencyData = getTableDataByTableName($table, $order, $column, $dataType);
							if (isset($agencyData) && !empty($agencyData)) {
								foreach ($agencyData as $adata) {
														if($_GET['int_id'] == $adata->code){
														$selected	= 'selected';
														}else
														{ 
														$selected	= ''; 
														}								?>
							<option value="<?php echo $adata->code ?>" <?php echo $selected; ?>><?php echo $adata->code; ?></option>
								<?php }
							}
						?>
					</select>
				</div>
			</div>
			<div class="col-sm-3">
				<div class="form-group">
					<label for="exampleId">-</label>
					<input type="submit" name="evaluation_create" id="submit" class="btn btn-block btn-primary" value="Search" />
				</div>
			</div>
		</div>
	</form>

    <?php }else{ ?>
    <div class="alert alert-warning">
      <strong>Warning!</strong> Undefine Access .
    </div>
    <?php } ?>
	<div class="box-body">
	 <?php
	if (isset($_GET['evaluation_create']) && !empty($_GET['evaluation_create'])){	
    // create employee object:
		$int_id = $_GET['int_id']; 	
	 ?>
	<div class="row text-center">
		<div class="col-md-12">
			<h3>Candidates Notesheet</h3>
			<table id="" class="table table-bordered">
				<tr>
					<td>Interview Details : <?php echo $int_id; ?> | Interview Date : 17th April 2022</td>
				</tr>
			</table>
		</div>
		<div class="col-md-12">
				<?php
				$table = 'interview_candiate';
				$order = 'ASC';
				//$column = 'name';
				$int_id = $int_id;
				$dataType = 'obj';
				$agencyData = getTableDataByTableNameAndIntId($table, $int_id, $dataType);
				if (isset($agencyData) && !empty($agencyData)) {
				?>
			<table id="rlp_list_table" class="table table-bordered table-striped list-table-custom-style">
				<thead>
					<tr>
						<th>Candidates</th>
						<th>Expected Salary</th>
						<th>Agreed Salary</th>
						<th colspan="2">Action</th>  
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ($agencyData as $adata) {
						 
							$int_id = $adata->interview_id; 
							$can_id = $adata->candidate_id;
							$table 	= 'evaluation_details';
							$sql = "SELECT * FROM $table WHERE `int_id`='$int_id' AND `can_id`='$can_id'";
							$result = $conn->query($sql);
							$row = mysqli_fetch_array($result);
						?>
						<tr id="row_id_<?php echo $adata->candidate_id; ?>">
							<td><?php echo getCandidatesNameByIdAndTable('candidates',$adata->candidate_id); ?></td>
							<td width="10%"><input type="text" class="form-control" value="<?php echo getCandidatesSalaryByIdAndTable('candidates',$adata->candidate_id); ?>"/></td>
							<td width="10%"><input type="text" class="form-control" value="<?php if (isset($row['salary_expectation']) && $row['salary_expectation'] != '') { echo $row['salary_expectation']; }?>"/></td>
							<td width="10%">
								<a title="Details" class="btn btn-sm btn-success"  data-toggle="modal" data-target="#myView1<?php echo $adata->candidate_id; ?>"><span class="fa fa-eye"> Details</span></a>
							</td>
							<td width="10%">
								<a title="Details" class="btn btn-sm btn-danger"  data-toggle="modal" data-target="#myView<?php echo $adata->candidate_id; ?>"><span class="fa fa-eye"> Evaluate</span></a>
							</td>
						</tr>
						<!-- Evaluate Modal View -->
						<div class="modal fade" id="myView<?php echo $adata->candidate_id; ?>" role="dialog">
							<div class="modal-dialog">
							  <!-- Modal content-->
							  <?php include('partial/evaluation_form.php'); ?>
							</div>
						</div>
						<!-- Evaluate Modal View -->
						<div class="modal fade" id="myView1<?php echo $adata->candidate_id; ?>" role="dialog">
							<div class="modal-dialog">
							  <!-- Modal content-->
							  <?php include('partial/evaluation_details.php'); ?>
							</div>
						</div>
					<?php } ?>
				</tbody>
			</table>
			<?php } ?>
		</div>
	</div>
    <?php }else{ ?>
    <!--- <div class="alert alert-warning">
      <strong>Select an Interview</strong> To Evaluate candidates .
    </div> --->
	
	<table id="example" class="table table-bordered table-striped list-table-custom-style" style="width: 100%;" width="100%">
            <thead>
                <tr> 
                    <th>SLN#</th>
                    <th>Group</th>
                    <th>Employee ID</th>
                    <th>Name</th>
                    <th>Designation</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
	
	
	
    <?php } ?>
	</div>
	<script>
	$(document).ready(function () {
    $('#example').DataTable();
});
	</script>