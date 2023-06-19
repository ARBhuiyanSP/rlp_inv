<?php
if (isset($_POST['create_notesheet']) && !empty($_POST['create_notesheet'])){

    //$date		= (isset($_POST['date']) && !empty($_POST['date']) ? trim(mysqli_real_escape_string($conn,$_POST['date'])) : date("Y-m-d"));
    $notesheet_no		= (isset($_POST['notesheet_no']) && !empty($_POST['notesheet_no']) ? trim(mysqli_real_escape_string($conn,$_POST['notesheet_no'])) : "");
    $rlp_no		= (isset($_POST['rlp_no']) && !empty($_POST['rlp_no']) ? trim(mysqli_real_escape_string($conn,$_POST['rlp_no'])) : "");
    $remarks		= (isset($_POST['remarks']) && !empty($_POST['remarks']) ? trim(mysqli_real_escape_string($conn,$_POST['remarks'])) : "");
    
    /*
     * *****************************rrr_info table operation********************
     */    
    $notesheets_info_response  =   execute_notesheets_details_table();
    $notesheets_info_response  =   execute_notesheets_master_table();
    if(isset($notesheets_info_response) && $notesheets_info_response['status'] == "success"){
		 $notesheet_info_id    =   $notesheets_info_response['last_id'];
		 
		$ackParam['acknowledge_user']   =   $_POST['assign_users_order'];
        $ackParam['notesheet_id']        =   $notesheet_info_id;
        $ackParam['created_by']         =   $_SESSION['logged']['user_id'];
        process_notesheet_acknowledgement($ackParam);
        
        $_SESSION['success']    =   "Your request have been successfully procced.";
    }else{
        //$_SESSION['error']    =   "Failed to save data";
		$_SESSION['success']    =   "Your request have been successfully procced.";
    }
    header("location: notesheets_list.php");
    exit();
}
function execute_notesheets_master_table(){
		global $conn;
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
            'status'		=>  'Created',
			'created_at'	=>  date('Y-m-d h:i:s'),
			'created_by'	=>  $_SESSION['logged']['user_id']
        ];
    
    $response   =   saveData("notesheets_master", $dataParam);
    return $response;
}
function execute_notesheets_details_table(){
    global $conn;
    /*
     * *****************************rrr_details table operation********************
     */
	 $no_of_material     =   0;
    for($count 		= 0; $count<count($_POST['item']); $count++){
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
    
        saveData("notesheets", $dataParam);
    }
}
//Create User:
if (isset($_POST['notesheet_create']) && !empty($_POST['notesheet_create'])){

    $date		= (isset($_POST['date']) && !empty($_POST['date']) ? trim(mysqli_real_escape_string($conn,$_POST['date'])) : date("Y-m-d"));
    $priority		= (isset($_POST['priority']) && !empty($_POST['priority']) ? trim(mysqli_real_escape_string($conn,$_POST['priority'])) : "");
    $rrrNo		= (isset($_POST['rrr_no']) && !empty($_POST['rrr_no']) ? trim(mysqli_real_escape_string($conn,$_POST['rrr_no'])) : "");
    $remarks		= (isset($_POST['remarks']) && !empty($_POST['remarks']) ? trim(mysqli_real_escape_string($conn,$_POST['remarks'])) : "");
    
    /*
     * *****************************rrr_info table operation********************
     */    
    $notesheet_info_response  =   execute_notesheet_info_table();
    if(isset($notesheet_info_response) && $rrr_info_response['status'] == "success"){
        $rrr_info_id    =   $rrr_info_response['last_id'];
        /*
        * *****************************rrr_details table operation********************
        */    
        //$rrr_details_response  =   execute_rrr_details_table($rrr_info_id);
        
        $ackParam['acknowledge_user']   =   $_POST['assign_users_order'];
        $ackParam['rrr_info_id']        =   $rrr_info_id;
        $ackParam['created_by']         =   $_SESSION['logged']['user_id'];
        process_rrr_acknowledgement($ackParam);
        
        $_SESSION['success']    =   "Your request have been successfully procced.";
    }else{
        $_SESSION['error']    =   "Failed to save data";
    }
    header("location: notesheet.php");
    exit();
}


function execute_notesheet_info_table(){
    global $conn;
    $date		= (isset($_POST['date']) && !empty($_POST['date']) ? trim(mysqli_real_escape_string($conn,$_POST['date'])) : date("Y-m-d"));
    $priority		= (isset($_POST['priority']) && !empty($_POST['priority']) ? trim(mysqli_real_escape_string($conn,$_POST['priority'])) : "");
    $rrrNo		= (isset($_POST['rrr_no']) && !empty($_POST['rrr_no']) ? trim(mysqli_real_escape_string($conn,$_POST['rrr_no'])) : "");
    $remarks		= (isset($_POST['remarks']) && !empty($_POST['remarks']) ? trim(mysqli_real_escape_string($conn,$_POST['remarks'])) : "");
	/*--------------------------*/
	$req_for	= (isset($_POST['req_for']) && !empty($_POST['req_for']) ? trim(mysqli_real_escape_string($conn,$_POST['req_for'])) : "");
	$emp_type	= (isset($_POST['emp_type']) && !empty($_POST['emp_type']) ? trim(mysqli_real_escape_string($conn,$_POST['emp_type'])) : "");
	$justification_for_rec	= (isset($_POST['justification_for_rec']) && !empty($_POST['justification_for_rec']) ? trim(mysqli_real_escape_string($conn,$_POST['justification_for_rec'])) : "");
	$rem_spe_rec	= (isset($_POST['rem_spe_rec']) && !empty($_POST['rem_spe_rec']) ? trim(mysqli_real_escape_string($conn,$_POST['rem_spe_rec'])) : "");
	$req_for_division	= (isset($_POST['req_for_division']) && !empty($_POST['req_for_division']) ? trim(mysqli_real_escape_string($conn,$_POST['req_for_division'])) : "");
	$req_for_department	= (isset($_POST['req_for_department']) && !empty($_POST['req_for_department']) ? trim(mysqli_real_escape_string($conn,$_POST['req_for_department'])) : "");
	$req_designation	= (isset($_POST['req_designation']) && !empty($_POST['req_designation']) ? trim(mysqli_real_escape_string($conn,$_POST['req_designation'])) : "");
	$req_number	= (isset($_POST['req_number']) && !empty($_POST['req_number']) ? trim(mysqli_real_escape_string($conn,$_POST['req_number'])) : "");
	$req_location_project	= (isset($_POST['req_location_project']) && !empty($_POST['req_location_project']) ? trim(mysqli_real_escape_string($conn,$_POST['req_location_project'])) : "");
	$req_reporting_man	= (isset($_POST['req_reporting_man']) && !empty($_POST['req_reporting_man']) ? trim(mysqli_real_escape_string($conn,$_POST['req_reporting_man'])) : "");
	$req_salary	= (isset($_POST['req_salary']) && !empty($_POST['req_salary']) ? trim(mysqli_real_escape_string($conn,$_POST['req_salary'])) : "");
	$req_responsibilities	= (isset($_POST['req_responsibilities']) && !empty($_POST['req_responsibilities']) ? trim(mysqli_real_escape_string($conn,$_POST['req_responsibilities'])) : "");
	/*--------------------------*/
    
    /*
     * *****************************rrr_info table operation********************
     */
    $table_sql     =   "rrr_info";
    $dataParam     =   [
        'id'                    =>  get_table_next_primary_id($table_sql),
        'rrr_no'                =>  get_rrr_no(),
        'rrr_user_id'           =>  $_SESSION['logged']['user_id'],
        'rrr_user_office_id'    =>  $_SESSION['logged']['office_id'],
        'priority'              =>  $priority,
        'request_date'          =>  date('Y-m-d h:i:s', strtotime($date)),
        'request_division'      =>  $_SESSION['logged']['branch_id'],
        'request_department'    =>  $_SESSION['logged']['department_id'],
        'request_person'        =>  $_SESSION['logged']['user_name'],
        'designation'           =>  $_SESSION['logged']['designation'],
        //'email'                 =>  $_SESSION['logged']['email'],
        //'contact_number'        =>  $_SESSION['logged']['contact_number'],
        'user_remarks'          =>  $remarks,
		/*--------------------------*/
		'req_for'					=>  $req_for,
		'emp_type'          		=>  $emp_type,
		'justification_for_rec' 	=>  $justification_for_rec,
		'rem_spe_rec'          		=>  $rem_spe_rec,
		'req_for_division'          =>  $req_for_division,
		'req_for_department'    	=>  $req_for_department,
		'req_designation'        	=>  $req_designation,
		'req_number'          		=>  $req_number,
		'req_location_project'   	=>  $req_location_project,
		'req_reporting_man'     	=>  $req_reporting_man,
		'req_salary'          		=>  $req_salary,
		'req_responsibilities'   	=>  $req_responsibilities,
		'rrr_status'   				=>  '5',
		/*--------------------------*/
        'created_by'            	=>  $_SESSION['logged']['user_id'],
        'created_at'            	=>  date('Y-m-d h:i:s')
    ];
    
    $response   =   saveData("rrr_info", $dataParam);
    return $response;
}

function execute_notesheet_details_table($rrr_info_id){
    global $conn;
    /*
     * *****************************rrr_details table operation********************
     */
    for($count 		= 0; $count<count($_POST['description']); $count++){        
        $description	= (isset($_POST['description'][$count]) && !empty($_POST['description'][$count]) ? trim(mysqli_real_escape_string($conn,$_POST['description'][$count])) : '');
        $purpose	= (isset($_POST['purpose'][$count]) && !empty($_POST['purpose'][$count]) ? trim(mysqli_real_escape_string($conn,$_POST['purpose'][$count])) : '');
        $quantity	= (isset($_POST['quantity'][$count]) && !empty($_POST['quantity'][$count]) ? trim(mysqli_real_escape_string($conn,$_POST['quantity'][$count])) : '');
        $estimatedPrice	= (isset($_POST['estimatedPrice'][$count]) && !empty($_POST['estimatedPrice'][$count]) ? trim(mysqli_real_escape_string($conn,$_POST['estimatedPrice'][$count])) : '');        
        $supplier	= (isset($_POST['supplier'][$count]) && !empty($_POST['supplier'][$count]) ? trim(mysqli_real_escape_string($conn,$_POST['supplier'][$count])) : '');        
        $details_remarks= (isset($_POST['details_remarks'][$count]) && !empty($_POST['details_remarks'][$count]) ? trim(mysqli_real_escape_string($conn,$_POST['details_remarks'][$count])) : '');        
        $dataParam     =   [
            'id'                =>  get_table_next_primary_id('rlp_details'),
            'rrr_info_id'       =>  $rrr_info_id,
            'item_des'          =>  $description,
            'purpose'           =>  $purpose,
            'quantity'          =>  $quantity,
            'estimated_price'   =>  $estimatedPrice,
            'supplier'          =>  $supplier,
            'details_remarks'   =>  $details_remarks,
        ];
    
        saveData("rlp_details", $dataParam);
    }
}

if(isset($_GET['request_type']) && $_GET['request_type'] == "requested_by_info"){
    session_start();

    include "../Class/Database/Database.php";
    include '../function/global_connection.php';
    include "../helper/utilities.php";
    include "../Class/Employee.php";

    $emp_name_id    =   $_POST['emp_name_id'];


    $emp_ob     =   new Employee;

    $emp_ob->emp_id     =   trim($emp_name_id);

    $emp_info           =   $emp_ob->get_employee_info();

    echo json_encode($emp_info);
    exit;
}

if(isset($_GET['process_type']) && $_GET['process_type'] == "notesheet_dh_update_execute"){
    date_default_timezone_set("Asia/Dhaka");
    include '../connection/connect.php';
    include '../helper/utilities.php';
    $param['rrr_info_id']   =   $_POST['rrr_info_id'];
        $param['ack_status']    =   $_POST['acknowledgement'];
        $param['user_id']       =   $_POST['created_by'];
        $param['remarks']       =   $_POST['remarks'];
        //update_rrr_acknowledgement($param);
        save_notesheet_remarks();
        $feedback   =   [
            'status'    => "success",
            'message'   => "data have been successfully updated",
        ];
    
    echo json_encode($feedback);
}

function save_notesheet_remarks(){
    if(isset($_POST['remarks']) && !empty($_POST['remarks'])){
        $dataParam      =   [];
        $dataParam['remarks']        =   $_POST['remarks'];
        $dataParam['rrr_info_id']    =   $_POST['rrr_info_id'];
        $dataParam['user_id']        =   $_POST['created_by'];
        $dataParam['remarks_date']   =   date("Y-m-d H:i:s");

        saveData('notesheet_remarks_history', $dataParam);
    }
}

if(isset($_GET['process_type']) && $_GET['process_type'] == "rrr_sa_supplier_update_execute"){
    include '../connection/connect.php';
    include '../helper/utilities.php';
    update_supplier_details();
    $feedback   =   [
        'status'  => "success",
        'message' => "Supplier have been successfully updated",
    ];
    echo json_encode($feedback);
}
/* function update_supplier_details(){
    global $conn;
    
     * *****************************rrr_details table operation********************
    
    foreach($_POST['supplier'] as $datKey=>$datValue){
        $dataParam['supplier']  =   (isset($datValue) && !empty($datValue) ? trim(mysqli_real_escape_string($conn, $datValue)) : '');;
        $where      =   [
            'id'    =>  $datKey
        ];
        updateData('rlp_details', $dataParam, $where);
    }        
    foreach($_POST['details_remarks'] as $datKey=>$datValue){
        $dataParam['details_remarks']  =   (isset($datValue) && !empty($datValue) ? trim(mysqli_real_escape_string($conn, $datValue)) : '');;
        $where      =   [
            'id'    =>  $datKey
        ];
        updateData('rlp_details', $dataParam, $where);
    }
} */ 

// get rrr list data depends on user:
function getNotesheetListFromEvaluation(){
    $user_id            =   $_SESSION['logged']['user_id'];
    $role       =   get_role_group_short_name();
    switch ($role){
        case 'sa':
            $table      = 'evaluation_details WHERE final_recommendation != 4';
            $order      = 'DESC';
            $column     = 'created_at';
            $dataType   = 'obj';
            $listData   = getTableDataByTableName($table, $order, $column, $dataType);
            break;
        case 'member':
            $table      = 'evaluation_details WHERE final_recommendation != 4';
            $order      = 'DESC';
            $column     = 'created_at';
            $dataType   = 'obj';
            $listData   = getTableDataByTableName($table, $order, $column, $dataType);
            break;
        case 'dh':
            $listData   =   [];
            // get others rlp for approval:
            $listData1   = getRRRInfoAcknowledgeData($user_id);
            // get own RLp:
            $table      = 'evaluation_details WHERE final_recommendation != 4';
            $order      = 'DESC';
            $column     = 'created_at';
            $dataType   = 'obj';
            $listData2   = getTableDataByTableName($table, $order, $column, $dataType);
            if (isset($listData2) && !empty($listData2)) {
                foreach ($listData2 as $l) {
                    array_push($listData, $l);
                }
            }
            if (isset($listData1) && !empty($listData1)) {
                foreach ($listData1 as $l) {
                    array_push($listData, $l);
                }
            }
            break; 
        case 'ab':
            $listData   = getRRRInfoAcknowledgeData($user_id);
            break; 
        default:
            $listData   = getRRRInfoAcknowledgeData($user_id);
            break;
    }
    
    return $listData;
}
// get approved rrr list data depends on user:
function getApprovedNotesheetListData(){
    $user_id  	=   $_SESSION['logged']['user_id'];
    $role       =   get_role_group_short_name();
    switch ($role){
        case 'sa':
            $table      = 'rrr_info WHERE is_delete = 0 AND rrr_status = 1';
            $order      = 'DESC';
            $column     = 'created_at';
            $dataType   = 'obj';
            $listData   = getTableDataByTableName($table, $order, $column, $dataType);
            break;
        case 'member':
            $table      = 'rrr_info WHERE is_delete = 0 AND rrr_user_id = '.$user_id;
            $order      = 'DESC';
            $column     = 'created_at';
            $dataType   = 'obj';
            $listData   = getTableDataByTableName($table, $order, $column, $dataType);
            break;
        case 'dh':
            $listData   =   [];
            // get others rlp for approval:
            $listData1   = getRRRInfoAcknowledgeData($user_id);
            // get own RLp:
            $table      = 'rrr_info WHERE is_delete = 0 AND rrr_user_id = '.$user_id;
            $order      = 'DESC';
            $column     = 'created_at';
            $dataType   = 'obj';
            $listData2   = getTableDataByTableName($table, $order, $column, $dataType);
            if (isset($listData2) && !empty($listData2)) {
                foreach ($listData2 as $l) {
                    array_push($listData, $l);
                }
            }
            if (isset($listData1) && !empty($listData1)) {
                foreach ($listData1 as $l) {
                    array_push($listData, $l);
                }
            }
            break; 
        case 'ab':
            $listData   = getRRRInfoAcknowledgeData($user_id);
            break; 
        default:
            $listData   = getRRRInfoAcknowledgeData($user_id);
            break;
    }
    
    return $listData;
}

/* function get_role_group_short_name(){
    $role_id            =   $_SESSION['logged']['role_id'];    
    $role_name          =   get_role_shortcode_by_role_id($role_id);
    $memberRoles        =   get_role_group('member'); 
    $approvalRoles      =   get_role_group('approval'); 
    $acknowledgeRoles   =   get_role_group('acknowledgers');
    if(in_array($role_name, $memberRoles)){
        $role_short_name           =      'member';
    }elseif(in_array($role_name, $acknowledgeRoles)){
        $role_short_name           =      'dh';
    }elseif(in_array($role_name, $approvalRoles)){
        $role_short_name           =      'ab';
    }else{
        $role_short_name           =      'sa';
    }
    
    return $role_short_name;
} */

function getNotesheetInfoAcknowledgeData($user_id, $column='created_at', $order="DESC"){    
    $sql    =   "SELECT ri.*
                     FROM rrr_info as ri
                     JOIN rrr_acknowledgement as rack 
                     ON ri.id = rack.rrr_info_id
                     WHERE ri.is_delete = 0 AND rack.user_id = $user_id AND rack.is_visible=1 order by ri.$column $order";
    $data   =   getDataRowIdAndTableBySQL($sql);
    return $data;
}

if(isset($_GET['process_type']) && $_GET['process_type'] == "rrr_delete"){
    session_start();
    include '../connection/connect.php';
    include '../helper/utilities.php';    
    $current_user_id        =   $_SESSION['logged']['user_id'];
    $current_user_role_name =   $_SESSION['logged']['role_name'];
    $id         =   $_GET['delete_id'];
    
    $table      =   "rrr_info WHERE id=$id";
    $rrr_info   = getDataRowIdAndTable($table);
    
    $table      =   "rrr_info";
    $fieldName  =   "id";
    // member user can only delete pending rlp:
    if($current_user_id == $rrr_info->rrr_user_id){
        if($rrr_info->rrr_status == 5){            
            //deleteRecordByTableAndId($table, $fieldName, $id);
            $dataParam['is_delete']      =   1;
            $dataParam['updated_by']     =   $current_user_id;
            $dataParam['updated_at']     =   date("Y-d-m H:i:s");
            $where      =   [
                'id'    =>  $id
            ];
            updateData('rrr_info', $dataParam, $where);
            $dataSaveParam  =   [
                'rrr_info_id'   => $id,
                'deleted_by'    => $current_user_id,
                'deleted_at'    => date("Y-d-m H:i:s")
            ];
            saveData('rrr_delete_history', $dataSaveParam);
            $status                 =   "success";
            $message                =   "RRR has been successfully deleted.";
        }else{
            $status                 =   "error";
            $message                =   "You have no authentication to delete this RRR.";
        }
    }elseif(is_super_admin($current_user_id)){
        $ack_status =   [1,2,3,4,5,6];
        if(rrr_acknowledgement_is_pending($id, $ack_status)){            
            //deleteRecordByTableAndId($table, $fieldName, $id);
            $dataParam['is_delete']      =   1;
            $dataParam['updated_by']     =   $current_user_id;
            $dataParam['updated_at']     =   date("Y-d-m H:i:s");
            $where      =   [
                'id'    =>  $id
            ];
            updateData('rrr_info', $dataParam, $where);
            
            $dataSaveParam  =   [
                'rrr_info_id'   => $id,
                'deleted_by'    => $current_user_id,
                'deleted_at'    => date("Y-d-m H:i:s")
            ];
            saveData('rrr_delete_history', $dataSaveParam);
            $status                 =   "success";
            $message                =   "RRR has been successfully deleted.";
        }else{
            $status                 =   "error";
            $message                =   "You have no authentication to delete this RRR.";
        }
    }
    $feedback   =   [
        'status'    => $status,
        'message'   => $message,
    ];
    
    echo json_encode($feedback);
}

function process_notesheet_acknowledgement($data){
    //rlp_acknowledgement will be inserted or updated!
    $notesheet_id        =   $data['notesheet_id'];
    $ack_request_date   =   date('Y-m-d H:i:s');
    $created_by         =   $data['created_by'];
    foreach($data['acknowledge_user'] as $dtKey=>$dtValue){
        $user_id    =   $dtKey;
        $ack_order  =   $dtValue;
        
        $dataParam['notesheet_id']       =   $notesheet_id;
        $dataParam['user_id']           =   $user_id;
        $dataParam['ack_order']         =   $ack_order;
        
        if(isset($data['ack_status']) && !empty($data['ack_status'])){
            $dataParam['ack_status']    =   $data['ack_status'];
        }
        $where  =   "notesheet_id=$notesheet_id AND user_id=$user_id";
        $isDuplicate    =   isDuplicateData('notesheet_acknowledgement', $where);
        if($isDuplicate){
            // process rlp_acknowledgement (table will be updated):
            $dataParam['ack_updated_date']  =   date("Y-m-d H:i:s");
            $dataParam['updated_by']        =   $created_by;
            $where      =   [
                'id'    =>  $isDuplicate
            ];
            updateData('notesheet_acknowledgement', $dataParam, $where);
        }else{
            $dataParam['ack_request_date']  =   date("Y-m-d H:i:s");
            $dataParam['created_by']        =   $created_by;
            $response   =   saveData('notesheet_acknowledgement', $dataParam);
        }
    }
    set_notesheet_visible_for_acknowledge($notesheet_id);
}


if(isset($_GET['process_type']) && $_GET['process_type'] == "notesheet_quick_view"){
    date_default_timezone_set("Asia/Dhaka");
    include '../connection/connect.php';
    include '../helper/utilities.php';
    $rrr_id     =   $_POST['rrr_id'];
    $table      =   "rrr_info WHERE id=$rrr_id";
    $rrr_info   = getDataRowIdAndTable($table);
    
  
    
    $feedbackData   =   [
        'rrr_info'      =>  $rrr_info
    ];
    get_notesheet_details($feedbackData);
}
function getNotesheetDetailsData($rrr_id){
    $table      =   "rrr_info WHERE id=$rrr_id";
    $rrr_info   = getDataRowIdAndTable($table);
    
   /*  $order = 'asc';
    $column='id';
    $table         =   "rrr_info WHERE rrr_info_id=$rrr_id";
    $rlp_details   = getTableDataByTableName($table, $order, $column);
     */
    $feedbackData   =   [
        'rrr_info'      =>  $rrr_info,
        //'rrr_details'   =>  $rrr_details
    ];
    return $feedbackData;
}

function getNotesheetsDetailsData($rlp_id){
    $table      =   "`notesheets_master` WHERE `notesheet_no`='$rlp_id'";
    $rlp_info   = getDataRowIdAndTable($table);
    
    $order = 'asc';
    $column='id';
    $table         =   "`notesheets` WHERE `notesheet_no`='$rlp_id'";
    $rlp_details   = getTableDataByTableName($table, $order, $column);
    
    $feedbackData   =   [
        'rlp_info'      =>  $rlp_info,
        'rlp_details'   =>  $rlp_details
    ];
    return $feedbackData;
}


