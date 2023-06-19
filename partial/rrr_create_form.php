<?php
    $currentUserId  =   $_SESSION['logged']['user_id'];
    if(!empty($_SESSION['logged']['branch_id']) && !empty($_SESSION['logged']['department_id'])){
		
    
    // create employee object:

    $emp_ob     =   new  Employee;
    $all_employees  =   $emp_ob->get_all_employees();
    
    ?>
<form action="" method="post">
    <div class="row">
        
				<?php $rrrNo    =   get_rrr_no(); ?>
				<input type="hidden" name="rrr_no" value="<?php echo $rrrNo; ?>" placeholder="(To be filled in by HRD)">
        <div class="col-sm-3">
            <div class="form-group">
                <label for="exampleId">Date</label>
                <input name="date" type="text" class="form-control" id="rlpdate" value="<?php echo date("Y-m-d"); ?>" size="30" autocomplete="off" required />
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label for="exampleId">Priority</label>
				<div class="radio">
                    <label><input type="radio" name="priority" value="1"> <span class="label label-danger">Urgent</span> </label>
                    <label><input type="radio" name="priority" value="4" checked > <span class="label label-success">Normal</span> </label>
                </div>
            </div>
        </div>
		<div class="col-sm-3">
            <div class="form-group">
				<label for="division/company">Recruitment Required For:</label>
                <div class="radio">
                    <label><input type="radio" name="req_for" value="NewPosition" checked > <span class="label label-danger">New Position</span> </label>
                    <label><input type="radio" name="req_for" value="replacement"> <span class="label label-success">Replacement</span> </label>
                </div>
			</div>
        </div>
		<div class="col-sm-3">
            <div class="form-group">
				<label for="division/company">Employee Type:</label>
                <select class="all_emplyees form-control" id="emp_type" name="emp_type" required >
					<option value="">Please select</option>
					<option value="management">Management</option>
					<option value="non-management">Non-management</option>
					<option value="contractual">Contractual</option>
					<option value="temporary">Temporary</option>
				</select>
			</div>
        </div>
    </div>
	<div class="row">
        <div class="col-sm-3">
            <div class="form-group">
			<?php 
				$rrr_user_office_id    = $_SESSION['logged']['office_id'];
				$request_division      = $_SESSION['logged']['branch_id'];
				$request_department    = $_SESSION['logged']['department_id'];
				$designation           = $_SESSION['logged']['designation'];
			?>
                <label for="req_by">Requested By</label>
                <select class="all_emplyees form-control" name="req_by" id="req_by" onchange="get_requested_by_information();" required >
					<option value="">Please select</option>
					<?php
						if(isset($all_employees) && !empty($all_employees)){
							foreach($all_employees as $emp){
								if($rrr_user_office_id == $emp->emp_id){
										$selected	= 'selected';
										}else{
										$selected	= '';
										}
										?>
								<option value="<?php echo $emp->emp_id ?>" <?php echo $selected; ?>><?php echo $emp->emp_name.' ('.$emp->emp_id.')'; ?></option>
							<?php }
						}
					?>
				</select>
            </div>
        </div>
		<div class="col-sm-3">
            <div class="form-group">
				<label for="division/company">Division/Company</label>
                <input class="form-control" type="text" id="req_by_division" name="req_by_division" value="<?php echo getDivisionNameById($request_division); ?>">
			</div>
        </div>
		<div class="col-sm-3">
            <div class="form-group">
				<label for="division/company">Department</label>
                <input class="form-control" type="text" id="department_id" name="req_by_department" value="<?php echo getDepartmentNameById($request_department); ?>">
			</div>
        </div>
		<div class="col-sm-3">
            <div class="form-group">
				<label for="division/company">Designation</label>
                <input class="form-control" type="text" id="designation" name="req_by_designation" value="<?php echo getDesignationNameById($designation); ?>">
			</div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleId">Justification for Recruitment:</label>
                <textarea class="form-control" id="" name="justification_for_rec" ></textarea>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleId">Remark/Special Requirements (if any):</label>
                <textarea class="form-control" id="" name="rem_spe_rec"></textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
			<div class="row">
			<center><h5 style="background-color:#F0EFEF;padding:5px;">Particulars</h5></center>
				<div class="col-md-3">
					<div class="form-group">
						<label for="exampleId">Company:</label>
						<select class="all_emplyees form-control" id="reqcompany" name="req_company" onchange="" >
							<option value="">Please select</option>
							<option value="Saif Powertec Ltd">Saif Powertec Ltd</option>
							<option value="Blueline Communications Ltd">Blueline Communications Ltd</option>
							<option value="E-Engineering Ltd">E-Engineering Ltd</option>
							<option value="Maxon Power Ltd">Maxon Power Ltd</option>
							<option value="Saif Electrical Manufacturing Ltd">Saif Electrical Manufacturing Ltd</option>
							<option value="Saif Global Sports Ltd">Saif Global Sports Ltd</option>
							<option value="SAIF Maritime Ltd">SAIF Maritime Ltd</option>
							<option value="Saif Port Holdings Ltd">Saif Port Holdings Ltd</option>
						</select>
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<label for="exampleId">Division:</label>
						<select class="form-control select2" id="reqdivision" name="req_division" onchange="getDepartmentByBranches(this.value);" required >
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
				<div class="col-md-2">
					<div class="form-group">
						<label for="exampleId">Branch--:</label>
						<select class="all_emplyees form-control" id="reqbranch" name="req_branch" onchange="" >
							<option value="">Please select</option>
						</select>
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<label for="exampleId">Department:</label>
						<select class="all_emplyees form-control" id="reqdepartment" name="req_department" required >
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
				<div class="col-md-2">
					<div class="form-group">
						<label for="exampleId">Designation:</label>
						<select class="all_emplyees form-control" id="req_designation" name="req_designation" required >
							<option value="">Please select</option>
							<?php
							$table = "designations";
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
				<!-- <div class="col-md-4">
					<div class="form-group">
						<label for="exampleId">Grade:</label>
						<select class="all_emplyees form-control" id="req_grade" name="req_grade" >
							<option value="">Please select</option>
							<?php
							//for( $i=1; $i<=20; $i++ )
								//{
								 ?>
								<option value="<?php //echo $i; ?>">Grade-<?php //echo $i; ?></option>
							<?php //} ?>
						</select>
					</div>
				</div> -->
				<div class="col-md-1">
					<div class="form-group">
						<label for="exampleId">Posts:</label>
						<input class="form-control" type="text" id="req_number" name="req_number" required >
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<label for="exampleId">Location:</label>
						<input class="form-control" type="text" id="req_location_project" name="req_location_project">
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<label for="exampleId">Reporting Person:</label>
						<input class="form-control" type="text" id="req_reporting_man" name="req_reporting_man">
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<label for="exampleId">Budgeted Salary:</label>
						<input class="form-control" type="text" id="req_salary" name="req_salary">
					</div>
				</div>
				<div class="col-md-3">
					 <label for="exampleId">Key Responsibilites:</label>
					<!-- <textarea class="form-control" id="" name="req_responsibilities"></textarea> -->
					<input class="form-control" type="text" id="" name="req_responsibilities">
				</div>
				<div class="col-md-3">
					 <label for="exampleId">Requester Remarks:</label>
					<!--  <textarea class="form-control" id="" name="remarks"></textarea> -->
					<input class="form-control" type="text" id="" name="remarks">
				</div>
			</div>
		</div>
        <div class="col-md-6"></div>
        <div class="col-md-6">
			<button type="button" class="btn btn-danger" data-toggle="collapse" data-target="#collapse" style="float:right;"><i class="fa fa-tags" aria-hidden="true"></i> Approval Chain</button>
			<div id="collapse" class="collapse">
				<?php echo get_user_department_wise_rrr_chain_for_create(); ?>
			</div>
		</div>
    </div>

    <div class="row" style="padding-top:5px;">
        <div class="col-sm-6">
            <input type="submit" name="rrr_create" id="submit" class="btn btn-block btn-primary" value="Submit Request" />
        </div>
		<div class="col-sm-6">
            <input type="submit" name="rrr_draft" id="submit" class="btn btn-block btn-info" value="Save As Draft" />
        </div>
    </div>
</form>

    <?php }else{ ?>
    <div class="alert alert-warning">
      <strong>Warning!</strong> Division and Department are required to create RLP .
    </div>
    <?php } ?>