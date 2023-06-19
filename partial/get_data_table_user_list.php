<?php
$divisionId     =   $_REQUEST['division_id'];
$departmentId   =   $_REQUEST['department_id'];

$request    =   $_REQUEST;
$col        =   array(
        0   =>  'id',
        1   =>  'role_id',
        2   =>  'branch_id',
        3   =>  'department_id',
        4   =>  'office_id',
        5   =>  'name',
        6   =>  'designation',
        7   =>  'action'
    );  //create column like table in database

$totalData= getDataRowByTable('users');

$totalFilter=$totalData;
//Search
$sql ="SELECT * FROM users WHERE 1=1";
if(!empty($request['search']['value'])){
    $sql.=" AND id Like '%".$request['search']['value']."%' ";
    $sql.=" OR branch_id Like '%".$request['search']['value']."%' ";
    $sql.=" OR department_id Like '%".$request['search']['value']."%' ";
    $sql.=" OR office_id Like '%".$request['search']['value']."%'";
    $sql.=" OR name Like '%".$request['search']['value']."%'";
    $sql.=" OR designation Like '%".$request['search']['value']."%'";
}
if(isset($divisionId) && !empty($divisionId)){
    $sql.=" AND branch_id Like '%".$divisionId."%'";
}
if(isset($departmentId) && !empty($departmentId)){
    $sql.=" AND department_id Like '%".$departmentId."%'";
}
$totalData=getTotalRowBySQL($sql);
//Order
$sql.=" ORDER BY ".$col[$request['order'][0]['column']]."   ".$request['order'][0]['dir']."  LIMIT ".
    $request['start']."  ,".$request['length']."  ";

$userData   = getDataRowIdAndTableBySQL($sql);

$data=[];


$slno   =   1;
if (isset($userData) && !empty($userData)) {
    foreach ($userData as $adata) {
        $actionData     =   get_user_list_action_data($adata);
        
        $subdata = array();
        $subdata[] = $adata->id; //id
        $subdata[] = (isset($adata->role_id) && !empty($adata->role_id) ? getRoleNameByRoleId($adata->role_id) : 'No data'); //name
        $subdata[] = (isset($adata->branch_id) && !empty($adata->branch_id) ? getDivisionNameById($adata->branch_id) : 'No data'); //salary
        $subdata[] = (isset($adata->department_id) && !empty($adata->department_id) ? getDepartmentNameById($adata->department_id) : 'No data');
        $subdata[] = (isset($adata->office_id) && !empty($adata->office_id) ? $adata->office_id : 'No data');
        $subdata[] = (isset($adata->name) && !empty($adata->name) ? $adata->name : 'No data');
        $subdata[] = (isset($adata->designation) && !empty($adata->designation) ? getDesignationNameById($adata->designation) : 'No data');
        $subdata[] = $actionData;
        $data[] = $subdata;
    }
}
$json_data=array(
    "draw"              =>  intval($request['draw']),
    "recordsTotal"      =>  intval($totalData),
    "recordsFiltered"   =>  intval($totalFilter),
    "data"              =>  $data
);

echo json_encode($json_data);


