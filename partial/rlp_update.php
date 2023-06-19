<?php
    $currentUserId  =   $_SESSION['logged']['user_id'];
    $rlp_id         =   $_GET['rlp_id'];    
    $rlp_details    =   getRlpDetailsData($rlp_id);   
    $rlp_info       =   $rlp_details['rlp_info'];
    $rlp_details    =   $rlp_details['rlp_details'];
?>
<!-- Main content -->
<section class="invoice">
    <!-- title row -->
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                <i class="fa fa-file"></i> RLP Details.
                <small class="pull-right">Priority: <?php echo getPriorityNameDiv($rlp_info->priority) ?></small>
            </h2>
        </div>
        <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-md-4 invoice-col">
            From
            <address>
                <strong>Name:&nbsp;<?php echo $rlp_info->request_person ?></strong><br>
                Designation:&nbsp;<?php echo getDesignationNameById($rlp_info->designation) ?><br>
                Division:&nbsp;<?php echo getDivisionNameById($rlp_info->request_division) ?><br>
                Department:&nbsp;<?php echo getDepartmentNameById($rlp_info->request_department) ?><br>
                Contact:&nbsp;<?php echo $rlp_info->contact_number ?><br>
                Email:&nbsp;: <?php echo $rlp_info->email ?>
            </address>
        </div>
        <!-- /.col -->
        <div class="col-md-8 invoice-col">
            <div class="pull-right">
                <b>RLP NO: &nbsp;<span class="rlpno_style"><?php echo $rlp_info->rlp_no ?></span></b><br>
                <b>Request Date:</b> <?php echo human_format_date($rlp_info->created_at) ?><br>
            </div>            
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <form id="rlp_product_supplier_assign_form">
        <div class="row">
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Item Description</th>
                            <th>Purpose of Purchase</th>
                            <th>Quantity</th>
                            <th>Estimated Price</th>
                            <th>Supplier</th>
                            <th>Remarks</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="tbl_posts_body">
                        <?php
                        $sl =   1;
                        $dataid =   1;
                            foreach($rlp_details as $data){
                        ?>
                        <tr id="rec-1">
                            <td><?php echo $sl++; ?></td>
                            <td><?php echo $data->item_des; ?></td>
                            <td><?php echo $data->purpose; ?></td>
                            <td><?php echo $data->quantity; ?></td>
                            <td><?php echo $data->estimated_price; ?></td>
                            <?php if(is_super_admin($currentUserId)){ ?>
                            <td>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="supplier[<?php echo $data->id; ?>]" value="<?php echo (isset($data->supplier) && !empty($data->supplier) ? $data->supplier : ""); ?>">
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="details_remarks[<?php echo $data->id; ?>]" value="<?php echo (isset($data->details_remarks) && !empty($data->details_remarks) ? $data->details_remarks : ""); ?>">
                                </div>
                            </td>
							<td><a class="btn btn-xs delete-record" data-id="<?php echo $dataid++; ?>"><i class="glyphicon glyphicon-trash"></i></a></td>
                            <?php }else{ ?>
                            <td><?php echo $data->supplier; ?></td>
                            <td><?php echo $data->details_remarks; ?></td>
                            <?php } ?>
                        </tr>                        
                            <?php } ?>
                        <?php if(is_super_admin($currentUserId)){ ?>
                        <tr>
                            <td colspan="7">
                                <button type="button" class="btn btn-primary btn-block" onclick="execute_rlp_supplier_update_form('rlp_product_supplier_assign_form');">Update Supplier</button>
                            </td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
				<table class="table table-striped table-bordered">
				 <?php if(is_member($currentUserId)){ ?>
                        <tr>
                            <td colspan="6">
                                <button type="button" class="btn btn-primary btn-block" onclick="execute_rlp_supplier_update_form('rlp_product_supplier_assign_form');">Update RLP</button>
                            </td>
							<td>
                                <a class="btn btn-primary pull-right add-record" data-added="0"><i class="glyphicon glyphicon-plus"></i> Add Another Item</a>
                            </td>
                        </tr>
                        <?php } ?>
				</table>
            </div>
            <!-- /.col -->
        </div>
    </form>
	<div style="display:none;">
		<table id="sample_table">
			<tr id="">
				<td><span class="sn"></span>.</td>
				<td><input type="text" class="form-control" id="" name="description[]" value="" size=""  required /></td>
				<td><input type="text" class="form-control" id="" name="purpose[]" value="" size=""  required /></td>
				<td><input type="text" class="form-control" id="" name="quantity[]" value="" size=""  required /></td>
				<td><input type="text" class="form-control" id="" name="estimatedPrice[]" value="" size=""  required /></td>
				<td><a class="btn btn-xs delete-record" data-id="0"><i class="glyphicon glyphicon-trash"></i></a></td>
			</tr>
		</table>
	</div>
    <!-- /.row -->
    <?php
    $role       =   get_role_group_short_name();
    
    if(is_super_admin($currentUserId)){
        include 'rlp_update_view_sa.php';
    }elseif($role    ==  "member"){
        include 'rlp_update_view_member.php';
    }elseif($role    ==  "dh"){
        include 'rlp_update_view_dh.php';
    }elseif($role    ==  "ab"){
        include 'rlp_update_view_ab.php';
    }else{
        include 'rlp_update_view_dh.php';
    }
    ?>
</section>
<!-- /.content -->
<div class="clearfix"></div>