<?php
if (isset($_POST['create_workorder']) && !empty($_POST['create_workorder'])){

    //$date		= (isset($_POST['date']) && !empty($_POST['date']) ? trim(mysqli_real_escape_string($conn,$_POST['date'])) : date("Y-m-d"));
    $wo_no		= (isset($_POST['wo_no']) && !empty($_POST['wo_no']) ? trim(mysqli_real_escape_string($conn,$_POST['wo_no'])) : "");
    $notesheet_no		= (isset($_POST['notesheet_no']) && !empty($_POST['notesheet_no']) ? trim(mysqli_real_escape_string($conn,$_POST['notesheet_no'])) : "");
    $rlp_no		= (isset($_POST['rlp_no']) && !empty($_POST['rlp_no']) ? trim(mysqli_real_escape_string($conn,$_POST['rlp_no'])) : "");
    $remarks		= (isset($_POST['remarks']) && !empty($_POST['remarks']) ? trim(mysqli_real_escape_string($conn,$_POST['remarks'])) : "");
    
    /*
     * *****************************rrr_info table operation********************
     */    
    $notesheets_info_response  =   execute_workorder_details_table();
    $notesheets_info_response  =   execute_workorder_master_table();
    if(isset($notesheets_info_response) && $notesheets_info_response['status'] == "success"){
        
        $_SESSION['success']    =   "Your request have been successfully procced.";
    }else{
        //$_SESSION['error']    =   "Failed to save data";
		$_SESSION['success']    =   "Your request have been successfully procced.";
    }
    header("location: workorders_list.php");
    exit();
}
function execute_workorder_master_table(){
		global $conn;
		$wo_no		= (isset($_POST['wo_no']) && !empty($_POST['wo_no']) ? trim(mysqli_real_escape_string($conn,$_POST['wo_no'])) : "");
		$notesheet_no		= (isset($_POST['notesheet_no']) && !empty($_POST['notesheet_no']) ? trim(mysqli_real_escape_string($conn,$_POST['notesheet_no'])) : "");
		$rlp_no		= (isset($_POST['rlp_no']) && !empty($_POST['rlp_no']) ? trim(mysqli_real_escape_string($conn,$_POST['rlp_no'])) : "");
		$subject		= (isset($_POST['subject']) && !empty($_POST['subject']) ? trim(mysqli_real_escape_string($conn,$_POST['subject'])) : "");
		$ns_info		= (isset($_POST['ns_info']) && !empty($_POST['ns_info']) ? trim(mysqli_real_escape_string($conn,$_POST['ns_info'])) : "");
		$supplier_name		= (isset($_POST['supplier_name']) && !empty($_POST['supplier_name']) ? trim(mysqli_real_escape_string($conn,$_POST['supplier_name'])) : "");
		$address		= (isset($_POST['address']) && !empty($_POST['address']) ? trim(mysqli_real_escape_string($conn,$_POST['address'])) : "");
		$concern_person		= (isset($_POST['concern_person']) && !empty($_POST['concern_person']) ? trim(mysqli_real_escape_string($conn,$_POST['concern_person'])) : "");
		$cell_number		= (isset($_POST['cell_number']) && !empty($_POST['cell_number']) ? trim(mysqli_real_escape_string($conn,$_POST['cell_number'])) : "");
		$email		= (isset($_POST['email']) && !empty($_POST['email']) ? trim(mysqli_real_escape_string($conn,$_POST['email'])) : "");
		$ait		= (isset($_POST['ait']) && !empty($_POST['ait']) ? trim(mysqli_real_escape_string($conn,$_POST['ait'])) : "");
		$sub_total		= (isset($_POST['sub_total']) && !empty($_POST['sub_total']) ? trim(mysqli_real_escape_string($conn,$_POST['sub_total'])) : "");
		$remarks		= (isset($_POST['remarks']) && !empty($_POST['remarks']) ? trim(mysqli_real_escape_string($conn,$_POST['remarks'])) : "");
		$vat		= (isset($_POST['vat']) && !empty($_POST['vat']) ? trim(mysqli_real_escape_string($conn,$_POST['vat'])) : "");
		$grand_total		= (isset($_POST['grand_total']) && !empty($_POST['grand_total']) ? trim(mysqli_real_escape_string($conn,$_POST['grand_total'])) : "");
                       
        $dataParam     =   [
            //'id'                =>  get_table_next_primary_id('rlp_details'),
            'wo_no'	=>  $wo_no,
            'notesheet_no'	=>  $notesheet_no,
            'rlp_no'       	=>  $rlp_no,
            'subject'	=>  $subject,
            'ns_info'	=>  $ns_info,
            'supplier_name'	=>  $supplier_name,
            'address' 		=>  $address,
            'concern_person' =>  $concern_person,
            'cell_number'   =>  $cell_number,
            'email'       	=>  $email,
            'no_of_item'       	=>  $no_of_material,
            'sub_total'			=>  $sub_total,
            'ait'	 	=>  $ait,
            'vat' 	=>  $vat,
            'grand_total' 	 	=>  $grand_total,
            'status'		=>  '0',
			'created_at'	=>  date('Y-m-d h:i:s'),
			'created_by'	=>  $_SESSION['logged']['user_id']
        ];
    
    $response   =   saveData("workorders_master", $dataParam);
    return $response;
}
function execute_workorder_details_table(){
    global $conn;
    /*
     * *****************************rrr_details table operation********************
     */
	 $no_of_material     =   0;
    for($count 		= 0; $count<count($_POST['item']); $count++){
        $wo_no		= (isset($_POST['wo_no']) && !empty($_POST['wo_no']) ? trim(mysqli_real_escape_string($conn,$_POST['wo_no'])) : "");
        $notesheet_no		= (isset($_POST['notesheet_no']) && !empty($_POST['notesheet_no']) ? trim(mysqli_real_escape_string($conn,$_POST['notesheet_no'])) : "");
		$rlp_no		= (isset($_POST['rlp_no']) && !empty($_POST['rlp_no']) ? trim(mysqli_real_escape_string($conn,$_POST['rlp_no'])) : "");
		$subject		= (isset($_POST['subject']) && !empty($_POST['subject']) ? trim(mysqli_real_escape_string($conn,$_POST['subject'])) : "");
		$supplier_name		= (isset($_POST['supplier_name']) && !empty($_POST['supplier_name']) ? trim(mysqli_real_escape_string($conn,$_POST['supplier_name'])) : "");
		$address		= (isset($_POST['address']) && !empty($_POST['address']) ? trim(mysqli_real_escape_string($conn,$_POST['address'])) : "");
		$concern_person		= (isset($_POST['concern_person']) && !empty($_POST['concern_person']) ? trim(mysqli_real_escape_string($conn,$_POST['concern_person'])) : "");
		$cell_number		= (isset($_POST['cell_number']) && !empty($_POST['cell_number']) ? trim(mysqli_real_escape_string($conn,$_POST['cell_number'])) : "");
		$email		= (isset($_POST['email']) && !empty($_POST['email']) ? trim(mysqli_real_escape_string($conn,$_POST['email'])) : "");
		$remarks		= (isset($_POST['remarks']) && !empty($_POST['remarks']) ? trim(mysqli_real_escape_string($conn,$_POST['remarks'])) : "");
        $item	= (isset($_POST['item'][$count]) && !empty($_POST['item'][$count]) ? trim(mysqli_real_escape_string($conn,$_POST['item'][$count])) : '');
        $quantity	= (isset($_POST['quantity'][$count]) && !empty($_POST['quantity'][$count]) ? trim(mysqli_real_escape_string($conn,$_POST['quantity'][$count])) : '');
        $unit_price	= (isset($_POST['unit_price'][$count]) && !empty($_POST['unit_price'][$count]) ? trim(mysqli_real_escape_string($conn,$_POST['unit_price'][$count])) : '');
        $total	= (isset($_POST['total'][$count]) && !empty($_POST['total'][$count]) ? trim(mysqli_real_escape_string($conn,$_POST['total'][$count])) : '');        
        $remarks= (isset($_POST['remarks'][$count]) && !empty($_POST['remarks'][$count]) ? trim(mysqli_real_escape_string($conn,$_POST['remarks'][$count])) : '');  
		$no_of_material     = $no_of_material+$quantity;
        $dataParam     =   [
            //'id'                =>  get_table_next_primary_id('rlp_details'),
            'wo_no'	=>  $wo_no,
            'notesheet_no'	=>  $notesheet_no,
            'rlp_no'       	=>  $rlp_no,
            'subject'	=>  $subject,
            'supplier_name'	=>  $supplier_name,
            'address' 		=>  $address,
            'concern_person' =>  $concern_person,
            'cell_number'   =>  $cell_number,
            'email'       	=>  $email,
            'item'       	=>  $item,
            'unit'			=>  'Pics',
            'quantity'	 	=>  $quantity,
            'unit_price' 	=>  $unit_price,
            'total' 	 	=>  $total,
            'remarks'		=>  $remarks,
            'status'		=>  'Created',
			'created_at'	=>  date('Y-m-d h:i:s'),
			'created_by'	=>  $_SESSION['logged']['user_id']
        ];
    
        saveData("workorders", $dataParam);
    }
}


if(isset($_GET['process_type']) && $_GET['process_type'] == "wo_update_execute"){
    date_default_timezone_set("Asia/Dhaka");
    include '../connection/connect.php';
    include '../helper/utilities.php';
    //$param['wo_no']   =   $_POST['wo_no'];
    //update_rlp_acknowledgement($param);
    $dataParam['wo_no']     =   $_POST['wo_no'];
    $dataParam['status']     =   $_POST['acknowledgement'];
    $dataParam['updated_by']     =   $_POST['created_by'];
    $dataParam['updated_at']     =   date("Y-d-m H:i:s");
    $where      =   [
        'id'    =>  $dataParam['wo_no']
    ];
    updateData('workorders_master', $dataParam, $where);
    //save_rlp_remarks();
    $feedback   =   [
        'status'    => "success",
        'message'   => "Work Order have been successfully updated",
    ];
    
    echo json_encode($feedback);
}



function getWorkordersDetailsData($rlp_id){
    $table      =   "`workorders_master` WHERE `wo_no`='$rlp_id'";
    $rlp_info   = getDataRowIdAndTable($table);
    
    $order = 'asc';
    $column='id';
    $table         =   "`workorders` WHERE `wo_no`='$rlp_id'";
    $rlp_details   = getTableDataByTableName($table, $order, $column);
    
    $feedbackData   =   [
        'rlp_info'      =>  $rlp_info,
        'rlp_details'   =>  $rlp_details
    ];
    return $feedbackData;
}




