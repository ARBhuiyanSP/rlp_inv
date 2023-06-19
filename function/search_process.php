 <?php
if(isset($_POST['submit'])){
	$branch_id		= $_POST['branch_id'];
	$department_id	= $_POST['department_id'];
	$fromdate		= date('Y-m-d H:i:s', strtotime($_POST['fromdate']));
	$todate			= date('Y-m-d H:i:s', strtotime($_POST['todate']));
	$status			= $_POST['status'];
	
	//query from db
	$resultSet = $conn->query("SELECT * FROM rlp_info WHERE request_division = $branch_id AND request_department = $department_id".($status!='all'?" AND rlp_status = $status":'')." AND request_date BETWEEN '$fromdate' AND '$todate'");
	$count = $resultSet->num_rows;
	if($resultSet->num_rows > 0){
		echo "<div id='printableArea'><center><h2>Saif Power Group</h2><span>72, Mohakhali C/A, 8th Floor, Rupayan Center, Dhaka-1212, Bangladesh</span><h3>Division Wise RLP List</h3>Number of RLP: $count</center>";
		echo "<table id='rlp_list_table' class='table table-bordered table-striped list-table-custom-style'>
		<tr>
			<th>Sl No</th>
			<th>RLP NO</th>
			<th>Requested Date</th>
			<th>RLP User</th>
			<th>Office ID</th>
			<th>Email</th>
			<th>Division</th>
			<th>Department</th>
			<th>Priority</th>
			<th>Status</th>
		</tr>";

		$i = 0;
		while($rows = $resultSet->fetch_assoc()) {
			$i++;
			echo "<tr><td>" . $i . "</td>
					<td>" . $rows['rlp_no'] . "</td>
					<td>" . human_format_date($rows['created_at']) . "</td>
					<td>" . getUserNameByUserId($rows['rlp_user_id']) . "</td>
					<td>" . $rows['rlp_user_office_id'] . "</td>
					<td>" . $rows['email'] . "</td>
					<td>" . getDivisionNameById($rows['request_division']) . "</td>
					<td>" . getDepartmentNameById($rows['request_department']) . "</td>
					<td>" . getPriorityName($rows['priority']) . "</td>
					<td>" . get_status_name($rows['rlp_status']) . "</td>
				</tr>";
			
		}
		echo "</table></div>";
	}
	else{
		echo "<center>No Result</center>";
	}
}
?>
<div class="row">
	<div class="col-sm-12">
		<center>
			<a class="btn btn-default" onclick="printDiv('printableArea')" value="print a div!">
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