<?php
$table = 'users';
$usersData = getDataRowByTable($table);
if (isset($usersData) && !empty($usersData)) {
    ?>
<table id="user_list_table" class="table table-bordered table-striped list-table-custom-style" style="width: 100%;" width="100%">
            <thead>
                <tr>
                    <th>SLN#</th>
                    <th>Group</th>
                    <th>
                        <?php echo get_division_select_box(); ?>
                    </th>
                    <th><?php echo get_department_select_box(); ?></th>
                    <th>Employee ID</th>
                    <th>Name</th>
                    <th>Designation</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
<?php } else { ?>
    <div class="alert alert-warning">
        <strong>Sorry there is no data!</strong>
    </div>
<?php } ?>