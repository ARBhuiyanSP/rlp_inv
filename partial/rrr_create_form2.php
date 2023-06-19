<?php
    $currentUserId  =   $_SESSION['logged']['user_id'];
    if(!empty($_SESSION['logged']['branch_id']) && !empty($_SESSION['logged']['department_id'])){
		
    
    // create employee object:

    $emp_ob     =   new  Employee;
    $all_employees  =   $emp_ob->get_all_employees();
    
    ?>
<form action="" method="post">
    <div class="row">
        <input type="hidden" name="rrr_no" value="SPL-0001" placeholder="(To be filled in by HRD)">
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
                    <label><input type="radio" name="priority" value="Urgent"> <span class="label label-success">Urgent</span> </label>
                    <label><input type="radio" name="priority" value="Normal"> <span class="label label-danger">Normal</span> </label>
                </div>
            </div>
        </div>
		<div class="col-sm-3">
            <div class="form-group">
				<label for="division/company">Recruitment Required For:</label>
                <div class="radio">
                    <label><input type="radio" name="req_for" value="NewPosition"> <span class="label label-success">New Position</span> </label>
                    <label><input type="radio" name="req_for" value="replacement"> <span class="label label-danger">Replacement</span> </label>
                </div>
			</div>
        </div>
		<div class="col-sm-3">
            <div class="form-group">
				<label for="division/company">Employee Type:</label>
                <select class="all_emplyees form-control" id="emp_type" name="emp_type">
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
                <label for="exampleId">Requested By</label>
                <select class="all_emplyees form-control" name="req_by" id="req_by" onchange="get_requested_by_information();">
					<option value="">Please select</option>
					<?php
						if(isset($all_employees) && !empty($all_employees)){
							foreach($all_employees as $emp){ ?>
								<option value="<?php echo $emp->emp_id ?>"><?php echo $emp->emp_name.' ('.$emp->emp_id.')'; ?></option>
							<?php }
						}
					?>
				</select>
            </div>
        </div>
		<div class="col-sm-3">
            <div class="form-group">
				<label for="division/company">Division/Company</label>
                <input class="form-control" type="text" id="req_by_division" name="req_by_division">
			</div>
        </div>
		<div class="col-sm-3">
            <div class="form-group">
				<label for="division/company">Department</label>
                <input class="form-control" type="text" id="department_id" name="req_by_department">
			</div>
        </div>
		<div class="col-sm-3">
            <div class="form-group">
				<label for="division/company">Designation</label>
                <input class="form-control" type="text" id="designation" name="req_by_designation">
			</div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleId">Justification for Recruitment:</label>
                <textarea class="form-control" id="" name="justification_for_rec"></textarea>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleId">Remark/Special Recruitment (if any):</label>
                <textarea class="form-control" id="" name="rem_spe_rec"></textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <center><p>Particulars :</p></center>
		<div class="col-md-3">
            <div class="form-group">
                <label for="exampleId">Division/Company:</label>
                <select class="form-control" id="reqdivision" name="req_division" onchange="getDepartmentByBranches(this.value);">
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
        <div class="col-md-3">
            <div class="form-group">
                <label for="exampleId">Department:</label>
                <select class="form-control" id="reqdepartment" name="req_department">
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
        <div class="col-md-3">
            <div class="form-group">
                <label for="exampleId">Designation:</label>
                <select class="form-control" id="req_designation" name="req_designation">
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
        <div class="col-md-3">
            <div class="form-group">
                <label for="exampleId">Grade:</label>
                <select class="all_emplyees form-control" id="req_grade" name="req_grade">
					<option value="">Please select</option>
					<option value="grade-01">Grade-01</option>
					<option value="grade-02">Grade-02</option>
					<option value="grade-03">Grade-03</option>
				</select>
            </div>
        </div>
    </div>
	<div class="row">
		<div class="col-md-3">
            <div class="form-group">
                <label for="exampleId">Required Number:</label>
                <input class="form-control" type="text" id="req_number" name="req_number">
            </div>
        </div>
		<div class="col-md-3">
            <div class="form-group">
                <label for="exampleId">Location:</label>
                <input class="form-control" type="text" id="req_location_project" name="req_location_project">
            </div>
        </div>
		<div class="col-md-3">
            <div class="form-group">
                <label for="exampleId">Reporting Manager:</label>
                <input class="form-control" type="text" id="req_reporting_man" name="req_reporting_man">
            </div>
        </div>
		<div class="col-md-3">
            <div class="form-group">
                <label for="exampleId">Budgeted Salary:</label>
                <input class="form-control" type="text" id="req_salary" name="req_salary">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
             <label for="exampleId">Key Responsibilites:</label>
			<textarea class="form-control" id="" name="req_responsibilities"></textarea>
        </div>
        <div class="col-md-6">
             <label for="exampleId">Requester Remarks:</label>
			<textarea class="form-control" id="" name="remarks"></textarea>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php echo get_user_department_wise_rrr_chain_for_create(); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <input type="submit" name="rrr_create" id="submit" class="btn btn-block btn-primary" value="Request" />
        </div>
    </div>
</form>

    <?php }else{ ?>
    <div class="alert alert-warning">
      <strong>Warning!</strong> Division and Department are required to create RLP .
    </div>
    <?php } ?>