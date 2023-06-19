<?php
    $currentUserId  =   $_SESSION['logged']['user_id'];
    if(!empty($_SESSION['logged']['branch_id']) && !empty($_SESSION['logged']['department_id'])){
?>
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
						<input name="equipment_id" type="text" class="form-control" id="equipment_id" value="<?php echo $row['eel_code']; ?>" autocomplete="off" readonly />
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
						<label for="exampleId">Brand/Make By</label>
						<input name="makeby" type="text" class="form-control" id="makeby" value="<?php echo $row['makeby']; ?>" autocomplete="off" readonly />
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
						<label for="exampleId">Date of service</label>
						<input name="lastseervice_date" type="text" class="form-control" id="rlpdate" value="<?php echo date("Y-m-d"); ?>" size="30" autocomplete="off" required />
					</div>
				</div>
				<div class="col-sm-2">
					<div class="form-group">
						<label for="exampleId">Service Done (HR/KM)</label>
						<input name="lastservice_hrkm" type="text" class="form-control" id="lastservice_hrkm" value="<?php if(isset($sm_info->present_hrkm)){echo $sm_info->present_hrkm;} ?>" autocomplete="off" required />
					</div>
				</div>
				<div class="col-sm-2">
					<div class="form-group">
						<label for="exampleId">Scheduled At (HR/KM)</label>
						<input name="schedule_hrkm" type="text" class="form-control" id="scheduled" value="<?php if(isset($sm_info->nextservice_hrkm)){echo $sm_info->nextservice_hrkm;} ?>" autocomplete="off" required />
					</div>
				</div>
				<div class="col-sm-2">
					<div class="form-group">
						<label for="exampleId">Present(HR/KM)</label>
						<input name="present_hrkm" type="text" class="form-control" id="presenthrkm" value="" autocomplete="off" onkeyup="cal()" required />
					</div>
				</div>
				<div class="col-sm-1">
					<div class="form-group">
						<label for="exampleId"> Due</label>
						<input name="dueforservice_hrkm" type="text" class="form-control" id="dueforservicehrkm" value="" autocomplete="off" readonly />
					</div>
				</div>
				<div class="col-sm-2">
					<div class="form-group">
						<label for="exampleId"> Type of Service</label>
						<input name="typeofservice_hrkm" type="text" class="form-control" id="" value="" autocomplete="off" />
					</div>
				</div>
				<div class="col-sm-3">
					<div class="form-group">
						<label for="exampleId"> Added (HR/KM) for Next Service</label>
						<input name="" type="text" class="form-control" id="typeofservicehrkm" value="" autocomplete="off" onkeyup="cal()" required />
					</div>
				</div>
				<div class="col-sm-2">
					<div class="form-group">
						<label for="exampleId">Next Service(HR/KM)</label>
						<input name="nextservice_hrkm" type="text" class="form-control" id="nextservicehrkm" value="" autocomplete="off" readonly />
					</div>
				</div>
				<div class="col-sm-2">
					<div class="form-group">
						<label for="exampleId">Next service Date</label>
						<input name="nextservice_date" type="text" class="form-control" id="fromdate" value="" size="30" autocomplete="off" />
					</div>
				</div>
				<div class="col-md-5">
					<div class="form-group">
						<label for="exampleId">Details of Maintenance Carried out:</label>
						<textarea class="form-control" id="" name="detailsofmaintenance" rows="1"></textarea>
					</div>
				</div>
				<div class="col-md-5">
					<div class="form-group">
						<label for="exampleId">Remarks:</label>
						<textarea class="form-control" id="" name="remarks" rows="1"></textarea>
					</div>
				</div>
				<div class="col-sm-12">
					<input type="submit" name="sm_entry" id="submit" class="btn btn-block btn-primary" value="Save Data" />
				</div>
			</div>
		</form>
	<?php  } }?>
	
<script>
	function cal() {
		var scheduled = document.getElementById('scheduled').value;
		var presenthrkm = document.getElementById('presenthrkm').value;
		var typeofservicehrkm = document.getElementById('typeofservicehrkm').value;



		var result =  parseInt(scheduled) - parseInt(presenthrkm);
		if (!isNaN(result)) {
			document.getElementById('dueforservicehrkm').value = result;
		}
		var result2 =  parseInt(presenthrkm) + parseInt(typeofservicehrkm);
		if (!isNaN(result2)) {
			document.getElementById('nextservicehrkm').value = result2;
		}
	}
</script>
		 