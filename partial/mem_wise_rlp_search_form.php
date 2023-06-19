<form action="" method="post">
    <div class="row">
        <div class="col-sm-4">
			<div class="form-group">
				<label>Member Name</label>
				<select class="select2 form-control" id="member" name="member">
                        <option value="0">Please select</option>
                        <?php
                        $table = "users";
                        $order = "ASC";
                        $column = "name";
                        $datas = getTableDataByTableName($table, $order, $column);
                        foreach ($datas as $data) {
                            ?>
						<option value="<?php echo $data->id; ?>"><?php echo $data->name; ?> | Office-ID : <?php echo $data->office_id; ?></option>
<?php } ?>
				</select>
			</div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="exampleId">From Date</label>
                <input name="fromdate" type="text" class="form-control" id="fromdate" value="<?php echo date("Y-m-d"); ?>" size="30" autocomplete="off"  />
            </div>
        </div>
		<div class="col-sm-4">
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
<?php include 'function/member_search_process.php';?>