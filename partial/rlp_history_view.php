<div class="row">
    <div class="col-md-6 col-sm-6" style="font-size:10px;">
		<h4>Remarks History<hr></h4>
		<div id="remarks_history_section">        
			<!-- /.box-comment -->
			<table class="table table-bordered">
                <tr>
                  <th style="width: 30%">User</th>
                  <th>Remarks</th>
                  <th style="width: 30%">Date</th>
                </tr>
				<?php
			$table = "rlp_remarks_history WHERE rlp_info_id=$rlp_id";
			$order = 'DESC';
			$column = 'remarks_date';
			$allRemarksHistory = getTableDataByTableName($table, $order, $column);
			if (isset($allRemarksHistory) && !empty($allRemarksHistory)) {
				foreach ($allRemarksHistory as $dat) {
					?>
					
                <tr>
                  <td><?php echo getUserNameByUserId($dat->user_id); ?></td>
                  <td><?php echo $dat->remarks ?></td>
                  <td><?php echo human_format_date($dat->remarks_date) ?></td>
                </tr>
				<?php
				} // foreach
			}
				?>
				<tr>
                  <td><?php echo getUserNameByUserId($rlp_info->rlp_user_id); ?></td>
                  <td><?php echo $rlp_info->user_remarks ?></td>
                  <td><?php echo human_format_date($rlp_info->created_at) ?></td>
                </tr>
            </table>	
		</div>
	</div>
	
	<div class="col-md-6 col-sm-6" style="font-size:10px;">
		<h4>Acknowledgement History<hr></h4>
		<div id="remarks_history_section">
		
		
		<table class="table table-bordered">
                <tr>
                  <th style="width: 40%">Acknowledged Person</th>
                  <th>Designation</th>
                  <th style="width: 10%">Status</th>
                  <th style="width: 30%">Date</th>
                </tr>
				<?php
				$table = "rlp_acknowledgement WHERE rlp_info_id=$rlp_id";
				$order = 'DESC';
				$column = 'ack_request_date';
				$allRemarksHistory = getTableDataByTableName($table, $order, $column);
					if (isset($allRemarksHistory) && !empty($allRemarksHistory)) {
					foreach ($allRemarksHistory as $dat) {
				?>
                <tr>
                  <td><?php echo getUserNameByUserId($dat->user_id) ?></td>
                  <td><?php echo getDesignationByUserId($dat->user_id) ?></td>
                  <td><?php echo get_status_name($dat->ack_status) ?></td>
                  <td><?php echo (isset($dat->ack_updated_date) && !empty($dat->ack_updated_date) ? human_format_date($dat->ack_updated_date) : ""); ?></td>
                </tr>
				<?php
				}
			}
			?>
              </table>
		
		
		
					
					
					
					
		</div>
	</div>
</div>