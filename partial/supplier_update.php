<?php
$id = $_GET['supplier_id'];
$userData = getSupplierDataByid($id);
?>
<form id="uploading_images" role="form" method="post" enctype="multipart/form-data">
    <div class="box-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
					<label for="exampleId">Supplier ID</label>
					<?php $supplier_id    =   $userData->supplier_id; ?>
					<div class="rlpno_style"><?php echo $supplier_id; ?></div>
					<input type="hidden" name="supplier_id" value="<?php echo $supplier_id; ?>">
				</div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
					<label for="exampleInputEmail1">Supplier Name</label>
					<input type="text" class="form-control" id="company" placeholder="Enter name" name="company" value="<?php if (isset($userData->company) && !empty($userData->company)) {
			echo $userData->company;
		} ?>">
				</div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
					<label for="exampleInputEmail1">Supplier Address</label>
					<input type="text" class="form-control" id="address" placeholder="Enter name" name="address" value="<?php if (isset($userData->address) && !empty($userData->address)) {
			echo $userData->address;
		} ?>">
				</div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
					<label for="exampleInputEmail1">Contact Person</label>
					<input type="text" class="form-control" id="contact_person" placeholder="Enter name" name="contact_person" value="<?php if (isset($userData->contact_person) && !empty($userData->contact_person)) {
			echo $userData->contact_person;
		} ?>">
				</div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
					<label for="exampleInputEmail1">Phone</label>
					<input type="text" class="form-control" id="phone" placeholder="Enter name" name="phone" value="<?php if (isset($userData->phone) && !empty($userData->phone)) {
			echo $userData->phone;
		} ?>">
				</div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
					<label for="exampleInputEmail1">Email</label>
					<input type="text" class="form-control" id="email" placeholder="Enter name" name="email" value="<?php if (isset($userData->email) && !empty($userData->email)) {
			echo $userData->email;
		} ?>">
				</div>
            </div>
        </div>
        


    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        <input type="hidden" name="edit_id" value="<?php echo $userData->id; ?>">
        <input type="submit" name="supplier_create" class="btn btn-primary btn-block" value="Update">
    </div>
</form>