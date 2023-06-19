<?php

//Create User:
if (isset($_POST['user_create']) && !empty($_POST['user_create'])){    
    $office_id          = (isset($_POST['office_id']) && !empty($_POST['office_id']) ? mysqli_real_escape_string($conn,$_POST['office_id']) : '');
    /*
        *  Update Data Into inv_receive Table:
    */
    $table          = 'users';
    if(isset($_POST['edit_id']) && !empty($_POST['edit_id'])){
        $id             = $_POST['edit_id'];
        $where          = "office_id='$office_id' AND id!=$id";
    }else{
        $where          = 'office_id=' . "'$office_id'";
    }    
    if (!isDuplicateData($table, $where)) {
        if(isset($_POST['edit_id']) && !empty($_POST['edit_id'])){
            $res    =   update_user();
            $_SESSION['success']    =   "Data have been successfully Updated.";
        }else{
            $res    =   create_user();
            $_SESSION['success']    =   "Data have been successfully Saved.";
        }
    }else{
        $_SESSION['error']                  =   "Duplicate data found!.";
    }
    header("location: users_list.php");
    exit();
}
function create_user(){
    global $conn;
    $role_id        = (isset($_POST['group_id']) && !empty($_POST['group_id']) ? mysqli_real_escape_string($conn,$_POST['group_id']) : '');
    $branch_id      = (isset($_POST['branch_id']) && !empty($_POST['branch_id']) ? mysqli_real_escape_string($conn,$_POST['branch_id']) : 'NULL');
    $department_id  = (isset($_POST['department_id']) && !empty($_POST['department_id']) ? mysqli_real_escape_string($conn,$_POST['department_id']) : 'NULL');
    $office_id      = (isset($_POST['office_id']) && !empty($_POST['office_id']) ? mysqli_real_escape_string($conn,$_POST['office_id']) : 'NULL');
    $email          = (isset($_POST['email']) && !empty($_POST['email']) ? mysqli_real_escape_string($conn,$_POST['email']) : '');
    $name           = (isset($_POST['name']) && !empty($_POST['name']) ? mysqli_real_escape_string($conn,$_POST['name']) : '');
    $designation    = (isset($_POST['designation']) && !empty($_POST['designation']) ? mysqli_real_escape_string($conn,$_POST['designation']) : '');
    $password       = (isset($_POST['password']) && !empty($_POST['password']) ? md5($_POST['password']) : md5('123456'));
    $dataParam      =   [
        'branch_id'     =>  $branch_id,
        'department_id' =>  $department_id,
        'office_id'     =>  $office_id,
        'role_id'       =>  $role_id,
        'role_name'     =>  getRoleShortNameByRoleId($role_id),
        'designation'   =>  $designation,
        'name'          =>  $name,
        'email'         =>  $email,
        'password'      =>  $password,
        'created_at'    =>  date('Y-m-d h:i:s'),
    ];
    $res    =   saveData('users', $dataParam);  
    return $res;
}
function update_user(){
    global $conn;
    $role_id        = (isset($_POST['group_id']) && !empty($_POST['group_id']) ? mysqli_real_escape_string($conn,$_POST['group_id']) : '');
    $branch_id      = (isset($_POST['branch_id']) && !empty($_POST['branch_id']) ? mysqli_real_escape_string($conn,$_POST['branch_id']) : 'NULL');
    $department_id  = (isset($_POST['department_id']) && !empty($_POST['department_id']) ? mysqli_real_escape_string($conn,$_POST['department_id']) : 'NULL');
    $office_id      = (isset($_POST['office_id']) && !empty($_POST['office_id']) ? mysqli_real_escape_string($conn,$_POST['office_id']) : 'NULL');
    $email          = (isset($_POST['email']) && !empty($_POST['email']) ? mysqli_real_escape_string($conn,$_POST['email']) : '');
    $name           = (isset($_POST['name']) && !empty($_POST['name']) ? mysqli_real_escape_string($conn,$_POST['name']) : '');
    $designation    = (isset($_POST['designation']) && !empty($_POST['designation']) ? mysqli_real_escape_string($conn,$_POST['designation']) : '');
	
	
	if (is_uploaded_file($_FILES['sn_prt_image']['tmp_name'])) 
	{
		$temp_file=$_FILES['sn_prt_image']['tmp_name'];
		$signature_image=time().$_FILES['sn_prt_image']['name'];
		$q = move_uploaded_file($temp_file,"images/signatures/".$signature_image);
	}
	else
	{
	 $signature_image = $_POST["sn_old_image"];
	}
	
	
	
	
    $param['fields'] = [
        'branch_id'     	=>  $branch_id,
        'department_id' 	=>  $department_id,
        'office_id'     	=>  $office_id,
        'role_id'       	=>  $role_id,
        'role_name'     	=>  getRoleShortNameByRoleId($role_id),
        'designation'   	=>  $designation,
        'name'          	=>  $name,
        'email'         	=>  $email,
        'signature_image'	=>  $signature_image,
        'updated_at'    	=>  date('Y-m-d h:i:s'),
        'updated_by'    	=>  $_SESSION['logged']['user_id'],
    ];
    if(isset($_POST['password']) && !empty($_POST['password'])){
        $param['fields']['password']    = md5($_POST['password']);
    }
    $param['where'] =[
        'id'    =>  $_POST['edit_id']
    ];
    $res     =   updateData('users',$param['fields'], $param['where']);
    return $res;
}
if(isset($_GET['process_type']) && $_GET['process_type'] == "user_delete"){
    include '../connection/connect.php';
    include '../helper/utilities.php';
    $id         =   $_GET['delete_id'];
    $table      =   "users";
    $fieldName  =   "id";
    deleteRecordByTableAndId($table, $fieldName, $id);
    
    $feedback   =   [
        'status'    => "success",
        'message'   => "Data have been successfully deleted",
    ];
    
    echo json_encode($feedback);
}

function getUserDataByid($id){    
    $data   = getDataRowByTableAndId("users", $id);
    return $data;
}
if(isset($_GET['process_type']) && $_GET['process_type'] == "getDataTableUserList"){
    session_start();
    include '../connection/connect.php';
    include '../helper/utilities.php';
    include '../partial/get_data_table_user_list.php';
}

function get_user_list_action_data($adata){
    $ac     =   "";
    $user_id_session    =   $_SESSION['logged']['user_id'];
    $editUrl            =   "user_update.php?user_id=".$adata->id;
    $delUrl             =   "function/user_management.php?process_type=user_delete";
    if(hasAccessPermission($user_id_session, 'crlp', 'edit_access')){
        $ac.=   '<a title="Edit User" class="btn btn-sm btn-info" href="'.$editUrl.'">
            <span class="fa fa-pencil"></span>
        </a>';
    }
    
    if(hasAccessPermission($user_id_session, 'crlp', 'delete_access')){
        if($user_id_session!=$adata->id){
            $ac.=   '<a title="Delete User" class="btn btn-sm btn-danger" href="javascript:void(0)" onclick="commonDeleteOperation(\''.$delUrl.'\',\''.$adata->id.'\');">
                <span class="fa fa-close"></span>
            </a>';
        }
    }
        
    if(is_super_admin($user_id_session)){
        if($user_id_session!=$adata->id){
            $ac.=   '<a title="Login As" class="btn btn-sm btn-warning" href="javascript:void(0)" onclick="loginAsAnotherUser(\''.$adata->id.'\',\''.$user_id_session.'\');">
                <span class="fa fa-user-secret"></span>
            </a>';
        }    
    }
    return $ac;
}

if(isset($_GET['process_type']) && $_GET['process_type'] == "getDepartmentusers"){
    include '../connection/connect.php';
    include '../helper/utilities.php';
    $division_id    =   $_POST['division_id'];
    $department_id  =   $_POST['department_id'];
    $form_type      =   $_POST['form_type'];
    
    if($form_type  != 'access_form'){
        $table      =   "users WHERE branch_id=$division_id AND department_id=$department_id AND role_id NOT IN (2,4,5,6,7,8,12)";
    }else{
        $table      =   "users WHERE branch_id=$division_id AND department_id=$department_id";
    }
    $order      =   "ASC";
    $column     =   "name";
    $dataType   =   "obj";
    //echo $table; exit;
    $users  =   getTableDataByTableName($table,$order,$column,$dataType);
    $param      =   [
        'users'     => $users,
        'formType'  => $form_type,
    ];
    get_rlp_chain_assign_user_view($param);
}
// Get Project user 
if(isset($_GET['process_type']) && $_GET['process_type'] == "getProjectusers"){
    include '../connection/connect.php';
    include '../helper/utilities.php';
    $division_id    =   $_POST['division_id'];
    $department_id  =   $_POST['department_id'];
    $project_id  =   $_POST['project_id'];
    $form_type      =   $_POST['form_type'];
    
    if($form_type  != 'access_form'){
        $table      =   "users WHERE branch_id=$division_id AND department_id=$department_id AND project_id=$project_id AND role_id NOT IN (2,4,5,6,7,8,12)";
    }else{
        $table      =   "users WHERE branch_id=$division_id AND department_id=$department_id AND project_id=$project_id ";
    }
    $order      =   "ASC";
    $column     =   "name";
    $dataType   =   "obj";
    //echo $table; exit;
    $users  =   getTableDataByTableName($table,$order,$column,$dataType);
    $param      =   [
        'users'     => $users,
        'formType'  => $form_type,
    ];
    get_rlp_chain_assign_user_view($param);
}

if(isset($_GET['process_type']) && $_GET['process_type'] == "assignThisUserToChain"){
    include '../connection/connect.php';
    include '../helper/utilities.php';
    $user_id    =   $_POST['user_id'];
    $user_name  =   $_POST['user_name'];
    ?>
    <tr id="user_assign_tr_<?php echo $user_id; ?>">
        <td><?php echo $user_name; ?></td>
        <td>
            <div class="form-group">
                <input style="width: 50px;" type="text" class="form-control" name="assign_users_order[<?php echo $user_id; ?>]" value="1">
            </div>
        </td>
        <td><a href="javascript:void(0);" onclick="deleteUserAssignTr('<?php echo $user_id; ?>');" class="btn btn-danger"><i class="fa fa-times-circle"></i></a></td>
    </tr>
<?php }
if(isset($_GET['process_type']) && $_GET['process_type'] == "assignThisUserToDefaultChain"){
    include '../connection/connect.php';
    include '../helper/utilities.php';
    $user_id    =   $_POST['user_id'];
    $user_name  =   $_POST['user_name'];
    ?>
    <tr id="user_assign_tr_<?php echo $user_id; ?>">
        <td>
            <?php 
                echo 'Name:&nbsp;'.getUserNameByUserId($user_id).'<br>';
                echo 'Designation:&nbsp;'. getDesignationByUserId($user_id);
                ?>
        </td>
        <td>
            <div class="form-group">
                <input style="width: 50px;" type="text" class="form-control" name="assign_users_order[<?php echo $user_id; ?>]" value="1">
            </div>
        </td>
        <td><a href="javascript:void(0);" onclick="deleteUserAssignTr('<?php echo $user_id; ?>');" class="btn btn-danger"><i class="fa fa-times-circle"></i> &nbsp;Delete</a></td>
    </tr>
<?php }

//Create Division:
if (isset($_POST['division_create']) && !empty($_POST['division_create'])){    
    $name          = (isset($_POST['name']) && !empty($_POST['name']) ? mysqli_real_escape_string($conn,$_POST['name']) : '');
    /*
        *  Update Data Into inv_receive Table:
    */
    $table          = 'branch';
    if(isset($_POST['edit_id']) && !empty($_POST['edit_id'])){
        $id             = $_POST['edit_id'];
        $where          = "name='$name' AND id!=$id";
    }else{
        $where          = 'name=' . "'$enamemail'";
    }    
    if (!isDuplicateData($table, $where)) {
        if(isset($_POST['edit_id']) && !empty($_POST['edit_id'])){
            $res    =   update_division();
            $_SESSION['success']    =   "Data have been successfully Updated.";
        }else{
            $res    =   create_division();
            $_SESSION['success']    =   "Data have been successfully Saved.";
        }
    }else{
        $_SESSION['error']                  =   "Duplicate data found!.";
    }
    header("location: division_create.php");
    exit();
}
function create_division(){
    global $conn;
    $name           = (isset($_POST['name']) && !empty($_POST['name']) ? mysqli_real_escape_string($conn,$_POST['name']) : '');
    $dataParam      =   [
        'name'          =>  $name,
    ];
    $res    =   saveData('branch', $dataParam);  
    return $res;
}
function update_division(){
    global $conn;
    $name           = (isset($_POST['name']) && !empty($_POST['name']) ? mysqli_real_escape_string($conn,$_POST['name']) : '');
	
	
	
	
	
    $param['fields'] = [
        'name'          	=>  $name,
    ];
    $param['where'] =[
        'id'    =>  $_POST['edit_id']
    ];
    $res     =   updateData('branch',$param['fields'], $param['where']);
    return $res;
}
if(isset($_GET['process_type']) && $_GET['process_type'] == "division_delete"){
    include '../connection/connect.php';
    include '../helper/utilities.php';
    $id         =   $_GET['delete_id'];
    $table      =   "branch";
    $fieldName  =   "id";
    deleteRecordByTableAndId($table, $fieldName, $id);
    
    $feedback   =   [
        'status'    => "success",
        'message'   => "Data have been successfully deleted",
    ];
    
    echo json_encode($feedback);
	header("location: division_create.php");
    exit();
}
function getDivisionDataByid($id){    
    $data   = getDataRowByTableAndId("branch", $id);
    return $data;
}
//Create Department:
if (isset($_POST['department_create']) && !empty($_POST['department_create'])){    
    $name          = (isset($_POST['name']) && !empty($_POST['name']) ? mysqli_real_escape_string($conn,$_POST['name']) : '');
    /*
        *  Update Data Into inv_receive Table:
    */
    $table          = 'department';
    if(isset($_POST['edit_id']) && !empty($_POST['edit_id'])){
        $id             = $_POST['edit_id'];
        $where          = "name='$name' AND id!=$id";
    }else{
        $where          = 'name=' . "'$name'";
    }    
    if (!isDuplicateData($table, $where)) {
        if(isset($_POST['edit_id']) && !empty($_POST['edit_id'])){
            $res    =   update_department();
            $_SESSION['success']    =   "Data have been successfully Updated.";
        }else{
            $res    =   create_department();
            $_SESSION['success']    =   "Data have been successfully Saved.";
        }
    }else{
        $_SESSION['error']                  =   "Duplicate data found!.";
    }
    header("location: department_create.php");
    exit();
}
function create_department(){
    global $conn;
    $branch_id      = (isset($_POST['branch_id']) && !empty($_POST['branch_id']) ? mysqli_real_escape_string($conn,$_POST['branch_id']) : 'NULL');
    $name           = (isset($_POST['name']) && !empty($_POST['name']) ? mysqli_real_escape_string($conn,$_POST['name']) : '');
    $dataParam      =   [
        'branch_id'     =>  $branch_id,
        'name'          =>  $name,
    ];
    $res    =   saveData('department', $dataParam);  
    return $res;
}
function update_department(){
    global $conn;
    $branch_id      = (isset($_POST['branch_id']) && !empty($_POST['branch_id']) ? mysqli_real_escape_string($conn,$_POST['branch_id']) : 'NULL');
    $name           = (isset($_POST['name']) && !empty($_POST['name']) ? mysqli_real_escape_string($conn,$_POST['name']) : '');
	
	
	
    $param['fields'] = [
        'branch_id'     	=>  $branch_id,
        'name'          	=>  $name,
    ];
    $param['where'] =[
        'id'    =>  $_POST['edit_id']
    ];
    $res     =   updateData('department',$param['fields'], $param['where']);
    return $res;
}
if(isset($_GET['process_type']) && $_GET['process_type'] == "department_delete"){
    include '../connection/connect.php';
    include '../helper/utilities.php';
    $id         =   $_GET['delete_id'];
    $table      =   "department";
    $fieldName  =   "id";
    deleteRecordByTableAndId($table, $fieldName, $id);
    
    $feedback   =   [
        'status'    => "success",
        'message'   => "Data have been successfully deleted",
    ];
    
    echo json_encode($feedback);
}

function getDepartmentDataByid($id){    
    $data   = getDataRowByTableAndId("department", $id);
    return $data;
}

function get_role_shortcode_by_role_id($role_id){
    global $conn;
    $table  = "roles";
    $sql    = "SELECT short_name FROM $table WHERE id=$role_id";
    $result = $conn->query($sql);
    $name   =   '';
    if ($result->num_rows > 0) {
        $name   =   $result->fetch_object()->short_name;
    }
    return $name;
}
//member update:
if (isset($_POST['member_update']) && !empty($_POST['member_update'])){    
    $password       = (isset($_POST['password']) && !empty($_POST['password']) ? md5($_POST['password']) : md5('123456'));
    /*
        *  Update Data Into inv_receive Table:
    */
    $table          = 'users';
    
        if(isset($_POST['edit_id']) && !empty($_POST['edit_id'])){
            $res    =   update_member();
            $_SESSION['success']    =   "Data have been successfully Updated.";
        }else{
			$_SESSION['error']		=   "Update Failed.";
		}
    header("location: dashboard.php");
    exit();
}


function update_member(){
    global $conn;
    $password       = (isset($_POST['password']) && !empty($_POST['password']) ? md5($_POST['password']) : md5('123456'));	
    $param['fields'] = [
        'password'          	=>  $password,
        'is_password_changed'	=>  1,
    ];
    $param['where'] =[
        'id'    =>  $_POST['edit_id']
    ];
    $res     =   updateData('users',$param['fields'], $param['where']);
    $_SESSION['logged']['is_password_changed']  =   1;
    return $res;
}
//Create Supplier:
if (isset($_POST['supplier_create']) && !empty($_POST['supplier_create'])){    
    $email          = (isset($_POST['email']) && !empty($_POST['email']) ? mysqli_real_escape_string($conn,$_POST['email']) : '');
    /*
        *  Update Data Into inv_receive Table:
    */
    $table          = 'suppliers';
    if(isset($_POST['edit_id']) && !empty($_POST['edit_id'])){
        $id             = $_POST['edit_id'];
        $where          = "email='$email' AND id!=$id";
    }else{
        $where          = 'email=' . "'$email'";
    }    
    if (!isDuplicateData($table, $where)) {
        if(isset($_POST['edit_id']) && !empty($_POST['edit_id'])){
            $res    =   update_supplier();
            $_SESSION['success']    =   "Data have been successfully Updated.";
        }else{
            $res    =   create_supplier();
            $_SESSION['success']    =   "Data have been successfully Saved.";
        }
    }else{
        $_SESSION['error']                  =   "Duplicate data found!.";
    }
    header("location: supplier_create.php");
    exit();
}
function create_supplier(){
    global $conn;
    $supplier_id	= (isset($_POST['supplier_id']) && !empty($_POST['supplier_id']) ? mysqli_real_escape_string($conn,$_POST['supplier_id']) : 'NULL');
    $company		= (isset($_POST['company']) && !empty($_POST['company']) ? mysqli_real_escape_string($conn,$_POST['company']) : '');
    $address		= (isset($_POST['address']) && !empty($_POST['address']) ? mysqli_real_escape_string($conn,$_POST['address']) : '');
    $contact_person	= (isset($_POST['contact_person']) && !empty($_POST['contact_person']) ? mysqli_real_escape_string($conn,$_POST['contact_person']) : '');
    $phone			= (isset($_POST['phone']) && !empty($_POST['phone']) ? mysqli_real_escape_string($conn,$_POST['phone']) : '');
    $email			= (isset($_POST['email']) && !empty($_POST['email']) ? mysqli_real_escape_string($conn,$_POST['email']) : '');
    $dataParam      =   [
        'supplier_id'		=>  $supplier_id,
        'company'			=>  $company,
        'address'			=>  $address,
        'contact_person'	=>  $contact_person,
        'phone'				=>  $phone,
        'email'				=>  $email,
    ];
    $res    =   saveData('suppliers', $dataParam);  
    return $res;
}
function update_supplier(){
    global $conn;
    $supplier_id	= (isset($_POST['supplier_id']) && !empty($_POST['supplier_id']) ? mysqli_real_escape_string($conn,$_POST['supplier_id']) : 'NULL');
    $company		= (isset($_POST['company']) && !empty($_POST['company']) ? mysqli_real_escape_string($conn,$_POST['company']) : '');
    $address		= (isset($_POST['address']) && !empty($_POST['address']) ? mysqli_real_escape_string($conn,$_POST['address']) : '');
    $contact_person	= (isset($_POST['contact_person']) && !empty($_POST['contact_person']) ? mysqli_real_escape_string($conn,$_POST['contact_person']) : '');
    $phone			= (isset($_POST['phone']) && !empty($_POST['phone']) ? mysqli_real_escape_string($conn,$_POST['phone']) : '');
    $email			= (isset($_POST['email']) && !empty($_POST['email']) ? mysqli_real_escape_string($conn,$_POST['email']) : '');
	
	
	
    $param['fields'] = [
        'supplier_id'		=>  $supplier_id,
        'company'			=>  $company,
        'address'			=>  $address,
        'contact_person'	=>  $contact_person,
        'phone'				=>  $phone,
        'email'				=>  $email,
    ];
    $param['where'] =[
        'id'    =>  $_POST['edit_id']
    ];
    $res     =   updateData('suppliers',$param['fields'], $param['where']);
    return $res;
}
if(isset($_GET['process_type']) && $_GET['process_type'] == "supplier_delete"){
    include '../connection/connect.php';
    include '../helper/utilities.php';
    $id         =   $_GET['delete_id'];
    $table      =   "suppliers";
    $fieldName  =   "id";
    deleteRecordByTableAndId($table, $fieldName, $id);
    
    $feedback   =   [
        'status'    => "success",
        'message'   => "Data have been successfully deleted",
    ];
    
    echo json_encode($feedback);
}

function getSupplierDataByid($id){    
    $data   = getDataRowByTableAndId("suppliers", $id);
    return $data;
}
