<?php

//Create User:
if (isset($_POST['rlp_create']) && !empty($_POST['rlp_create'])){
    $date		= (isset($_POST['date']) && !empty($_POST['date']) ? trim(mysqli_real_escape_string($conn,$_POST['date'])) : date("Y-m-d"));
    $priority		= (isset($_POST['priority']) && !empty($_POST['priority']) ? trim(mysqli_real_escape_string($conn,$_POST['priority'])) : "");
    $rlpNo		= (isset($_POST['rlp_no']) && !empty($_POST['rlp_no']) ? trim(mysqli_real_escape_string($conn,$_POST['rlp_no'])) : "");
    $remarks		= (isset($_POST['remarks']) && !empty($_POST['remarks']) ? trim(mysqli_real_escape_string($conn,$_POST['remarks'])) : "");
    
    /*
     * *****************************rlp_info table operation********************
     */    
    $rlp_info_response  =   execute_rlp_info_table();
    if(isset($rlp_info_response) && $rlp_info_response['status'] == "success"){
        $rlp_info_id    =   $rlp_info_response['last_id'];
        /*
        * *****************************rlp_details table operation********************
        */    
        $rlp_details_response  =   execute_rlp_details_table($rlp_info_id);
        
        $ackParam['acknowledge_user']   =   $_POST['assign_users_order'];
        $ackParam['rlp_info_id']        =   $rlp_info_id;
        $ackParam['created_by']         =   $_SESSION['logged']['user_id'];
        process_rlp_acknowledgement($ackParam);
        
        $_SESSION['success']    =   "Your request have been successfully procced.";
    }else{
        $_SESSION['error']    =   "Failed to save data";
    }
    header("location: rlp_create.php");
    exit();
}

function execute_rlp_info_table(){
    global $conn;
    $date		= (isset($_POST['date']) && !empty($_POST['date']) ? trim(mysqli_real_escape_string($conn,$_POST['date'])) : date("Y-m-d"));
    $priority		= (isset($_POST['priority']) && !empty($_POST['priority']) ? trim(mysqli_real_escape_string($conn,$_POST['priority'])) : "");
    $rlpNo		= (isset($_POST['rlp_no']) && !empty($_POST['rlp_no']) ? trim(mysqli_real_escape_string($conn,$_POST['rlp_no'])) : "");
    $remarks		= (isset($_POST['remarks']) && !empty($_POST['remarks']) ? trim(mysqli_real_escape_string($conn,$_POST['remarks'])) : "");
    
    /*
     * *****************************rlp_info table operation********************
     */
    $table_sql     =   "rlp_info";
    $dataParam     =   [
        'id'                    =>  get_table_next_primary_id($table_sql),
        'rlp_no'                =>  get_rlp_no(),
        'rlp_user_id'           =>  $_SESSION['logged']['user_id'],
        'rlp_user_office_id'    =>  $_SESSION['logged']['office_id'],
        'priority'              =>  $priority,
        'request_date'          =>  date('Y-m-d h:i:s', strtotime($date)),
        'request_division'      =>  $_SESSION['logged']['branch_id'],
        'request_department'    =>  $_SESSION['logged']['department_id'],
        'request_project'   	=>  $_SESSION['logged']['project_id'],
        'request_person'        =>  $_SESSION['logged']['user_name'],
        'designation'           =>  $_SESSION['logged']['designation'],
        'email'                 =>  $_SESSION['logged']['email'],
        'contact_number'        =>  $_SESSION['logged']['contact_number'],
        'user_remarks'          =>  $remarks,
        'created_by'            =>  $_SESSION['logged']['user_id'],
        'created_at'            =>  date('Y-m-d h:i:s')
    ];
    
    $response   =   saveData("rlp_info", $dataParam);
    return $response;
}

function execute_rlp_details_table($rlp_info_id){
    global $conn;
    /*
     * *****************************rlp_details table operation********************
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
            'rlp_info_id'       =>  $rlp_info_id,
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
if(isset($_GET['process_type']) && $_GET['process_type'] == "rlp_sa_supplier_update_execute"){
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
     */
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
}

// get rlp list data depends on user:
function getRLPListData(){
    $user_id            =   $_SESSION['logged']['user_id'];
    $role       =   get_role_group_short_name();
    switch ($role){
        case 'sa':
            $table      = 'rlp_info WHERE is_delete = 0';
            $order      = 'DESC';
            $column     = 'created_at';
            $dataType   = 'obj';
            $listData   = getTableDataByTableName($table, $order, $column, $dataType);
            break;
        case 'member':
            $table      = 'rlp_info WHERE is_delete = 0 AND rlp_user_id = '.$user_id;
            $order      = 'DESC';
            $column     = 'created_at';
            $dataType   = 'obj';
            $listData   = getTableDataByTableName($table, $order, $column, $dataType);
            break;
        case 'dh':
            $listData   =   [];
            // get others rlp for approval:
            $listData1   = getRlpInfoAcknowledgeData($user_id);
            // get own RLp:
            $table      = 'rlp_info WHERE is_delete = 0 AND rlp_user_id = '.$user_id;
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
            $listData   = getRlpInfoAcknowledgeData($user_id);
            break; 
        default:
            $listData   = getRlpInfoAcknowledgeData($user_id);
            break;
    }
    
    return $listData;
}

function get_role_group_short_name(){
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
}

function getRlpInfoAcknowledgeData($user_id, $column='created_at', $order="DESC"){    
    $sql    =   "SELECT ri.*
                     FROM rlp_info as ri
                     JOIN rlp_acknowledgement as rack 
                     ON ri.id = rack.rlp_info_id
                     WHERE ri.is_delete = 0 AND rack.user_id = $user_id AND rack.is_visible=1 order by ri.$column $order";
    $data   =   getDataRowIdAndTableBySQL($sql);
    return $data;
}

if(isset($_GET['process_type']) && $_GET['process_type'] == "rlp_delete"){
    session_start();
    include '../connection/connect.php';
    include '../helper/utilities.php';    
    $current_user_id        =   $_SESSION['logged']['user_id'];
    $current_user_role_name =   $_SESSION['logged']['role_name'];
    $id         =   $_GET['delete_id'];
    
    $table      =   "rlp_info WHERE id=$id";
    $rlp_info   = getDataRowIdAndTable($table);
    
    $table      =   "rlp_info";
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


function getRlpDetailsData($rlp_id){
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
    return $feedbackData;
}

if(isset($_GET['process_type']) && $_GET['process_type'] == "rlp_quick_view"){
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
    get_rlp_item_details($feedbackData);
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

if(isset($_GET['process_type']) && $_GET['process_type'] == "rlp_dh_update_execute"){
    date_default_timezone_set("Asia/Dhaka");
    include '../connection/connect.php';
    include '../helper/utilities.php';
    if(is_dh_update_field_validation_pass()){
        $param['rlp_info_id']   =   $_POST['rlp_info_id'];
        $param['ack_status']    =   $_POST['acknowledgement'];
        $param['user_id']       =   $_POST['created_by'];
        $param['remarks']       =   $_POST['remarks'];
        update_rlp_acknowledgement($param);
        save_rlp_remarks();
        $feedback   =   [
            'status'    => "success",
            'message'   => "RLP data have been successfully updated",
        ];
    }else{
        $feedback   =   [
            'status'    => "error",
            'message'   => "Both Acknowledgement status And Remarks are required.",
        ];
    }
    
    echo json_encode($feedback);
}
// common rlp approve
// common rlp approve

if(isset($_GET['process_type']) && $_GET['process_type'] == "rlp_ab_common_update_execute"){
    date_default_timezone_set("Asia/Dhaka");
    include '../connection/connect.php';
    include '../helper/utilities.php';
    $param['rlp_info_id']   =   $_GET['approve_id'];
    $param['ack_status']    =   '1';
    $param['user_id']       =   $_GET['user_id'];
    $param['remarks']       =   'Approved';
    update_common_rlp_acknowledgement($param);
    /* $dataParam['rlp_status']     =   $_POST['acknowledgement'];
    $dataParam['updated_by']     =   $_POST['created_by'];
    $dataParam['updated_at']     =   date("Y-d-m H:i:s");
    $where      =   [
        'id'    =>  $param['rlp_info_id']
    ];
    updateData('rlp_info', $dataParam, $where); */
    save_common_rlp_remarks();
    $feedback   =   [
        'status'    => "success",
        'message'   => "RLP data have been successfully updated",
    ];
    
    echo json_encode($feedback);
}
if(isset($_GET['process_type']) && $_GET['process_type'] == "rlp_dh_common_update_execute"){
    date_default_timezone_set("Asia/Dhaka");
    include '../connection/connect.php';
    include '../helper/utilities.php';
        
		$param['rlp_info_id']   =   $_GET['approve_id'];
        $param['ack_status']    =   '6';
        $param['user_id']       =   $_GET['user_id'];
        $param['remarks']       =   'Recommended';
        update_common_rlp_acknowledgement($param);
        save_common_rlp_remarks();
        $feedback   =   [
            'status'    => "success",
            'message'   => "RLP data have been successfully updated",
        ];
    echo json_encode($feedback);
}

function update_common_rlp_acknowledgement($data){
   
	$user_id        =   $data['user_id'];
    $rlp_info_id    =   $data['rlp_info_id'];
    $dataParam['rlp_info_id']       =   $data['rlp_info_id'];
    $dataParam['user_id']           =   $data['user_id'];
    if(isset($data['ack_status']) && !empty($data['ack_status'])){
        $dataParam['ack_status']    =   $data['ack_status'];
    }
    $where  =   "rlp_info_id=$rlp_info_id AND user_id=$user_id";
    $isDuplicate    =   isDuplicateData('rlp_acknowledgement', $where);
    if($isDuplicate){
        // process rlp_acknowledgement (table will be updated):
        $dataParam['ack_updated_date']  =   date("Y-m-d H:i:s");
        $dataParam['updated_by']        =   $user_id;
        $where      =   [
            'id'    =>  $isDuplicate
        ];
        updateData('rlp_acknowledgement', $dataParam, $where);
        
        $dataParam                      =   [];
        $where                          =   [];
        $dataParam['rlp_status']        =   $data['ack_status'];
		$dataParam['updated_by']        =   $user_id;
        $dataParam['updated_at'] 		=   date("Y-m-d H:i:s");
        $where      =   [
            'id'    =>  $rlp_info_id
        ];
        updateData('rlp_info', $dataParam, $where);
        
        set_rlp_visible_for_acknowledge($rlp_info_id);
    }
}

function save_common_rlp_remarks(){
        $dataParam      =   [];
        $dataParam['remarks']        =   'Approved';
        $dataParam['rlp_info_id']    =   $_GET['approve_id'];
        $dataParam['user_id']        =   $_GET['user_id'];
        $dataParam['remarks_date']   =   date("Y-m-d H:i:s");

        saveData('rlp_remarks_history', $dataParam);
    
}

// common rlp approve

function is_dh_update_field_validation_pass(){
    $status     =   true;
    if(empty($_POST['acknowledgement'])){
        $status     =   false;
    }
    if(empty($_POST['remarks'])){
        $status     =   false;
    }
    return $status;
}
if(isset($_GET['process_type']) && $_GET['process_type'] == "rlp_ab_update_execute"){
    date_default_timezone_set("Asia/Dhaka");
    include '../connection/connect.php';
    include '../helper/utilities.php';
    $param['rlp_info_id']   =   $_POST['rlp_info_id'];
    $param['ack_status']    =   $_POST['acknowledgement'];
    $param['user_id']       =   $_POST['created_by'];
    $param['remarks']       =   $_POST['remarks'];
    update_rlp_acknowledgement($param);
    $dataParam['rlp_status']     =   $_POST['acknowledgement'];
    $dataParam['updated_by']     =   $_POST['created_by'];
    $dataParam['updated_at']     =   date("Y-d-m H:i:s");
    $where      =   [
        'id'    =>  $param['rlp_info_id']
    ];
    updateData('rlp_info', $dataParam, $where);
    save_rlp_remarks();
    $feedback   =   [
        'status'    => "success",
        'message'   => "RLP data have been successfully updated",
    ];
    
    echo json_encode($feedback);
}
if(isset($_GET['process_type']) && $_GET['process_type'] == "rlp_sa_update_execute"){
    date_default_timezone_set("Asia/Dhaka");
    include '../connection/connect.php';
    include '../helper/utilities.php';
    if(isset($_POST['acknowledgement']) && !empty($_POST['acknowledgement'])){
        $rlp_info_id   =   $_POST['rlp_info_id'];
        if(isset($_POST['department_heads']) && !empty($_POST['department_heads'])){
    //        process rlp_acknowledgement
            $param  =   [];
            $param['acknowledge_user']    =   $_POST['department_heads'];
            process_rlp_acknowledgement($param);
        }
        if(isset($_POST['approval_bodies']) && !empty($_POST['approval_bodies'])){
    //        process rlp_acknowledgement
            $param  =   [];
            $param['acknowledge_user']    =   $_POST['approval_bodies'];
            process_rlp_acknowledgement($param);
        }

        // process rlp_info (table will be updated):
        if(isset($_POST['acknowledgement']) && !empty($_POST['acknowledgement'])){
            $dataParam['rlp_status']     =   $_POST['acknowledgement'];
            $dataParam['is_viewd']       =   1;
            $dataParam['updated_by']     =   $_POST['created_by'];
            $dataParam['updated_at']     =   date("Y-d-m H:i:s");
            $where      =   [
                'id'    =>  $rlp_info_id
            ];
            updateData('rlp_info', $dataParam, $where);
        }
        // process rlp_remarks_history (table will be inserted):
        save_rlp_remarks();
        $feedback   =   [
            'status'    => "success",
            'message'   => "RLP data have been successfully updated",
        ];
    }else{
        $feedback   =   [
            'status'    => "error",
            'message'   => "You must give Acknowledgement Status"
        ];
    }
    echo json_encode($feedback);
}

function update_rlp_acknowledgement($data){
    $user_id        =   $data['user_id'];
    $rlp_info_id    =   $data['rlp_info_id'];
    $dataParam['rlp_info_id']       =   $data['rlp_info_id'];
    $dataParam['user_id']           =   $data['user_id'];
    if(isset($data['ack_status']) && !empty($data['ack_status'])){
        $dataParam['ack_status']    =   $data['ack_status'];
    }
    $where  =   "rlp_info_id=$rlp_info_id AND user_id=$user_id";
    $isDuplicate    =   isDuplicateData('rlp_acknowledgement', $where);
    if($isDuplicate){
        // process rlp_acknowledgement (table will be updated):
        $dataParam['ack_updated_date']  =   date("Y-m-d H:i:s");
        $dataParam['updated_by']        =   $user_id;
        $where      =   [
            'id'    =>  $isDuplicate
        ];
        updateData('rlp_acknowledgement', $dataParam, $where);
        
        $dataParam                      =   [];
        $where                          =   [];
        $dataParam['rlp_status']        =   $data['ack_status'];
        $dataParam['updated_at'] 		=   date("Y-m-d H:i:s");
        $where      =   [
            'id'    =>  $rlp_info_id
        ];
        updateData('rlp_info', $dataParam, $where);
        
        set_rlp_visible_for_acknowledge($rlp_info_id);
    }
}
function process_rlp_acknowledgement($data){
    //rlp_acknowledgement will be inserted or updated!
    $rlp_info_id        =   $data['rlp_info_id'];
    $ack_request_date   =   date('Y-m-d H:i:s');
    $created_by         =   $data['created_by'];
    foreach($data['acknowledge_user'] as $dtKey=>$dtValue){
        $user_id    =   $dtKey;
        $ack_order  =   $dtValue;
        
        $dataParam['rlp_info_id']       =   $rlp_info_id;
        $dataParam['user_id']           =   $user_id;
        $dataParam['ack_order']         =   $ack_order;
        
        if(isset($data['ack_status']) && !empty($data['ack_status'])){
            $dataParam['ack_status']    =   $data['ack_status'];
        }
        $where  =   "rlp_info_id=$rlp_info_id AND user_id=$user_id";
        $isDuplicate    =   isDuplicateData('rlp_acknowledgement', $where);
        if($isDuplicate){
            // process rlp_acknowledgement (table will be updated):
            $dataParam['ack_updated_date']  =   date("Y-m-d H:i:s");
            $dataParam['updated_by']        =   $created_by;
            $where      =   [
                'id'    =>  $isDuplicate
            ];
            updateData('rlp_acknowledgement', $dataParam, $where);
        }else{
            $dataParam['ack_request_date']  =   date("Y-m-d H:i:s");
            $dataParam['created_by']        =   $created_by;
            $response   =   saveData('rlp_acknowledgement', $dataParam);
        }
    }
    set_rlp_visible_for_acknowledge($rlp_info_id);
}
function save_rlp_remarks(){
    if(isset($_POST['remarks']) && !empty($_POST['remarks'])){
        $dataParam      =   [];
        $dataParam['remarks']        =   $_POST['remarks'];
        $dataParam['rlp_info_id']    =   $_POST['rlp_info_id'];
        $dataParam['user_id']        =   $_POST['created_by'];
        $dataParam['remarks_date']   =   date("Y-m-d H:i:s");

        saveData('rlp_remarks_history', $dataParam);
    }
}