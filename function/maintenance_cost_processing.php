<?php
if (isset($_POST['cost_entry']) && !empty($_POST['cost_entry'])){

    $m_cost_id		= (isset($_POST['m_cost_id']) && !empty($_POST['m_cost_id']) ? trim(mysqli_real_escape_string($conn,$_POST['m_cost_id'])) : "");
    $eel_code		= (isset($_POST['eel_code']) && !empty($_POST['eel_code']) ? trim(mysqli_real_escape_string($conn,$_POST['eel_code'])) : "");
	$in_time		= (isset($_POST['in_time']) && !empty($_POST['in_time']) ? trim(mysqli_real_escape_string($conn,$_POST['in_time'])) : date("Y-m-d h:i:s"));
	$out_time		= (isset($_POST['out_time']) && !empty($_POST['out_time']) ? trim(mysqli_real_escape_string($conn,$_POST['out_time'])) : date("Y-m-d h:i:s"));
    $problem_details		= (isset($_POST['problem_details']) && !empty($_POST['problem_details']) ? trim(mysqli_real_escape_string($conn,$_POST['problem_details'])) : "");
    $remarks		= (isset($_POST['remarks']) && !empty($_POST['remarks']) ? trim(mysqli_real_escape_string($conn,$_POST['remarks'])) : "");
    
    /*
     * *****************************rrr_info table operation********************
     */    
    $notesheets_info_response  =   execute_maintenance_spare_parts_table();
    $notesheets_info_response  =   execute_maintenance_mechanic_table();
    $notesheets_info_response  =   execute_maintenance_cost_table();
    if(isset($notesheets_info_response) && $notesheets_info_response['status'] == "success"){
        
        $_SESSION['success']    =   "Your request have been successfully procced.";
    }else{
        //$_SESSION['error']    =   "Failed to save data";
		$_SESSION['success']    =   "Your request have been successfully procced.";
    }
    header("location: maintenance_cost.php");
    exit();
}
function execute_maintenance_cost_table(){
		global $conn;
		$m_cost_id		= (isset($_POST['m_cost_id']) && !empty($_POST['m_cost_id']) ? trim(mysqli_real_escape_string($conn,$_POST['m_cost_id'])) : "");
		$eel_code		= (isset($_POST['eel_code']) && !empty($_POST['eel_code']) ? trim(mysqli_real_escape_string($conn,$_POST['eel_code'])) : "");
		$in_time		= (isset($_POST['in_time']) && !empty($_POST['in_time']) ? trim(mysqli_real_escape_string($conn,$_POST['in_time'])) : date("Y-m-d h:i:s"));
		$out_time		= (isset($_POST['out_time']) && !empty($_POST['out_time']) ? trim(mysqli_real_escape_string($conn,$_POST['out_time'])) : date("Y-m-d h:i:s"));
		$problem_details		= (isset($_POST['problem_details']) && !empty($_POST['problem_details']) ? trim(mysqli_real_escape_string($conn,$_POST['problem_details'])) : "");
		$remarks		= (isset($_POST['remarks']) && !empty($_POST['remarks']) ? trim(mysqli_real_escape_string($conn,$_POST['remarks'])) : "");
                       
        $dataParam     =   [
            'm_cost_id'	=>  $m_cost_id,
            'eel_code'	=>  $eel_code,
            'in_time'       	=>  $in_time,
            'out_time'	=>  $out_time,
            'problem_details'	=>  $problem_details,
            'remarks'	=>  $remarks,
            'status'		=>  'Created',
			'created_at'	=>  date('Y-m-d h:i:s'),
			'created_by'	=>  $_SESSION['logged']['user_id']
        ];
    
    $response   =   saveData("maintenance_cost", $dataParam);
    return $response;
}
function execute_maintenance_spare_parts_table(){
    global $conn;
    /*
     * *****************************rrr_details table operation********************
     */
	 $no_of_material     =   0;
    for($count 		= 0; $count<count($_POST['material_name']); $count++){
        $m_cost_id		= (isset($_POST['m_cost_id']) && !empty($_POST['m_cost_id']) ? trim(mysqli_real_escape_string($conn,$_POST['m_cost_id'])) : "");
        $material_name	= (isset($_POST['material_name'][$count]) && !empty($_POST['material_name'][$count]) ? trim(mysqli_real_escape_string($conn,$_POST['material_name'][$count])) : '');
        $quantity	= (isset($_POST['quantity'][$count]) && !empty($_POST['quantity'][$count]) ? trim(mysqli_real_escape_string($conn,$_POST['quantity'][$count])) : '');
        $unit_price	= (isset($_POST['unit_price'][$count]) && !empty($_POST['unit_price'][$count]) ? trim(mysqli_real_escape_string($conn,$_POST['unit_price'][$count])) : '');
        $totalamount	= (isset($_POST['totalamount'][$count]) && !empty($_POST['totalamount'][$count]) ? trim(mysqli_real_escape_string($conn,$_POST['totalamount'][$count])) : '');
		$no_of_material     = $no_of_material+$quantity;
        $dataParam     =   [
            //'id'                =>  get_table_next_primary_id('rlp_details'),
            'm_cost_id'	=>  $m_cost_id,
            'spare_parts_name'	=>  $material_name,
            'qty'	=>  $quantity,
            'rate'	=>  $unit_price,
            'amount'	=>  $totalamount,
            
			'created_at'	=>  date('Y-m-d h:i:s'),
			'created_by'	=>  $_SESSION['logged']['user_id']
        ];
    
        saveData("maintenance_spare_parts", $dataParam);
    }
}

function execute_maintenance_mechanic_table(){
    global $conn;
    /*
     * *****************************rrr_details table operation********************
     */
	 $no_of_mmechanic     =   0;
    for($count 		= 0; $count<count($_POST['mechanic_name']); $count++){
        $m_cost_id		= (isset($_POST['m_cost_id']) && !empty($_POST['m_cost_id']) ? trim(mysqli_real_escape_string($conn,$_POST['m_cost_id'])) : "");
        $mechanic_name	= (isset($_POST['mechanic_name'][$count]) && !empty($_POST['mechanic_name'][$count]) ? trim(mysqli_real_escape_string($conn,$_POST['mechanic_name'][$count])) : '');
		$no_of_mmechanic     = $no_of_mmechanic+$mechanic_name;
        $dataParam     =   [
            //'id'                =>  get_table_next_primary_id('rlp_details'),
            'm_cost_id'	=>  $m_cost_id,
            'mechanic_name'	=>  $mechanic_name,
            
			'created_at'	=>  date('Y-m-d h:i:s'),
			'created_by'	=>  $_SESSION['logged']['user_id']
        ];
    
        saveData("maintenance_mechanic", $dataParam);
    }
}


function getMaintenanceCostDetailsData($m_cost_id){
    $table      =   "`maintenance_cost` WHERE `m_cost_id`='$m_cost_id'";
    $m_cost_info   = getDataRowIdAndTable($table);
    
    $order = 'asc';
    $column='id';
    $table         =   "`maintenance_spare_parts` WHERE `m_cost_id`='$m_cost_id'";
    $m_cost_parts_details   = getTableDataByTableName($table, $order, $column);
    
    $feedbackData   =   [
        'm_cost_info'      =>  $m_cost_info,
        'm_cost_parts_details'   =>  $m_cost_parts_details
    ];
    return $feedbackData;
}


