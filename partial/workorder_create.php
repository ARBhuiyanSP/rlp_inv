<?php

	
	
	$currentUserId  	=   $_SESSION['logged']['user_id'];
    $notesheet_id  	 	=   $_GET['id'];    
    $notesheets    		=   getNotesheetDetailsData($notesheet_id);   
    $notesheets_master	=   $notesheets['notesheets_master'];
    $notesheets    		=   $notesheets['notesheets'];
?>
<!-- Main content -->
<section class="invoice">
    <form action="" method="POST">
    <!-- info row -->
    <div class="row invoice-info">
        <!-- /.col -->
        <div class="col-md-8 invoice-col">
            <div class="pull-left">
                <?php $workorderNo    =   get_wo_no(); ?>
                <b>Workorder NO: &nbsp;<span class="rlpno_style"><?php echo $workorderNo; ?></span></b><br>
				<input type="hidden" name="wo_no" value="<?php echo $workorderNo; ?>">
                <b>Notesheet NO: &nbsp;<span class="rlpno_style"><?php echo $notesheets_master->notesheet_no; ?></span></b><br>
				<input type="hidden" name="notesheet_no" value="<?php echo $notesheets_master->notesheet_no; ?>">
                <b>RLP NO: &nbsp;<span class="rlpno_style"><?php echo $notesheets_master->rlp_no ?></span></b><br>
                <input type="hidden" name="rlp_no" value="<?php echo $notesheets_master->rlp_no; ?>">
                <b>Request Date:</b> <?php echo human_format_date($notesheets_master->created_at) ?><br>
            </div>            
        </div>
        <!-- /.col -->
		<div class="col-md-4s invoice-col">
            <div class="pull-right">
            </div>            
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
        <div class="row">
            <div class="col-xs-6">
				<div class="form-group">
					<label for="exampleId">Subject</label>
					<textarea name="subject" class="form-control"></textarea>
				</div>
			</div>
            <div class="col-xs-6">
				<div class="form-group">
					<label for="exampleId">Ref. Text/ NS Info</label>
					<textarea name="ns_info" class="form-control"></textarea>
				</div>
			</div>
            <div class="col-xs-6">
				<div class="form-group">
					<label for="exampleId">Supplier Name</label>
					<input name="supplier_name" type="text" class="form-control" id="supplier_name" value="" autocomplete="off" />
				</div>
			</div>
            <div class="col-xs-6">
				<div class="form-group">
					<label for="exampleId">Address</label>
					<input name="address" type="text" class="form-control" id="address" value="" autocomplete="off" />
				</div>
			</div>
            <div class="col-xs-4">
				<div class="form-group">
					<label for="exampleId">Concern Person</label>
					<input name="concern_person" type="text" class="form-control" id="concern_person" value="" autocomplete="off" />
				</div>
			</div>
            <div class="col-xs-4">
				<div class="form-group">
					<label for="exampleId">Cell Number</label>
					<input name="cell_number" type="text" class="form-control" id="cell_number" value="" autocomplete="off" />
				</div>
			</div>
            <div class="col-xs-4">
				<div class="form-group">
					<label for="exampleId">Email</label>
					<input name="email" type="text" class="form-control" id="email" value="" autocomplete="off" />
				</div>
			</div>
			<div class="col-xs-12 table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
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
                            foreach($notesheets as $data){
                        ?>
                        <tr id="rec-1">
                            <td><?php echo $sl++; ?></td>
                            <td><?php echo (isset($data->item) && !empty($data->item) ? $data->item : ""); ?></td>
							<input type="hidden" class="form-control" name="item[]" value="<?php echo (isset($data->item) && !empty($data->item) ? $data->item : ""); ?>" >
                            <td></td>
                            <td><?php echo (isset($data->quantity) && !empty($data->quantity) ? $data->quantity : ""); ?></td>
							<input type="hidden" class="form-control" name="quantity[]" value="<?php echo (isset($data->quantity) && !empty($data->quantity) ? $data->quantity : ""); ?>" >
                            <td><?php echo (isset($data->unit_price) && !empty($data->unit_price) ? $data->unit_price : ""); ?></td>
							<input type="hidden" class="form-control" name="unit_price[]" value="<?php echo (isset($data->unit_price) && !empty($data->unit_price) ? $data->unit_price : ""); ?>" >
                            <td><?php echo (isset($data->total) && !empty($data->total) ? $data->total : ""); ?></td>
							<input type="hidden" class="form-control" name="total[]" value="<?php echo (isset($data->total) && !empty($data->total) ? $data->total : ""); ?>" >
                        </tr>                        
                            <?php } ?>
							
                        <?php if(is_super_admin($currentUserId)){ ?>                       
					   <tr>
                            <td colspan="5" style="text-align:right">Sub Total : </td>
							<td><?php echo (isset($notesheets_master->sub_total) && !empty($notesheets_master->sub_total) ? $notesheets_master->sub_total : ""); ?></td>
							<input type="hidden" class="form-control" name="sub_total" value="<?php echo (isset($notesheets_master->sub_total) && !empty($notesheets_master->sub_total) ? $notesheets_master->sub_total : ""); ?>" >
                        </tr>
						<tr>
                            <td colspan="5" style="text-align:right">AIT [%] : </td>
							<td><?php echo (isset($notesheets_master->ait) && !empty($notesheets_master->ait) ? $notesheets_master->ait : ""); ?></td>
							<input type="hidden" class="form-control" name="ait" value="<?php echo (isset($notesheets_master->ait) && !empty($notesheets_master->ait) ? $notesheets_master->ait : ""); ?>" >
                        </tr>
						<tr>
                            <td colspan="5" style="text-align:right">VAT [%] : </td>
							<td><?php echo (isset($notesheets_master->vat) && !empty($notesheets_master->vat) ? $notesheets_master->vat : ""); ?></td>
							<input type="hidden" class="form-control" name="vat" value="<?php echo (isset($notesheets_master->vat) && !empty($notesheets_master->vat) ? $notesheets_master->vat : ""); ?>" >
                        </tr>
						<tr>
                            <td colspan="5" style="text-align:right">Grand Total : </td>
							<td><?php echo (isset($notesheets_master->grand_total) && !empty($notesheets_master->grand_total) ? $notesheets_master->grand_total : ""); ?></td>
							<input type="hidden" class="form-control" name="grand_total" value="<?php echo (isset($notesheets_master->grand_total) && !empty($notesheets_master->grand_total) ? $notesheets_master->grand_total : ""); ?>" >
                        </tr>
					   <tr>
                            <td colspan="7">
								<input type="submit" class="btn btn-primary btn-block" name="create_workorder" value="Generate Work Order">
                            </td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
            <!-- /.col -->
        </div>
    </form>
    <!-- /.row -->
</section>

<!-- /.content -->
<div class="clearfix"></div>

<script>
function  caltotal(id){
	let quantity = parseFloat($('#quantity_'+id).val());
    let unit_price = parseFloat($('#unit_price_'+id).val());
	
	let myResult = parseFloat(quantity * unit_price).toFixed(2);

    $('#total_'+id).val(myResult);
	
	 calculate_total_buy_amount();
}

function calculate_total_buy_amount() {
        let subTotalAmount     =   $(".total_amount");
        let subBuyTotal     =   0;

        for(let mySubValue = 0;  mySubValue < subTotalAmount.length; mySubValue++){
            subBuyTotal+= parseFloat($("#" + subTotalAmount[mySubValue].id).val());
			
        }
        
        document.getElementById('allcur').value = subBuyTotal.toFixed(2);
		 
		
		$(function(){
    
    $('#allcur').on('input', function() {
      calculate();
    });
    $('#vat').on('input', function() {
     calculate();
    });
	$('#ait').on('input', function() {
     calculate();
    });
    function calculate(){
        var subTotal = parseFloat($('#allcur').val()).toFixed(2); 
        var vat = parseFloat($('#vat').val()).toFixed(2);
        var ait = parseFloat($('#ait').val()).toFixed(2);
        var aitPerc="";
		if(isNaN(subTotal) || isNaN(ait)){
            aitPerc=" ";
           }else{
           aitPerc = ((subTotal*ait)/ 100).toFixed(2);
           }
        
        $('#aitamount').val(aitPerc);
		var pAit = parseFloat($('#aitamount').val()).toFixed(2);
		
        var vatPerc="";
        if(isNaN(subTotal) || isNaN(vat)){
            vatPerc=" ";
           }else{
           vatPerc = ((subTotal*vat)/ 100).toFixed(2);
           }
        
        $('#vatamount').val(vatPerc);
		var pVat = parseFloat($('#vatamount').val()).toFixed(2);
		
		//var grandTotal = parseFloat(subTotal + pVat).toFixed(2);
		var grandTotal = (parseFloat(subTotal) + parseFloat(pVat) + parseFloat(pAit)).toFixed(2);

		$('#grandTotal').val(grandTotal).toFixed(2);
    }
calculate();
});
                
    }
	





</script>
