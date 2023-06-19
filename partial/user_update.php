<?php
$id = $_GET['user_id'];
$userData = getUserDataByid($id);
?>
<form id="uploading_images" role="form" method="post" enctype="multipart/form-data">
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
                            <option value="<?php echo $data->id; ?>"<?php if (isset($userData) && $userData->role_id == $data->id) {
                            echo "selected";
                        } ?>><?php echo $data->name; ?></option>
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
                            <option value="<?php echo $data->id; ?>"<?php if (isset($userData) && $userData->branch_id == $data->id) {
                            echo "selected";
                        } ?>><?php echo $data->name; ?></option>
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
                            <option value="<?php echo $data->id; ?>"<?php if (isset($userData) && $userData->department_id == $data->id) {
                                echo "selected";
                            } ?>><?php echo $data->name; ?></option>
<?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleId">Office-ID</label>
                    <input type="text" class="form-control" id="office_id" placeholder="Enter ID" name="office_id" value="<?php if (isset($userData->office_id) && !empty($userData->office_id)) {
    echo $userData->office_id;
} ?>">
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
                        <option value="<?php echo $data->id; ?>"<?php if (isset($userData) && $userData->designation == $data->id) {
                                echo "selected";
                            } ?>><?php echo $data->name; ?></option>
<?php } ?>
                </select>
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Name</label>
            <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" value="<?php if (isset($userData->name) && !empty($userData->name)) {
    echo $userData->name;
} ?>">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Email</label>
            <input type="text" class="form-control" id="email" placeholder="Enter email" name="email" value="<?php if (isset($userData->email) && !empty($userData->email)) {
    echo $userData->email;
} ?>">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Password</label>
            <input type="text" class="form-control" id="password" placeholder="Enter password" name="password" value="">
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="form-group">
                    <label class="control-label">Signature</label>
                    <input type="hidden" name="sn_old_image" value="<?php if (isset($userData->signature_image) && !empty($userData->signature_image)) {
    echo $userData->signature_image;
} ?>"  />
                    <input type="file" name="sn_prt_image"  id="imgInp" onChange="uploadImage(this)"  class="filestyle" data-buttonname="btn-default">
                    <p class="help-block">Please select image file like jpg, png or gif</p>
                </div>
            </div>
            <div class="col-md-4">
                <?php if(isset($userData->signature_image) && !empty($userData->signature_image)){ ?>
                <img id='img-upload' style="height:100px;" class="img-thumbnail" src="images/signatures/<?php if (isset($userData->signature_image) && !empty($userData->signature_image)) {
    echo $userData->signature_image;
} ?>"  style="background-color:#9972B5;"/>
                <?php }else{ ?>
                <div class="alert alert-info">
                    <strong>Info!</strong> No signature image found.
                </div>
                <?php } ?>
            </div>
        </div>

        <script>
            $(document).ready(function () {
                $(document).on('change', '.btn-file :file', function () {
                    var input = $(this),
                            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                    input.trigger('fileselect', [label]);
                });

                $('.btn-file :file').on('fileselect', function (event, label) {

                    var input = $(this).parents('.input-group').find(':text'),
                            log = label;

                    if (input.length) {
                        input.val(log);
                    } else {
                        if (log)
                            alert(log);
                    }

                });
                function readURL(input) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();

                        reader.onload = function (e) {
                            $('#img-upload').attr('src', e.target.result);
                        }

                        reader.readAsDataURL(input.files[0]);
                    }
                }

                $("#imgInp").change(function () {
                    readURL(this);
                });
            });


            function uploadImage(_this) {
                const file = _this.files[0];
                const  fileType = file['type'];
                const validImageTypes = ['image/gif', 'image/jpeg', 'image/png'];
                if (!validImageTypes.includes(fileType)) {
                    swal('Please select an image! Fill is not an image')
                    document.getElementById("uploading_images").reset();
                } else {
                    swal('All good, image has been selected')
                }
            }
        </script>

    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        <input type="hidden" name="edit_id" value="<?php echo $userData->id; ?>">
        <input type="submit" name="user_create" class="btn btn-primary btn-block" value="Update">
    </div>
</form>