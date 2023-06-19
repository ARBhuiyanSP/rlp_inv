<?php

//Create Division:
if (isset($_POST['rrr_create']) && !empty($_POST['rrr_create'])){    
    $rrr_no          = (isset($_POST['rrr_no']) && !empty($_POST['rrr_no']) ? mysqli_real_escape_string($conn,$_POST['rrr_no']) : '');
    /*
        *  Update Data Into inv_receive Table:
    */
    $table          = ' ';
    if(isset($_POST['edit_id']) && !empty($_POST['edit_id'])){
        $id             = $_POST['edit_id'];
        $where          = "rrr_no='$rrr_no' AND id!=$id";
    }else{
        $where          = 'rrr_no=' . "'$rrr_no'";
    }    
    if (!isDuplicateData($table, $where)) {
        if(isset($_POST['edit_id']) && !empty($_POST['edit_id'])){
            $res    =   update_rrr();
            $_SESSION['success']    =   "Data have been successfully Updated.";
        }else{
            $res    =   create_rrr();
            $_SESSION['success']    =   "Data have been successfully Saved.";
        }
    }else{
        $_SESSION['error']                  =   "Duplicate data found!.";
    }
    header("location: rrr_list.php");
    exit();
}
function create_rrr(){
    global $conn;
    $rrr_date				= (isset($_POST['rrr_date']) && !empty($_POST['rrr_date']) ? mysqli_real_escape_string($conn,$_POST['rrr_date']) : '');
    $rrr_no					= (isset($_POST['rrr_no']) && !empty($_POST['rrr_no']) ? mysqli_real_escape_string($conn,$_POST['rrr_no']) : '');
    $req_by					= (isset($_POST['req_by']) && !empty($_POST['req_by']) ? mysqli_real_escape_string($conn,$_POST['req_by']) : '');
    $req_by_division		= (isset($_POST['req_by_division']) && !empty($_POST['req_by_division']) ? mysqli_real_escape_string($conn,$_POST['req_by_division']) : '');
    $req_by_department		= (isset($_POST['req_by_department']) && !empty($_POST['req_by_department']) ? mysqli_real_escape_string($conn,$_POST['req_by_department']) : '');
    $req_by_designation		= (isset($_POST['req_by_designation']) && !empty($_POST['req_by_designation']) ? mysqli_real_escape_string($conn,$_POST['req_by_designation']) : '');
    $req_for				= (isset($_POST['req_for']) && !empty($_POST['req_for']) ? mysqli_real_escape_string($conn,$_POST['req_for']) : '');
    $emp_type				= (isset($_POST['emp_type']) && !empty($_POST['emp_type']) ? mysqli_real_escape_string($conn,$_POST['emp_type']) : '');
    $urgency				= (isset($_POST['urgency']) && !empty($_POST['urgency']) ? mysqli_real_escape_string($conn,$_POST['urgency']) : '');
    $justification_for_rec	= (isset($_POST['justification_for_rec']) && !empty($_POST['justification_for_rec']) ? mysqli_real_escape_string($conn,$_POST['justification_for_rec']) : '');
    $rem_spe_rec			= (isset($_POST['rem_spe_rec']) && !empty($_POST['rem_spe_rec']) ? mysqli_real_escape_string($conn,$_POST['rem_spe_rec']) : '');
    $req_division			= (isset($_POST['req_division']) && !empty($_POST['req_division']) ? mysqli_real_escape_string($conn,$_POST['req_division']) : '');
    $req_department			= (isset($_POST['req_department']) && !empty($_POST['req_department']) ? mysqli_real_escape_string($conn,$_POST['req_department']) : '');
    $req_designation		= (isset($_POST['req_designation']) && !empty($_POST['req_designation']) ? mysqli_real_escape_string($conn,$_POST['req_designation']) : '');
    $req_number				= (isset($_POST['req_number']) && !empty($_POST['req_number']) ? mysqli_real_escape_string($conn,$_POST['req_number']) : '');
    $req_location_project	= (isset($_POST['req_location_project']) && !empty($_POST['req_location_project']) ? mysqli_real_escape_string($conn,$_POST['req_location_project']) : '');
    $req_reporting_man		= (isset($_POST['req_reporting_man']) && !empty($_POST['req_reporting_man']) ? mysqli_real_escape_string($conn,$_POST['req_reporting_man']) : '');
    $req_salary				= (isset($_POST['req_salary']) && !empty($_POST['req_salary']) ? mysqli_real_escape_string($conn,$_POST['req_salary']) : '');
    $req_responsibilities	= (isset($_POST['req_responsibilities']) && !empty($_POST['req_responsibilities']) ? mysqli_real_escape_string($conn,$_POST['req_responsibilities']) : '');
	
    $dataParam      =   [
        'rrr_date'        		=>  $rrr_date,
        'rrr_no'          		=>  $rrr_no,
        'req_by'          		=>  $req_by,
        'req_by_division' 		=>  $req_by_division,
        'req_by_department' 	=>  $req_by_department,
        'req_by_designation' 	=>  $req_by_designation,
        'req_for' 				=>  $req_for,
        'emp_type' 				=>  $emp_type,
        'urgency' 				=>  $urgency,
        'justification_for_rec' =>  $justification_for_rec,
        'rem_spe_rec' 			=>  $rem_spe_rec,
        'req_division' 			=>  $req_division,
        'req_department' 		=>  $req_department,
        'req_designation' 		=>  $req_designation,
        'req_number' 			=>  $req_number,
        'req_location_project' 	=>  $req_location_project,
        'req_reporting_man' 	=>  $req_reporting_man,
        'req_salary' 			=>  $req_salary,
        'req_responsibilities' 	=>  $req_responsibilities,
    ];
    $res    =   saveData('recruite_requests', $dataParam);  
    return $res;
}
function update_rrr(){
    global $conn;
    $rrr_no           = (isset($_POST['rrr_no']) && !empty($_POST['rrr_no']) ? mysqli_real_escape_string($conn,$_POST['rrr_no']) : '');
	
	
	
	
	
    $param['fields'] = [
        'rrr_no'          	=>  $rrr_no,
    ];
    $param['where'] =[
        'id'    =>  $_POST['edit_id']
    ];
    $res     =   updateData('branch',$param['fields'], $param['where']);
    return $res;
}
// get rlp list data depends on user:
function getRRRListData(){
    $user_id            =   $_SESSION['logged']['user_id'];
    $role       =   get_role_group_short_name();
    switch ($role){
        case 'sa':
            $table      = 'recruite_requests WHERE is_delete = 0';
            $order      = 'DESC';
            $column     = 'created_at';
            $dataType   = 'obj';
            $listData   = getTableDataByTableName($table, $order, $column, $dataType);
            break;
        case 'member':
            $table      = 'recruite_requests WHERE is_delete = 0';
            $order      = 'DESC';
            $column     = 'created_at';
            $dataType   = 'obj';
            $listData   = getTableDataByTableName($table, $order, $column, $dataType);
            break; 
    }
    
    return $listData;
}
if(isset($_GET['process_type']) && $_GET['process_type'] == "rrr_delete"){
    include '../connection/connect.php';
    include '../helper/utilities.php';
    $id         =   $_GET['delete_id'];
    $table      =   "recruite_requests";
    $fieldName  =   "id";
    deleteRecordByTableAndId($table, $fieldName, $id);
    
    $feedback   =   [
        'status'    => "success",
        'message'   => "Data have been successfully deleted",
    ];
    
    echo json_encode($feedback);
	header("location: rrr_create.php");
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

function getRrrDetailsData($rrr_id){
    $table      = "recruite_requests WHERE id=$rrr_id";
    $rrr_info   = getDataRowIdAndTable($table);
	
    
    $feedbackData   =   [
        'rrr_info'  =>  $rrr_info,
    ];
    return $feedbackData;
}