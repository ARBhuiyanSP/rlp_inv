<?php

	$currentUserId  	=   $_SESSION['logged']['user_id'];
    $notesheet_id  	 	=   $_GET['id'];    
    $notesheets    		=   getNotesheetDetailsData($notesheet_id);   
    $notesheets_master	=   $notesheets['notesheets_master'];
    $notesheets    		=   $notesheets['notesheets'];
?>
<!-- Main content -->
<section class="invoice" id="printableArea">
    <form action="" method="POST">
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-md-12">
			<center>
				<h5 align="center"><img src="images/spl.png" height="50"></h5>
				<h2>E-Engineering Limited</h2>
				<p>Khawaja Tower[13th Floor], 95 Bir Uttam A.K Khandokar Road, Mohakhali C/A, Dhaka-1212, Bangladesh</p>
				<h5><b>Note Sheet - [Req No: <?php echo $notesheets_master->notesheet_no ?>]</b></h5>
			</center>
			<h5><b>Subject : <?php echo $notesheets_master->subject ?></b></h5></br>
			<h5>
				<b>Supplier Name : <?php echo $notesheets_master->supplier_name ?></b></br>
				Address : <?php echo $notesheets_master->address ?></br>
				Concern person : <?php echo $notesheets_master->concern_person ?></br>
				Call : <?php echo $notesheets_master->cell_number ?>, E-Mail:  <?php echo $notesheets_master->email ?></br>
			</h5>
		</div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
        <div class="row">
			<div class="col-xs-12 table-responsive">
                <p><?php echo $notesheets_master->ns_info ?></p>
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
                            foreach($notesheets as $data){
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
                            <td><?php echo $notesheets_master->sub_total; ?></td>
                        </tr>
						<tr id="rec-1">
                            <td colspan="5" style="text-align:right">AIT: </td>
                            <td><?php echo $notesheets_master->ait; ?></td>
                        </tr>
						<tr id="rec-1">
                            <td colspan="5" style="text-align:right">VAT: </td>
                            <td><?php echo $notesheets_master->vat; ?></td>
                        </tr>
						<tr id="rec-1">
                            <td colspan="5" style="text-align:right">Grand Total: </td>
                            <td><?php echo $notesheets_master->grand_total; ?></td>
                        </tr>
						<tr id="rec-1">
                            <td colspan="7" style="text-align:left"><b>In word: <?php echo convertNumberToWords($notesheets_master->grand_total); ?> Only</b></td>
                        </tr>
                    </tbody>
                </table>
            </div>
			<div class="col-xs-12 table-responsive">
				<p>This is for your kind approval.</p>
				<p style="text-decoration:underline;"><b>Other terms and conditions</b></p>
				<ul>
					<li> Date of Commencement</li>
					<li> Delivery of Goods: Within 03(Three) days after receiving the work order.</li>
					<li> Mode of payment: After 45 days from the date of bill Submission.</li>
					<li> Avobe rate is includig VAT, AIT & other Taxes.</li>
					<li> Transport & Courier cost will be charged by Buyers.</li>
					<li> Supply Location: Mongla Project Contact Person:Shadat Babu, 01729714503(Manager, mechanical)</li>
				</ul>
            </div>
			<div class="row">
				<div class="col-sm-4 col-xs-4" style="padding-top:100px;">
					<center>________________________</br>Asst. Manager(Mechanical)</center>
				</div>
				<div class="col-sm-4 col-xs-4" style="padding-top:100px;">
					<center>________________________</br>Logistic Incharge</center>
				</div>
				<div class="col-sm-4 col-xs-4" style="padding-top:100px;">
					<center>________________________</br>Head of Accounts</center>
				</div>
				<div class="col-sm-4 col-xs-4" style="padding-top:100px;">
					<center>________________________</br>ED(Mechanical)</center>
				</div>
				<div class="col-sm-4 col-xs-4" style="padding-top:100px;">
					<center>________________________</br>Director</center>
				</div>
				<div class="col-sm-4 col-xs-4" style="padding-top:100px;">
					<center>________________________</br>Chairman</center>
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
