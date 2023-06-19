<?php
    $currentUserId  =   $_SESSION['logged']['user_id'];
    if(!empty($_SESSION['logged']['branch_id']) && !empty($_SESSION['logged']['department_id'])){
		
    
    // create employee object:

    $emp_ob     =   new  Employee;
    $all_employees  =   $emp_ob->get_all_employees();
    
?>
    <div class="row justify-content-center mt-0">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 text-center p-0 mt-3 mb-2">
            <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
                <h2><strong>Interview Creation Form</strong></h2>
                <p>Fill all form field to go to next step</p>
                <div class="row">
                    <div class="col-md-12 mx-0">
                        <form method="post" id="register_form">
						<ul class="nav nav-tabs">
							<li class="nav-item">
								<a class="nav-link active_tab1" style="border:1px solid #ccc" id="list_login_details">Interview Information</a>
							</li>
							<li class="nav-item">
								<a class="nav-link inactive_tab1" id="list_personal_details" style="border:1px solid #ccc">Board Member</a>
							</li>
							<li class="nav-item">
								<a class="nav-link inactive_tab1" id="list_contact_details" style="border:1px solid #ccc">Candidates</a>
							</li>
						</ul>
						<div class="tab-content" style="margin-top:16px;">
							<div class="tab-pane active" id="login_details">
								<div class="row">
									<div class="col-md-6">
										<div class="panel panel-default">
											<div class="panel-body">
												<div class="row">
													<div class="col-sm-6">
														<div class="form-group">
															<label>Interview date</label>
															<input type="text" name="date" id="rlpdate" class="form-control" value="<?php echo date("Y-m-d"); ?>" autocomplete="off" />
															<span id="error_date" class="text-danger"></span>
														</div>
													</div>
													<div class="col-sm-6">
														<div class="form-group">
															<label>Interview time</label>
															<input type="password" name="password" id="password" class="form-control" />
															<span id="error_password" class="text-danger"></span>
														</div>
													</div>
													<div class="col-sm-12">
														<div class="form-group">
															<label for="exampleId">Location</label>
															<input name="date" type="text" class="form-control" id="" value="" autocomplete="off" required />
														</div>
													</div>
												</div>
												<br />
											</div>
										</div>
									</div>
									<div class="col-md-6"></div>
									<br />
									<div class="col-md-12">
										<div align="center">
											<button type="button" name="btn_interview_details" id="btn_interview_details" class="btn btn-info btn-block">Save and Next</button>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane fade" id="personal_details">
								<div class="panel panel-default">
									<div class="panel-body">
										<div class="form-group">
											<label>Enter First Name</label>
											<input type="text" name="first_name" id="first_name" class="form-control" />
											<span id="error_first_name" class="text-danger"></span>
										</div>
										<div class="form-group">
											<label>Enter Last Name</label>
											<input type="text" name="last_name" id="last_name" class="form-control" />
											<span id="error_last_name" class="text-danger"></span>
										</div>
										<div class="form-group">
											<label>Gender</label>
											<label class="radio-inline">
												<input type="radio" name="gender" value="male" checked> Male
											</label>
											<label class="radio-inline">
												<input type="radio" name="gender" value="female"> Female
											</label>
										</div>
										<br />
										<div align="center">
											<button type="button" name="previous_btn_personal_details" id="previous_btn_personal_details" class="btn btn-default btn-lg">Previous</button>
											<button type="button" name="btn_personal_details" id="btn_personal_details" class="btn btn-info btn-lg">Next</button>
										</div>
										<br />
									</div>
								</div>
							</div>
							<div class="tab-pane fade" id="contact_details">
								<div class="panel panel-default">
									<div class="panel-body">
										<div class="form-group">
											<label>Enter Address</label>
											<textarea name="address" id="address" class="form-control"></textarea>
											<span id="error_address" class="text-danger"></span>
										</div>
										<div class="form-group">
											<label>Enter Mobile No.</label>
											<input type="text" name="mobile_no" id="mobile_no" class="form-control" />
											<span id="error_mobile_no" class="text-danger"></span>
										</div>
										<br />
										<div align="center">
											<button type="button" name="previous_btn_contact_details" id="previous_btn_contact_details" class="btn btn-default btn-lg">Previous</button>
											<button type="button" name="btn_contact_details" id="btn_contact_details" class="btn btn-success btn-lg">Register</button>
										</div>
										<br />
									</div>
								</div>
							</div>
						</div>
					    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
 <?php }else{ ?>
    <div class="alert alert-warning">
      <strong>Warning!</strong> Division and Department are required to create Interview .
    </div>
    <?php } ?>