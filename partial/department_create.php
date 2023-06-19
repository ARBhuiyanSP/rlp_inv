<form role="form" method="post">
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
					<label for="exampleInputEmail1">Name</label>
					<input type="text" class="form-control" id="name" placeholder="Enter name" name="name">
				</div>
            </div>
			<div class="col-md-6">
                <div class="form-group">
                    <label for="sel1">Division:</label>
                    <select class="form-control" id="branch_id" name="branch_id" onchange="getDepartmentByBranch(this.value);">
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
        </div>
    </div>
    <!-- /.box-body -->

    <div class="box-footer">
        <input type="submit" name="department_create" class="btn btn-primary btn-block" value="Create">
    </div>
</form>