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
	<div class="row">
		<div class="col-xs-3">
			<div class="form-group">
				<?php 
					$eel_code	= 	$equipment_info->eel_code;
					$sql2		= 	"SELECT * FROM `equipment_assign` WHERE `eel_code`='$eel_code' ORDER BY `id` DESC LIMIT 1 ;";
					$result2 	=	mysqli_query($conn, $sql2);
					$row2		=	mysqli_fetch_array($result2);
					?>
				<label>Present Location</label>
				<?php 
				$project_id=$row2['project_id'];
				$sql3	= "SELECT * FROM `projects` WHERE `id`='$project_id' ;";
				$result3 = mysqli_query($conn, $sql3);
				$row3=mysqli_fetch_array($result3);
				?>
				<input name="employee_id" type="text" class="form-control" id="" value="<?php echo $row3['project_name'] ?>" readonly />
			</div>
		</div>
		<div class="col-xs-3">
			<div class="form-group">
				<label>Assigned Date</label>
				<input name="assign_date" type="text" class="form-control" id="" value="<?php echo $row2['assign_date'] ?>" readonly />
			</div>
		</div>
		<div class="col-xs-6">
			<div class="form-group">
				<label>Remarks</label>
				<input name="remarks" type="text" class="form-control" id="" value="<?php echo $row2['remarks'] ?>" readonly />
			</div>
		</div>
	</div>
	<h3 style="color:red;">Want To Shift This Equipment To Another Project ?</h3>
	<form action="" method="post">
		<div class="row">
			<div class="col-xs-3">
				<div class="form-group">
					<?php 
						$eel_code	= 	$equipment_info->eel_code;
						$sql2	= "SELECT * FROM `equipment_assign` WHERE `eel_code`='$eel_code' ORDER BY `id` DESC LIMIT 1 ;";
						$result2 = mysqli_query($conn, $sql2);
						$row2=mysqli_fetch_array($result2);
						?>
					<label>Transfer To</label>
					<select id="dv" name="project_id" class="form-control select2">
						<option>Select Project</option>
						<?php 
						$sqllt	= "select * from `projects` WHERE `id`!='$project_id' ORDER BY id ASC";
						$resultlt = mysqli_query($conn, $sqllt);
						while($rowlt=mysqli_fetch_array($resultlt))
							{
						?>
						<option value="<?php echo $rowlt['id'] ?>">
						<?php echo $rowlt['project_name'] ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="col-xs-3">
				<div class="form-group">
					<label>Transfer Date</label>
					<input name="assign_date" type="text" class="form-control" id="rlpdate" autocomplete="off" />
				</div>
			</div>
			<div class="col-xs-3">
				<div class="form-group">
					<label>Requisition No</label>
					<input name="req_no" type="text" class="form-control" autocomplete="off" />
				</div>
			</div>
			<div class="col-xs-3">
				<div class="form-group">
					<label>Requisition Date</label>
					<input name="req_date" type="text" class="form-control" id="date" autocomplete="off" />
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<div class="form-group">
					<label for="ad">Remarks</label>
					<textarea id="ad" name="remarks" class="form-control" placeholder=""></textarea>
				</div>
			</div>
		</div>
		<input type="hidden" name="id" value="<?php echo $row2['id'] ?>" />
		<input type="hidden" name="eel_code" value="<?php echo $equipment_info->eel_code;?>" />
		<input type="hidden" name="equipment_type" value="<?php echo $equipment_info->equipment_type;?>" />
		<button class="btn btn-success btn-block" type="submit" name="equipment_shift"> Transfer/Shift This Equipment</i></button>
	</form>
    <!-- /.row -->
</section>
<!-- /.content -->
<div class="clearfix"></div>