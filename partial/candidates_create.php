<form id="candidates_form" role="form" method="post" enctype="multipart/form-data">
<div class="box-body">
	<?php
	get_candidates_form();
	?>
</div>
<div class="box-footer">
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<input type="submit" name="candidate_create" class="btn btn-primary btn-block" value="Create">
			</div>
		</div>
	</div>
</div>
</form>