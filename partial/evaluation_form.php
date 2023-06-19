<style>
.box-border{
	border-top:1px solid gray;
	border-bottom:1px solid gray;
}
</style>
<?php 
$can_id = $adata->candidate_id;
$sqlcan = "SELECT * FROM `candidates` WHERE `id`='$can_id'";
$resultcan = $conn->query($sqlcan);
$rowcan = mysqli_fetch_array($resultcan);
 ?>
<div class="modal-content">
	<form action="" method="post">
		<div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		  <div class="row text-center">
			<h3>Candidates Evaluation Form</h3>
			<div class="col-md-12" style="border-right: 1px solid gray;">
				<p>Interview Details : <?php echo $int_id; ?> | Interview Date : 17th April 2022</p>
				Candidates Name : <?php echo $rowcan['name']; ?> | Position : <?php echo getDesignationNameById($rowcan['designation']); ?>
				<p>Interviewer : ---</p>
				<input type="hidden" class="form-control" value="<?php echo $int_id; ?>" name="int_id" />
				<input type="hidden" class="form-control" value="<?php echo $adata->candidate_id; ?>" name="can_id" />
			</div>
		  </div>
		</div>
		<div class="modal-body">
			<div class="row" style="border-bottom: 1px solid gray;">
				<div class="col-md-5" style="">Criteria</div>	
				<div class="col-md-5" style="">Comments</div>	
				<div class="col-md-2" style="">Rating</div>	
			</div>
			<div class="row" style="border-bottom: 1px solid gray;padding:5px;">
				<div class="col-md-5" style="">
					<span>01. Educatin</br><small>(Does candidate's Educatinal qualification or trainings received meet the requirement for the position)</small></span>
				</div>	
				<div class="col-md-5" style=""><input type="text" class="form-control" value="" name="education_remarks" /></div>	
				<div class="col-md-2" style=""><input type="text" class="form-control" value="<?php if (isset($row['education']) && $row['education'] != '') { echo $row['education']; }?>" name="education" /></div>	
			</div>
			<div class="row" style="border-bottom: 1px solid gray;padding:5px;">
				<div class="col-md-5" style="">
					<span>02. Experience</br><small>(Does the candidate have minimum and relevant working experience?)</small></span>
				</div>	
				<div class="col-md-5" style=""><input type="text" class="form-control" value="" name="" /></div>	
				<div class="col-md-2" style=""><input type="text" class="form-control" value="<?php if (isset($row['experience']) && $row['experience'] != '') { echo $row['experience']; }?>" name="experience" /></div>	
			</div>
			<div class="row" style="border-bottom: 1px solid gray;padding:5px;">
				<div class="col-md-5" style="">
					<span>03. Presentation</br><small>(Was the candidate well aware for self presentation in the interview?)</small></span>
				</div>	
				<div class="col-md-5" style=""><input type="text" class="form-control" value="" name="" /></div>	
				<div class="col-md-2" style=""><input type="text" class="form-control" value="<?php if (isset($row['presentation']) && $row['presentation'] != '') { echo $row['presentation']; }?>" name="presentation" /></div>	
			</div>
			<div class="row" style="border-bottom: 1px solid gray;padding:5px;">
				<div class="col-md-5" style="">
					<span>04. Knowledge of Company and Position</br><small>(Did the candidate research about the organization and the position prior to the interview?)</small></span>
				</div>	
				<div class="col-md-5" style=""><input type="text" class="form-control" value="" name="" /></div>	
				<div class="col-md-2" style=""><input type="text" class="form-control" value="<?php if (isset($row['know_com_pos']) && $row['know_com_pos'] != '') { echo $row['know_com_pos']; }?>" name="know_com_pos" /></div>	
			</div>
			<div class="row" style="border-bottom: 1px solid gray;padding:5px;">
				<div class="col-md-5" style="">
					<span>05. Communication</br><small>(How were the candidate's communication skills during the interview?)</small></span>
				</div>	
				<div class="col-md-5" style=""><input type="text" class="form-control" value="" name="" /></div>	
				<div class="col-md-2" style=""><input type="text" class="form-control" value="<?php if (isset($row['communication']) && $row['communication'] != '') { echo $row['communication']; }?>" name="communication" /></div>	
			</div>
			<div class="row" style="border-bottom: 1px solid gray;padding:5px;">
				<div class="col-md-5" style="">
					<span>06. Attitude & Body Language</br><small>(Did the candidate demonstrate positive attitude and body language during the interview?)</small></span>
				</div>	
				<div class="col-md-5" style=""><input type="text" class="form-control" value="" name="" /></div>	
				<div class="col-md-2" style=""><input type="text" class="form-control" value="<?php if (isset($row['attitude']) && $row['attitude'] != '') { echo $row['attitude']; }?>" name="attitude" /></div>	
			</div>
			<div class="row" style="border-bottom: 1px solid gray;padding:5px;">
				<div class="col-md-5" style="">
					<span>07. Teamwork</br><small>(Did the candidate possess the willingness to work in teams?)</small></span>
				</div>	
				<div class="col-md-5" style=""><input type="text" class="form-control" value="" name="" /></div>	
				<div class="col-md-2" style=""><input type="text" class="form-control" value="<?php if (isset($row['teamwork']) && $row['teamwork'] != '') { echo $row['teamwork']; }?>" name="teamwork" /></div>	
			</div>
			<div class="row" style="border-bottom: 1px solid gray;padding:5px;">
				<div class="col-md-5" style="">
					<span>08. Leadership</br><small>(Did the candidate demonstrate the ability to lead a team?)</small></span>
				</div>	
				<div class="col-md-5" style=""><input type="text" class="form-control" value="" name="" /></div>	
				<div class="col-md-2" style=""><input type="text" class="form-control" value="<?php if (isset($row['leadership']) && $row['leadership'] != '') { echo $row['leadership']; }?>" name="leadership" /></div>	
			</div>
			<div class="row" style="border-bottom: 1px solid gray;padding:5px;">
				<div class="col-md-5" style="">
					<span>09. Technical Know-how</br><small>(Does the candidate possess proper understanding of the industry and work segment where s/he currently is?)</small></span>
				</div>	
				<div class="col-md-5" style=""><input type="text" class="form-control" value="" name="" /></div>	
				<div class="col-md-2" style=""><input type="text" class="form-control" value="<?php if (isset($row['technical_know']) && $row['technical_know'] != '') { echo $row['technical_know']; }?>" name="technical_know" /></div>	
			</div>
			<div class="row" style="border-bottom: 1px solid gray;padding:5px;">
				<div class="col-md-5" style="">
					<span>10. Willingness to take on challenges and changes</br><small>(Did the candidate demonstrate his/her willingness to take on new challenges and accept change?)</small></span>
				</div>	
				<div class="col-md-5" style=""><input type="text" class="form-control" value="" name="" /></div>	
				<div class="col-md-2" style=""><input type="text" class="form-control" value="<?php if (isset($row['willingness']) && $row['willingness'] != '') { echo $row['willingness']; }?>" name="willingness" /></div>	
			</div>
			<div class="row" style="padding:5px;">	
				<div class="col-md-6" style="">
					<div class="form-group">
						<label for="exampleId">Comments :</label>
						<textarea class="form-control" name="remarks"><?php if (isset($row['remarks']) && $row['remarks'] != '') { echo $row['remarks']; }?></textarea>
					</div>
					<div class="form-group">
						<label for="exampleId">Final Recommendation :</label>
						<div class="radio">
							<label><input type="radio" name="final_recommendation" value="1" <?php if (isset($row['final_recommendation']) && $row['final_recommendation'] == '1') { echo 'checked'; }?>> <span class=""> Suitable</span> </label></br>
							<label><input type="radio" name="final_recommendation" value="2" <?php if (isset($row['final_recommendation']) && $row['final_recommendation'] == '2') { echo 'checked'; }?>> <span class=""> Recommend for other position</span> </label> </br>
							<label><input type="radio" name="final_recommendation" value="3" <?php if (isset($row['final_recommendation']) && $row['final_recommendation'] == '3') { echo 'checked'; }?>> <span class=""> Hold for Comparison</span> </label></br>
							<label><input type="radio" name="final_recommendation" value="4" <?php if (isset($row['final_recommendation']) && $row['final_recommendation'] == '4') { echo 'checked'; }?>> <span class=""> Reject</span> </label>
						</div>
					</div>
				</div>	
				<div class="col-md-6" style="">
					<div class="form-group">
						<label for="exampleId">Final Score :</label>
						<input type="text" class="form-control" value="<?php if (isset($row['final_score']) && $row['final_score'] != '') { echo $row['final_score']; }?>" name="final_score" />
					</div>
					<div class="form-group">
						<label for="exampleId">Salary Expectation :</label>
						<input type="text" class="form-control" value="<?php if (isset($row['salary_expectation']) && $row['salary_expectation'] != '') { echo $row['salary_expectation']; }?>" name="salary_expectation" />
					</div>
					<div class="form-group">
						<label for="exampleId">Other Requirement :</label>
						<input type="text" class="form-control" value="<?php if (isset($row['other_req']) && $row['other_req'] != '') { echo $row['other_req']; }?>" name="other_req" />
					</div>
					<div class="form-group">
						<label for="exampleId">Notice Period :</label>
						<input type="text" class="form-control" value="<?php if (isset($row['notice_period']) && $row['notice_period'] != '') { echo $row['notice_period']; }?>" name="notice_period" />
					</div> 
				</div>	
			</div>
		</div>
		<div class="modal-footer">
		  <input type="submit" class="btn btn-success" value="Submit" name="evaluation_submit" />
		  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		</div>
	</form>
</div>