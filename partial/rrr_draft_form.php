<?php
    $currentUserId  =   $_SESSION['logged']['user_id'];
    if(!empty($_SESSION['logged']['branch_id']) && !empty($_SESSION['logged']['department_id'])){
		
    
    // create employee object:

    $emp_ob     =   new  Employee;
    $all_employees  =   $emp_ob->get_all_employees();
    


    $rrr_id         =   $_GET['draft_id'];    
    $rrr_details    =   getRRRDetailsData($rrr_id);   
    $rrr_info       =   $rrr_details['rrr_info'];
    $rrr_details    =   $rrr_details['rrr_info'];
?>
<form action="" method="post">
    <div class="row">
        
				<input type="hidden" name="rrr_no" value="<?php echo $rrr_info->rrr_no; ?>" placeholder="(To be filled in by HRD)">
				<input type="text" name="rrr_id" value="<?php echo $rrr_info->id; ?>">
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
					
                    <label><input type="radio" name="priority" value="1" <?php if($rrr_info->priority == '1'){ echo 'checked';} ?>> <span class="label label-danger">Urgent</span> </label>
                    <label><input type="radio" name="priority" value="4" <?php if($rrr_info->priority == '4'){ echo 'checked';} ?>> <span class="label label-success">Normal</span> </label>
                </div>
            </div>
        </div>
		<div class="col-sm-3">
            <div class="form-group">
				<label for="division/company">Recruitment Required For:</label>
                <div class="radio">
                    <label><input type="radio" name="req_for" value="NewPosition" <?php if($rrr_info->req_for == 'NewPosition'){ echo 'checked';} ?>> <span class="label label-danger">New Position</span> </label>
                    <label><input type="radio" name="req_for" value="replacement" <?php if($rrr_info->req_for == 'replacement'){ echo 'checked';} ?>> <span class="label label-success">Replacement</span> </label>
                </div>
			</div>
        </div>
		<div class="col-sm-3">
            <div class="form-group">
				<label for="division/company">Employee Type:</label>
                <select class="form-control" id="emp_type" name="emp_type" required >
					<option value="">Please select</option>
					<option value="management" <?php if($rrr_info->emp_type == 'management'){ echo 'selected';} ?>>Management</option>
					<option value="non-management" <?php if($rrr_info->emp_type == 'non-management'){ echo 'selected';} ?>>Non-management</option>
					<option value="contractual"<?php if($rrr_info->emp_type == 'contractual'){ echo 'selected';} ?>>Contractual</option>
					<option value="temporary"<?php if($rrr_info->emp_type == 'temporary'){ echo 'selected';} ?>>Temporary</option>
				</select>
			</div>
        </div>
    </div>
	<div class="row">
        <div class="col-sm-3">
            <div class="form-group">
                <label for="exampleId">Requested By</label>
                <select class="all_emplyees form-control" name="req_by" id="req_by" onchange="get_requested_by_information();" required >
					<option value="">Please select</option>
					<?php
						if(isset($all_employees) && !empty($all_employees)){
							foreach($all_employees as $emp){ ?>
								<option value="<?php echo $emp->emp_id ?>" <?php if($rrr_info->request_person == $emp->emp_name){ echo 'selected';} ?>><?php echo $emp->emp_name.' ('.$emp->emp_id.')'; ?></option>
							<?php }
						}
					?>
				</select>
            </div>
        </div>
		<div class="col-sm-3">
            <div class="form-group">
				<label for="division/company">Division/Company</label>
                <input class="form-control" type="text" id="req_by_division" name="req_by_division" value="<?php echo getDivisionNameById($rrr_info->request_division);?>">
			</div>
        </div>
		<div class="col-sm-3">
            <div class="form-group">
				<label for="division/company">Department</label>
                <input class="form-control" type="text" id="department_id" name="req_by_department" value="<?php echo getDepartmentNameById($rrr_info->request_department);?>">
			</div>
        </div>
		<div class="col-sm-3">
            <div class="form-group">
				<label for="division/company">Designation</label>
                <input class="form-control" type="text" id="designation" name="req_by_designation" value="<?php echo getDesignationNameById($rrr_info->designation);?>">
			</div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleId">Justification for Recruitment:</label>
                <textarea class="form-control" id="" name="justification_for_rec" ><?php echo $rrr_info->justification_for_rec; ?></textarea>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleId">Remark/Special Requirements (if any):</label>
                <textarea class="form-control" id="" name="rem_spe_rec"><?php echo $rrr_info->rem_spe_rec; ?></textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
			<div class="row">
			<center><h3>Particulars</h3></center>
				<div class="col-md-4">
					<div class="form-group">
						<label for="exampleId">Company--:</label>
						<select class="form-control" id="reqcompany" name="req_company" onchange="" >
							<option value="">Please select</option>
						</select>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="exampleId">Division:</label>
						<select class="form-control" id="reqdivision" name="req_division" onchange="getDepartmentByBranches(this.value);" required >
							<option value="">Please select</option>
							<?php
							$table = "branch";
							$order = "ASC";
							$column = "name";
							$datas = getTableDataByTableName($table, $order, $column);
							foreach ($datas as $data) {
								?>
								<option value="<?php echo $data->id; ?>" <?php if($rrr_info->req_for_division == $data->id){ echo 'selected';} ?>><?php echo $data->name; ?></option>
		<?php } ?>
						</select>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="exampleId">Branch--:</label>
						<select class="form-control" id="reqbranch" name="req_branch" onchange="" >
							<option value="">Please select</option>
						</select>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="exampleId">Department:</label>
						<select class="form-control" id="reqdepartment" name="req_department" required >
							<option value="">Please select</option>
							<?php
							$table = "department";
							$order = "ASC";
							$column = "name";
							$datas = getTableDataByTableName($table, $order, $column);
							foreach ($datas as $data) {
								?>
								<option value="<?php echo $data->id; ?>" <?php if($rrr_info->req_for_department == $data->id){ echo 'selected';} ?>><?php echo $data->name; ?></option>
								<?php } ?>
						</select>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="exampleId">Designation:</label>
						<select class="form-control" id="req_designation" name="req_designation" required >
							<option value="">Please select</option>
							<?php
							$table = "designations";
							$order = "ASC";
							$column = "name";
							$datas = getTableDataByTableName($table, $order, $column);
							foreach ($datas as $data) {
								?>
								<option value="<?php echo $data->id; ?>" <?php if($rrr_info->req_designation == $data->id){ echo 'selected';} ?>><?php echo $data->name; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="exampleId">Grade:</label>
						<select class="all_emplyees form-control" id="req_grade" name="req_grade" >
							<option value="">Please select</option>
							<?php
							for( $i=1; $i<=20; $i++ )
								{
								 ?>
								<option value="<?php echo $i; ?>">Grade-<?php echo $i; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label for="exampleId">Required Number:</label>
						<input class="form-control" type="text" id="req_number" name="req_number" value="<?php echo $rrr_info->req_number; ?>" required >
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label for="exampleId">Location:</label>
						<input class="form-control" type="text" id="req_location_project" name="req_location_project" value="<?php echo $rrr_info->req_location_project; ?>">
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label for="exampleId">ReportingManager:</label>
						<input class="form-control" type="text" id="req_reporting_man" name="req_reporting_man" value="<?php echo $rrr_info->req_reporting_man; ?>">
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label for="exampleId">Budgeted Salary:</label>
						<input class="form-control" type="text" id="req_salary" name="req_salary" value="<?php echo $rrr_info->req_salary; ?>">
					</div>
				</div>
				<div class="col-md-6">
					 <label for="exampleId">Key Responsibilites:</label>
					<textarea class="form-control" id="" name="req_responsibilities"><?php echo $rrr_info->req_responsibilities; ?></textarea>
				</div>
				<div class="col-md-6">
					 <label for="exampleId">Requester Remarks:</label>
					<textarea class="form-control" id="" name="remarks"><?php echo $rrr_info->user_remarks; ?></textarea>
				</div>
			</div>
		</div>
        <div class="col-md-6"><?php echo get_user_department_wise_rrr_chain_for_create(); ?></div>
    </div>

    <div class="row" style="padding-top:5px;">
        <div class="col-sm-6">
            <input type="submit" name="rrr_create_draft" id="submit" class="btn btn-block btn-primary" value="Submit Request" />
        </div>
		<div class="col-sm-6">
            <input type="" name="" id="submit" class="btn btn-block btn-info" value="Update As Draft" />
        </div>
    </div>
</form>

    <?php }else{ ?>
    <div class="alert alert-warning">
      <strong>Warning!</strong> Division and Department are required to create RLP .
    </div>
    <?php } ?>