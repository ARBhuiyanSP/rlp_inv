<?php
    $currentUserId  =   $_SESSION['logged']['user_id'];
    if(!empty($_SESSION['logged']['branch_id']) && !empty($_SESSION['logged']['department_id'])){
?>
<style>
.reqfield{
	color:red;
	font-size:10px;
}
</style>
<form action="" method="post">
    <div class="row">
		<div class="col-sm-12">
			<form action="" method="post">
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label>Equipment</label>
							<select class="form-control select2" id="project_id" name="eel_code">
									<?php $results = mysqli_query($conn, "SELECT * FROM `equipments`"); 
									while ($row = mysqli_fetch_array($results)) {
										if($_POST['eel_code'] == $row['eel_code']){
											$selected	= 'selected';
											}else{
											$selected	= '';
											}
										?>
									<option value="<?php echo $row['eel_code']; ?>" <?php echo $selected; ?>><?php echo $row['eel_code']; ?> || <?php echo $row['name']; ?></option>
									<?php } ?>
							</select>
						</div>
					</div>
					<div class="col-sm-2">
						<div class="form-group">
							<label></label>
							<input type="submit" name="submit" id="submit" class="btn btn-block btn-primary" value="NEXT" />
						</div>
					</div>
				</div>
			</form>
		</div>
		
		<?php    
			if(isset($_POST['submit'])){ 
				$eel_code = $_POST['eel_code'];
				$sql	=	"select * from `equipments` where `eel_code`='$eel_code'";
				$result = mysqli_query($conn, $sql);
				$row=mysqli_fetch_array($result);
				
				$id			= $row['eel_code'];
				$sm_details    =   getSMDetailsData($id);   
				$sm_info       =   $sm_details['maintenance'];
				$sm_details    =   $sm_details['maintenance'];
		?>
		
		<form action="" method="post">
			<div class="" id="printableArea" style="display:block;">
				<div class="col-sm-3">
					<?php $mcslNo    =   get_mcsl_no(); ?>
					<b>MCSL No: &nbsp;<span class="rlpno_style"><?php echo $mcslNo; ?></span></b><br>
					<input type="hidden" name="m_cost_id" value="<?php echo $mcslNo; ?>">
				</div>
				<div class="col-sm-2">
					<div class="form-group">
						<label for="exampleId">Project</label>
						<input name="" type="text" class="form-control" id="" value="<?php $dataresult =   getDataRowByTableAndId('projects', $row['project_id']); echo (isset($dataresult) && !empty($dataresult) ? $dataresult->project_name : ''); ?>" autocomplete="off" readonly />
					</div>
					<input name="project_id" type="hidden" class="form-control" id="project_id" value="<?php echo $row['project_id']; ?>" autocomplete="off" />
				</div>
				<div class="col-sm-2">
					<div class="form-group">
						<label for="exampleId">EEL Code</label>
						<input name="eel_code" type="text" class="form-control" id="eel_code" value="<?php echo $row['eel_code']; ?>" autocomplete="off" readonly />
					</div>
				</div>
				
				 <div class="col-sm-2">
					<div class="form-group">
						<label for="exampleId">Equipment Name</label>
						<input name="equipment_Name" type="text" class="form-control" id="equipment_Name" value="<?php echo $row['name']; ?>" autocomplete="off" readonly />
					</div>
				</div>
				<div class="col-sm-2">
					<div class="form-group">
						<label for="exampleId">Model</label>
						<input name="model" type="text" class="form-control" id="model" value="<?php echo $row['model']; ?>" autocomplete="off" readonly />
					</div>
				</div>
				<div class="col-sm-2">
					<div class="form-group">
						<label for="exampleId">Date of in</label>
						<input name="in_time" type="text" class="form-control" id="rlpdate" value="<?php echo date("Y-m-d"); ?>" size="30" autocomplete="off" required />
					</div>
				</div>
				<div class="col-sm-2">
					<div class="form-group">
						<label for="exampleId">Date of Out</label>
						<input name="out_time" type="text" class="form-control" id="date" value="" size="30" autocomplete="off" />
					</div>
				</div>
				<div class="col-sm-12">
					<div class="form-group">
						<label for="exampleId">Problem Description</label>
						<textarea name="problem_details" class="form-control" rows="1"></textarea>
					</div>
				</div>
			
					<div class="col-sm-6">
						<label for="exampleId">List of Spare Parts Used</label>
						<?php include('partial/cost_items_table.php'); ?>
					</div>
					<div class="col-sm-6">
						<label for="exampleId">Responsible Mechanic</label>
						<?php include('partial/cost_mechanics_table.php'); ?>
					</div>
				
				<div class="col-md-12">
					<div class="form-group">
						<label for="exampleId">Remarks:</label>
						<textarea class="form-control" id="" name="remarks" rows="1"></textarea>
					</div>
				</div>
				<div class="col-sm-12">
					<input type="submit" name="cost_entry" id="submit" class="btn btn-block btn-primary" value="Save Data" />
				</div>
			</div>
		</form>
	<?php  } }?>

		 