<form action="" method="post">
    <div class="row">
        <div class="col-sm-3">
			<div class="form-group">
				<label for="sel1">Division:</label>
				<select class="form-control" id="branch_id" name="branch_id" onchange="getDepartmentByBranch(this.value);">
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
        <div class="col-sm-3">
            <div class="form-group">
				<label for="sel1">Department:</label>
				<select class="form-control" id="department_id" name="department_id">
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
        <div class="col-sm-3">
            <div class="form-group">
                <label for="exampleId">From Date</label>
                <input name="fromdate" type="text" class="form-control" id="fromdate" value="<?php echo date("Y-m-d"); ?>" size="30" autocomplete="off"  />
            </div>
        </div>
		<div class="col-sm-3">
            <div class="form-group">
                <label for="exampleId">To Date</label>
                <input name="todate" type="text" class="form-control" id="todate" value="<?php echo date("Y-m-d"); ?>" size="30" autocomplete="off"  />
            </div>
        </div>
        <div class="col-sm-12">
            <div class="form-group form-inline">
                <label for="exampleId">Status : </label>
                <div class="radio">
                    <label><input type="radio" name="status" value="all" checked> All</label>
					<?php
                        $table = "status_details";
                        $order = "ASC";
                        $column = "name";
                        $datas = getTableDataByTableName($table, $order, $column);
                        foreach ($datas as $data) {
                    ?>
					<label><input type="radio" name="status" value="<?php echo $data->id; ?>"> <?php echo $data->name; ?></label>
					<?php } ?>
					
					
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <input type="submit" name="submit" id="submit" class="btn btn-block btn-primary" value="Request" />
        </div>
    </div>
</form>
<?php include 'function/search_process.php';?>