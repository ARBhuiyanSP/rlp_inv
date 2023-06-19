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
		<input name="date" type="hidden" value="<?php echo date("Y-m-d"); ?>" />
		<div class="col-sm-3">
            <div class="form-group">
                <label for="exampleId">Candidate Name</label>
                <input name="name" type="text" class="form-control" id="" value="" size="" autocomplete="off" required />
            </div>
        </div>
		<div class="col-sm-3">
            <div class="form-group">
                <label for="exampleId">Candidate Email</label>
                <input name="name" type="text" class="form-control" id="" value="" size="" autocomplete="off" required />
            </div>
        </div>
		<div class="col-sm-2">
            <div class="form-group">
                <label for="exampleId">Cell Number</label>
                <input name="name" type="text" class="form-control" id="" value="" size="" autocomplete="off" required />
            </div>
        </div>
		<div class="col-sm-2">
            <div class="form-group">
                <label for="exampleId">Date of Birth</label>
                <input name="date" type="text" class="form-control" id="rlpdate" value="<?php echo date("Y-m-d"); ?>" size="30" autocomplete="off" required />
            </div>
        </div>
    </div>
	<div class="row">
        <div class="col-sm-3">
            <div class="form-group">
                <label for="exampleId">Forwarded/Referred By:</label>
                <select class="all_emplyees form-control" name="req_by" id="req_by" onchange="get_requested_by_information();" required >
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
		<div class="col-sm-2">
            <div class="form-group">
				<label for="division/company">Last Exam/Degree Title</label>
                <input class="form-control" type="text" id="designation" name="req_by_designation">
			</div>
        </div>
		<div class="col-sm-2">
            <div class="form-group">
				<label for="division/company">Last Degree Subject</label>
                <input class="form-control" type="text" id="designation" name="req_by_designation">
			</div>
        </div>
		<div class="col-sm-3">
            <div class="form-group">
				<label for="division/company">Last Degree Institution</label>
                <input class="form-control" type="text" id="designation" name="req_by_designation">
			</div>
        </div>
		<div class="col-sm-2">
            <div class="form-group">
				<label for="division/company">Passing Year</label>
                <input class="form-control" type="text" id="designation" name="req_by_designation">
			</div>
        </div>
		<div class="col-sm-2">
            <div class="form-group">
				<label for="division/company">Total Experience</label>
                <input class="form-control" type="text" id="designation" name="req_by_designation">
			</div>
        </div>
		<div class="col-sm-2">
            <div class="form-group">
				<label for="division/company">Experience With DDC</label>
                <input class="form-control" type="text" id="designation" name="req_by_designation">
			</div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label for="exampleId">Upload CV</label>
                <input class="form-control" type="file" id="designation" name="req_by_designation">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleId">Remarks</label>
                <textarea class="form-control" id="" name="justification_for_rec" ></textarea>
            </div>
        </div>
    </div>

    <div class="row" style="padding-top:5px;">
        <div class="col-sm-12">
            <input type="submit" name="rrr_create" id="submit" class="btn btn-block btn-primary" value="Submit Request" />
        </div>
    </div>
</form>

    <?php }else{ ?>
    <div class="alert alert-warning">
      <strong>Warning!</strong> Division and Department are required to create RLP .
    </div>
    <?php } ?>