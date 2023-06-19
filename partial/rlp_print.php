<?php
    $currentUserId  =   $_SESSION['logged']['user_id'];
    $rlp_id         =   $_GET['rlp_id'];    
    $rlp_details    =   getRlpDetailsData($rlp_id);   
    $rlp_info       =   $rlp_details['rlp_info'];
    $rlp_details    =   $rlp_details['rlp_details'];
?>
<style>
.table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td{
	border: 1px solid #000000;
}
</style>
<!-- Main content -->
<section class="invoice" id="printableArea">
    <!-- title row -->
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                <i class="fa fa-globe"></i> RLP Details.
                <small class="pull-right">Priority: <?php echo getPriorityName($rlp_info->priority) ?></small>
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
                Department:&nbsp;<?php echo getNameByIdAndTable("department",$rlp_info->request_department) ?><br>
                Contact:&nbsp;<?php echo $rlp_info->contact_number ?>
            </address>
        </div>
        <!-- /.col -->
        <div class="col-md-8 invoice-col">
            <div class="pull-right">
                <b>RLP NO: &nbsp;<span style="border:1px solid;padding:2px 5px;"><?php echo $rlp_info->rlp_no ?></span></b><br>
                <b>Request Date:</b> <?php echo human_format_date($rlp_info->created_at) ?><br><br>
                <b>Current Status: &nbsp;<span style="border:1px solid;padding:2px 5px;"><?php echo get_status_name($rlp_info->rlp_status) ?></span></b><br>
            </div>            
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
        <div class="col-sm-12 table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Item Description</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sl =   1;
                        foreach($rlp_details as $data){
                    ?>
                    <tr>
                        <td><?php echo $sl++; ?></td>
                        <td><?php echo $data->item_des; ?></td>
                        <td><?php echo $data->quantity; ?></td>
                    </tr>
                        <?php } ?>
					<tr>
                        <td colspan="3"><?php echo $rlp_info->user_remarks; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
	<div class="row">
		<div class="col-sm-3 col-xs-3"><img src="images/signatures/<?php echo getSignatureByUserId($rlp_info->rlp_user_id); ?>" height="70px"/></br></br><span style="border-top: double;">Prepared by </span></div>
		
		<div class="col-sm-3 col-xs-3"><img src="images/signatures/<?php echo getSignatureByUserId($rlp_info->rlp_user_id); ?>" height="70px"/></br></br><span style="border-top: double;">Checked By</span></div>
		
		<div class="col-sm-3 col-xs-3"><img src="images/signatures/<?php echo getSignatureByUserId($rlp_info->rlp_user_id); ?>" height="70px"/></br></br><span style="border-top: double;"> Verified By</span></div>
		
		<div class="col-sm-3 col-xs-3"><img src="images/signatures/<?php echo getSignatureByUserId($rlp_info->rlp_user_id); ?>" height="70px"/></br></br><span style="border-top: double;"> Approved By</span></div>
		
	</div>
    <!-- /.row -->
	
</section>
	<div class="row">
		<div class="col-sm-12">
			<center>
				<a class="btn btn-app" onclick="printDiv('printableArea')" value="print a div!">
					<i class="fa fa-print"></i> Print 
				</a>
			</center>
			<script>
			function printDiv(divName) {
				 var printContents = document.getElementById(divName).innerHTML;
				 var originalContents = document.body.innerHTML;

				 document.body.innerHTML = printContents;

				 window.print();

				 document.body.innerHTML = originalContents;
			}
			</script>
		</div>
	</div>
<!-- /.content -->
<div class="clearfix"></div>