<style>
.table-bordered>thead>tr>th, .table-bordered>tbody>tr>th, .table-bordered>tfoot>tr>th, .table-bordered>thead>tr>td, .table-bordered>tbody>tr>td, .table-bordered>tfoot>tr>td{
	border: 1px solid gray;
	color: gray;
}
</style>
<?php
    $currentUserId  =   $_SESSION['logged']['user_id'];
    $id         =   $_GET['id'];    
    $equipment_details    =   getEquipmentDetailsData($id);   
    $equipment_info       =   $equipment_details['equipments'];
    $equipment_details    =   $equipment_details['equipments'];
?>
<!-- Main content -->
<section class="invoice" id="printableArea">
    <!-- title row -->
    <div class="row">
        <div class="col-xs-12">
            <h1 align="center"><img src="images/spl.png" width="162" height=""></h1>
			<h3 align="center">SAIF POWERTEC LTD</h3>
			<p align="center">95 Bir Uttam AK Khandokar Road,Mohakhali, Dhaka, Bangladesh.</p>
			<h3 align="center">Equipment Details</h3>
        </div>
        <!-- /.col -->
    </div>

    <!-- Table row -->
    <div class="row">
        <div class="col-sm-12 table-responsive">
            <table style="" class="table table-bordered">
				<tr>
					<th>EEL Code:</th>
					<td><?php echo $equipment_info->eel_code; ?></td>
				</tr>
				<tr>
					<th>Name:</th>
					<td><?php echo $equipment_info->name; ?></td>
				</tr>
				<tr>
					<th>Model:</th>
					<td><?php echo $equipment_info->model;?></td>
				</tr>
				<tr>
					<th>Country Origin:</th>
					<td><?php echo $equipment_info->origin; ?></td>
				</tr>
				<tr>
					<th>Manufacture Year:</th>
					<td><?php echo $equipment_info->year_manufacture;?></td>
				</tr>
			</table>
        </div>
        <!-- /.col -->
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