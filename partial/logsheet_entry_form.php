<?php
    $currentUserId  =   $_SESSION['logged']['user_id'];
    if(!empty($_SESSION['logged']['branch_id']) && !empty($_SESSION['logged']['department_id'])){
?>
<form action="" method="post">
    <div class="row">
        <div class="col-sm-2">
            <div class="form-group">
                <label for="exampleId">Date</label>
                <input name="commissioning_date" type="text" class="form-control" id="rlpdate" value="<?php echo date("Y-m-d"); ?>" size="30" autocomplete="off" required />
            </div>
        </div>
		
		 <div class="col-sm-2">
            <div class="form-group">
                <label for="exampleId">Equipment Code</label>
                <input name="equipment_code" type="text" class="form-control" id="equipment_code" value="" autocomplete="off" required />
            </div>
        </div>
		
		
		 <div class="col-sm-2">
            <div class="form-group">
                <label for="exampleId">Equipment Name</label>
                <input name="equipment_Name" type="text" class="form-control" id="equipment_Name" value="" autocomplete="off" required />
            </div>
        </div>
		
		<div class="col-sm-2">
            <div class="form-group">
				<label for="division/company">Project:</label>
				<select class="all_emplyees form-control" id="project_id" name="project_id" required >
					<option value="">Select Project</option>
					<?php
					$tableName = 'projects';
					$column = 'project_name';
					$order = 'asc';
					$dataType = 'obj';
					$projectsData = getTableDataByTableName($tableName, $order, $column, $dataType);
					if (isset($projectsData) && !empty($projectsData)) {
						foreach ($projectsData as $data) {
							?>
							<option value="<?php echo $data->id; ?>"><?php echo $data->project_name; ?></option>
							<?php
						}
					}
					?>
				</select>
			</div>
        </div>
		<div class="col-sm-2">
            <div class="form-group">
				<label for="division/company">Sub Project:</label>
                <select class="all_emplyees form-control" id="sub_project_id" name="sub_project_id" >
					<option value="">Select Sub Project</option>
					<?php
					$tableName = 'sub_projects';
					$column = 'name';
					$order = 'asc';
					$dataType = 'obj';
					$projectsData = getTableDataByTableName($tableName, $order, $column, $dataType);
					if (isset($projectsData) && !empty($projectsData)) {
						foreach ($projectsData as $data) {
							?>
							<option value="<?php echo $data->id; ?>"><?php echo $data->name; ?></option>
							<?php
						}
					}
					?>
				</select>
			</div>
        </div>
		
        <div class="col-sm-2">
            <div class="form-group">
                <label for="exampleId">Month Name</label>
                <input name="name" type="text" class="form-control" id="name" value="" autocomplete="off" required />
            </div>
        </div>
       
	</div>
	
	
	
	<div class="row">
		
       <div class="col-md-4">
            <div class="form-group">
                <label for="exampleId">Work Narration</label>
                <textarea class="form-control" id="" name="remarks" rows="1"></textarea>
            </div>
        </div>
		
        <div class="col-sm-2">
            <div class="form-group">
                <label for="exampleId">Running (Hr/KM)</label>
                <input name="runhrkm" type="text" class="form-control" id="runhrkm" value="" autocomplete="off" required />
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <label for="exampleId">Close (Hr/KM)</label>
                <input name="closehrkm" type="text" class="form-control" id="closehrkm" value="" autocomplete="off" required />
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <label for="exampleId">Total hour(Hr/KM)</label>
                <input name="year_manufacture" type="text" class="form-control" id="year_manufacture" value="" autocomplete="off" required />
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <label for="exampleId">Stand By</label>
                <input name="standby" type="text" class="form-control" id="standby" value="" autocomplete="off" required />
				<select calss="form-control select2">
					<option value="">Select</option>
					<option value="Running">Running</option>
					<option value="Stand By">Stand By</option>
					<option value="Breakdown">Breakdown</option>
				</select>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <label for="exampleId">Hydrolic (Ltr)</label>
                <input name="hydrolicltr" type="text" class="form-control" id="hydrolicltr" value="" autocomplete="off" required />
            </div>
        </div>
        <div class="col-sm-2">
            <div class="form-group">
                <label for="exampleId">Diseal (Ltr)</label>
                <input name="disealltr" type="text" class="form-control" id="disealltr" value="" autocomplete="off" required />
            </div>
        </div>
		
		 <div class="col-sm-2">
            <div class="form-group">
                <label for="exampleId">Engine oil</label>
                <input name="engineoil" type="text" class="form-control" id="engineoil" value="" autocomplete="off" required />
            </div>
        </div>
		
		
		
				 <div class="col-sm-2">
            <div class="form-group">
                <label for="exampleId">Gresing Hour servicing</label>
                <input name="engineoil" type="text" class="form-control" id="engineoil" value="" autocomplete="off" required />
            </div>
        </div>
		
		
		
       
    </div>
    <div class="row" style="padding-top:5px;">
        <div class="col-sm-12">
            <input type="submit" name="logsheet_entry" id="submit" class="btn btn-block btn-primary" value="Save Daily Logsheet Data" />
        </div>
    </div>
</form>

    
    <?php } ?>