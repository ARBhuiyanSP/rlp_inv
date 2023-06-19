<?php
$id = $_GET['department_id'];
$userData = getDepartmentDataByid($id);
?>
<form id="uploading_images" role="form" method="post" enctype="multipart/form-data">
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
					<label for="exampleInputEmail1">Name</label>
					<input type="text" class="form-control" id="name" placeholder="Enter name" name="name" value="<?php if (isset($userData->name) && !empty($userData->name)) {
			echo $userData->name;
		} ?>">
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
                            <option value="<?php echo $data->id; ?>"<?php if (isset($userData) && $userData->branch_id == $data->id) {
                            echo "selected";
                        } ?>><?php echo $data->name; ?></option>
<?php } ?>
                    </select>
                </div>
            </div>
        </div>
        


    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        <input type="hidden" name="edit_id" value="<?php echo $userData->id; ?>">
        <input type="submit" name="department_create" class="btn btn-primary btn-block" value="Update">
    </div>
</form>