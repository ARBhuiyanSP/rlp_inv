<form role="form" method="post">
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="sel1">Group:</label>
                    <select class="form-control" id="row_number" name="row_number">
                        <option value="">Please select</option>
                        <?php
                        $datas      =   ['250','350','500'];
                        foreach ($datas as $data) {
                            ?>
                            <option value="<?php echo $data; ?>"><?php echo $data; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
        <!-- /.box-body -->

        <div class="box-footer">
            <input type="submit" name="user_import" class="btn btn-primary btn-block" value="Import">
        </div>
</form>