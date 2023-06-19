
<?php
$id = $_GET['employee_id'];
$userData = getUserDataByid($id);
?>
<div class="row">
            <div class="col-sm-12">
			<!-- Widget: user widget style 1 -->
			<div class="box box-widget widget-user">
				<!-- Add the bg color to the header using any of the bg-* classes -->
				<div class="widget-user-header bg-aqua-active">
					<h3 class="widget-user-username"><?php if (isset($userData->name) && !empty($userData->name)) {
    echo $userData->name;
} ?></h3>
					<h5 class="widget-user-desc"><?php if (isset($userData->designation) && !empty($userData->designation)) {
    echo getDesignationNameById($userData->designation);
} ?></h5>
				</div>
				<div class="widget-user-image">
					<img class="img-circle" src="images/default-user.png" alt="User Avatar">
				</div>
				<div class="box-footer">
					<div class="row">
						<div class="col-sm-4 border-right">
								<h5 class="">Division: <?php if (isset($userData->branch_id) && !empty($userData->branch_id)) {
    echo getDivisionNameById($userData->branch_id);
} ?></h5>
						<!-- /.description-block -->
						</div>
						<div class="col-sm-4 border-right">
								<h5 class="">Department: <?php if (isset($userData->department_id) && !empty($userData->department_id)) {
    echo getDepartmentNameById($userData->department_id);
} ?></h5>
						<!-- /.description-block -->
						</div>
						<div class="col-sm-4 border-right">
								<h5 class="">Office-ID:<?php if (isset($userData->office_id) && !empty($userData->office_id)) {
    echo $userData->office_id;
} ?></h5>
						<!-- /.description-block -->
						</div> 
						<!-- /.col -->
					<!-- /.col -->
					</div>
				<!-- /.row -->
				</div>
			</div>
			<!-- /.widget-user -->
			</div>
        </div>
<form id="uploading_images" role="form" method="post" enctype="multipart/form-data">
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
					<label for="exampleInputEmail1">New Password</label>
					<input type="text" class="form-control" id="password" placeholder="Enter password" name="password" value="">
				</div>
            </div>
			<div class="col-md-6">
                <div class="form-group">
					<label for="exampleInputEmail1">Confirm Password</label>
					<input type="text" class="form-control" id="confirm_password" placeholder="Enter password" name="confirm_password" value="">
				</div>
            </div>
        </div>

        <script>
			var password = document.getElementById("password")
			  , confirm_password = document.getElementById("confirm_password");

			function validatePassword(){
			  if(password.value != confirm_password.value) {
				confirm_password.setCustomValidity("Passwords Don't Match");
			  } else {
				confirm_password.setCustomValidity('');
			  }
			}

			password.onchange = validatePassword;
			confirm_password.onkeyup = validatePassword;
        </script>

    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        <input type="hidden" name="edit_id" value="<?php echo $userData->id; ?>">
        <input type="submit" name="member_update" class="btn btn-primary btn-block" value="Update">
    </div>
</form>