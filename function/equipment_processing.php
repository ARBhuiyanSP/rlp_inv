<?php
//Create User:
if (isset($_POST['equipment_entry']) && !empty($_POST['equipment_entry'])){
    /******************************assets table operation******************** */
    
    $rrr_info_response  =   execute_equipment_table();
    if(isset($rrr_info_response) && $rrr_info_response['status'] == "success"){
        $_SESSION['success']    =   "Your request have been successfully procced.";
    }else{
        $_SESSION['error']    =   "Failed to save data";
    }
    header("location: equipment_list.php");
    exit();
}


function execute_equipment_table(){
    global $conn;
    $commissioning_date		= (isset($_POST['commissioning_date']) && !empty($_POST['commissioning_date']) ? trim(mysqli_real_escape_string($conn,$_POST['commissioning_date'])) : date("Y-m-d"));
	
    $project_id		= (isset($_POST['project_id']) && !empty($_POST['project_id']) ? trim(mysqli_real_escape_string($conn,$_POST['project_id'])) : "");
	
    $sub_project_id		= (isset($_POST['sub_project_id']) && !empty($_POST['sub_project_id']) ? trim(mysqli_real_escape_string($conn,$_POST['sub_project_id'])) : "");
	
    $name		= (isset($_POST['name']) && !empty($_POST['name']) ? trim(mysqli_real_escape_string($conn,$_POST['name'])) : "");
	
    $equipment_type		= (isset($_POST['equipment_type']) && !empty($_POST['equipment_type']) ? trim(mysqli_real_escape_string($conn,$_POST['equipment_type'])) : "");
	
    $eel_code		= (isset($_POST['eel_code']) && !empty($_POST['eel_code']) ? trim(mysqli_real_escape_string($conn,$_POST['eel_code'])) : "");
	
    $origin		= (isset($_POST['origin']) && !empty($_POST['origin']) ? trim(mysqli_real_escape_string($conn,$_POST['origin'])) : "");
	
    $capacity		= (isset($_POST['capacity']) && !empty($_POST['capacity']) ? trim(mysqli_real_escape_string($conn,$_POST['capacity'])) : "");
	
    $makeby		= (isset($_POST['makeby']) && !empty($_POST['makeby']) ? trim(mysqli_real_escape_string($conn,$_POST['makeby'])) : "");
	
    $model		= (isset($_POST['model']) && !empty($_POST['model']) ? trim(mysqli_real_escape_string($conn,$_POST['model'])) : "");
	
    $year_manufacture		= (isset($_POST['year_manufacture']) && !empty($_POST['year_manufacture']) ? trim(mysqli_real_escape_string($conn,$_POST['year_manufacture'])) : "");
	
    $present_location		= (isset($_POST['present_location']) && !empty($_POST['present_location']) ? trim(mysqli_real_escape_string($conn,$_POST['present_location'])) : "");
	
    $present_condition		= (isset($_POST['present_condition']) && !empty($_POST['present_condition']) ? trim(mysqli_real_escape_string($conn,$_POST['present_condition'])) : "");

    $price		= (isset($_POST['price']) && !empty($_POST['price']) ? trim(mysqli_real_escape_string($conn,$_POST['price'])) : "");
	
    $remarks		= (isset($_POST['remarks']) && !empty($_POST['remarks']) ? trim(mysqli_real_escape_string($conn,$_POST['remarks'])) : "");
	/*--------------------------*/
    
    /*
     * *****************************rrr_info table operation********************
     */
    $table_sql     =   "equipments";
    $dataParam     =   [
        //'id'                    =>  get_table_next_primary_id($table_sql),
        //'rrr_no'                =>  get_rrr_no(),
        //'rrr_user_id'           =>  $_SESSION['logged']['user_id'],
        //'rrr_user_office_id'    =>  $_SESSION['logged']['office_id'],
        'project_id'           	=>  $project_id,
        'sub_project_id'    	=>  $sub_project_id,
        'equipment_type'      	=>  $equipment_type,
        'category'          	=>  $category,
        'date_from'          	=>  date('Y-m-d h:i:s', strtotime($commissioning_date)),
        'name'          		=>  $name,
        'eel_code'          	=>  $eel_code,
        'origin'          		=>  $origin,
        'capacity'          	=>  $capacity,
        'makeby'          		=>  $makeby,
        'model'          		=>  $model,
        'year_manufacture' 		=>  $year_manufacture,
        'inventory_sl_no'   	=>  $inventory_sl_no,
        'engine_model'         	=>  $engine_model,
        'engine_sl_no'      	=>  $engine_sl_no,
        'present_location'  	=>  $present_location,
        'present_condition'   	=>  $present_condition,
        'price'  	            =>  $price,
        'assign_status'       	=>  'assigned',
        'remarks'          		=>  $remarks,
        'status'          		=>  $status,
		
		/*--------------------------*/
        //'created_by'            	=>  $_SESSION['logged']['user_id'],
        'created_at'            	=>  date('Y-m-d h:i:s')
    ];
    
    $response   =   saveData("equipments", $dataParam);
    return $response;
}

/// equipment shifting process
if (isset($_POST['equipment_shift'])){
    /******************************assets table operation******************** */
    $eel_code 		= $_POST['eel_code'];
	$project_id 	= $_POST['project_id'];
	$equipment_type	= $_POST['equipment_type'];
	$assign_date 	= $_POST['assign_date'];
	$remarks 		= $_POST['remarks'];
	$id 			= $_POST['id'];

	$sql	=	"insert into `equipment_assign` values('','$eel_code','$project_id','','$equipment_type','$assign_date','','$remarks')";
	$response	=	mysqli_query($conn, $sql);

    $sql2	=	"UPDATE `equipment_assign` set `refund_date`='$assign_date' where `id`='$id'";
    $response2	=	mysqli_query($conn, $sql2);
	
	if(isset($response)){
        $_SESSION['success']    =   "Your request have been successfully procced.";
    }else{
        $_SESSION['error']    =   "Failed to save data";
    }
    header("location: equipment_list.php");
    exit();
    
	/* $shifting_info_response  =   execute_assign_table();
    if(isset($shifting_info_response) && $shifting_info_response['status'] == "success"){
        $_SESSION['success']    =   "Your request have been successfully procced.";
    }else{
        $_SESSION['error']    =   "Failed to save data";
    } 
    header("location: equipment_list.php");
    exit(); */
}
function execute_assign_table(){
    global $conn;
    $commissioning_date		= (isset($_POST['commissioning_date']) && !empty($_POST['commissioning_date']) ? trim(mysqli_real_escape_string($conn,$_POST['commissioning_date'])) : date("Y-m-d"));
	
    $project_id		= (isset($_POST['project_id']) && !empty($_POST['project_id']) ? trim(mysqli_real_escape_string($conn,$_POST['project_id'])) : "");
	
    $sub_project_id		= (isset($_POST['sub_project_id']) && !empty($_POST['sub_project_id']) ? trim(mysqli_real_escape_string($conn,$_POST['sub_project_id'])) : "");
	
    $name		= (isset($_POST['name']) && !empty($_POST['name']) ? trim(mysqli_real_escape_string($conn,$_POST['name'])) : "");
	
    $remarks		= (isset($_POST['remarks']) && !empty($_POST['remarks']) ? trim(mysqli_real_escape_string($conn,$_POST['remarks'])) : "");
	/*--------------------------*/
    
    /*
     * *****************************rrr_info table operation********************
     */
    $table_sql     =   "equipments";
    $dataParam     =   [
        //'id'                    =>  get_table_next_primary_id($table_sql),
        //'rrr_no'                =>  get_rrr_no(),
        //'rrr_user_id'           =>  $_SESSION['logged']['user_id'],
        //'rrr_user_office_id'    =>  $_SESSION['logged']['office_id'],
        'eel_code'           	=>  $eel_code,
        'project_id'    	=>  $project_id,
        'equipment_type'      	=>  $equipment_type,
        'assign_date'          	=>  $assign_date,
        'date_from'          	=>  date('Y-m-d h:i:s', strtotime($commissioning_date)),
        'assign_status'       	=>  'assigned',
        'remarks'          		=>  $remarks,
        'status'          		=>  $status,
		
		$eel_code 		= $_POST['eel_code'],
		$project_id 	= $_POST['project_id'],
		$equipment_type	= $_POST['equipment_type'],
		$assign_date 	= $_POST['assign_date'],
		$remarks 		= $_POST['remarks'],
		$id 			= $_POST['id'],
		
		/*--------------------------*/
        //'created_by'            	=>  $_SESSION['logged']['user_id'],
        'created_at'            	=>  date('Y-m-d h:i:s')
    ];
    $where		=	"id=$id";	
    $response   =   saveData("equipment_assign", $dataParam);
	$response2 	=	updateData('equipment_assign', $dataParam, $where);
    return $response;
    return $response2;
}

//////inspection

if (isset($_POST['ins_submit'])){
    /******************************assets table operation******************** */
    	$id 			= $_POST['id'];
	$product_id 	= $_POST['product_id'];
	$ins_date 		= $_POST['ins_date'];
	$status 		= $_POST['status'];
	$remarks 		= $_POST['remarks'];



	$sql	=	"insert into `inspaction` values('','$product_id','$ins_date','$status','$remarks')";
	$response	=	mysqli_query($conn, $sql);
	
    $sql2	=	"UPDATE `equipments`  set `inspaction_date`='$ins_date',`status`='$status' where `eel_code`='$product_id'";
    $response2	=	mysqli_query($conn, $sql2);

	
	
	if(isset($response)){
        $_SESSION['success']    =   "Your request have been successfully procced.";
    }else{
        $_SESSION['error']    =   "Failed to save data";
    }
    header("location: inspection.php");
    exit();
    
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

// get rrr list data depends on user:
function getEquipmentListData(){
    $user_id            =   $_SESSION['logged']['user_id'];
    $role       =   get_role_group_short_name();
    switch ($role){
        case 'sa':
            $table      = 'equipments';
            $order      = 'DESC';
			$column     = 'eel_code';
            $dataType   = 'obj';
            $listData   = getTableDataByTableName($table, $order, $column, $dataType);
            break;
        case 'member':
            $table      = 'equipments';
            $order      = 'DESC';
			$column     = 'eel_code';
            $dataType   = 'obj';
            $listData   = getTableDataByTableName($table, $order, $column, $dataType);
            break;
        case 'dh':
            $listData   =   [];
            // get others rlp for approval:
            $listData1   = getEquipmentInfoAcknowledgeData($user_id);
            // get own RLp:
            $table      = 'equipments';
            $order      = 'DESC';
			$column     = 'eel_code';
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
            $listData   = getEquipmentInfoAcknowledgeData($user_id);
            break; 
        default:
            $listData   = getEquipmentInfoAcknowledgeData($user_id);
            break;
    }
    
    return $listData;
}
// get approved rrr list data depends on user:
function getApprovedEquipmentListData(){
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
            $listData1   = getEquipmentInfoAcknowledgeData($user_id);
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
            $listData   = getEquipmentInfoAcknowledgeData($user_id);
            break; 
        default:
            $listData   = getEquipmentInfoAcknowledgeData($user_id);
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

function getEquipmentInfoAcknowledgeData($user_id, $column='created_at', $order="DESC"){    
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

function getEquipmentDetailsData($id){
    $table      =   "equipments WHERE id=$id";
    $equipment_info   = getDataRowIdAndTable($table);
    
   /*  $order = 'asc';
    $column='id';
    $table         =   "rrr_info WHERE rrr_info_id=$rrr_id";
    $rlp_details   = getTableDataByTableName($table, $order, $column);
     */
    $feedbackData   =   [
        'equipments'      =>  $equipment_info,
        //'rrr_details'   =>  $rrr_details
    ];
    return $feedbackData;
}

function getLogDetailsData($id){
    $table      =   "tb_logsheet WHERE `equipment_code`='$id' ORDER BY `slno` desc";
    $log_info   = getDataRowIdAndTable($table);
    
   /*  $order = 'asc';
    $column='id';
    $table         =   "rrr_info WHERE rrr_info_id=$rrr_id";
    $rlp_details   = getTableDataByTableName($table, $order, $column);
     */
    $feedbackData   =   [
        'tb_logsheet'      =>  $log_info,
        //'rrr_details'   =>  $rrr_details
    ];
    return $feedbackData;
}
function getSMDetailsData($id){
    $table      =   "maintenance WHERE `equipment_id`='$id' ORDER BY `id` desc";
    $sm_info   = getDataRowIdAndTable($table);
    
   /*  $order = 'asc';
    $column='id';
    $table         =   "rrr_info WHERE rrr_info_id=$rrr_id";
    $rlp_details   = getTableDataByTableName($table, $order, $column);
     */
    $feedbackData   =   [
        'maintenance'      =>  $sm_info,
        //'rrr_details'   =>  $rrr_details
    ];
    return $feedbackData;
}
if(isset($_GET['process_type']) && $_GET['process_type'] == "rrr_quick_view"){
    date_default_timezone_set("Asia/Dhaka");
    include '../connection/connect.php';
    include '../helper/utilities.php';
    $rrr_id     =   $_POST['rrr_id'];
    $table      =   "rrr_info WHERE id=$rrr_id";
    $rrr_info   = getDataRowIdAndTable($table);
    
  
    
    $feedbackData   =   [
        'rrr_info'      =>  $rrr_info
    ];
    get_rrr_item_details($feedbackData);
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

if(isset($_GET['process_type']) && $_GET['process_type'] == "rrr_dh_update_execute"){
    date_default_timezone_set("Asia/Dhaka");
    include '../connection/connect.php';
    include '../helper/utilities.php';
    if(is_equipment_dh_update_field_validation_pass()){
        $param['rrr_info_id']   =   $_POST['rrr_info_id'];
        $param['ack_status']    =   $_POST['acknowledgement'];
        $param['user_id']       =   $_POST['created_by'];
        $param['remarks']       =   $_POST['remarks'];
        update_equipment_acknowledgement($param);
        save_equipment_remarks();
        $feedback   =   [
            'status'    => "success",
            'message'   => "RRR data have been successfully updated",
        ];
    }else{
        $feedback   =   [
            'status'    => "error",
            'message'   => "Both Acknowledgement status And Remarks are required.",
        ];
    }
    
    echo json_encode($feedback);
}
if(isset($_GET['process_type']) && $_GET['process_type'] == "rrr_ab_update_execute"){
    date_default_timezone_set("Asia/Dhaka");
    include '../connection/connect.php';
    include '../helper/utilities.php';
    if(is_equipment_dh_update_field_validation_pass()){
        $param['rrr_info_id']   =   $_POST['rrr_info_id'];
        $param['ack_status']    =   $_POST['acknowledgement'];
        $param['user_id']       =   $_POST['created_by'];
        $param['remarks']       =   $_POST['remarks'];
        update_equipment_acknowledgement($param);
        save_equipment_remarks();
        $feedback   =   [
            'status'    => "success",
            'message'   => "RRR data have been successfully updated",
        ];
    }else{
        $feedback   =   [
            'status'    => "error",
            'message'   => "Both Acknowledgement status And Remarks are required.",
        ];
    }
    
    echo json_encode($feedback);
}

if(isset($_GET['process_type']) && $_GET['process_type'] == "rrr_sa_update_execute"){
    date_default_timezone_set("Asia/Dhaka");
    include '../connection/connect.php';
    include '../helper/utilities.php';
    if(is_equipment_dh_update_field_validation_pass()){
        $param['rrr_info_id']   =   $_POST['rrr_info_id'];
        $param['ack_status']    =   $_POST['acknowledgement'];
        $param['user_id']       =   $_POST['created_by'];
        $param['remarks']       =   $_POST['remarks'];
        update_equipment_acknowledgement($param);
        save_equipment_remarks();
        $feedback   =   [
            'status'    => "success",
            'message'   => "RRR data have been successfully updated",
        ];
    }else{
        $feedback   =   [
            'status'    => "error",
            'message'   => "Both Acknowledgement status And Remarks are required.",
        ];
    }
    
    echo json_encode($feedback);
}

 function is_equipment_dh_update_field_validation_pass(){
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
    $param['rrr_info_id']   =   $_POST['rrr_info_id'];
    $param['ack_status']    =   $_POST['acknowledgement'];
    $param['user_id']       =   $_POST['created_by'];
    $param['remarks']       =   $_POST['remarks'];
    update_equipment_acknowledgement($param);
    $dataParam['rlp_status']     =   $_POST['acknowledgement'];
    $dataParam['updated_by']     =   $_POST['created_by'];
    $dataParam['updated_at']     =   date("Y-d-m H:i:s");
    $where      =   [
        'id'    =>  $param['rrr_info_id']
    ];
    updateData('rlp_info', $dataParam, $where);
    save_equipment_remarks();
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
        $rrr_info_id   =   $_POST['rrr_info_id'];
        if(isset($_POST['department_heads']) && !empty($_POST['department_heads'])){
    //        process rrr_acknowledgement
            $param  =   [];
            $param['acknowledge_user']    =   $_POST['department_heads'];
            process_equipment_acknowledgement($param);
        }
        if(isset($_POST['approval_bodies']) && !empty($_POST['approval_bodies'])){
    //        process rrr_acknowledgement
            $param  =   [];
            $param['acknowledge_user']    =   $_POST['approval_bodies'];
            process_equipment_acknowledgement($param);
        }

        // process rrr_info (table will be updated):
        if(isset($_POST['acknowledgement']) && !empty($_POST['acknowledgement'])){
            $dataParam['rlp_status']     =   $_POST['acknowledgement'];
            $dataParam['is_viewd']       =   1;
            $dataParam['updated_by']     =   $_POST['created_by'];
            $dataParam['updated_at']     =   date("Y-d-m H:i:s");
            $where      =   [
                'id'    =>  $rrr_info_id
            ];
            updateData('rlp_info', $dataParam, $where);
        }
        // process rrr_remarks_history (table will be inserted):
        save_equipment_remarks();
        $feedback   =   [
            'status'    => "success",
            'message'   => "RRR data have been successfully updated",
        ];
    }else{
        $feedback   =   [
            'status'    => "error",
            'message'   => "You must give Acknowledgement Status"
        ];
    }
    echo json_encode($feedback);
}

function update_equipment_acknowledgement($data){
    $user_id        =   $data['user_id'];
    $rrr_info_id    =   $data['rrr_info_id'];
    $dataParam['rrr_info_id']       =   $data['rrr_info_id'];
    $dataParam['user_id']           =   $data['user_id'];
    if(isset($data['ack_status']) && !empty($data['ack_status'])){
        $dataParam['ack_status']    =   $data['ack_status'];
    }
    $where  =   "rrr_info_id=$rrr_info_id AND user_id=$user_id";
    $isDuplicate    =   isDuplicateData('rrr_acknowledgement', $where);
    if($isDuplicate){
        // process rrr_acknowledgement (table will be updated):
        $dataParam['ack_updated_date']  =   date("Y-m-d H:i:s");
        $dataParam['updated_by']        =   $user_id;
        $where      =   [
            'id'    =>  $isDuplicate
        ];
        updateData('rrr_acknowledgement', $dataParam, $where);
        
        $dataParam                      =   [];
        $where                          =   [];
        $dataParam['rrr_status']        =   $data['ack_status'];
        $where      =   [
            'id'    =>  $rrr_info_id
        ];
        updateData('rrr_info', $dataParam, $where);
        
        set_rrr_visible_for_acknowledge($rrr_info_id);
    }
}
function process_equipment_acknowledgement($data){
    //rrr_acknowledgement will be inserted or updated!
    $rrr_info_id        =   $data['rrr_info_id'];
    $ack_request_date   =   date('Y-m-d H:i:s');
    $created_by         =   $data['created_by'];
    foreach($data['acknowledge_user'] as $dtKey=>$dtValue){
        $user_id    =   $dtKey;
        $ack_order  =   $dtValue;
        
        $dataParam['rrr_info_id']       =   $rrr_info_id;
        $dataParam['user_id']           =   $user_id;
        $dataParam['ack_order']         =   $ack_order;
        
        if(isset($data['ack_status']) && !empty($data['ack_status'])){
            $dataParam['ack_status']    =   $data['ack_status'];
        }
        $where  =   "rrr_info_id=$rrr_info_id AND user_id=$user_id";
        $isDuplicate    =   isDuplicateData('rrr_acknowledgement', $where);
        if($isDuplicate){
            // process rrr_acknowledgement (table will be updated):
            $dataParam['ack_updated_date']  =   date("Y-m-d H:i:s");
            $dataParam['updated_by']        =   $created_by;
            $where      =   [
                'id'    =>  $isDuplicate
            ];
            updateData('rrr_acknowledgement', $dataParam, $where);
        }else{
            $dataParam['ack_request_date']  =   date("Y-m-d H:i:s");
            $dataParam['created_by']        =   $created_by;
            $response   =   saveData('rrr_acknowledgement', $dataParam);
        }
    }
    set_rrr_visible_for_acknowledge($rrr_info_id);
}
function save_equipment_remarks(){
    if(isset($_POST['remarks']) && !empty($_POST['remarks'])){
        $dataParam      =   [];
        $dataParam['remarks']        =   $_POST['remarks'];
        $dataParam['rrr_info_id']    =   $_POST['rrr_info_id'];
        $dataParam['user_id']        =   $_POST['created_by'];
        $dataParam['remarks_date']   =   date("Y-m-d H:i:s");

        saveData('rrr_remarks_history', $dataParam);
    }
}


//// logsheet process

if (isset($_POST['logsheet_entry']) && !empty($_POST['logsheet_entry'])){
    /******************************assets table operation******************** */
    
    $rrr_info_response  =   execute_logsheet_table();
    if(isset($rrr_info_response) && $rrr_info_response['status'] == "success"){
        $_SESSION['success']    =   "Your request have been successfully procced.";
    }else{
        $_SESSION['error']    =   "Failed to save data";
    }
    header("location: logsheet.php");
    exit();
}


function execute_logsheet_table(){
    global $conn;
    $d_date		= (isset($_POST['d_date']) && !empty($_POST['d_date']) ? trim(mysqli_real_escape_string($conn,$_POST['d_date'])) : date("Y-m-d"));
	
    $equipment_code		= (isset($_POST['equipment_code']) && !empty($_POST['equipment_code']) ? trim(mysqli_real_escape_string($conn,$_POST['equipment_code'])) : "");
	
    $project_id		= (isset($_POST['project_id']) && !empty($_POST['project_id']) ? trim(mysqli_real_escape_string($conn,$_POST['project_id'])) : "");
	
    $workdetails		= (isset($_POST['workdetails']) && !empty($_POST['workdetails']) ? trim(mysqli_real_escape_string($conn,$_POST['workdetails'])) : "");
	
    $runninghrkm		= (isset($_POST['runninghrkm']) && !empty($_POST['runninghrkm']) ? trim(mysqli_real_escape_string($conn,$_POST['runninghrkm'])) : "");
	
    $closehrkm		= (isset($_POST['closehrkm']) && !empty($_POST['closehrkm']) ? trim(mysqli_real_escape_string($conn,$_POST['closehrkm'])) : "");
	
    $totalhrkm		= (isset($_POST['totalhrkm']) && !empty($_POST['totalhrkm']) ? trim(mysqli_real_escape_string($conn,$_POST['totalhrkm'])) : "");
	
    $standby		= (isset($_POST['standby']) && !empty($_POST['standby']) ? trim(mysqli_real_escape_string($conn,$_POST['standby'])) : "");
	
    $hydrolicltr		= (isset($_POST['hydrolicltr']) && !empty($_POST['hydrolicltr']) ? trim(mysqli_real_escape_string($conn,$_POST['hydrolicltr'])) : "");
	
    $disealltr		= (isset($_POST['disealltr']) && !empty($_POST['disealltr']) ? trim(mysqli_real_escape_string($conn,$_POST['disealltr'])) : "");
	
    $engineoil		= (isset($_POST['engineoil']) && !empty($_POST['engineoil']) ? trim(mysqli_real_escape_string($conn,$_POST['engineoil'])) : "");
	
    $greasing		= (isset($_POST['greasing']) && !empty($_POST['greasing']) ? trim(mysqli_real_escape_string($conn,$_POST['greasing'])) : "");
	/*--------------------------*/
    
    /*
     * *****************************logsheet table operation********************
     */
    $table_sql     =   "tb_logsheet";
    $dataParam     =   [
        //'rrr_user_id'           =>  $_SESSION['logged']['user_id'],
        //'rrr_user_office_id'    =>  $_SESSION['logged']['office_id'],
        'd_date'          	=>  date('Y-m-d h:i:s', strtotime($d_date)),
        'equipment_code'	=>  $equipment_code,
        'project_id' 		=>  $project_id,
        'workdetails' 		=>  $workdetails,
        'runninghrkm' 		=>  $runninghrkm,
        'closehrkm' 		=>  $closehrkm,
        'totalhrkm' 		=>  $totalhrkm,
        'standby' 		=>  $standby,
        'hydrolicltr' 		=>  $hydrolicltr,
        'disealltr' 		=>  $disealltr,
        'engineoil' 		=>  $engineoil,
        'greasing' 		=>  $greasing,
		
		/*--------------------------*/
        //'created_by'            	=>  $_SESSION['logged']['user_id'],
        //'created_at'            	=>  date('Y-m-d h:i:s')
    ];
    
    $response   =   saveData("tb_logsheet", $dataParam);
    return $response;
}

//// schedule maintenance process

if (isset($_POST['sm_entry']) && !empty($_POST['sm_entry'])){
    /******************************assets table operation******************** */
    
    $rrr_info_response  =   execute_sm_table();
    if(isset($rrr_info_response) && $rrr_info_response['status'] == "success"){
        $_SESSION['success']    =   "Your request have been successfully procced.";
    }else{
        $_SESSION['error']    =   "Failed to save data";
    }
    header("location: schedulemaintenance.php");
    exit();
}


function execute_sm_table(){
    global $conn;
	
	
    $project_id		= (isset($_POST['project_id']) && !empty($_POST['project_id']) ? trim(mysqli_real_escape_string($conn,$_POST['project_id'])) : "");
	
    $equipment_id		= (isset($_POST['equipment_id']) && !empty($_POST['equipment_id']) ? trim(mysqli_real_escape_string($conn,$_POST['equipment_id'])) : "");
	
    $lastseervice_date		= (isset($_POST['lastseervice_date']) && !empty($_POST['lastseervice_date']) ? trim(mysqli_real_escape_string($conn,$_POST['lastseervice_date'])) : date("Y-m-d"));
	
    $lastservice_hrkm		= (isset($_POST['lastservice_hrkm']) && !empty($_POST['lastservice_hrkm']) ? trim(mysqli_real_escape_string($conn,$_POST['lastservice_hrkm'])) : "");
	
    $schedule_hrkm		= (isset($_POST['schedule_hrkm']) && !empty($_POST['schedule_hrkm']) ? trim(mysqli_real_escape_string($conn,$_POST['schedule_hrkm'])) : "");
	
    $present_hrkm		= (isset($_POST['present_hrkm']) && !empty($_POST['present_hrkm']) ? trim(mysqli_real_escape_string($conn,$_POST['present_hrkm'])) : "");
	
    $nextservice_date		= (isset($_POST['nextservice_date']) && !empty($_POST['nextservice_date']) ? trim(mysqli_real_escape_string($conn,$_POST['nextservice_date'])) : date("Y-m-d"));
	
    $nextservice_hrkm		= (isset($_POST['nextservice_hrkm']) && !empty($_POST['nextservice_hrkm']) ? trim(mysqli_real_escape_string($conn,$_POST['nextservice_hrkm'])) : "");
	
    $dueforservice_hrkm		= (isset($_POST['dueforservice_hrkm']) && !empty($_POST['dueforservice_hrkm']) ? trim(mysqli_real_escape_string($conn,$_POST['dueforservice_hrkm'])) : "");
	
    $typeofservice_hrkm		= (isset($_POST['typeofservice_hrkm']) && !empty($_POST['typeofservice_hrkm']) ? trim(mysqli_real_escape_string($conn,$_POST['typeofservice_hrkm'])) : "");
	
    $detailsofmaintenance		= (isset($_POST['detailsofmaintenance']) && !empty($_POST['detailsofmaintenance']) ? trim(mysqli_real_escape_string($conn,$_POST['detailsofmaintenance'])) : "");
	
    $remarks		= (isset($_POST['remarks']) && !empty($_POST['remarks']) ? trim(mysqli_real_escape_string($conn,$_POST['remarks'])) : "");
	
    
	/*--------------------------*/
    
    /*
     * *****************************maintenance table operation********************
     */
    $table_sql     =   "maintenance";
    $dataParam     =   [
        //'rrr_user_id'           =>  $_SESSION['logged']['user_id'],
        //'rrr_user_office_id'    =>  $_SESSION['logged']['office_id'],
        'project_id' 			=>  $project_id,
        'equipment_id' 			=>  $equipment_id,
        'lastseervice_date' 	=>  date('Y-m-d h:i:s', strtotime($lastseervice_date)),
        'lastservice_hrkm' 		=>  $lastservice_hrkm,
        'schedule_hrkm' 		=>  $schedule_hrkm,
        'present_hrkm' 			=>  $present_hrkm,
        'nextservice_date' 		=>  date('Y-m-d h:i:s', strtotime($nextservice_date)),
        'nextservice_hrkm' 		=>  $nextservice_hrkm,
        'dueforservice_hrkm' 	=>  $dueforservice_hrkm,
        'typeofservice_hrkm' 	=>  $typeofservice_hrkm,
        'detailsofmaintenance' 	=>  $detailsofmaintenance,
        'remarks' 				=>  $remarks,
		
		/*--------------------------*/
        //'created_by'            	=>  $_SESSION['logged']['user_id'],
        //'created_at'            	=>  date('Y-m-d h:i:s')
    ];
    
    $response   =   saveData("maintenance", $dataParam);
    return $response;
}