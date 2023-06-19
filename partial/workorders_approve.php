<?php
    $currentUserId  =   $_SESSION['logged']['user_id'];
    $wo_id         =   $_GET['id'];    
    $rlp_details    =   getWorkordersDetailsData($wo_id);   
    $rlp_info       =   $rlp_details['rlp_info'];
    $rlp_details    =   $rlp_details['rlp_details'];
?>
<!-- Main content -->
<section class="invoice" id="printableArea">
    <form action="" method="POST">
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-md-12">
			<center>
				<h5 align="center"><img src="images/spl.png" height="50"></h5>
				<p>Khawaja Tower[13th Floor], 95 Bir Uttam A.K Khandokar Road, Mohakhali C/A, Dhaka-1212, Bangladesh</p>
				<h5><b>Work Order</b></h5>
			</center>
			<h5><b>Ref : <?php echo $rlp_info->wo_no ?></b></h5>
			<h5><b>Date : <?php echo human_format_date($rlp_info->created_at) ?></b></h5>
			<h5>
				<b>To,</br><?php echo $rlp_info->supplier_name ?></b></br>
				Address : <?php echo $rlp_info->address ?></br>
				Concern person : <?php echo $rlp_info->concern_person ?></br>
				Call : <?php echo $rlp_info->cell_number ?>, E-Mail:  <?php echo $rlp_info->email ?></br>
			</h5>
			<h5><b>Subject : <?php echo $rlp_info->subject ?></b></h5>
		</div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
        <div class="row">
			<div class="col-xs-12 table-responsive">
                <p><?php echo $rlp_info->ns_info ?></p>
				<table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Item Description</th>
                            <th>Part No</th>
                            <th width="10%">Quantity</th>
                            <th width="10%">Unit Price</th>
                            <th width="10%">Total</th>
                        </tr>
                    </thead>
                    <tbody id="tbl_posts_body">
                        <?php
							$sl =   1;
							$total = 0;
							$totalQty = 0;
                            foreach($rlp_details as $data){
								$total += $data->total;
								$totalQty += $data->quantity;
                        ?>
                        <tr id="rec-1">
                            <td><?php echo $sl++; ?></td>
                            <td><?php echo $data->item; ?></td>
                            <td><?php echo $data->part_no; ?></td>
                            <td><?php echo $data->quantity; ?></td>
                            <td><?php echo $data->unit_price; ?></td>
                            <td><?php echo $data->total; ?></td>
                        </tr>                        
                            <?php } ?>
						<tr id="rec-1">
                            <td colspan="5" style="text-align:right">Sub Total: </td>
                            <td><?php echo $rlp_info->sub_total; ?></td>
                        </tr>
						<tr id="rec-1">
                            <td colspan="5" style="text-align:right">AIT: </td>
                            <td><?php echo $rlp_info->ait; ?></td>
                        </tr>
						<tr id="rec-1">
                            <td colspan="5" style="text-align:right">VAT: </td>
                            <td><?php echo $rlp_info->vat; ?></td>
                        </tr>
						<tr id="rec-1">
                            <td colspan="5" style="text-align:right">Grand Total: </td>
                            <td><?php echo $rlp_info->grand_total; ?></td>
                        </tr>
						<tr id="rec-1">
                            <td colspan="7" style="text-align:left"><b>In word: <?php echo convertNumberToWords($rlp_info->grand_total); ?> Only</b></td>
                        </tr>
                    </tbody>
                </table>
            </div>
			<div class="col-xs-12 table-responsive">
				<p style="text-decoration:underline;"><b>Other terms and conditions</b></p>
				<ul>
					<li> Commencement of Supply</li>
					<li> Delivery Status: Delivered at site within 07 days(as per telephonic discussion with managing director Md. Afzal & executive Director Alauddin Ahmed).</li>
					<li> This price is including VAT & AIT other taxes</li>
					<li> Mode of payment : After 45 days from the date of bill submission</li>
					<li> Delivery Location: CWLP Project, Chattogram, Contact : 01784704948</li>
				</ul>
				<div class="row">
				<div class="col-sm-4 col-xs-4">
					Thanking You,</br>
					<p style="padding-top:30px;">Alauddin Ahmed</br>Executive Director(Mechanical)</br>E-Engineering Ltd.</br>Cell:01324263969,Email: alauddin.ahmed@e-enggltd.com</p>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-4 col-xs-4">
					Copy To:</br>
					<ul>
						<li>BOD, EEL</li>
						<li>ED, Mechanical, EEL</li>
						<li>ACC DEPT.EEL</li>
						<li>PM, CWLP Project</li>
						<li>Office Copy</li>
					</ul>
				</div>
				<div class="col-md-4">
					<?php
						if(!has_wo_approved($wo_id)){
							if($currentUserId!=$rlp_info->created_by){
					?>
							<form id="wo_update_form">        
								<div class="common_individual_section approval_body_section_style">
									<h4>Acknowledgement<hr></h4>
									<div class="radio">
										<label><input type="radio" name="acknowledgement" value="1" required >Approve</label>
									</div>
									<div class="radio">
										<label><input type="radio" name="acknowledgement" value="4">Withheld</label>
									</div>
								</div>
								<input type="hidden" name="wo_no" value="<?php echo $rlp_info->id; ?>">
								<input type="hidden" name="created_by" value="<?php echo $currentUserId; ?>">
								<button type="button" class="btn btn-primary btn-block" onclick="execute_wo_update_form('wo_update_form', 'wo_update_execute');">Update</button>
							</form>
						<?php
							
							if($rlp_info->status == 0){
						?>
						<div style="margin: 30% 5% 5% 5%;">
								<img style="margin-left: 30%" src="images/icon/pending_small.png" class="img img-responsive" />
							</div>
						<?php }else{ ?>
							<div style="margin: 30% 5% 5% 5%;">
								<img style="margin-left: 30%" src="images/icon/processing_small.png" class="img img-responsive" />
							</div>
						<?php }
						
						}else{ ?>
							<div style="margin: 30% 5% 5% 5%;">
								<img style="margin-left: 30%" src="images/icon/approved_small.png" class="img img-responsive" />
							</div>
						<?php } }?>
				</div>
			</div>
            </div>
            <!-- /.col -->
        </div>
    </form>
    <!-- /.row -->
</section>
<!-- /.content -->
<div class="clearfix"></div>
<div class="row">
		<div class="col-sm-12">
			<center>
				<a class="btn btn-app" onclick="printDiv('printableArea')" value="print a div!">
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
