<table class="table table-bordered" id="dynamic_field2">
	<thead>
		<th width="90%">Mechanic Name<span class="reqfield"> ***req</span></th>
		<th></th>
	</thead>
	<tbody>
		<tr>
			<td><input type="text" name="mechanic_name[]" id="mechanic_name0" class="form-control" required ></td>
			<td><button type="button" name="addMechanic" id="addMechanic" class="btn btn-success">+</button></td>
		</tr>
	</tbody>
</table>
<script>
	var i = 0;
	$(document).ready(function () {
		$('#addMechanic').click(function () {
			i++;
			$('#dynamic_field2').append('<tr id="row' + i + '"><td><input type="text" name="mechanic_name[]" id="mechanic_name' + i + '" class="form-control" required ></td><td><button type="button" name="remove" id="' + i + '" class="btn btn-warning btn_remove">X</button></td></tr>');
			$(".material_select_2").select2();
		});

		$(document).on('click', '.btn_remove', function () {
			var button_id = $(this).attr("id");
			$('#row' + button_id + '').remove();
		});
	});
</script>