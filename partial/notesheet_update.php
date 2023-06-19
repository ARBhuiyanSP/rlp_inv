<?php
    $currentUserId  	=   $_SESSION['logged']['user_id'];
    $notesheet_id  	 	=   $_GET['id'];    
    $notesheets    		=   getNotesheetDetailsData($notesheet_id);   
    $notesheets_master	=   $notesheets['notesheets_master'];
    $notesheets    		=   $notesheets['notesheets'];
?>
<!-- Main content -->
<section class="invoice">
    <!-- Info row -->
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
    <!-- table row -->
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
            <!-- /.col -->
        </div>
    <!-- /.row -->
    <?php
    $role       =   get_role_group_short_name();
    
    if(is_super_admin($currentUserId)){
        include 'notesheet_update_view_sa.php';
    }elseif($role    ==  "member"){
        include 'notesheet_update_view_member.php';
    }elseif($role    ==  "dh"){
        include 'notesheet_update_view_dh.php';
    }elseif($role    ==  "ab"){
        include 'notesheet_update_view_ab.php';
    }else{
        include 'notesheet_update_view_dh.php';
    }
    ?>
</section>
<!-- /.content -->
<div class="clearfix"></div>