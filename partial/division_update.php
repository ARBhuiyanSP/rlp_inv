<?php
$id = $_GET['division_id'];
$divisionData = getDivisionDataByid($id);
?>
<form id="uploading_images" role="form" method="post" enctype="multipart/form-data">
    <div class="box-body">
        <div class="form-group">
            <label for="exampleInputEmail1">Name</label>
            <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" value="<?php if (isset($divisionData->name) && !empty($divisionData->name)) {
    echo $divisionData->name;
} ?>">
        </div>

    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        <input type="hidden" name="edit_id" value="<?php echo $divisionData->id; ?>">
        <input type="submit" name="division_create" class="btn btn-primary btn-block" value="Update">
    </div>
</form>