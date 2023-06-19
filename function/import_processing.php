<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (isset($_POST['user_import']) && !empty($_POST['user_import'])) {
    $error          =   [];
    $count          =   1;
    $table          =   "users";
    $rowCount       =   $_POST['row_number'];
    $sql            = "SELECT * FROM temp_info LIMIT $rowCount";
    $result         =   $conn->query($sql);
    if ($result->num_rows > 0) { 
        while ($row = $result->fetch_object()) {
            $current_id     =   $row->id;
            $division_id    =   (isset($row->division) && !empty($row->division) ? getDivisionIdByName(trim($row->division)) : '');
            $configdatas = [
                'id'            => get_table_next_primary_id('users'),
                'office_id'     => $row->emp_id,
                'name'          => $row->emp_name,
                'designation'   => (isset($row->designation) && !empty($row->designation) ? getDesignationIdByName(trim($row->designation)) : ''),
                'department_id' => (isset($division_id) && !empty($division_id) ? getDepartmentIdByName($division_id,trim($row->department)) : ''),
                'role_id'       => (isset($row->grade) && !empty($row->grade) ? getRoleIdByRoleName(trim($row->grade)) : ''),
                'branch_id'     => $division_id,
                'password'      => md5($row->emp_id),
            ];
            $res = saveData('users', $configdatas);
            if($res['status']   ==  'success'){
                deleteRecordByTableAndId('temp_info', 'id', $current_id);
                $count++;
            }else{
                $error[]    =  $res; 
            }
        }
    }
    $_SESSION['success'] = "Data have been successfuly Imported. Total Imported ".'<b>'.$count.'</b>';
    header("location: live_user_import.php");
    exit();
}
if (isset($_POST['import_csv']) && !empty($_POST['import_csv'])) {
        $import_file_name   =  "csv_file";
        $fileHaveError = false;
        $importSuccess = 0;
        $importError = 0;
        $fileErrorMessage = [];
        $allowed = array('csv');
        $filename = $_FILES[$import_file_name]['name'];
        if ($_FILES[$import_file_name]['error'] > 0) {
            $fileHaveError = true;
            array_push($fileErrorMessage, 'Please select an import file first');
        }
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (!in_array($ext, $allowed)) {
            $fileHaveError = true;
            array_push($fileErrorMessage, 'Please import only CSV file');
        }
        if (!$fileHaveError) {
            $file = $_FILES[$import_file_name]['tmp_name'];
            $csvdata = csvToArray($file);
            if (isset($csvdata) && !empty($csvdata)) {
                foreach($csvdata as $dat){                    
                    $emp_id             =   $dat[1];                    
                    $configdatas        =   [
                        'id'        =>   get_table_next_primary_id('temp_info'),
                        'emp_id'    =>   $emp_id,
                        'emp_name'  =>   $dat[2],
                        'designation'=>  $dat[3],
                        'department'=>   $dat[4],
                        'grade'     =>   $dat[5],
                        'category'  =>   $dat[6],
                        'company'   =>   $dat[7],
                        'division'  =>   $dat[8],
                        'branch'    =>   $dat[9],
                        'section'   =>   $dat[10],
                        'location'  =>   $dat[11],
                        'join_date' =>   $dat[12],
                        'is_status' =>   $dat[13],
                        'sex'       =>   $dat[14]
                    ];
                    $whereDeleteTable   =   " WHERE emp_id='$emp_id'";
                    $table              =   "temp_info";
                    $fieldName          =   "emp_id";
                    $id                 =   $emp_id;
                    deleteRecordByTableAndId($table,$fieldName,$id);
                    $res    =   saveData('temp_info', $configdatas);
                }
                $_SESSION['success'] = "Data have been successfuly Imported.";
            }
        }else{
            $error_message  =   "";
            $sl             =   1;
            foreach($fileErrorMessage as $error){
                $error_message.=$sl.". ".$error."\n<br>";
                $_SESSION['error'] = $error_message;
                $sl++;
            }
        }
    header("location: import_system.php");
    exit();
}

if(isset($_GET['execution_type']) && $_GET['execution_type']==1){
    $dataContainer  =   [];
    $table          =   'branch';
    $sql            =   "SELECT DISTINCT division FROM temp_info WHERE division!='Blank'";
    $result         =   $conn->query($sql);
    if ($result->num_rows > 0) { 
        while ($row = $result->fetch_object()) {
            if (isset($row->division) && !empty($row->division)) {
                $configdatas = [
                    'id' => get_table_next_primary_id($table),
                    'name' => trim($row->division)
                ];
                $res = saveData($table, $configdatas);
            }
        }
        echo "Successfully Updated division";
    }
    
}
if(isset($_GET['execution_type']) && $_GET['execution_type']==2){
    $dataContainer          =   [];
    $sql            =   "SELECT id,name FROM branch";
    $result         =   $conn->query($sql);
    if ($result->num_rows > 0) {  
        while ($row = $result->fetch_object()) {
            $departmentContainer    =   [];
            $division_id    =   $row->id;
            $division_name  =   $row->name;
            $sql2            =   "SELECT DISTINCT department FROM temp_info WHERE division='$division_name'";
            $result2         =   $conn->query($sql2);
            if ($result2->num_rows > 0) {  
                while ($row2 = $result2->fetch_object()) { 
                    $departmentContainer[]  =   trim($row2->department);
                }
                $dataContainer[$division_id]    =   $departmentContainer;
            }
        }
    }
    $table              =   'middle_datas';
    $configdatas = [
        'id'            => get_table_next_primary_id($table),
        'name'          => 'department',
        'data_details'  => json_encode($dataContainer)
    ];
    $res = saveData($table, $configdatas);
    echo "Successfully Updated Dipartment";
}
if(isset($_GET['execution_type']) && $_GET['execution_type']==3){
    $dataContainer  =   [];
    $table          =   'department';
    $sql            =   "SELECT data_details FROM middle_datas WHERE name='department'";
    $result         =   $conn->query($sql);
    if ($result->num_rows > 0) { 
        $row = $result->fetch_object();
        $departmentData     = json_decode($row->data_details);
        foreach($departmentData as $divisionId=>$departments) {            
            if (isset($departments) && !empty($departments)) {
                foreach($departments as $depart){
                    $configdatas = [
                        'id'            => get_table_next_primary_id($table),
                        'branch_id'     => $divisionId,
                        'branch_name'   => getDivisionNameById($divisionId),
                        'name'          => trim($depart)
                    ];
                    $res = saveData($table, $configdatas);
                }
                
            }
        }
        echo "Successfully Updated division";
    }
    
}
if(isset($_GET['execution_type']) && $_GET['execution_type']==4){
    $dataContainer  =   [];
    $table          =   'designations';
    $sql            =   "SELECT DISTINCT designation FROM temp_info";
    $result         =   $conn->query($sql);
    if ($result->num_rows > 0) { 
        while ($row = $result->fetch_object()) {
            if (isset($row->designation) && !empty($row->designation)) {
                $configdatas = [
                    'id' => get_table_next_primary_id($table),
                    'name' => trim($row->designation)
                ];
                $res = saveData($table, $configdatas);
            }
        }
        echo "Successfully Updated designation";
    }
    
}
if(isset($_GET['execution_type']) && $_GET['execution_type']==10){
    $container      =   [
        [
            'name'      =>  'member',
            'details'   => json_encode(['g1','g2','g3','g4','g5','g6','g7','g8'])
        ],
        [
            'name'      =>  'acknowledgers',
            'details'   => json_encode(['g9','g10','g11','g12','g13','g14','g15','g16','g17'])
        ],
        [
            'name'      =>  'approval',
            'details'   => json_encode(['g18','g19','g20'])
        ]
    ];
    foreach($container as $data){
        $configdatas = [
            'id'        => get_table_next_primary_id('roles_group'),
            'name'      => trim($data['name']),
            'details'   => trim($data['details']),
        ];
        $res = saveData('roles_group', $configdatas);
        if($res['status'] !='success'){
            print '<pre>';
            print_r($res);
            print '</pre>';
            exit;
            
        }
    }
}
if(isset($_GET['execution_type']) && $_GET['execution_type']==5){
    $dataContainer  =   [];
    $table          =   'roles';
    $sql            =   "SELECT DISTINCT grade FROM temp_info WHERE grade!='Blank' OR grade!='&nbsp;'";
    $result         =   $conn->query($sql);
    if ($result->num_rows > 0) { 
        while ($row = $result->fetch_object()) {
            if (isset($row->grade) && !empty($row->grade)) {
                $configdatas = [
                    'id' => get_table_next_primary_id($table),
                    'name' => trim($row->grade)
                ];
                $res = saveData($table, $configdatas);
            }
        }
        echo "Successfully Updated grade";
    }
}
