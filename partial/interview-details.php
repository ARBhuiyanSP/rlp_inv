<style>
.box-border{
	border-top:1px solid gray;
	border-bottom:1px solid gray;
}
</style>
<div class="modal-content">
	<div class="modal-header">
	  <button type="button" class="close" data-dismiss="modal">&times;</button>
	  <h4 class="modal-title">Interview Details</h4>
	</div>
	<div class="modal-body">
		<div class="row" style="border-bottom: 1px solid gray;">
			<div class="col-md-4" style="border-right: 1px solid gray;">
				<p>Interview ID : <?php echo (isset($adata->code) && !empty($adata->code) ? $adata->code : 'No data'); ?></p>
				<p>Interview Date :</br> <?php echo (isset($adata->date) && !empty($adata->date) ? human_format_date($adata->date) : 'No data'); ?></p>
				<p>Time : <?php echo (isset($adata->time) && !empty($adata->time) ? $adata->time : 'No data'); ?></p>
				<p>Location : <?php echo (isset($adata->location) && !empty($adata->location) ? $adata->location : 'No data'); ?></p>
			</div>
			<div class="col-md-8" style="border-left: 1px solid gray;">
				<h5>Selected RRR For This Interview</h5>
				<div class="row">
					<div class="col-md-6 box-border">RRR No</div>
					<div class="col-md-6 box-border">Position</div>
				</div>
					<?php
					$table 	= 'interview_requisition';
					$order = 'ASC';
					$column = 'rrr_id';
					$interviewId = $adata->code;
					$dataType = 'obj';
					$agencyData = getInterviewDataByTableNameAndIntId($table,$interviewId, $order, $column, $dataType);
					if (isset($agencyData) && !empty($agencyData)) {
						foreach ($agencyData as $adata) {
							$rrr_id = $adata->rrr_id;
							$table = 'rrr_info';
							$interviewData = getDataRowByTableAndId($table,$rrr_id); 
							?>
					<div class="row box-border">
						<div class="col-md-6"><?php echo $interviewData->rrr_no; ?></div>
						<div class="col-md-6"><?php echo getDesignationNameById($interviewData->req_designation); ?></div>
					</div>
					<?php } } ?>
				</div>	
			</div>
		<div class="row" style="border-bottom: 1px solid gray;">
			<div class="col-md-12">
				<h5>Selected Candidates For This Interview</h5>
				<?php
					$table 	= 'interview_candiate';
					$order = 'ASC';
					$column = 'interview_id';
					$dataType = 'obj';
					$agencyData = getInterviewDataByTableNameAndIntId($table,$interviewId, $order, $column, $dataType);
					if (isset($agencyData) && !empty($agencyData)) {
						foreach ($agencyData as $adata) {
							$candidate_id = $adata->candidate_id;
							$table = 'candidates';
							$interviewData = getDataRowByTableAndId($table,$candidate_id);
							?>
						<div class="col-md-8"><?php echo $interviewData->name; ?></div>
						<div class="col-md-4"><?php echo $interviewData->email; ?></div>
					<?php } } ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<h5>Selected Board Members For This Interview</h5>
				<?php
					$table 	= 'interview_bom';
					$order = 'ASC';
					$column = 'interview_id';
					$dataType = 'obj';
					$agencyData = getInterviewDataByTableNameAndIntId($table,$interviewId, $order, $column, $dataType);
					if (isset($agencyData) && !empty($agencyData)) {
						foreach ($agencyData as $adata) {
							?>
						<div class="col-md-8"><?php echo $adata->emp_id; ?></div>
						<div class="col-md-4"></div>
					<?php } } ?>
			</div>
		</div>
	</div>
	<div class="modal-footer">
	  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	</div>
</div>