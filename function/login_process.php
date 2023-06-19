<?php

if(isset($_GET['process_type']) && $_GET['process_type'] == "loginAsAnotherUser"){
    session_start();
    include '../connection/connect.php';
    include '../helper/utilities.php';
    $user_id    =   trim($_POST['user_id']);    
    $su_id      =   trim($_POST['su_id']);    
    $is_login_as=   $_POST['is_login_as'];    
    $passsql    = "SELECT * FROM users where id=$user_id";
    $presult = $conn->query($passsql);
    if ($presult->num_rows > 0) {
        $row        =   $presult->fetch_object();
        $name       =   $row->name;
        $user_id    =   $row->id;
        unset($_SESSION['error']);
        $_SESSION['success']                =   $name." have successfully loggedin!";
        $_SESSION['logged']['email']        =   $row->email;
        $_SESSION['logged']['user_name']    =   $name;
        $_SESSION['logged']['user_id']      =   $user_id;
        $_SESSION['logged']['branch_id']    =   (isset($row->branch_id) && !empty($row->branch_id) ? $row->branch_id : "");
        $_SESSION['logged']['department_id']=   (isset($row->department_id) && !empty($row->department_id) ? $row->department_id : "");
        $_SESSION['logged']['project_id']=   (isset($row->project_id) && !empty($row->project_id) ? $row->project_id : "");
        $_SESSION['logged']['office_id']    =   (isset($row->office_id) && !empty($row->office_id) ? $row->office_id : "");
        $_SESSION['logged']['role_id']      =   (isset($row->role_id) && !empty($row->role_id) ? $row->role_id : "");
        $_SESSION['logged']['designation']  =   (isset($row->designation) && !empty($row->designation) ? $row->designation : "");
        $_SESSION['logged']['role_name']    =   (isset($row->role_id) && !empty($row->role_id) ? getRoleShortNameByRoleId($row->role_id) : "");
        $_SESSION['logged']['contact_number']    =   (isset($row->contact_number) && !empty($row->contact_number) ? $row->contact_number : "");
        $_SESSION['logged']['is_password_changed']    =   (isset($row->is_password_changed) && !empty($row->is_password_changed) ? $row->is_password_changed : 0);
        $_SESSION['logged']['status']       =   true;
        $_SESSION['is_login_as']            =   $is_login_as;    
        $_SESSION['su_id']                  =   $su_id;    
        $feedback   =   [
            'status'    => "success",
            'message'   => "You have been successfully login AS ".$name,
            'location'  => "dashboard_top_menu.php"
        ];
    }else{
        $feedback   =   [
            'status'    => "error",
            'message'   => "No user found!",
        ];
    }
    echo json_encode($feedback);
}

if (isset($_POST['login_submit']) && !empty($_POST['login_submit'])) { 
    $error_status   =   false;
    $error_string   =   [];
    if(isset($_POST['email']) && !empty($_POST['email'])){
        $email      =   $_POST['email'];
//        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//            $error_status                   =   true;
//            $error_string['email_valid']    =   'Invalid format and please re-enter valid email';
//        }
    }else{
        $error_status                   =   true;
        $error_string['email_empty']    =   'User name is required.';
    }
    if(isset($_POST['password']) && !empty($_POST['password'])){
        $password      =  mysqli_real_escape_string($conn, $_POST['password']);
        $password      =  md5($password);
    }else{
        $error_status                   =   true;
        $error_string['password_empty'] =   'Password is required.';
    }
    
    if($error_status){
        foreach($error_string as $errorKey=>$errorVal){
            $_SESSION['error_message'][$errorKey]   =   $errorVal;            
        }
        $_SESSION['error']    =   "Login credential was not correct.";
        header("location: index.php");
        exit();
    }else{
        $emailsql    = "SELECT * FROM users where office_id='$email'";
        $result = $conn->query($emailsql);
        if ($result->num_rows > 0) {
            $passsql    = "SELECT * FROM users where office_id='$email' AND password='$password'";
            $presult = $conn->query($passsql);
            if ($presult->num_rows > 0) {
                $row        =   $presult->fetch_object();
                $name       =   $row->name;
                $user_id    =   $row->id;
                $type		=   $row->type;
                $role_id      =   $row->role_id;
                $project_id		=   $row->project_id;
                $warehouse_id	=   $row->warehouse_id;
				$_SESSION['logged']['permissin_urls'] =   [];
				
                unset($_SESSION['error']);
                $_SESSION['success']                =   $name." have successfully loggedin!";
                $_SESSION['logged']['email']        =   $email;
                $_SESSION['logged']['user_name']    =   $name;
                $_SESSION['logged']['user_id']      =   $user_id;
                $_SESSION['logged']['branch_id']    =   (isset($row->branch_id) && !empty($row->branch_id) ? $row->branch_id : "");
                $_SESSION['logged']['department_id']=   (isset($row->department_id) && !empty($row->department_id) ? $row->department_id : "");
                $_SESSION['logged']['project_id']=   (isset($row->project_id) && !empty($row->project_id) ? $row->project_id : "");
                $_SESSION['logged']['office_id']    =   (isset($row->office_id) && !empty($row->office_id) ? $row->office_id : "");
                $_SESSION['logged']['role_id']      =   (isset($row->role_id) && !empty($row->role_id) ? $row->role_id : "");
                $_SESSION['logged']['designation']  =   (isset($row->designation) && !empty($row->designation) ? $row->designation : "");
                $_SESSION['logged']['role_name']    =   (isset($row->role_id) && !empty($row->role_id) ? getRoleShortNameByRoleIdDuringLogin($row->role_id) : "");
                $_SESSION['logged']['contact_number']    =   (isset($row->contact_number) && !empty($row->contact_number) ? $row->contact_number : "");
                $_SESSION['logged']['is_password_changed']    =   (isset($row->is_password_changed) && !empty($row->is_password_changed) ? $row->is_password_changed : 0);
				
                $_SESSION['logged']['type']	=   $type;
                $_SESSION['logged']['role_id']    =   $role_id;
                $_SESSION['logged']['project_id']	=   $project_id;
                $_SESSION['logged']['warehouse_id']	=   $warehouse_id;
				 $_SESSION['logged']['ip']           =   $_SERVER['REMOTE_ADDR'];
                $ip                                 =   $_SERVER['REMOTE_ADDR'];

                    $role_query    = "SELECT t2.name AS permision_url FROM `permission_role` AS t1
                    INNER JOIN permissions AS t2 ON t1.permission_id=t2.id
                    WHERE t1.role_id='$role_id'";
            $rResult = $conn->query($role_query);
            if ($rResult->num_rows > 0) {
                while ($rData = $rResult->fetch_assoc()) {
                    $_SESSION['logged']['permissin_urls'][]=$rData['permision_url'];
                }
            }
            
                $_SESSION['logged']['status']       =   true;
                $_SESSION['is_login_as']            =   false;
                header("location: dashboard_top_menu.php");
                exit();
            }else{
                $error_status                       =   true;
                $_SESSION['error_message']['password_empty']     =   'Password did not matched.';
                $_SESSION['error']                               =   "Login credential was not correct.";
                header("location: index.php");
                exit();
            }
        }else{
            $error_status   =   true;
            $_SESSION['error_message']['email_valid']    =   'Invalid email';
            $_SESSION['error']                           =   "Login credential was not correct.";
            header("location: index.php");
            exit();
        }
    }
}
function getRoleShortNameByRoleIdDuringLogin($id){
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