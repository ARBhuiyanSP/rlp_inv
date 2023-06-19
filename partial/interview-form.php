<?php
$currentUserId  =   $_SESSION['logged']['user_id'];
if (!empty($_SESSION['logged']['branch_id']) && !empty($_SESSION['logged']['department_id'])) {


	// create employee object:

	$emp_ob     =   new  Employee;
	$all_employees  =   $emp_ob->get_all_employees();


	$table = 'candidates';
	$order = 'ASC';
	$column = 'name';
	$dataType = 'obj';
	$agencyData = getTableDataByTableName($table, $order, $column, $dataType);

?>
	<div class="row justify-content-center mt-0">
		<div class="col-12 col-sm-12 col-md-12 col-lg-12 p-0 mt-3 mb-2">
			<div class="card px-0 pt-4 pb-0 mt-3 mb-3">
				<h2 class="text-center"><strong>Interview Creation Form</strong></h2>
				<p class="text-center">Fill all form field to go to next step</p>
				<div class="row">
					<div class="col-md-12 mx-0">
						<form method="post" id="interview_register_form">
							<ul class="nav nav-tabs">
								<li class="nav-item">
									<a class="nav-link active_tab1" style="border:1px solid #ccc" id="list_interview_time_details">Interview Information</a>
								</li>
								<li class="nav-item">
									<a class="nav-link inactive_tab1" id="list_candidate_details" style="border:1px solid #ccc">Candidates</a>
								</li>
								<li class="nav-item">
									<a class="nav-link inactive_tab1" id="list_personal_details" style="border:1px solid #ccc">Board Member</a>
								</li>
								
							</ul>
							<div class="tab-content" style="margin-top:16px;">
								<div class="tab-pane active" id="interview_time_details">
									<div class="row">
										<div class="col-md-6">
											<div class="panel panel-default">
												<div class="panel-body">
													<div class="row">
														<?php $interview_id    =   get_interview_id(); ?>
														<div class="col-sm-4">
															<div class="form-group">
																<label>Interview ID</label>
																<input type="text" name="code" id="code" class="form-control" value="<?php echo $interview_id ?>" autocomplete="off" readonly />
															</div>
														</div>
														<div class="col-sm-4">
															<div class="form-group">
																<label>Enter Date</label>
																<input type="text" name="date" id="date" class="form-control" autocomplete="off" />
																<span id="error_date" class="text-danger"></span>
															</div>
														</div>
														<div class="col-sm-4">
															<div class="form-group">
																<label>Enter Time</label>
																<input type="text" name="time" id="time" class="form-control" />
																<span id="error_time" class="text-danger"></span>
															</div>
														</div>
														<div class="col-sm-12">
															<div class="form-group">
																<label>Enter Location</label>
																<input type="text" name="location" id="location" class="form-control" />
																<span id="error_location" class="text-danger"></span>
															</div>
														</div>
													</div>
													<br />
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div id="" class="test" style=""> </div>
											<!-------->
											<script>
												$(function() {
													var t = $('.test').bootstrapTransfer({
														'target_id': 'multi-select-input',
														'height': '12em',
														'hilite_selection': true
													});
													<?php 
													$rrrListData = getRRRListData();
													
													?>
													t.populate([
														<?php foreach ($rrrListData as $adata) { ?> {
																value: "<?php echo (isset($adata->id) && !empty($adata->id) ? $adata->id : 'No data'); ?>",
																content: "<?php echo (isset($adata->rrr_no) && !empty($adata->rrr_no) ? $adata->rrr_no : 'No data'); ?>"
															},
														<?php } ?>
													]);
													//t.set_values(["2", "4"]);
													//console.log(t.get_values());
												});
											</script>
											<!-------->
										</div>
										<br />
										<div class="col-md-12">
											<div align="center">
												<button type="button" name="btn_interview_time_details" id="btn_interview_time_details" class="btn btn-info btn-lg">Next</button>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="candidate_details">
									<div class="panel panel-default">
										<div class="panel-body">
											<div class="row">
												<div class="col-sm-6">
													<h3> Select Candidates</h3>
													<div class="row">
														<div class="col-sm-6">
															<div class="input-group">
																<input type="text" class="form-control" placeholder="Type Names" name="search">
																<div class="input-group-btn">
																	<button class="form-control btn btn-info" type=""> Search</button>
																</div>
															</div>
														</div>
														<div class="col-sm-3">
															<button class="form-control btn btn-success" type="button" id="add_new_candidate">Add New</button>
														</div>
													</div>

													<div id="candidate_show_area">
														
													</div>

													
												</div>
												<div class="col-sm-6">
													<div class="form-group">
														<label>Selected Candidates</label>
													</div>

													<div class="table-responsive">          
														<table class="table">
															<thead>
																<tr>
																	<th style="width: 60%">Name</th>
																	<th style="width: 15%">Action</th>
																</tr>
															</thead>
															<tbody id="candidate_selection"></tbody>
														</table>
													</div>

												</div>
											</div>
											<br />
											<div align="center">
												<button type="button" name="previous_btn_candidate_details" id="previous_btn_candidate_details" class="btn btn-default btn-lg">Previous</button>
												
												<button type="button" name="btn_candidate_details" id="btn_candidate_details" class="btn btn-info btn-lg">Next</button>
											</div>
											<br />
										</div>
									</div>
								</div>

								<div class="tab-pane fade" id="personal_details">
									<div class="panel panel-default">
										<div class="panel-body">
											<div class="form-group">
												<label>Select Board Member</label>
												<div id="" class="bom" style=""> </div>
												<!-------->
												<script>
													$(function() {
														var t = $('.bom').bomTransfer({
															'target_id': 'multi-select-input',
															'height': '12em',
															'hilite_selection': true
														});
														<?php //$rrrListData = getRRRListData(); 
														?>
														t.populate([
															<?php if (isset($all_employees) && !empty($all_employees)) {
																foreach ($all_employees as $emp) { ?> {
																		value: "<?php echo $emp->emp_id ?>",
																		content: "<?php echo $emp->emp_name ?>"
																	},
															<?php }
															} ?>
														]);
														//t.set_values(["2", "4"]);
														//console.log(t.get_values());
													});
												</script>
												<!-------->
											</div>
											<br />
											<div align="center">
												<button type="button" name="previous_btn_personal_details" id="previous_btn_personal_details" class="btn btn-default btn-lg">Previous</button>
												<!-- <button onclick="interview_data_process();" type="submit" name="interview_create" id="btn_personal_details" class="btn btn-success btn-lg">Register</button> -->
												<input type="submit" name="interview_create" class="btn btn-success btn-lg" value="Register">
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
<?php } else { ?>
	<div class="alert alert-warning">
		<strong>Warning!</strong> Division and Department are required to create Interview .
	</div>
<?php } ?>