<?php
    $currentUserId  =   $_SESSION['logged']['user_id'];
    if(!empty($_SESSION['logged']['branch_id']) && !empty($_SESSION['logged']['department_id'])){
?>
<form action="" method="post">
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label for="exampleId">Date</label>
                <input name="date" type="text" class="form-control" id="rlpdate" value="<?php echo date("Y-m-d"); ?>" size="30" autocomplete="off" required />
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="exampleId">Priority</label>
                <div class="radio">
                    <?php
                        $priorities     =   get_priorities();
                        if(isset($priorities) && !empty($priorities)){
                            foreach($priorities as $priority){
                    ?>
                            <label><input type="radio" name="priority" value="<?php echo $priority->id; ?>" <?php if($priority->name == 'Low'){ echo 'checked';} ?>>                                
                                <span class="label label-<?php echo $priority->color_code; ?>"><?php echo $priority->name; ?></span>
                            </label>
                    <?php
                    } 
                        }
                    ?>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label for="exampleId">RLP No</label>
                <?php $rlpNo    =   get_rlp_no(); ?>
                <div class="rlpno_style"><?php echo $rlpNo; ?></div>
                <input type="hidden" name="rlp_no" value="<?php echo $rlpNo; ?>">
            </div>
        </div>
    </div>
    <table class="table table-bordered" id="tbl_posts">
        <thead>
            <tr>
                <th>SL No</th>
                <th>Item Description</th>
                <th>Purpose of Purchase</th>
                <th>Quantity</th>
                <th>Estimated Price</th>
                <?php if(is_super_admin($currentUserId)){ ?>
                <th>Supplier</th>
                <th>Remarks</th>
                <?php } ?>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="tbl_posts_body">
            <tr id="rec-1">
                <td><span class="sn">1</span>.</td>
                <td><textarea class="form-control" id="" name="description[]" rows="1" required></textarea></td>
                <td><input type="text" class="form-control" id="" name="purpose[]" value="" size=""  required /></td>
                <td><input type="text" class="form-control" id="" name="quantity[]" value="" size=""  required /></td>
                <td><input type="text" class="form-control" id="" name="estimatedPrice[]" value="" size=""  /></td>
                <?php if(is_super_admin($currentUserId)){ ?>
                <td><input type="text" class="form-control" id="" name="supplier[]" value="" size=""/></td>
                <td><input type="text" class="form-control" id="" name="details_remarks[]" value="" size=""/></td>
                <?php } ?>
                <td><a class="btn btn-xs" data-id=""><i class="glyphicon glyphicon-trash"></i></a></td>
            </tr>
        </tbody>
    </table>
    <div class="row">
        <div class="col-md-12 pull-right">
            <div class="form-group">
                <a class="btn btn-primary pull-right add-record" data-added="0"><i class="glyphicon glyphicon-plus"></i> Add Another Item</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="exampleId">Remarks</label>
                <textarea class="form-control" id="remarks" name="remarks"></textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php echo get_user_department_wise_rlp_chain_for_create(); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <input type="submit" name="rlp_create" id="submit" class="btn btn-block btn-primary" value="Request" />
        </div>
    </div>
</form>
<div style="display:none;">
    <table id="sample_table">
        <tr id="">
            <td><span class="sn"></span>.</td>
            <td><textarea class="form-control" id="" name="description[]" rows="1" required></textarea></td>
            <td><input type="text" class="form-control" id="" name="purpose[]" value="" size=""  required /></td>
            <td><input type="text" class="form-control" id="" name="quantity[]" value="" size=""  required /></td>
            <td><input type="text" class="form-control" id="" name="estimatedPrice[]" value="" size="" /></td>
		 <?php if(is_super_admin($currentUserId)){ ?>
			<td><input type="text" class="form-control" id="" name="supplier[]" value="" size=""/></td>
			<td><input type="text" class="form-control" id="" name="details_remarks[]" value="" size=""/></td>
		 <?php } ?>
            <td><a class="btn btn-xs delete-record" data-id="0"><i class="glyphicon glyphicon-trash"></i></a></td>
        </tr>
    </table>
</div>

    <?php }else{ ?>
    <div class="alert alert-warning">
      <strong>Warning!</strong> Division and Department are required to create RLP .
    </div>
    <?php } ?>