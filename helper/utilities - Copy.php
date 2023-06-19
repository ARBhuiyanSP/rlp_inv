<?php
function is_member($user_id, $roleName = 'member') {
    global $conn;
    $sql    =   "SELECT r.*
                     FROM roles as r
                     JOIN users as u 
                     ON r.id = u.role_id
                     WHERE u.id = $user_id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {  
            $users = $result->fetch_object();
            if ($users->short_name == $roleName) {
                return true;
            }
            return false;
        }
    return false;
}
function is_super_admin($user_id, $roleName = 'sa') {
    global $conn;
    $sql    =   "SELECT r.*
                     FROM roles as r
                     JOIN users as u 
                     ON r.id = u.role_id
                     WHERE u.id = $user_id";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {  
            $users = $result->fetch_object();
            if ($users->short_name == $roleName) {
                return true;
            }
            return false;
        }
    return false;
}
function hasAccessPermission($user_id, $page_name, $accessType) {
    global $conn;
    $return = false;
    $fieldsName     =   'pa.' . $accessType;
    $sql    =   "SELECT pa.*
                     FROM role_access as pa
                     JOIN roles as r 
                     ON pa.role_id = r.id
                     JOIN users as u
                     ON u.role_id = r.id
                     WHERE u.id = '$user_id' AND pa.page_name = '$page_name' AND $fieldsName=1";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {            
            $return = true;
        }

    return $return;
}
function getTableDataByTableNameAndIntId($table, $int_id, $dataType) {
    global $conn;
    $dataContainer  =   [];
    $sql = "SELECT * FROM $table WHERE `interview_id` = '$int_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        if (isset($dataType) && $dataType == 'obj') {
            while ($row = $result->fetch_object()) {
                $dataContainer[] = $row;
            }
        } else {
            while ($row = $result->fetch_assoc()) {
                $dataContainer[] = $row;
            }
        }
    }
    return $dataContainer;
}
function getTableDataByTableName($table, $order = 'asc', $column='name', $dataType = 'obj') {
    global $conn;
    $dataContainer  =   [];
    $sql = "SELECT * FROM $table order by $column $order";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        if (isset($dataType) && $dataType == 'obj') {
            while ($row = $result->fetch_object()) {
                $dataContainer[] = $row;
            }
        } else {
            while ($row = $result->fetch_assoc()) {
                $dataContainer[] = $row;
            }
        }
    }
    return $dataContainer;
}

function getInterviewDataByTableName($table, $order = 'asc', $column='name', $dataType = 'obj') {
    global $conn;
    $dataContainer  =   [];
    $sql = "SELECT * FROM $table order by $column $order";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        if (isset($dataType) && $dataType == 'obj') {
            while ($row = $result->fetch_object()) {
                $dataContainer[] = $row;
            }
        } else {
            while ($row = $result->fetch_assoc()) {
                $dataContainer[] = $row;
            }
        }
    }
    return $dataContainer;
}
function getInterviewDataByTableNameAndIntId($table, $interviewId, $order = 'asc', $column='name', $dataType = 'obj') {
    global $conn;
    $dataContainer  =   [];
    $sql = "SELECT * FROM $table WHERE `interview_id`='$interviewId' order by $column $order";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        if (isset($dataType) && $dataType == 'obj') {
            while ($row = $result->fetch_object()) {
                $dataContainer[] = $row;
            }
        } else {
            while ($row = $result->fetch_assoc()) {
                $dataContainer[] = $row;
            }
        }
    }
    return $dataContainer;
}
function getDataByIntIdAndCanId($table, $int_id, $can_id, $dataType = 'obj') {
    global $conn;
    $dataContainer  =   [];
    $sql = "SELECT * FROM $table WHERE `int_id`='$int_id' AND `can_id`='$can_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        if (isset($dataType) && $dataType == 'obj') {
            while ($row = $result->fetch_object()) {
                $dataContainer[] = $row;
            }
        } else {
            while ($row = $result->fetch_assoc()) {
                $dataContainer[] = $row;
            }
        }
    }
    return $dataContainer;
}
function getAgentDataForGroupWise() {
    global $conn;
    $dataContainer  =   [];
    $sql = "SELECT * FROM agency_info";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_object()) {
            $dataContainer[] = $row;
        }
    }
    return $dataContainer;
}
function saveData($table, $dataParam) {
    global $conn;
    $fields_array   =   array_keys($dataParam);   
    $fields         =   implode(',', array_keys($dataParam));
    $values         =   "'" . implode ( "', '", array_values($dataParam) ) . "'";;
    $sql            = "INSERT INTO $table ($fields) VALUES ($values)";

    if ($conn->query($sql) === TRUE) {
        $feedbackData   =   [
            'status'    =>  'success',
            'data'      =>  'Data have been successfully inserted',
            'last_id'   =>  $conn->insert_id,
        ];
        return $feedbackData;
    } else {
        $feedbackData   =   [
            'status'    =>  'error',
            'data'      =>  "Error: " . $sql . "<br>" . $conn->error,
            'last_id'   =>  '',
        ];
        return $feedbackData;
    }
}
function updateData($table, $dataParam, $where) {
    global $conn;
    $valueSets = array();
    foreach($dataParam as $key => $value) {
        if(isset($value) && !empty($value)){
            $valueSets[] = $key . " = '" . $value . "'";
        }
    }

    $conditionSets = array();
    foreach($where as $key => $value) {
       $conditionSets[] = $key . " = '" . $value . "'";
    }
    $sql = "UPDATE $table SET ". join(",",$valueSets) . " WHERE " . join(" AND ", $conditionSets);
    if ($conn->query($sql) === TRUE) {
        $feedbackData   =   [
            'status'    =>  'success',
            'message'   =>  'Data have been successfully Updated',
        ];
    } else {
        $feedbackData   =   [
            'status'    =>  'error',
            'message'   =>  "Error: " . $sql . "<br>" . $conn->error,
        ];        
    }
    return $feedbackData;
}
function getCandidatesSalaryByIdAndTable($table, $id){
    global $conn;
    $sql = "SELECT * FROM $table WHERE `id`='$id'";
    $result = $conn->query($sql);
    $name   =   '';
    if ($result->num_rows > 0) {
        $name   =   $result->fetch_object()->expected_salary;
    }
    return $name;
}
function getCandidatesNameByIdAndTable($table, $id){
    global $conn;
    $sql = "SELECT * FROM $table WHERE `id`='$id'";
    $result = $conn->query($sql);
    $name   =   '';
    if ($result->num_rows > 0) {
        $name   =   $result->fetch_object()->name;
    }
    return $name;
}
function getNameByIdAndTable($table){
    global $conn;
    $sql = "SELECT * FROM $table";
    $result = $conn->query($sql);
    $name   =   '';
    if ($result->num_rows > 0) {
        $name   =   $result->fetch_object()->name;
    }
    return $name;
}
function getDataRowIdAndTable($table){
    global $conn;
    $sql = "SELECT * FROM $table";
    $result = $conn->query($sql);
    $name   =   '';
    if ($result->num_rows > 0) {
        return $result->fetch_object();
    }
}
function getDataRowIdAndTableBySQL($sql){
    global $conn;
    $dataContainer  =   [];
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_object()) {
            $dataContainer[] = $row;
        }
    }
    return $dataContainer;
}
function getTotalRowBySQL($sql){
    global $conn;
    $result = $conn->query($sql);
    $name   =   '';
    if ($result->num_rows > 0) {
        return $result->num_rows;
    }
    return "0";
}
function getDataRowByTable($table){
    global $conn;
    $sql = "SELECT * FROM $table";
    $result = $conn->query($sql);
    $name   =   '';
    if ($result->num_rows > 0) {
        return $result->num_rows;
    }
    return "0";
}
function getAssignmentTotalRows($import_id){
    global $conn;
    $sql = "SELECT * FROM delivery_assignment_details where sms_status=1 and import_id=".$import_id;
    $result = $conn->query($sql);
    $name   =   '';
    if ($result->num_rows > 0) {
        return $result->num_rows;
    }
    return "0";
}
function getDataRowByTableAndId($table, $id){
    global $conn;
    $sql    = "SELECT * FROM $table where id=".$id;
    $result = $conn->query($sql);
    $name   =   '';
    if ($result->num_rows > 0) {
        return $result->fetch_object();
    }else{
        return false;
    }
}
function getDefaultCategoryCode($table, $fieldName, $modifier, $defaultCode, $prefix){
    global $conn;
    $sql    = "SELECT count($fieldName) as total_row FROM $table";
    $result = $conn->query($sql);
    $name   =   '';
    $lastRows   = $result->fetch_object();
    $number     = intval($lastRows->total_row) + 1;
    $defaultCode = $prefix.sprintf('%'.$modifier, $number);
    return $defaultCode;
    
}
function isDuplicateData($table, $where, $notWhere=''){
    global $conn;
    $sql='';
    $sql.="SELECT * FROM $table where $where ";
    if(isset($notWhere) && !empty($notWhere)){
        $sql.=" And $notWhere";
    }
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $lastRows   = $result->fetch_object();
        return $lastRows->id;
    }
    return false;
}
function setActiveMenuClass($menuName,  $currentMenu, $activeClass='active'){
    if($menuName == $currentMenu){
        return $activeClass;
    }else{
        return 'inactive';
    }
}
function csvToArray($filename = '', $delimiter = ',') {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $data = array();
        $count  =   1;
        if (($handle = fopen($filename, 'r')) !== false) {
            while ($row = fgetcsv($handle)) {
                if($count==1){
                    $count++;
                    continue;
                }
                $data[]     =     $row;
                
            }
            fclose($handle);
        }

        return $data;
    } // end of method
// get Daily Assignment Import Code:
function getDailyAssignmentImportCode($date, $prefix="DAI"){
    global $conn;
    $sql                = "SELECT count(id) as total_row FROM delivery_assignment where import_date = '$date'";
    $result             = $conn->query($sql);
    $lastRows           = $result->fetch_object();
    $number             = intval($lastRows->total_row) + 1;
    $dateFormatExplode  = explode('-', $date);
    $dateFormat         = $dateFormatExplode[0].$dateFormatExplode[1].$dateFormatExplode[2];
    $defaultCode        = $prefix.$dateFormat.sprintf('%08d', $number);
    return $defaultCode;

}
function human_format_date($timestamp){
    return date("jS M, Y h:i:a", strtotime($timestamp)); //September 30th, 2013
}
function getUserNameByUserId($id){
    global $conn;
    $sql = "SELECT * FROM users where id=$id";
    $result = $conn->query($sql);
    $name   =   '';
    if ($result->num_rows > 0) {
        $users  = $result->fetch_object();
        return $users->name;
    }
    return $name;
}
function getSignatureByUserId($id){
    global $conn;
    $sql = "SELECT * FROM users where id=$id";
    $result = $conn->query($sql);
    $name   =   '';
    if ($result->num_rows > 0) {
        $users  = $result->fetch_object();
        return $users->signature_image;
    }
    return $name;
}
function getDesignationByUserId($id){
    global $conn;
    $sql = "SELECT * FROM users where id=$id";
    $result = $conn->query($sql);
    $name   =   '';
    if ($result->num_rows > 0) {
        $users  = $result->fetch_object();
        return getDesignationNameById($users->designation);
    }
    return $name;
}
function sending_sms($smsData) {
    $curl = curl_init();
// Set some options - we are passing in a useragent too here
    curl_setopt_array($curl, [
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => 'http://users.sendsmsbd.com/smsapi',
        CURLOPT_USERAGENT => 'SMS Process',
        CURLOPT_POST => 1,
        CURLOPT_POSTFIELDS => [
            'api_key'   => 'C20048105db9338ce405a5.84287692',
            'type'      => 'text',
            'senderid'  => 'SAIF POWER',
            'contacts'  => '88'.$smsData['contacts'],
            'msg'       => $smsData['msg'],
        ]
    ]);
// Send the request & save response to $resp
    $resp = curl_exec($curl);
// Close request to clear up some resources
    curl_close($curl);
    return $resp;
}

function deleteRecordByTableAndId($table,$fieldName,$id){
    global $conn;
    $sql            = "DELETE FROM $table WHERE $fieldName='$id'";
    if ($conn->query($sql) === TRUE) {
        $feedbackData   =   [
            'status'    =>  'success',
            'message'   =>  'Data have been successfully Deleted',
        ];
        return $feedbackData;
    } else {
        $feedbackData   =   [
            'status'    =>  'error',
            'message'   =>  "Error: " . $sql . "<br>" . $conn->error,
        ];
        return $feedbackData;
    }
}

function getRoleShortNameByRoleId($id){
    global $conn;
    $table  =   "roles";
    $sql = "SELECT * FROM $table WHERE id=$id";
    $result = $conn->query($sql);
    $name   =   '';
    if ($result->num_rows > 0) {
        $name   =   $result->fetch_object()->short_name;
    }
    return $name;
}

function validate_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function get_page_short_name_by_id($id){
    global $conn;
    $table  =   "page_details";
    $sql = "SELECT * FROM $table WHERE id=$id";
    $result = $conn->query($sql);
    $name   =   '';
    if ($result->num_rows > 0) {
        $name   =   $result->fetch_object()->short_name;
    }
    return $name;
}

function getDesignationNameById($id){
    global $conn;
    $table  =   "designations";
    $sql = "SELECT * FROM $table WHERE id=$id";
    $result = $conn->query($sql);
    $name   =   '';
    if ($result->num_rows > 0) {
        $name   =   $result->fetch_object()->name;
    }
    return $name;
}
function getDesignationIdByName($name){
    global $conn;
    $table  =   "designations";
    $sql = "SELECT * FROM $table WHERE name='$name'";
    $result = $conn->query($sql);
    $name   =   '';
    if ($result->num_rows > 0) {
        $name   =   $result->fetch_object()->id;
    }
    return $name;
}

function getRoleIdByRoleName($name){
    global $conn;
    $table  =   "roles";
    $sql = "SELECT * FROM $table WHERE name='$name'";
    $result = $conn->query($sql);
    $name   =   '';
    if ($result->num_rows > 0) {
        $name   =   $result->fetch_object()->id;
    }
    return $name;
}
function getRoleNameByRoleId($id){
    global $conn;
    $table  =   "roles";
    $sql = "SELECT * FROM $table WHERE id=$id";
    $result = $conn->query($sql);
    $name   =   '';
    if ($result->num_rows > 0) {
        $name   =   $result->fetch_object()->name;
    }
    return $name;
}
function getDivisionNameById($id){
    global $conn;
    $table  =   "branch";
    $sql = "SELECT * FROM $table WHERE id=$id";
    $result = $conn->query($sql);
    $name   =   '';
    if ($result->num_rows > 0) {
        $name   =   $result->fetch_object()->name;
    }
    return $name;
}
function getCandidateNameById($id){
    global $conn;
    $table  =   "candidates";
    $sql = "SELECT * FROM $table WHERE id=$id";
    $result = $conn->query($sql);
    $name   =   '';
    if ($result->num_rows > 0) {
        $name   =   $result->fetch_object()->name;
    }
    return $name;
}
function getDivisionIdByName($name){
    global $conn;
    $table  =   "branch";
    $sql = "SELECT * FROM $table WHERE name='$name'";
    $result = $conn->query($sql);
    $name   =   '';
    if ($result->num_rows > 0) {
        $name   =   $result->fetch_object()->id;
    }
    return $name;
}
function getDepartmentIdByName($branch_id,$name){
    global $conn;
    $table  =   "department";
    $sql = "SELECT * FROM $table WHERE branch_id=$branch_id AND name='$name'";
    $result = $conn->query($sql);
    $name   =   '';
    if ($result->num_rows > 0) {
        $name   =   $result->fetch_object()->id;
    }
    return $name;
}
function getDepartmentNameById($id){
    global $conn;
    $table  =   "department";
    $sql = "SELECT * FROM $table WHERE id=$id";
    $result = $conn->query($sql);
    $name   =   '';
    if ($result->num_rows > 0) {
        $name   =   $result->fetch_object()->name;
    }
    return $name;
}
function get_table_next_primary_id($table){
    global $conn;
    $sql        = "SELECT count('id') as total FROM $table";
    $result     = $conn->query($sql);
    $total_row  =   $result->fetch_object()->total;
    $nextRow    =   $total_row+1;
    return $nextRow;
}
function get_rlp_no($prefix="RLP", $formater_length=4){
    global $conn;
    
    $division_id    =   $_SESSION['logged']['branch_id'];
    $department_id  =   $_SESSION['logged']['department_id'];
    $department_id  =   $_SESSION['logged']['department_id'];
    $office_id      =   $_SESSION['logged']['office_id'];
    $user_id        =   $_SESSION['logged']['user_id'];
    
    $year       =   date("Y");
    $month      =   date("m");
    $sql        = "SELECT count('id') as total FROM rlp_info WHERE YEAR(created_at) = '$year' AND MONTH(created_at) = $month AND is_delete=0 AND rlp_user_id=$user_id AND request_division=$division_id AND request_department=$department_id";
    $result     = $conn->query($sql);
    $total_row  =   $result->fetch_object()->total;
    
    $nextRLP    =   $total_row+1;
    $finalRLPNo = sprintf('%0' . $formater_length . 'd', $nextRLP);
    $divName    = replace_dashes(getDivisionNameById($division_id));
    $depName    = replace_dashes(getDepartmentNameById($department_id));
    
    return $prefix."-".$year."-".$month."-".$divName.'-'.$depName.'-'.$finalRLPNo;
}
function get_notesheet_no($prefix="NS", $formater_length=4){
    global $conn;
    
    $division_id    =   $_SESSION['logged']['branch_id'];
    $department_id  =   $_SESSION['logged']['department_id'];
    $department_id  =   $_SESSION['logged']['department_id'];
    $office_id      =   $_SESSION['logged']['office_id'];
    $user_id        =   $_SESSION['logged']['user_id'];
    
    $year       =   date("Y");
    $month      =   date("m");
    $sql        = "SELECT count('id') as total FROM notesheets_master WHERE YEAR(created_at) = '$year' AND MONTH(created_at) = $month";
    $result     = $conn->query($sql);
    $total_row  =   $result->fetch_object()->total;
    
    $nextRLP    =   $total_row+1;
    $finalRLPNo = sprintf('%0' . $formater_length . 'd', $nextRLP);
    $divName    = replace_dashes(getDivisionNameById($division_id));
    $depName    = replace_dashes(getDepartmentNameById($department_id));
    
    return $prefix."-".$year."-".$month."-".$divName.'-'.$depName.'-'.$finalRLPNo;
}
function get_mcsl_no($prefix="MCSL", $formater_length=4){
    global $conn;
    
    $division_id    =   $_SESSION['logged']['branch_id'];
    $department_id  =   $_SESSION['logged']['department_id'];
    $department_id  =   $_SESSION['logged']['department_id'];
    $office_id      =   $_SESSION['logged']['office_id'];
    $user_id        =   $_SESSION['logged']['user_id'];
    
    $year       =   date("Y");
    $month      =   date("m");
    $sql        = "SELECT count('id') as total FROM maintenance_cost WHERE YEAR(created_at) = '$year' AND MONTH(created_at) = $month";
    $result     = $conn->query($sql);
    $total_row  =   $result->fetch_object()->total;
    
    $nextRLP    =   $total_row+1;
    $finalRLPNo = sprintf('%0' . $formater_length . 'd', $nextRLP);
    //$divName    = replace_dashes(getDivisionNameById($division_id));
    $divName    = 'EEL';
    $depName    = replace_dashes(getDepartmentNameById($department_id));
    
    return $year."-".$month."-".$divName.'-'.$prefix.'-'.$finalRLPNo;
}
function get_wo_no($prefix="WO", $formater_length=4){
    global $conn;
    
    $division_id    =   $_SESSION['logged']['branch_id'];
    $department_id  =   $_SESSION['logged']['department_id'];
    $department_id  =   $_SESSION['logged']['department_id'];
    $office_id      =   $_SESSION['logged']['office_id'];
    $user_id        =   $_SESSION['logged']['user_id'];
    
    $year       =   date("Y");
    $month      =   date("m");
    $sql        = "SELECT count('id') as total FROM workorders_master WHERE YEAR(created_at) = '$year' AND MONTH(created_at) = $month";
    $result     = $conn->query($sql);
    $total_row  =   $result->fetch_object()->total;
    
    $nextRLP    =   $total_row+1;
    $finalRLPNo = sprintf('%0' . $formater_length . 'd', $nextRLP);
    $divName    = replace_dashes(getDivisionNameById($division_id));
    $depName    = replace_dashes(getDepartmentNameById($department_id));
    
    return $year."-".$month."-".$divName.'-'.$prefix.'-'.$finalRLPNo;
}
function get_rrr_no($prefix="RRR", $formater_length=4){
    global $conn;
    
    $division_id    =   $_SESSION['logged']['branch_id'];
    $department_id  =   $_SESSION['logged']['department_id'];
    $department_id  =   $_SESSION['logged']['department_id'];
    $office_id      =   $_SESSION['logged']['office_id'];
    $user_id        =   $_SESSION['logged']['user_id'];
    
    $year       =   date("Y");
    $month      =   date("m");
    $sql        = "SELECT count('id') as total FROM rrr_info WHERE YEAR(created_at) = '$year' AND MONTH(created_at) = $month AND is_delete=0 AND request_division=$division_id AND request_department=$department_id";
    $result     = $conn->query($sql);
    $total_row  =   $result->fetch_object()->total;
    
    $nextRLP    =   $total_row+1;
    $finalRLPNo = sprintf('%0' . $formater_length . 'd', $nextRLP);
    $divName    = replace_dashes(getDivisionNameById($division_id));
    $depName    = replace_dashes(getDepartmentNameById($department_id));
    
    return $prefix."-".$year."-".$month."-".$divName.'-'.$depName.'-'.$finalRLPNo;
}

function replace_dashes($string) {
    $string = str_replace("-", " ", $string);
    return $string;
}
function get_priorities(){
    $table      = 'priority_details';
    $order      = 'ASC';
    $column     = 'show_order';
    $dataType   = 'obj';
    $listData   = getTableDataByTableName($table, $order, $column, $dataType);
    return $listData;
}

function getPriorityName($id){
    global $conn;
    $table  =   "priority_details";
    $sql = "SELECT * FROM $table WHERE id=$id";
    $result = $conn->query($sql);
    $name   =   'Urgent';
    if ($result->num_rows > 0) {
        $name   =   $result->fetch_object()->name;
    }
    return $name;
}
function getPriorityNameDiv($id){
    global $conn;
    $table  =   "priority_details";
    $sql = "SELECT * FROM $table WHERE id=$id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $priority   =   $result->fetch_object();
    ?>    
    <span class="label label-<?php echo $priority->color_code; ?>"><?php echo $priority->name; ?></span>
    <?php }
}
function get_status_color($id){
    global $conn;
    $table  =   "status_details";
    $sql = "SELECT * FROM $table WHERE id=$id";
    $result = $conn->query($sql);
    $name   =   '#FFDB58';
    if ($result->num_rows > 0) {
        $name   =   $result->fetch_object()->bg_color;
    }
    return $name;
}
function get_status_name($id){
    global $conn;
    $table  =   "status_details";
    $sql = "SELECT * FROM $table WHERE id=$id";
    $result = $conn->query($sql);
    $name   =   'Pending';
    if ($result->num_rows > 0) {
        $name   =   $result->fetch_object()->name;
    }
    return $name;
}

function getAllDepartmentHeads($department_id){
    $table  =   "SELECT id,name,branch_id,department_id,office_id FROM users WHERE role_id=3 AND department_id=$department_id";
    $datas  =    getDataRowIdAndTableBySQL($table);
    return $datas;
}
function getAllApprovalBodies(){
    $table  =   "SELECT id,name,branch_id,department_id,office_id FROM users WHERE role_id IN (16,20,21)";
    $datas  =    getDataRowIdAndTableBySQL($table);
    return $datas;
}

function has_rlp_approved($rlp_id){
    global $conn;
    $table  =   "rlp_info";
    $sql = "SELECT * FROM $table WHERE id=$rlp_id";
    $result = $conn->query($sql);
    $is_approved   =   false;
    if ($result->num_rows > 0) {
        $is_approved   =   ($result->fetch_object()->rlp_status == 1 ? true : false);
    }
    return $is_approved;
}
function has_rrr_approved($rrr_id){
    global $conn;
    $table  =   "rrr_info";
    $sql = "SELECT * FROM $table WHERE id=$rrr_id";
    $result = $conn->query($sql);
    $is_approved   =   false;
    if ($result->num_rows > 0) {
        $is_approved   =   ($result->fetch_object()->rrr_status == 1 ? true : false);
    }
    return $is_approved;
}

function rlp_acknowledgement_is_pending($rlp_info_id, $ack_status){
    global $conn;    
    $table      =   "rlp_acknowledgement";
    $ack_status = implode(',', $ack_status);
    $sql        =   "SELECT * FROM $table WHERE rlp_info_id=$rlp_info_id AND ack_status IN($ack_status)";
    $result     =   $conn->query($sql);
    $is_pending =   true;
    if ($result->num_rows > 0) {
        $is_pending =   false;
    }    
    return $is_pending;
}

function rrr_acknowledgement_is_pending($rrr_info_id, $ack_status){
    global $conn;    
    $table      =   "rrr_acknowledgement";
    $ack_status = implode(',', $ack_status);
    $sql        =   "SELECT * FROM $table WHERE rrr_info_id=$rrr_info_id AND ack_status IN($ack_status)";
    $result     =   $conn->query($sql);
    $is_pending =   true;
    if ($result->num_rows > 0) {
        $is_pending =   false;
    }    
    return $is_pending;
}

function get_next_rlp_visible_user($rlp_info_id){
    $table  =   "rlp_acknowledgement WHERE rlp_info_id=$rlp_info_id AND ack_status=0 AND is_visible=0 ORDER BY ack_order ASC LIMIT 1";
    $datas  =    getDataRowIdAndTable($table);
    if(isset($datas) && !empty($datas)){
        return $datas->id;
    }
    return false;
}

function set_rlp_visible_for_acknowledge($rlp_info_id){
    $id                 =   get_next_rlp_visible_user($rlp_info_id);
    if($id){
        $table          =   "rlp_acknowledgement";
        $dataParam      =   [
            'ack_request_date'  =>  date('Y-m-d H:i:s'),
            'is_visible'        =>  1
        ];
        $where      =   [
            'id'    =>  $id
        ];
        updateData($table, $dataParam, $where);
    }
}

function get_next_rrr_visible_user($rrr_info_id){
    $table  =   "rrr_acknowledgement WHERE rrr_info_id=$rrr_info_id AND ack_status=0 AND is_visible=0 ORDER BY ack_order ASC LIMIT 1";
    $datas  =    getDataRowIdAndTable($table);
    if(isset($datas) && !empty($datas)){
        return $datas->id;
    }
    return false;
}
function set_rrr_visible_for_acknowledge($rrr_info_id){
    $id                 =   get_next_rrr_visible_user($rrr_info_id);
    if($id){
        $table          =   "rrr_acknowledgement";
        $dataParam      =   [
            'ack_request_date'  =>  date('Y-m-d H:i:s'),
            'is_visible'        =>  1
        ];
        $where      =   [
            'id'    =>  $id
        ];
        updateData($table, $dataParam, $where);
    }
}

function loadPageAccessPageBody($pagedetails){ ?>
    <?php
        if (isset($pagedetails) && !empty($pagedetails)) {
            foreach ($pagedetails as $data) {
                $data   =   (array)$data;
                ?>
                <tr>
                    <td style="text-align: right;"><?php echo $data['name']; ?></td>
                    <td style="text-align: center;">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="add[]" value="<?php echo $data['page_id'] ?>" <?php if ($data['add']) { ?> checked <?php } ?>>
                            </label>
                        </div>
                    </td>
                    <td style="text-align: center;">
                        <div class="checkbox">
                            <label><input type="checkbox" name="edit[]" value="<?php echo $data['page_id'] ?>" <?php if ($data['edit']) { ?> checked <?php } ?>></label>
                        </div>
                    </td>
                    <td style="text-align: center;">
                        <div class="checkbox">
                            <label><input type="checkbox" name="delete[]" value="<?php echo $data['page_id'] ?>" <?php if ($data['delete']) { ?> checked <?php } ?>></label>
                        </div>
                    </td>
                    <td style="text-align: center;">
                        <div class="checkbox">
                            <label><input type="checkbox" name="view[]" value="<?php echo $data['page_id'] ?>" <?php if ($data['view']) { ?> checked <?php } ?>></label>
                        </div>
                    </td>
                    <td style="text-align: center;">
                        <div class="checkbox">
                            <label><input type="checkbox" name="print[]" value="<?php echo $data['page_id'] ?>" <?php if ($data['print']) { ?> checked <?php } ?>></label>
                        </div>
                    </td>
                </tr>
                <?php
            }
        }
}
function loadDefaultPageAccessPageBody(){ ?>
    <?php
        $table = "page_details";
        $order = "ASC";
        $column = "show_order";
        $pagedetails = getTableDataByTableName($table, $order, $column);
        if (isset($pagedetails) && !empty($pagedetails)) {
            foreach ($pagedetails as $data) {
                ?>
                <tr>
                    <td style="text-align: right;"><?php echo $data->name ?></td>
                    <td style="text-align: center;">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="add[]" value="<?php echo $data->id; ?>">
                            </label>
                        </div>
                    </td>
                    <td style="text-align: center;">
                        <div class="checkbox">
                            <label><input type="checkbox" name="edit[]" value="<?php echo $data->id; ?>"></label>
                        </div>
                    </td>
                    <td style="text-align: center;">
                        <div class="checkbox">
                            <label><input type="checkbox" name="delete[]" value="<?php echo $data->id; ?>"></label>
                        </div>
                    </td>
                    <td style="text-align: center;">
                        <div class="checkbox">
                            <label><input type="checkbox" name="view[]" value="<?php echo $data->id; ?>"></label>
                        </div>
                    </td>
                    <td style="text-align: center;">
                        <div class="checkbox">
                            <label><input type="checkbox" name="print[]" value="<?php echo $data->id; ?>"></label>
                        </div>
                    </td>
                </tr>
                <?php
            }
        }
}
function get_rlp_item_details($rlp_details){   
    $rlp_info       =   $rlp_details['rlp_info'];
    $rlp_details    =   $rlp_details['rlp_details'];
?>
<!-- Main content -->
<section class="invoice">
    <!-- title row -->
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                <i class="fa fa-globe"></i> RLP Details.
                <small class="pull-right">Priority: <?php echo getPriorityName($rlp_info->priority) ?></small>
            </h2>
        </div>
        <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-sm-8 invoice-col">
            From
            <address>
                <strong>Name:&nbsp;<?php echo $rlp_info->request_person ?></strong><br>
                Designation:&nbsp;<?php echo $rlp_info->designation ?><br>
                Department:&nbsp;<?php echo getNameByIdAndTable("department",$rlp_info->request_department) ?><br>
                Contact:&nbsp;<?php echo $rlp_info->contact_number ?><br>
                Email:&nbsp;Email: <?php echo $rlp_info->email ?>
            </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
            <div class="pull-right">
                <b>RLP NO: &nbsp;<span class="rlpno_style"><?php echo $rlp_info->rlp_no ?></span></b><br>
                <b>Request Date:</b> <?php echo human_format_date($rlp_info->created_at) ?><br>
            </div>            
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
        <div class="col-xs-12 table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Item Description</th>
                        <th>Purpose of Purchase</th>
                        <th>Quantity</th>
                        <th>Estimated Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sl =   1;
                        foreach($rlp_details as $data){
                    ?>
                    <tr>
                        <td><?php echo $sl++; ?></td>
                        <td><?php echo $data->item_des; ?></td>
                        <td><?php echo $data->purpose; ?></td>
                        <td><?php echo $data->quantity; ?></td>
                        <td><?php echo $data->estimated_price; ?></td>
                    </tr>
                        <?php } ?>
                </tbody>
            </table>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>
<!-- /.content -->
<div class="clearfix"></div>
<?php }
function get_rrr_item_details($rrr_details){   
    $rrr_info       =   $rrr_details['rrr_info'];
    //$rrr_remarks    =   $rrr_details['rrr_remarks_history'];
?>
<!-- Main content -->
<section class="invoice">
    <!-- title row -->
    <div class="row">
        <div class="col-xs-12">
			<table class="table table-bordered">
				<tr>
					<td class="">Recruitement Request No: <?php echo $rrr_info->rrr_no; ?></td>
					<td class="">Recruitement For: <?php echo getDesignationNameById($rrr_info->req_designation); ?>/<?php echo getDivisionNameById($rrr_info->request_division); ?></td>
					<td class="">Priority: <?php echo getPriorityName($rrr_info->priority) ?></td>
				</tr>
			</table>
        </div>
        <!-- /.col -->
    </div>
    <!-- info row -->
    <!-- /.row -->

    <!-- Table row -->
    <div class="box-footer box-comments">
        <?php
        $table = "rrr_remarks_history WHERE rrr_info_id=$rrr_info->id";
        $order = 'DESC';
        $column = 'remarks_date';
        $allRemarksHistory = getTableDataByTableName($table, $order, $column);
        if (isset($allRemarksHistory) && !empty($allRemarksHistory)) {
            foreach ($allRemarksHistory as $dat) {
                ?>
                <div class="box-comment">
                  <div class="comment-text" style="margin-left: 0;">
                      <span class="username">
                        By <?php echo getUserNameByUserId($dat->user_id); ?>
                        <span class="text-muted pull-right"> at <?php echo human_format_date($dat->remarks_date) ?></span>
                      </span><!-- /.username -->
                  <?php echo $dat->remarks ?>
                </div>
                <!-- /.comment-text -->
              </div>
              <!-- /.box-comment -->
                <?php
            } // foreach
        }
            ?>
            <div class="box-comment">
                <div class="comment-text" style="margin-left: 0;">
                    <span class="username">
                        By <?php echo getUserNameByUserId($rrr_info->rrr_user_id); ?>
                        <span class="text-muted pull-right"> at <?php echo human_format_date($rrr_info->created_at) ?></span>
                    </span><!-- /.username -->
                    <?php echo $rrr_info->user_remarks ?>
                </div>
                <!-- /.comment-text -->
            </div>
			<form id="rrr_dh_update_form">


				<input type="hidden" name="acknowledgement" value="<?php echo $rrr_info->rrr_status; ?>">			
				<div class="form-group">
					<label for="comment">Comments:</label>
					<textarea class="form-control" rows="5" id="remarks" name="remarks"></textarea>
				</div>
				<input type="hidden" name="rrr_info_id" value="<?php echo $rrr_info->id; ?>">
				<input type="hidden" name="created_by" value="<?php echo $rrr_info->rrr_user_id; ?>">
				<button type="button" class="btn btn-primary btn-block" onclick="execute_rrr_dh_update_form('rrr_dh_update_form', 'rrr_dh_update_execute');">Update</button>
			</form>
        </div>
    <!-- /.row -->
</section>
<!-- /.content -->
<div class="clearfix"></div>
<?php }
function get_notesheet_details($rrr_details){   
    $rrr_info       =   $rrr_details['rrr_info'];
    //$rrr_remarks    =   $rrr_details['rrr_remarks_history'];
?>
<!-- Main content -->
<section class="invoice">
    <!-- title row -->
    <div class="row">
        <div class="col-xs-12">
			<table class="table table-bordered">
				<tr>
					<td class="">Notesheet No: <?php echo $rrr_info->rrr_no; ?></td>
					<td class="">Notesheet For: <?php echo getDesignationNameById($rrr_info->req_designation); ?>/<?php echo getDivisionNameById($rrr_info->request_division); ?></td>
					<td class="">Notesheet: <?php echo getPriorityName($rrr_info->priority) ?></td>
				</tr>
			</table>
        </div>
        <!-- /.col -->
    </div>
    <!-- info row -->
    <!-- /.row -->

    <!-- Table row -->
    <div class="box-footer box-comments">
        <?php
        $table = "notesheet_remarks_history WHERE rrr_info_id=$rrr_info->id";
        $order = 'DESC';
        $column = 'remarks_date';
        $allRemarksHistory = getTableDataByTableName($table, $order, $column);
        if (isset($allRemarksHistory) && !empty($allRemarksHistory)) {
            foreach ($allRemarksHistory as $dat) {
                ?>
                <div class="box-comment">
                  <div class="comment-text" style="margin-left: 0;">
                      <span class="username">
                        By <?php echo getUserNameByUserId($dat->user_id); ?>
                        <span class="text-muted pull-right"> at <?php echo human_format_date($dat->remarks_date) ?></span>
                      </span><!-- /.username -->
                  <?php echo $dat->remarks ?>
                </div>
                <!-- /.comment-text -->
              </div>
              <!-- /.box-comment -->
                <?php
            } // foreach
        }
            ?>
            <div class="box-comment">
                <div class="comment-text" style="margin-left: 0;">
                    <span class="username">
                        By <?php echo getUserNameByUserId($rrr_info->rrr_user_id); ?>
                        <span class="text-muted pull-right"> at <?php echo human_format_date($rrr_info->created_at) ?></span>
                    </span><!-- /.username -->
                    <?php echo $rrr_info->user_remarks ?>
                </div>
                <!-- /.comment-text -->
            </div>
			<form id="rrr_dh_update_form">


				<input type="hidden" name="acknowledgement" value="<?php echo $rrr_info->rrr_status; ?>">			
				<div class="form-group">
					<label for="comment">Comments:</label>
					<textarea class="form-control" rows="5" id="remarks" name="remarks"></textarea>
				</div>
				<input type="hidden" name="rrr_info_id" value="<?php echo $rrr_info->id; ?>">
				<input type="hidden" name="created_by" value="<?php echo $rrr_info->rrr_user_id; ?>">
				<button type="button" class="btn btn-primary btn-block" onclick="execute_notesheet_dh_update_form('rrr_dh_update_form', 'notesheet_dh_update_execute');">Update</button>
			</form>
        </div>
    <!-- /.row -->
</section>
<!-- /.content -->
<div class="clearfix"></div>
<?php }
function get_rlp_chain_assign_user_view($data){
    $users      =   $data['users'];
    $formType   =   $data['formType'];
    if (isset($users) && !empty($users)){
        if($formType  != 'access_form'){
            foreach ($users as $data) {            
                include '../partial/rlp_chain_assign_user_common_checkbox_view.php';
            }
        }else{
            include '../partial/department_users_dropdown.php';
        } ?>
    <?php }else{ ?>
        <div class="alert alert-warning">
            <strong>Warning!</strong> No user found with the Division And Department.
      </div>
<?php }
}
function get_user_department_wise_rlp_chain_for_create(){
    $division_id    =   $_SESSION['logged']['branch_id'];
    $department_id  =   $_SESSION['logged']['department_id'];
    $table          =   "rlp_access_chain"
            . " WHERE chain_type='default'"
            . " AND division_id=$division_id"
            . " AND department_id=$department_id";
    $defaultChain       =   getDataRowIdAndTable($table);
    $defaultChainUsers  =   (isset($defaultChain) && !empty($defaultChain) ? json_decode($defaultChain->users) : "");
    include 'partial/rlp_chain_for_form.php';
}

function get_user_department_wise_rrr_chain_for_create(){
    $division_id    =   $_SESSION['logged']['branch_id'];
    $department_id  =   $_SESSION['logged']['department_id'];
    $table          =   "rlp_access_chain"
            . " WHERE chain_type='default'"
            . " AND division_id=$division_id"
            . " AND department_id=$department_id";
    $defaultChain       =   getDataRowIdAndTable($table);
    $defaultChainUsers  =   (isset($defaultChain) && !empty($defaultChain) ? json_decode($defaultChain->users) : "");
    include 'partial/rrr_chain_for_form.php';
}

function is_password_changed(){
    if($_SESSION['logged']['is_password_changed']){
        return true;
    }else{
        return false;
    }
}

function get_role_group($name){
    $table  = "roles_group WHERE name = '$name'";
    $res    = getDataRowIdAndTable($table);
    $details    = json_decode($res->details);
    return $details;
}

function get_division_select_box(){
    include 'partial/division_select_box.php';
}
function get_department_select_box(){
    include 'partial/department_select_box.php';
}
function get_supplier_id($prefix="SUP", $formater_length=4){
    global $conn;
    $sql        = "SELECT count('id') as total FROM suppliers";
    $result     = $conn->query($sql);
    $total_row  =   $result->fetch_object()->total;
    $nextsupplier    =   $total_row+1;
    $finalsupplierid = sprintf('%0' . $formater_length . 'd', $nextsupplier);
    return $prefix."-".$finalsupplierid;
}
function get_candidate_id($prefix="CAN", $formater_length=4){
    global $conn;
    $sql        = "SELECT count('id') as total FROM candidates";
    $result     = $conn->query($sql);
    $total_row  =   $result->fetch_object()->total;
    $nextsupplier    =   $total_row+1;
    $finalsupplierid = sprintf('%0' . $formater_length . 'd', $nextsupplier);
    return $prefix."-".$finalsupplierid;
}
function get_interview_id($prefix="INT", $formater_length=4){
    global $conn;
    $sql        = "SELECT count('id') as total FROM interviews";
    $result     = $conn->query($sql);
    $total_row  =   $result->fetch_object()->total;
    $nextsupplier    =   $total_row+1;
    $finalsupplierid = sprintf('%0' . $formater_length . 'd', $nextsupplier);
    return $prefix."-".$finalsupplierid;
}

function convertNumberToWords(float $number)
{
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $decimal_part = $decimal;
    $hundred = null;
    $hundreds = null;
    $digits_length = strlen($no);
    $decimal_length = strlen($decimal);
    $i = 0;
    $str = array();
    $str2 = array();
    $words = array(0 => '', 1 => 'One', 2 => 'Two',
        3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
        7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
        10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
        13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
        16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
        19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
        40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
        70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
    $digits = array('', 'Hundred','Thousand','Lakh', 'Crore');

    while( $i < $digits_length ) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? '' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
        } else $str[] = null;
    }

    $d = 0;
    while( $d < $decimal_length ) {
        $divider = ($d == 2) ? 10 : 100;
        $decimal_number = floor($decimal % $divider);
        $decimal = floor($decimal / $divider);
        $d += $divider == 10 ? 1 : 2;
        if ($decimal_number) {
            $plurals = (($counter = count($str2)) && $decimal_number > 9) ? '' : null;
            $hundreds = ($counter == 1 && $str2[0]) ? ' and ' : null;
            @$str2 [] = ($decimal_number < 21) ? $words[$decimal_number].' '. $digits[$decimal_number]. $plural.' '.$hundred:$words[floor($decimal_number / 10) * 10].' '.$words[$decimal_number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
        } else $str2[] = null;
    }

    $Taka = implode('', array_reverse($str));
    $Paysa = implode('', array_reverse($str2));
    $Paysa = ($decimal_part > 0) ? $Paysa . ' Paysa' : '';
    return ($Taka ? $Taka . 'Taka ' : '') . $Paysa;
}












function get_my_credit_amount($param){
	global $conn;
	if($_SESSION['logged']['user_type'] !== 'whm'){
		$sqloutqty = "SELECT SUM(`pb_cr_amount`) AS totalcredit FROM `inv_partybalance` WHERE `pb_party_id` = '$param->pb_party_id' AND pb_date BETWEEN '$param->from_date' AND '$param->to_date'";
		}else{
		$sqloutqty = "SELECT SUM(`pb_cr_amount`) AS totalcredit FROM `inv_partybalance` WHERE `warehouse_id` = $param->warehouse_id  AND `pb_party_id` = '$param->pb_party_id'  AND pb_date BETWEEN '$param->from_date' AND '$param->to_date'";
		}
		
		$resultoutqty = mysqli_query($conn, $sqloutqty);
		$rowoutqty = mysqli_fetch_object($resultoutqty) ;
		$totcredit = $rowoutqty->totalcredit;
		return $totcredit;
		
}

function get_my_debit_amount($param){
	global $conn;
	if($_SESSION['logged']['user_type'] !== 'whm'){
		$sqlinqty = "SELECT SUM(`pb_dr_amount`) AS totaldebit FROM `inv_partybalance` WHERE `pb_party_id` = '$param->pb_party_id'  and pb_date BETWEEN '$param->from_date' AND '$param->to_date'";
	}else{
		$sqlinqty = "SELECT SUM(`pb_dr_amount`) AS totaldebit FROM `inv_partybalance` WHERE warehouse_id = $param->warehouse_id  and `pb_party_id` = '$param->pb_party_id' AND pb_date BETWEEN '$param->from_date' AND '$param->to_date'";
	}
	
	$resultinqty = mysqli_query($conn, $sqlinqty);
	$rowinqty = mysqli_fetch_object($resultinqty) ;
	$totdebit = $rowinqty->totaldebit;
	return $totdebit;
}


function is_showable($cr, $dt){
	
	$status = false;
	
	if($cr > 0 && $dt == 0){
		$status = true;
	}
	
	if($dt > 0 && $cr == 0){
		$status = true;
	}
	
	if($cr > 0 && $dt > 0){
		$status = true;
	}
	
	return $status;
	
}


function getTableDataByTableNamePackage($table, $order = 'asc', $column='id', $dataType = '') {
    global $conn;
    $dataContainer  =   [];
	$warehouse_id = $_SESSION['logged']['warehouse_id'];
    $sql = "SELECT * FROM $table WHERE warehouse_id=$warehouse_id order by $column $order";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        if (isset($dataType) && $dataType == 'obj') {
            while ($row = $result->fetch_object()) {
                $dataContainer[] = $row;
            }
        } else {
            while ($row = $result->fetch_assoc()) {
                $dataContainer[] = $row;
            }
        }
    }
    return $dataContainer;
}






	
	
	
	
function getwarehouseinfo($table, $order = 'asc', $column='id', $dataType = '') {
    global $conn;
    $dataContainer  =   [];
    $sql = "SELECT * FROM $table WHERE `short_name` !='CW' order by $column $order";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        if (isset($dataType) && $dataType == 'obj') {
            while ($row = $result->fetch_object()) {
                $dataContainer[] = $row;
            }
        } else {
            while ($row = $result->fetch_assoc()) {
                $dataContainer[] = $row;
            }
        }
    }
    return $dataContainer;
}
function getTableDataByTableNameWid($table, $order = 'asc', $column='id', $dataType = '') {
    global $conn;
	$warehouse_id	=	$_SESSION['logged']['warehouse_id'];
    $dataContainer  =   [];
    $sql = "SELECT * FROM $table WHERE warehouse_id=$warehouse_id order by $column $order";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        if (isset($dataType) && $dataType == 'obj') {
            while ($row = $result->fetch_object()) {
                $dataContainer[] = $row;
            }
        } else {
            while ($row = $result->fetch_assoc()) {
                $dataContainer[] = $row;
            }
        }
    }
    return $dataContainer;
}

function getTableDataByTableNameTid($table, $order = 'asc', $column='id', $dataType = '') {
    global $conn;
	$warehouse_id	=	$_SESSION['logged']['warehouse_id'];
    $dataContainer  =   [];
    $sql = "SELECT * FROM $table WHERE from_warehouse=$warehouse_id OR to_warehouse=$warehouse_id order by $column $order";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        if (isset($dataType) && $dataType == 'obj') {
            while ($row = $result->fetch_object()) {
                $dataContainer[] = $row;
            }
        } else {
            while ($row = $result->fetch_assoc()) {
                $dataContainer[] = $row;
            }
        }
    }
    return $dataContainer;
}


function getMaterialNameByIdAndTable($table){
    global $conn;
    $sql = "SELECT * FROM $table";
    $result = $conn->query($sql);
    $name   =   '';
    if ($result->num_rows > 0) {
        $name   =   $result->fetch_object()->material_description;
    }
    return $name;
}


function getItemCodeByParam($table, $field){
    global $conn;
    $sql = "SELECT * FROM $table";
    $result = $conn->query($sql);
    $name   =   '';
    if ($result->num_rows > 0) {
        $name   =   $result->fetch_object()->{$field};
    }
    return $name;
}





                      // varchar type value    WHERE party_id='$id1'";

function getDataRowByTableAndId1($table, $id1){
    global $conn;
    $sql    = "SELECT * FROM $table WHERE party_id='$id1'";
    $result = $conn->query($sql);
    $name   =   '';
    if ($result->num_rows > 0) {
        return $result->fetch_object();
    }else{
        return false;
    }
}








                      // varchar type value    WHERE party_id='$id1'";

function getDataRowByTableAndIdPartner($table, $id1){
    global $conn;
    $sql    = "SELECT * FROM $table WHERE partner_id='$id1'";
    $result = $conn->query($sql);
    $name   =   '';
    if ($result->num_rows > 0) {
        return $result->fetch_object();
    }else{
        return false;
    }
}


















// added by tanveer Qureshee: 2021-05-29
    function check_input_data($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
     }






function getDefaultCategoryCodeByWarehouse($table, $fieldName, $modifier, $defaultCode, $prefix){
    global $conn;
	$warehouse_id	=	$_SESSION['logged']['warehouse_id'];
    $sql    	= "SELECT count($fieldName) as total_row FROM $table WHERE warehouse_id=$warehouse_id";
    $result 	= $conn->query($sql);
    $name   	=   '';
    $lastRows   = $result->fetch_object();
    $number     = intval($lastRows->total_row) + 1;
    $defaultCode = $prefix.sprintf('%'.$modifier, $number);
    return $defaultCode;
    
}

function getDefaultCategoryCodeByWarehouseT($table, $fieldName, $modifier, $defaultCode, $prefix){
    global $conn;
	$warehouse_id	=	$_SESSION['logged']['warehouse_id'];
    $sql    	= "SELECT count($fieldName) as total_row FROM $table WHERE from_warehouse=$warehouse_id";
    $result 	= $conn->query($sql);
    $name   	=   '';
    $lastRows   = $result->fetch_object();
    $number     = intval($lastRows->total_row) + 1;
    $defaultCode = $prefix.sprintf('%'.$modifier, $number);
    return $defaultCode;
    
}

function get_product_with_category() {
    $final_array = [];
    global $conn;
    $sql = "SELECT * FROM inv_materialcategorysub order by category_description asc";
    $presult = $conn->query($sql);
    if ($presult->num_rows > 0) {
        // output data of each row
        while ($cat = $presult->fetch_object()) {
            $parent_id      = $cat->id;
            $parent_name    = $cat->category_description;
            $ssql           = "SELECT * FROM inv_materialcategory where category_id=$parent_id order by material_sub_description asc";
            $sresult        = $conn->query($ssql);
            if ($sresult->num_rows > 0) {
                while ($scat = $sresult->fetch_object()) {
                    $sub_item_id    = $scat->id;
                    $sub_item_name  = $scat->material_sub_description;
                    $msql           = "SELECT * FROM inv_material where material_id=$parent_id and material_sub_id=$sub_item_id order by material_description asc";
                    $mresult = $conn->query($msql);
                    if ($mresult->num_rows > 0) {
                        while ($material    = $mresult->fetch_object()) {
                            $final_array[]  = [
                                'id'                    => $material->id,
                                'parent_item_id'        => $material->material_id,
                                'sub_item_id'           => $material->material_sub_id,
                                'item_code'             => $material->material_id_code,
                                'cur_price'             => $material->cur_price,
                                'material_name'         => $material->material_description.' ('.$parent_name.' - '.$sub_item_name.')',
                            ];
                        }
                    }
                }
            }
        }
    }
    return $final_array;
}


function stockReportCheck() {
    $dataContainer = [];
    global $conn;
    $sql = "SELECT mb_materialid, (SUM(mbin_qty)-SUM(mbout_qty)) as BalanceQty, (SUM(mbin_val)-SUM(mbout_val)) as BalanceVal  FROM `inv_materialbalance` GROUP BY mb_materialid";
	
    /* $sql = "SELECT mb_materialid, (SUM(mbin_qty)-SUM(mbout_qty)) as BalanceQty, (SUM(mbin_val)-SUM(mbout_val)) as BalanceVal  FROM `inv_materialbalance` WHERE `approval_status`='1' GROUP BY mb_materialid"; */
	
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_object()) {
            $dataContainer[] = $row;
        }
    }
    return $dataContainer;
}
function getTotalstockInOutQuantityCheck($mid, $type) {
    $TOTAL = 0;
    global $conn;
    if($type    ==  'in'){
        $sql = "SELECT SUM(mbin_qty) as Total  FROM `inv_materialbalance` WHERE mb_materialid='$mid'";
        /* $sql = "SELECT SUM(mbin_qty) as Total  FROM `inv_materialbalance` WHERE mb_materialid='$mid' AND `approval_status`='1'"; */
    }
    if($type    ==  'out'){
        $sql = "SELECT SUM(mbout_qty) as Total  FROM `inv_materialbalance` WHERE mb_materialid='$mid'";
       /*  $sql = "SELECT SUM(mbout_qty) as Total  FROM `inv_materialbalance` WHERE mb_materialid='$mid' AND `approval_status`='1'"; */
    }
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $TOTAL = $result->fetch_object()->Total;
    }
    return $TOTAL;
}
function get_product_stock_by_material_id($param) {
    //default value:
    $totalStock =   0;
    // opening quantity:
    $opeingQuantityData     =   get_material_balance_opening_quantity($param);
    $openingQuantity        =   (isset($opeingQuantityData->openingMbInTotal) && !empty($opeingQuantityData->openingMbInTotal) ? $opeingQuantityData->openingMbInTotal : 0);
    
    // recieving quantity:
    $receivingQuantityData  =   get_material_balance_receiving_quantity($param);
    $receivingQuantity      =   (isset($receivingQuantityData->receivingMbInTotal) && !empty($receivingQuantityData->receivingMbInTotal) ? $receivingQuantityData->receivingMbInTotal : 0);
	
	
	  // ADJUSTMENT IN:
    $adjustmentinQuantityData  =   get_material_balance_adjustmentin_quantity($param);
    $adjustmentinQuantity      =   (isset($adjustmentinQuantityData->adjustmentInqty) && !empty($adjustmentinQuantityData->adjustmentInqty) ? $adjustmentinQuantityData->adjustmentInqty : 0);
	
	
	
		  // ADJUSTMENT out:
     $adjustmentOUTQuantityData  =   get_material_balance_adjustmentout_quantity($param);
    $adjustmentoutQuantity      =   (isset($adjustmentOUTQuantityData->adjustmentoutqty) && !empty($adjustmentOUTQuantityData->adjustmentoutqty) ? $adjustmentOUTQuantityData->adjustmentoutqty : 0);
	
	
	

    
    // issue quantity:
    $issueQuantityData      =   get_material_balance_issue_quantity($param);
    $issueQuantity          =   (isset($issueQuantityData->issueMbOutTotal) && !empty($issueQuantityData->issueMbOutTotal) ? $issueQuantityData->issueMbOutTotal : 0);
	
	// return quantity:
    $returnQuantityData      =   get_material_balance_return_quantity($param);
    $returnQuantity          =   (isset($returnQuantityData->returnMbInTotal) && !empty($returnQuantityData->returnMbInTotal) ? $returnQuantityData->returnMbInTotal : 0);
    
    // transfer_out quantity:
    $transfer_outQuantityData      =   get_material_balance_transfer_out_quantity($param);
    $transfer_outQuantity          =   (isset($transfer_outQuantityData->transferOutMbOutTotal) && !empty($transfer_outQuantityData->transferOutMbOutTotal) ? $transfer_outQuantityData->transferOutMbOutTotal : 0);
    
    // transfer_out quantity:
    $transfer_inQuantityData      =   get_material_balance_transfer_in_quantity($param);
    $transfer_inQuantity          =   (isset($transfer_inQuantityData->transferInMbInTotal) && !empty($transfer_inQuantityData->transferInMbInTotal) ? $transfer_inQuantityData->transferInMbInTotal : 0);
    
    
    $totalIn    =   ($openingQuantity + $receivingQuantity + $returnQuantity + $transfer_inQuantity + $adjustmentinQuantity);
    $totalOut   =   ($issueQuantity + $transfer_outQuantity+ $adjustmentoutQuantity);
    
    $totalStock     =   $totalIn - $totalOut;
    return $totalStock;
}
/*
 * Method for get opeing total data
 * $param
 * 1. mb_materialid
 * 2. warehouse_id
 */
function get_material_balance_opening_quantity($param){
    global $conn;
    $rowData    =   '';
    $mb_materialid  =   $param['mb_materialid'];
    $warehouse_id   =   $param['warehouse_id'];
    $sql            =   "SELECT mb_materialid,"
            . " sum(mbin_qty) as openingMbInTotal,"
            . " sum(mbout_qty) as openingMbOutTotal,"
            . " mbin_qty, mbin_val,"
            . " mbout_qty,"
            . " mbout_val,"
            . " mbprice FROM inv_materialbalance WHERE mb_materialid = '$mb_materialid'"
            . " AND warehouse_id='$warehouse_id'"
            /* . " AND `approval_status`='1'" */
            . " AND mbtype='OP'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $rowData = $result->fetch_object();
    }
    return $rowData;
}

/*
 * Method for get receiving total data
 * $param
 * 1. mb_materialid
 * 2. warehouse_id
 */
function get_material_balance_receiving_quantity($param){
    global $conn;
    $rowData    =   '';
    $mb_materialid  =   $param['mb_materialid'];
    $warehouse_id   =   $param['warehouse_id'];
    $sql            =   "SELECT mb_materialid,"
            . " sum(mbin_qty) as receivingMbInTotal,"
            . " sum(mbout_qty) as receivingMbOutTotal,"
            . " mbin_qty, mbin_val,"
            . " mbout_qty,"
            . " mbout_val,"
            . " mbprice FROM inv_materialbalance WHERE mb_materialid = '$mb_materialid'"
            . " AND warehouse_id='$warehouse_id'"
            /* . " AND `approval_status`='1'" */
            . " AND mbtype='Receive'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $rowData = $result->fetch_object();
    }
    return $rowData;
}
/*
 * Method for get return total data
 * $param
 * 1. mb_materialid
 * 2. warehouse_id
 */
function get_material_balance_return_quantity($param){
    global $conn;
    $rowData    =   '';
    $mb_materialid  =   $param['mb_materialid'];
    $warehouse_id   =   $param['warehouse_id'];
    $sql            =   "SELECT mb_materialid,"
            . " sum(mbin_qty) as returnMbInTotal,"
            . " sum(mbout_qty) as returnMbOutTotal,"
            . " mbin_qty, mbin_val,"
            . " mbout_qty,"
            . " mbout_val,"
            . " mbprice FROM inv_materialbalance WHERE mb_materialid = '$mb_materialid'"
            . " AND warehouse_id='$warehouse_id'"
            /* . " AND `approval_status`='1'" */
            . " AND mbtype='Return'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $rowData = $result->fetch_object();
    }
    return $rowData;
}

/*
 * Method for get Issue total data
 * $param
 * 1. mb_materialid
 * 2. warehouse_id
 */
function get_material_balance_issue_quantity($param){
    global $conn;
    $rowData    =   '';
    $mb_materialid  =   $param['mb_materialid'];
    $warehouse_id   =   $param['warehouse_id'];
    $sql            =   "SELECT mb_materialid,"
            . " sum(mbin_qty) as issueMbInTotal,"
            . " sum(mbout_qty) as issueMbOutTotal,"
            . " mbin_qty, mbin_val,"
            . " mbout_qty,"
            . " mbout_val,"
            . " mbprice FROM inv_materialbalance WHERE mb_materialid = '$mb_materialid'"
            . " AND warehouse_id='$warehouse_id'"
            /* . " AND `approval_status`='1'" */
            . " AND mbtype='Issue'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $rowData = $result->fetch_object();
    }
    return $rowData;
}

/*
 * Method for get Transfer Out total data
 * $param
 * 1. mb_materialid
 * 2. warehouse_id
 */
function get_material_balance_transfer_out_quantity($param){
    global $conn;
    $rowData    	=   '';
    $mb_materialid  =   $param['mb_materialid'];
    $warehouse_id   =   $param['warehouse_id'];
    $sql            =   "SELECT mb_materialid,"
            . " sum(mbin_qty) as transferOutMbInTotal,"
            . " sum(mbout_qty) as transferOutMbOutTotal,"
            . " mbin_qty, mbin_val,"
            . " mbout_qty,"
            . " mbout_val,"
            . " mbprice FROM inv_materialbalance WHERE mb_materialid = '$mb_materialid'"
            . " AND warehouse_id='$warehouse_id'"
            /* . " AND `approval_status`='1'" */
            . " AND mbtype='Transfer Out'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $rowData = $result->fetch_object();
    }
    return $rowData;
}

/*
 * Method for get Transfer In total data
 * $param
 * 1. mb_materialid
 * 2. warehouse_id
 */
function get_material_balance_transfer_in_quantity($param){
    global $conn;
    $rowData    =   '';
    $mb_materialid  =   $param['mb_materialid'];
    $warehouse_id   =   $param['warehouse_id'];
    $sql            =   "SELECT mb_materialid,"
            . " sum(mbin_qty) as transferInMbInTotal,"
            . " sum(mbout_qty) as transferInMbOutTotal,"
            . " mbin_qty, mbin_val,"
            . " mbout_qty,"
            . " mbout_val,"
            . " mbprice FROM inv_materialbalance WHERE mb_materialid = '$mb_materialid'"
            . " AND warehouse_id='$warehouse_id'"
            /* . " AND `approval_status`='1'" */
            . " AND mbtype='Transfer In'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $rowData = $result->fetch_object();
    }
    return $rowData;
}










function get_material_balance_adjustmentin_quantity($param){
    global $conn;
    $rowData    =   '';
    $mb_materialid  =   $param['mb_materialid'];
    $warehouse_id   =   $param['warehouse_id'];
    $sql            =   "SELECT mb_materialid,"
            . " sum(mbin_qty) as adjustmentInqty  FROM inv_materialbalance WHERE mb_materialid = '$mb_materialid'"
            . " AND warehouse_id='$warehouse_id'"
            /* . " AND `approval_status`='1'" */
            . " AND mbtype='ADJIN'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $rowData = $result->fetch_object();
    }
    return $rowData;
}




function get_material_balance_adjustmentout_quantity($param){
    global $conn;
    $rowData    =   '';
    $mb_materialid  =   $param['mb_materialid'];
    $warehouse_id   =   $param['warehouse_id'];
    $sql            =   "SELECT mb_materialid,"
            . " sum(mbout_qty) as adjustmentoutqty  FROM inv_materialbalance WHERE mb_materialid = '$mb_materialid'"
            . " AND warehouse_id='$warehouse_id'"
            /* . " AND `approval_status`='1'" */
            . " AND mbtype='ADJOUT'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $rowData = $result->fetch_object();
    }
    return $rowData;
}




    
    function getmaterialbrand(){
        global $conn;
        $sql = "SELECT brand_name FROM inv_material group by brand_name order by brand_name";
        $result = $conn->query($sql);
        $dataContainer   =   [];
        if ($result->num_rows > 0) {
            // output data of each row
            if (isset($dataType) && $dataType == 'obj') {
                while ($row = $result->fetch_object()) {
                    $dataContainer[] = $row;
                }
            } else {
                while ($row = $result->fetch_assoc()) {
                    $dataContainer[] = $row;
                }
            }
        }
        return $dataContainer;
    }
	
	
	
	
	function getTableDataByTableNameTtransfer($table, $order = 'asc', $column='id', $dataType = '') {
    global $conn;
	$warehouse_id	=	$_SESSION['logged']['warehouse_id'];
    $dataContainer  =   [];
    $sql = "SELECT * FROM $table WHERE from_warehouse=$warehouse_id  order by $column $order";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        if (isset($dataType) && $dataType == 'obj') {
            while ($row = $result->fetch_object()) {
                $dataContainer[] = $row;
            }
        } else {
            while ($row = $result->fetch_assoc()) {
                $dataContainer[] = $row;
            }
        }
    }
    return $dataContainer;
}
	
	
	
	
	
	
	
	
	
	
	