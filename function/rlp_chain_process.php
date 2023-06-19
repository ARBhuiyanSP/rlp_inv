<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (isset($_POST['rlp_chain_create']) && !empty($_POST['rlp_chain_create'])){
    $division_id    = (isset($_POST['branch_id']) && !empty($_POST['branch_id']) ? validate_input(trim($_POST['branch_id'])) : '');
    $department_id  = (isset($_POST['department_id']) && !empty($_POST['department_id']) ? validate_input(trim($_POST['department_id'])) : "");
    $project_id  = (isset($_POST['project_id']) && !empty($_POST['project_id']) ? validate_input(trim($_POST['project_id'])) : "");
    
    /*
     * *****************************rlp_info table operation********************
     */ 
    $table              = "rlp_access_chain";
    $where              = "chain_type='default' AND division_id=$division_id AND department_id=$department_id AND project_id=$project_id";
    $is_duplicte        = isDuplicateData($table, $where);
    if(!$is_duplicte){
        $rlp_info_response  =   execute_rlp_chain_create();
        $message            =   "Data have been successfully created";
    }else{
        deleteRecordByTableAndId('rlp_access_chain', 'id', $is_duplicte);
        $rlp_info_response  =   execute_rlp_chain_create();
        $message            =   "Data have been successfully Updated";
    }
    if(isset($rlp_info_response) && $rlp_info_response['status'] == "success"){
        $rlp_info_id    =   $rlp_info_response['last_id'];
        $_SESSION['success']    =   $message;
    }else{
        $_SESSION['error']    =   "Failed to save data".$rlp_info_response['data'];
    }
    header("location: rlp_approve_chain_list.php");
    exit();
}
function execute_rlp_chain_create(){
    global $conn;
    $division_id    = (isset($_POST['branch_id']) && !empty($_POST['branch_id']) ? validate_input(trim($_POST['branch_id'])) : '');
    $department_id  = (isset($_POST['department_id']) && !empty($_POST['department_id']) ? validate_input(trim($_POST['department_id'])) : "");
    $project_id  = (isset($_POST['project_id']) && !empty($_POST['project_id']) ? validate_input(trim($_POST['project_id'])) : "");
    $users          = (isset($_POST['assign_users_order']) && !empty($_POST['assign_users_order']) ? $_POST['assign_users_order'] : "");
    $rlp_type       = (isset($_POST['rlp_type']) && !empty($_POST['rlp_type']) ? validate_input(trim($_POST['rlp_type'])) : "");
    
    /*
     * *****************************rlp_info table operation********************
     */
    $table_sql     =   "rlp_access_chain";
    $dataParam     =   [
        'chain_type'            =>  "default",
        'division_id'           =>  $division_id,
        'department_id'         =>  $department_id,
        'project_id'         	=>  $project_id,
        'rlp_type'              =>  $rlp_type,
        'users'                 =>  json_encode($users),
        'created_by'            =>  $_SESSION['logged']['user_id'],
        'created_at'            =>  date('Y-m-d h:i:s')
    ];
    $response   =   saveData("rlp_access_chain", $dataParam);
    return $response;
}

if(isset($_GET['process_type']) && $_GET['process_type'] == "rlp_chain_delete"){
    include '../connection/connect.php';
    include '../helper/utilities.php';
    $id         =   $_GET['delete_id'];
    $table      =   "rlp_access_chain";
    $fieldName  =   "id";
    deleteRecordByTableAndId($table, $fieldName, $id);
    
    $feedback   =   [
        'status'    => "success",
        'message'   => "Data have been successfully deleted",
    ];
    
    echo json_encode($feedback);
}