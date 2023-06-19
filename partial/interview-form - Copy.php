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
                        <form id="msform">
                            <!-- progressbar -->
                            <ul id="progressbar">
                                <li class="active" id="account"><strong>Interview Information</strong></li>
                                <li id="personal"><strong>Personal</strong></li>
                                <li id="payment"><strong>Payment</strong></li>
                                <li id="confirm"><strong>Finish</strong></li>
                            </ul> <!-- fieldsets -->
							
							
                            <fieldset>
                                <div class="form-card">
									<div class="row">
										<div class="col-md-6">
											<div class="row">
												<div class="col-sm-12">
													<div class="form-group">
														<label for="exampleId">Date</label>
														<input name="date" type="text" class="form-control" id="rlpdate" value="<?php echo date("Y-m-d"); ?>" size="30" autocomplete="off" required />
													</div>
												</div>
												<div class="col-sm-12">
													<div class="form-group">
														<label for="exampleId">Time</label>
														<input name="time" type="text" class="form-control" id="" value="" size="30" autocomplete="off" required />
													</div>
												</div>
												<div class="col-sm-12">
													<div class="form-group">
														<label for="exampleId">Location</label>
														<input name="date" type="text" class="form-control" id="" value="" autocomplete="off" required />
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-6">sdsd</div>
									</div>
								</div> 
								<input type="button" name="next" class="next action-button" value="Next Step" />
                            </fieldset>
							
							
							
                            <fieldset>
                                <div class="form-card">
                                    <h2 class="fs-title">Personal Information</h2> <input type="text" name="fname" placeholder="First Name" /> <input type="text" name="lname" placeholder="Last Name" /> <input type="text" name="phno" placeholder="Contact No." /> <input type="text" name="phno_2" placeholder="Alternate Contact No." />
                                </div> <input type="button" name="previous" class="previous action-button-previous" value="Previous" /> <input type="button" name="next" class="next action-button" value="Next Step" />
                            </fieldset>
                            <fieldset>
                                <div class="form-card">
                                    <h2 class="fs-title">Payment Information</h2>
                                    <div class="radio-group">
                                        <div class='radio' data-value="credit"><img src="https://i.imgur.com/XzOzVHZ.jpg" width="200px" height="100px"></div>
                                        <div class='radio' data-value="paypal"><img src="https://i.imgur.com/jXjwZlj.jpg" width="200px" height="100px"></div> <br>
                                    </div> <label class="pay">Card Holder Name*</label> <input type="text" name="holdername" placeholder="" />
                                    <div class="row">
                                        <div class="col-9"> <label class="pay">Card Number*</label> <input type="text" name="cardno" placeholder="" /> </div>
                                        <div class="col-3"> <label class="pay">CVC*</label> <input type="password" name="cvcpwd" placeholder="***" /> </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-3"> <label class="pay">Expiry Date*</label> </div>
                                        <div class="col-9"> <select class="list-dt" id="month" name="expmonth">
                                                <option selected>Month</option>
                                                <option>January</option>
                                                <option>February</option>
                                                <option>March</option>
                                                <option>April</option>
                                                <option>May</option>
                                                <option>June</option>
                                                <option>July</option>
                                                <option>August</option>
                                                <option>September</option>
                                                <option>October</option>
                                                <option>November</option>
                                                <option>December</option>
                                            </select> <select class="list-dt" id="year" name="expyear">
                                                <option selected>Year</option>
                                            </select> </div>
                                    </div>
                                </div> <input type="button" name="previous" class="previous action-button-previous" value="Previous" /> <input type="button" name="make_payment" class="next action-button" value="Confirm" />
                            </fieldset>
                            <fieldset>
                                <div class="form-card">
                                    
                                    <div class="row">
                                        <div class="col-md-12">
											<center>
												<h2 class="">Success !</h2> <br><br>
												<img src="https://img.icons8.com/color/96/000000/ok--v2.png" class="img-responsive" height="100px;">
											</center> 
										</div>
                                    </div> <br><br>
                                    <div class="row justify-content-center">
                                        <div class="col-md-12 text-center">
                                            <h5>You Have Successfully Signed Up</h5>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
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