<?php
    $currentUserId  =   $_SESSION['logged']['user_id'];
    $rlp_id         =   $_GET['rlp_id'];    
    $rlp_details    =   getRlpDetailsData($rlp_id);   
    $rlp_info       =   $rlp_details['rlp_info'];
    $rlp_details    =   $rlp_details['rlp_details'];
?>
<!-- Main content -->
<section class="invoice">
    <form action="" method="POST">
    <!-- title row -->
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                <i class="fa fa-file"></i> RLP Details.
                <small class="pull-right">Priority: <?php echo getPriorityNameDiv($rlp_info->priority) ?></small>
            </h2>
        </div>
        <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-md-4 invoice-col">
            From
            <address>
                <strong>Name:&nbsp;<?php echo $rlp_info->request_person ?></strong><br>
                Designation:&nbsp;<?php echo getDesignationNameById($rlp_info->designation) ?><br>
                Division:&nbsp;<?php echo getDivisionNameById($rlp_info->request_division) ?><br>
                Department:&nbsp;<?php echo getDepartmentNameById($rlp_info->request_department) ?><br>
            </address>
        </div>
        <!-- /.col -->
        <div class="col-md-8 invoice-col">
            <div class="pull-right">
				<?php $notesheetNo    =   get_notesheet_no(); ?>
                <b>Notesheet NO: &nbsp;<span class="rlpno_style"><?php echo $notesheetNo; ?></span></b><br>
                <input type="hidden" name="notesheet_no" value="<?php echo $notesheetNo; ?>">
				
                <b>RLP NO: &nbsp;<span class="rlpno_style"><?php echo $rlp_info->rlp_no ?></span></b><br>
                <input type="hidden" name="rlp_no" value="<?php echo $rlp_info->rlp_no; ?>">
                <b>Request Date:</b> <?php echo human_format_date($rlp_info->created_at) ?><br>
            </div>            
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
        <div class="row">
            <div class="col-xs-12">
				<div class="form-group">
					<label for="exampleId">Subject</label>
					<input name="subject" type="text" class="form-control" id="subject" value="" autocomplete="off" />
				</div>
			</div>
            <div class="col-xs-12">
				<div class="form-group">
					<label for="exampleId">Ref. Text/ NS Info</label>
					<input name="ns_info" type="text" class="form-control" id="subject" value="" autocomplete="off" />
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
                            <th>Purpose of Purchase</th>
                            <th width="10%">Quantity</th>
                            <th width="10%">Unit Price</th>
                            <th width="10%">Total</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody id="tbl_posts_body">
                        <?php
                        $sl =   1;
                            foreach($rlp_details as $data){
                        ?>
                        <tr id="rec-1">
                            <td><?php echo $sl++; ?></td>
                            <td><input type="text" class="form-control" name="item[]" id="" value="<?php echo (isset($data->item_des) && !empty($data->item_des) ? $data->item_des : ""); ?>" readonly ></td>
                            <td><?php echo $data->purpose; ?></td>
                            <td><input type="text" class="form-control" onkeyup="caltotal(<?php echo $data->id; ?>)" name="quantity[]" id="quantity_<?php echo $data->id; ?>" value="<?php echo (isset($data->quantity) && !empty($data->quantity) ? $data->quantity : ""); ?>" required ></td>
                            <td><input type="text" class="form-control" onkeyup="caltotal(<?php echo $data->id; ?>)" name="unit_price[]" id="unit_price_<?php echo $data->id; ?>" value="" required ></td>
                            <td>
                                <div class="form-group">
                                    <input type="text" class="form-control total_amount" name="total[]" id="total_<?php echo $data->id; ?>" value="" readonly >
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input type="text" class="form-control" name="remarks[]" value="">
                                    
                                </div>
                            </td>
                        </tr>                        
                            <?php } ?>
							
                        <?php if(is_super_admin($currentUserId)){ ?>                       
					   <tr>
                            <td colspan="5" style="text-align:right">Sub Total : </td>
							<td>
								<input type="text" class="form-control" name="sub_total" onchange="calculate_total_buy_amount()" id="allcur" />
                            </td>
                            <td></td>
                        </tr>
						<tr>
                            <td colspan="3" style="text-align:right">AIT [%] : </td>
							<td colspan="2">
								<input type="text" class="form-control" id="ait" onkeyup="calculate_total_buy_amount()" required /><small style="color:red">Type '0' If Not Applicable</small>
                            </td>
							<td>
								<input type="text" class="form-control" name="ait" id="aitamount" readonly />
                            </td>
                            <td></td>
                        </tr>
						<tr>
                            <td colspan="3" style="text-align:right">VAT [%] : </td>
							<td colspan="2">
								<input type="text" class="form-control" id="vat" onkeyup="calculate_total_buy_amount()" required /><small style="color:red">Type '0' If Not Applicable</small>
                            </td>
							<td>
								<input type="text" class="form-control" name="vat" id="vatamount" readonly />
                            </td>
                            <td></td>
                        </tr>
						<tr>
                            <td colspan="5" style="text-align:right">Grand Total : </td>
							<td>
								<input type="text" class="form-control" name="grand_total" id="grandTotal" readonly />
                            </td>
                            <td></td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
            <!-- /.col -->
        </div>
		<div class="row">
			<div class="col-md-12">
				<?php echo get_user_wise_notesheet_chain_for_create(); ?>
			</div>
			<input type="submit" class="btn btn-primary btn-block" name="create_notesheet" value="Generate Note Sheet">
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
