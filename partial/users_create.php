<form role="form" method="post">
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="sel1">Group:</label>
                    <select class="form-control" id="group_id" name="group_id">
                        <option value="">Please select</option>
                        <?php
                        $table = "roles";
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
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="sel1">Department:</label>
                    <select class="form-control" id="department_id" name="department_id">
                        <option value="">Please select</option>
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
            <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleId">Office-ID</label>
                    <input type="text" class="form-control" id="office_id" placeholder="Enter ID" name="office_id">
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Designation</label>
                <select class="form-control" id="designation" name="designation">
                    <option value="">Please select</option>
                    <?php
                    $table = "designations";
                    $order = "ASC";
                    $column = "name";
                    $datas = getTableDataByTableName($table, $order, $column);
                    foreach ($datas as $data) {
                        ?>
                        <option value="<?php echo $data->id; ?>"><?php echo $data->name; ?></option>
<?php } ?>
                </select>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Name</label>
            <input type="text" class="form-control" id="name" placeholder="Enter name" name="name">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Email</label>
            <input type="text" class="form-control" id="email" placeholder="Enter email" name="email">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Password</label>
            <input type="text" class="form-control" id="password" placeholder="Enter password" name="password" value="">
        </div>
    </div>
    <!-- /.box-body -->

    <div class="box-footer">
        <input type="submit" name="user_create" class="btn btn-primary btn-block" value="Create">
    </div>
</form>