<?php

//Create User:
if (isset($_POST['create_notesheet']) && !empty($_POST['create_notesheet'])){
    //$date		= (isset($_POST['date']) && !empty($_POST['date']) ? trim(mysqli_real_escape_string($conn,$_POST['date'])) : date("Y-m-d"));
    $notesheet_no		= (isset($_POST['notesheet_no']) && !empty($_POST['notesheet_no']) ? trim(mysqli_real_escape_string($conn,$_POST['notesheet_no'])) : "");
    $rlp_no		= (isset($_POST['rlp_no']) && !empty($_POST['rlp_no']) ? trim(mysqli_real_escape_string($conn,$_POST['rlp_no'])) : "");
    //$remarks		= (isset($_POST['remarks']) && !empty($_POST['remarks']) ? trim(mysqli_real_escape_string($conn,$_POST['remarks'])) : "");
    
    /*
     * *****************************rlp_info table operation********************
     */    
    $notesheets_info_response  =   execute_notesheets_master_table();
    if(isset($notesheets_info_response) && $notesheets_info_response['status'] == "success"){
        $notesheet_id    =   $notesheets_info_response['last_id'];
        /*
        * *****************************rlp_details table operation********************
        */    
        $notesheet_details_response  =   execute_notesheet_details_table($notesheet_id);
        
        $ackParam['acknowledge_user']   =   $_POST['assign_users_order'];
        $ackParam['notesheet_id']        =   $notesheet_id;
        $ackParam['created_by']         =   $_SESSION['logged']['user_id'];
        process_notesheet_acknowledgement($ackParam);
        
        $_SESSION['success']    =   "Your request have been successfully procced.";
    }else{
        $_SESSION['error']    =   "Failed to save data";
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
		//$remarks		= (isset($_POST['remarks']) && !empty($_POST['remarks']) ? trim(mysqli_real_escape_string($conn,$_POST['remarks'])) : "");
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
            //'no_of_item'       	=>  $no_of_material,
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

function execute_notesheet_details_table($notesheet_id){
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
		//$remarks		= (isset($_POST['remarks']) && !empty($_POST['remarks']) ? trim(mysqli_real_escape_string($conn,$_POST['remarks'])) : "");
        $item	= (isset($_POST['item'][$count]) && !empty($_POST['item'][$count]) ? trim(mysqli_real_escape_string($conn,$_POST['item'][$count])) : '');
        $quantity	= (isset($_POST['quantity'][$count]) && !empty($_POST['quantity'][$count]) ? trim(mysqli_real_escape_string($conn,$_POST['quantity'][$count])) : '');
        $unit_price	= (isset($_POST['unit_price'][$count]) && !empty($_POST['unit_price'][$count]) ? trim(mysqli_real_escape_string($conn,$_POST['unit_price'][$count])) : '');
        $total	= (isset($_POST['total'][$count]) && !empty($_POST['total'][$count]) ? trim(mysqli_real_escape_string($conn,$_POST['total'][$count])) : '');        
        $remarks= (isset($_POST['remarks'][$count]) && !empty($_POST['remarks'][$count]) ? trim(mysqli_real_escape_string($conn,$_POST['remarks'][$count])) : '');  
		$no_of_material     = $no_of_material+$quantity;
        $dataParam     =   [
            //'id'                =>  get_table_next_primary_id('rlp_details'),
            'notesheet_no'	=>  $notesheet_no,
            'notesheet_id'	=>  $notesheet_id,
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
            //'remarks'		=>  $remarks,
            'status'		=>  'Created',
			'created_at'	=>  date('Y-m-d h:i:s'),
			'created_by'	=>  $_SESSION['logged']['user_id']
        ];
    
        saveData("notesheets", $dataParam);
    }
}
/* if(isset($_GET['process_type']) && $_GET['process_type'] == "rlp_sa_supplier_update_execute"){
    include '../connection/connect.php';
    include '../helper/utilities.php';
    update_supplier_details();
    $feedback   =   [
        'status'  => "success",
        'message' => "Supplier have been successfully updated",
    ];
    echo json_encode($feedback);
}
function update_supplier_details(){
    global $conn;
    /*
     * *****************************rlp_details table operation********************
     
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

// get rlp list data depends on user:
function getNotesheetListData(){
    $user_id            =   $_SESSION['logged']['user_id'];
    $role       =   get_role_group_short_name();
    switch ($role){
        case 'sa':
            $table      = 'notesheets_master WHERE is_delete = 0';
            $order      = 'DESC';
            $column     = 'created_at';
            $dataType   = 'obj';
            $listData   = getTableDataByTableName($table, $order, $column, $dataType);
            break;
        case 'member':
            $table      = 'notesheets_master WHERE is_delete = 0';
            $order      = 'DESC';
            $column     = 'created_at';
            $dataType   = 'obj';
            $listData   = getTableDataByTableName($table, $order, $column, $dataType);
            break;
        case 'dh':
            $listData   =   [];
            // get others rlp for approval:
            $listData1   = getNotesheetAcknowledgeData($user_id);
            // get own RLp:
            $table      = 'notesheets_master WHERE is_delete = 0';
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
            $listData   = getNotesheetAcknowledgeData($user_id);
            break; 
        default:
            $listData   = getNotesheetAcknowledgeData($user_id);
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

function getNotesheetAcknowledgeData($user_id, $column='created_at', $order="DESC"){    
    $sql    =   "SELECT ri.*
                     FROM notesheets_master as ri
                     JOIN notesheet_acknowledgement as rack 
                     ON ri.id = rack.notesheet_id
                     WHERE ri.is_delete = 0 AND rack.user_id = $user_id AND rack.is_visible=1 order by ri.$column $order";
    $data   =   getDataRowIdAndTableBySQL($sql);
    return $data;
}

if(isset($_GET['process_type']) && $_GET['process_type'] == "notesheet_delete"){
    session_start();
    include '../connection/connect.php';
    include '../helper/utilities.php';    
    $current_user_id        =   $_SESSION['logged']['user_id'];
    $current_user_role_name =   $_SESSION['logged']['role_name'];
    $id         =   $_GET['delete_id'];
    
    $table      =   "notesheets_master WHERE id=$id";
    $notesheets_master   = getDataRowIdAndTable($table);
    
    $table      =   "notesheets_master";
    $fieldName  =   "id";
    // member user can only delete pending rlp:
    if($current_user_id == $rlp_info->rlp_user_id){
        if($rlp_info->rlp_status == 5){            
            //deleteRecordByTableAndId($table, $fieldName, $id);
            $dataParam['is_delete']      =   1;
            $dataParam['updated_by']     =   $current_user_id;
            $dataParam['updated_at']     =   date("Y-d-m H:i:s");
            $where      =   [
                'id'    =>  $id
            ];
            updateData('rlp_info', $dataParam, $where);
            $dataSaveParam  =   [
                'rlp_info_id'   => $id,
                'deleted_by'    => $current_user_id,
                'deleted_at'    => date("Y-d-m H:i:s")
            ];
            saveData('rlp_delete_history', $dataSaveParam);
            $status                 =   "success";
            $message                =   "RLP has been successfully deleted.";
        }else{
            $status                 =   "error";
            $message                =   "You have no authentication to delete this RLP.";
        }
    }elseif(is_super_admin($current_user_id)){
        $ack_status =   [1,2,3,4,5,6];
        if(rlp_acknowledgement_is_pending($id, $ack_status)){            
            //deleteRecordByTableAndId($table, $fieldName, $id);
            $dataParam['is_delete']      =   1;
            $dataParam['updated_by']     =   $current_user_id;
            $dataParam['updated_at']     =   date("Y-d-m H:i:s");
            $where      =   [
                'id'    =>  $id
            ];
            updateData('rlp_info', $dataParam, $where);
            
            $dataSaveParam  =   [
                'rlp_info_id'   => $id,
                'deleted_by'    => $current_user_id,
                'deleted_at'    => date("Y-d-m H:i:s")
            ];
            saveData('rlp_delete_history', $dataSaveParam);
            $status                 =   "success";
            $message                =   "RLP has been successfully deleted.";
        }else{
            $status                 =   "error";
            $message                =   "You have no authentication to delete this RLP.";
        }
    }
    $feedback   =   [
        'status'    => $status,
        'message'   => $message,
    ];
    
    echo json_encode($feedback);
}

function getNotesheetDetailsData($notesheet_id){
    /* $table      =   "notesheets_master WHERE id=$notesheet_id"; */
    $table      =   "notesheets_master WHERE id=$notesheet_id";
    $notesheets_master   = getDataRowIdAndTable($table);
    
    $order = 'asc';
    $column='id';
    $table         =   "notesheets WHERE notesheet_id=$notesheet_id";
    $notesheets   = getTableDataByTableName($table, $order, $column);
    
    $feedbackData   =   [
        'notesheets_master'      =>  $notesheets_master,
        'notesheets'   =>  $notesheets
    ];
    return $feedbackData;
}

if(isset($_GET['process_type']) && $_GET['process_type'] == "notesheet_quick_view"){
    date_default_timezone_set("Asia/Dhaka");
    include '../connection/connect.php';
    include '../helper/utilities.php';
    $rlp_id     =   $_POST['rlp_id'];
    $table      =   "rlp_info WHERE id=$rlp_id";
    $rlp_info   = getDataRowIdAndTable($table);
    
    $order = 'asc';
    $column='id';
    $table         =   "rlp_details WHERE rlp_info_id=$rlp_id";
    $rlp_details   = getTableDataByTableName($table, $order, $column);
    
    $feedbackData   =   [
        'rlp_info'      =>  $rlp_info,
        'rlp_details'   =>  $rlp_details
    ];
    get_notesheet_details($feedbackData);
}
if(isset($_GET['process_type']) && $_GET['process_type'] == "getDepartmentByBranch"){
    include '../connection/connect.php';
    include '../helper/utilities.php';
    $branch_id  =   $_POST['branch_id'];
    $table      =   "department WHERE branch_id=$branch_id";
    
    $order      = 'asc';
    $column     = 'name';
    $details    = getTableDataByTableName($table, $order, $column);
    echo "<option value=''>Please select</option>";    
    if(isset($details) && !empty($details)){
        foreach($details as $dat){ ?>
            <option value="<?php echo $dat->id; ?>"><?php echo $dat->name; ?></option>
    <?php }
    }
}

if(isset($_GET['process_type']) && $_GET['process_type'] == "getDepartmentByBranches"){
    include '../connection/connect.php';
    include '../helper/utilities.php';
    $branch_id  =   $_POST['reqdivision'];
    $table      =   "department WHERE branch_id=$branch_id";
    
    $order      = 'asc';
    $column     = 'name';
    $details    = getTableDataByTableName($table, $order, $column);
    echo "<option value=''>Please select</option>";    
    if(isset($details) && !empty($details)){
        foreach($details as $dat){ ?>
            <option value="<?php echo $dat->id; ?>"><?php echo $dat->name; ?></option>
    <?php }
    }
}

if(isset($_GET['process_type']) && $_GET['process_type'] == "notesheet_dh_update_execute"){
    date_default_timezone_set("Asia/Dhaka");
    include '../connection/connect.php';
    include '../helper/utilities.php';
    if(is_ns_dh_update_field_validation_pass()){
        $param['notesheet_id']  =   $_POST['notesheet_id'];
        $param['ack_status']    =   $_POST['acknowledgement'];
        $param['user_id']       =   $_POST['created_by'];
        $param['remarks']       =   $_POST['remarks'];
        update_notesheet_acknowledgement($param);
        save_notesheet_remarks();
        $feedback   =   [
            'status'    => "success",
            'message'   => "notesheet data have been successfully updated",
        ];
    }else{
        $feedback   =   [
            'status'    => "error",
            'message'   => "Both Acknowledgement status And Remarks are required.",
        ];
    }
    
    echo json_encode($feedback);
}

 function is_ns_dh_update_field_validation_pass(){
    $status     =   true;
    if(empty($_POST['acknowledgement'])){
        $status     =   false;
    }
    if(empty($_POST['remarks'])){
        $status     =   false;
    }
    return $status;
} 

if(isset($_GET['process_type']) && $_GET['process_type'] == "notesheet_ab_update_execute"){
    date_default_timezone_set("Asia/Dhaka");
    include '../connection/connect.php';
    include '../helper/utilities.php';
    $param['notesheet_id']   =   $_POST['notesheet_id'];
    $param['ack_status']    =   $_POST['acknowledgement'];
    $param['user_id']       =   $_POST['created_by'];
    $param['remarks']       =   $_POST['remarks'];
    update_notesheet_acknowledgement($param);
    $dataParam['notesheet_status']     =   $_POST['acknowledgement'];
    $dataParam['updated_by']     =   $_POST['created_by'];
    $dataParam['updated_at']     =   date("Y-d-m H:i:s");
    $where      =   [
        'id'    =>  $param['notesheet_id']
    ];
    updateData('notesheets_master', $dataParam, $where);
    save_notesheet_remarks();
    $feedback   =   [
        'status'    => "success",
        'message'   => "Notesheet data have been successfully updated By AB",
    ];
    
    echo json_encode($feedback);
}
if(isset($_GET['process_type']) && $_GET['process_type'] == "notesheet_sa_update_execute"){
    date_default_timezone_set("Asia/Dhaka");
    include '../connection/connect.php';
    include '../helper/utilities.php';
    if(isset($_POST['acknowledgement']) && !empty($_POST['acknowledgement'])){
        $notesheet_id   =   $_POST['notesheet_id'];
        if(isset($_POST['department_heads']) && !empty($_POST['department_heads'])){
    //        process rlp_acknowledgement
            $param  =   [];
            $param['acknowledge_user']    =   $_POST['department_heads'];
            process_notesheet_acknowledgement($param);
        }
        if(isset($_POST['approval_bodies']) && !empty($_POST['approval_bodies'])){
    //        process rlp_acknowledgement
            $param  =   [];
            $param['acknowledge_user']    =   $_POST['approval_bodies'];
            process_notesheet_acknowledgement($param);
        }

        // process rlp_info (table will be updated):
        if(isset($_POST['acknowledgement']) && !empty($_POST['acknowledgement'])){
            $dataParam['notesheet_status']     =   $_POST['acknowledgement'];
            $dataParam['is_viewd']       =   1;
            $dataParam['updated_by']     =   $_POST['created_by'];
            $dataParam['updated_at']     =   date("Y-d-m H:i:s");
            $where      =   [
                'id'    =>  $notesheet_id
            ];
            updateData('notesheets_master', $dataParam, $where);
        }
        // process rlp_remarks_history (table will be inserted):
        save_notesheet_remarks();
        $feedback   =   [
            'status'    => "success",
            'message'   => "Notesheet data have been successfully updated",
        ];
    }else{
        $feedback   =   [
            'status'    => "error",
            'message'   => "You must give Acknowledgement Status"
        ];
    }
    echo json_encode($feedback);
}

function update_notesheet_acknowledgement($data){
    $user_id        =   $data['user_id'];
    $notesheet_id    =   $data['notesheet_id'];
    $dataParam['notesheet_id']       =   $data['notesheet_id'];
    $dataParam['user_id']           =   $data['user_id'];
    if(isset($data['ack_status']) && !empty($data['ack_status'])){
        $dataParam['ack_status']    =   $data['ack_status'];
    }
    $where  =   "notesheet_id=$notesheet_id AND user_id=$user_id";
    $isDuplicate    =   isDuplicateData('notesheet_acknowledgement', $where);
    if($isDuplicate){
        // process rlp_acknowledgement (table will be updated):
        $dataParam['ack_updated_date']  =   date("Y-m-d H:i:s");
        $dataParam['updated_by']        =   $user_id;
        $where      =   [
            'id'    =>  $isDuplicate
        ];
        updateData('notesheet_acknowledgement', $dataParam, $where);
        
        $dataParam                      =   [];
        $where                          =   [];
        $dataParam['notesheet_status']        =   $_POST['acknowledgement'];
        $where      =   [
            'id'    =>  $notesheet_id
        ];
        updateData('notesheets_master', $dataParam, $where);
        
        set_notesheet_visible_for_acknowledge($notesheet_id);
    }
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
function save_notesheet_remarks(){
    if(isset($_POST['remarks']) && !empty($_POST['remarks'])){
        $dataParam      =   [];
        $dataParam['remarks']        =   $_POST['remarks'];
        $dataParam['notesheet_id']    =   $_POST['notesheet_id'];
        $dataParam['user_id']        =   $_POST['created_by'];
        $dataParam['remarks_date']   =   date("Y-m-d H:i:s");

        saveData('notesheet_remarks_history', $dataParam);
    }
}