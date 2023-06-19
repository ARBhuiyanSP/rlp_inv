<style>
.table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td{
	border: 1px solid gray;
	color: gray;
}
</style>
<?php
    $currentUserId  =   $_SESSION['logged']['user_id'];
    $rrr_id         =   $_GET['rrr_id'];    
    $rrr_details    =   getRRRDetailsData($rrr_id);   
    $rrr_info       =   $rrr_details['rrr_info'];
    $rrr_details    =   $rrr_details['rrr_info'];
?>
<!-- Main content -->
<section class="invoice" id="printableArea">
    <!-- title row -->
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                <i class="fa fa-globe"></i> Recruitment Requisition Request Details.
                <small class="pull-right">Priority: <?php echo getPriorityNameDiv($rrr_info->priority) ?></small>
            </h2>
        </div>
        <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-md-4 invoice-col">
            From
            <address>
                <strong>Name:&nbsp;<?php echo $rrr_info->request_person ?></strong><br>
                Designation:&nbsp;<?php echo getDesignationNameById($rrr_info->designation) ?><br>
                Division:&nbsp;<?php echo getDivisionNameById($rrr_info->request_division) ?><br>
                Department:&nbsp;<?php echo getDepartmentNameById($rrr_info->request_department) ?><br>
            </address>
        </div>
        <!-- /.col -->
        <div class="col-md-8 invoice-col">
            <div class="pull-right">
                <b>RLP NO: &nbsp;<span style="border:1px solid;padding:2px 5px;"><?php echo $rrr_info->rrr_no ?></span></b><br>
                <b>Request Date:</b> <?php echo human_format_date($rrr_info->created_at) ?><br><br>
                <b>Current Status: &nbsp;<span style="border:1px solid;padding:2px 5px;"><?php echo get_status_name($rrr_info->rrr_status) ?></span></b><br>
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
                            <th>Requested Post</th>
                            <th>Type</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody id="tbl_posts_body">
                        <tr id="rec-1">
                            <td><?php echo getDesignationNameById($rrr_info->req_designation) ?></td>
                            <td><?php echo $rrr_info->emp_type; ?></td>
                            <td><?php echo $rrr_info->req_number; ?></td>
                        </tr>           
                    </tbody>
                </table>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
	
    <?php include 'rrr_history_view.php'; ?>
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