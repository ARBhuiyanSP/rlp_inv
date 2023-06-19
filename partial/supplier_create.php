<form role="form" method="post">
    <div class="box-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
					<label for="exampleId">Supplier ID</label>
					<?php $supplier_id    =   get_supplier_id(); ?>
					<div class="rlpno_style"><?php echo $supplier_id; ?></div>
					<input type="hidden" name="supplier_id" value="<?php echo $supplier_id; ?>">
				</div>
            </div>
            <div class="col-md-8">
                <div class="form-group">
					<label for="exampleInputEmail1">Supplier Name</label>
					<input type="text" class="form-control" id="company" placeholder="Enter name" name="company" required>
				</div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
					<label for="exampleInputEmail1">Supplier Address</label>
					<input type="text" class="form-control" id="address" placeholder="Enter name" name="address" required>
				</div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
					<label for="exampleInputEmail1">Contact Person</label>
					<input type="text" class="form-control" id="contact_person" placeholder="Enter name" name="contact_person" required>
				</div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
					<label for="exampleInputEmail1">Phone</label>
					<input type="text" class="form-control" id="phone" placeholder="Enter phone" name="phone" required>
				</div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
					<label for="exampleInputEmail1">Email</label>
					<input type="text" class="form-control" id="email" placeholder="Enter phone" name="email" required>
				</div>
            </div>
        </div>
    </div>
    <!-- /.box-body -->

    <div class="box-footer">
        <input type="submit" name="supplier_create" class="btn btn-primary btn-block" value="Create">
    </div>
</form>