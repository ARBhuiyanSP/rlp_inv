<div class="form-group">
    <select class="form-control" id="division_id" name="division_id" onchange="getDepartmentByBranch(this.value);get_user_list_data_division_department(this.value, '');">
        <option value="">Division</option>

        <?php
        $table = 'branch';
        $order = 'ASC';
        $column = 'name';
        $dataType = 'obj';
        $resData = getTableDataByTableName($table, $order, $column, $dataType);
        if (isset($resData) && !empty($resData)) {
            foreach ($resData as $res) {
                ?>
                <option value="<?php echo $res->id; ?>"><?php echo $res->name; ?></option>
            <?php
            }
        }
        ?>
    </select>
</div>