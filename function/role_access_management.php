<?php

//Create User:
if (isset($_GET['process_type']) && $_GET['process_type'] == "getRoleAccessByGroupId"){
    include '../connection/connect.php';
    include '../helper/utilities.php';
    $role_id                =   $_POST['role_id'];
    if(isset($role_id) && !empty($role_id)){
        $sp_array               =   [];
        $sp_array_page_access   =   [];
        $sp_name_array          =   [];      
        $table  =   "page_details";
        $order  =   "ASC";
        $column =   "show_order";
        $screen_pages = getTableDataByTableName($table, $order, $column);
        foreach($screen_pages as $sp){
            $sp_array[] =   $sp->id;
            $sp_name_array[$sp->id] =   $sp->name;
        }
        global $conn;
        $sql    =   "SELECT role_access.*, page_details.name
                     FROM page_details
                     LEFT JOIN role_access
                     ON page_details.id = role_access.page_id
                     WHERE role_access.role_id = '$role_id'
                     ORDER BY page_details.show_order ASC";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $final_page_data    =   [];
            while ($asp = $result->fetch_object()) {
                $sp_array_page_access[] =   $asp->page_id;
                $final_page_data[]    =   [
                    'id' => $asp->id,
                    'role_id' => $asp->role_id,
                    'page_id' => $asp->page_id,
                    'add' => $asp->add_access,
                    'edit' => $asp->edit_access,
                    'delete' => $asp->delete_access,
                    'view' => $asp->view_access,
                    'print' => $asp->print_access,
                    'name' => $asp->name,
                ];
            }
            $missing_page   =   array_diff($sp_array,$sp_array_page_access);
                if(isset($missing_page) && !empty($missing_page)){
                    foreach($missing_page as $mp){
                        $final_page_data[]    =   [
                        'id' => '',
                        'role_id' => '',
                        'page_id' => $mp,
                        'add' => '',
                        'edit' => '',
                        'delete' => '',
                        'view' => '',
                        'print' => '',
                        'created_at' => '',
                        'updated_at' => '',
                        'name' => $sp_name_array[$mp],
                    ];
                    }
                }
                loadPageAccessPageBody($final_page_data);
        }else{
            loadDefaultPageAccessPageBody();
        }
    }else{
        loadDefaultPageAccessPageBody();
    }
//    $all_screen_page = DB::table('page_details')
//                ->leftJoin('role_access', 'page_details.id', '=', 'role_access.page_id')
//                ->select('role_access.*','page_details.name')
//                ->where('role_access.role_id', '=', $request->role_id)
//                ->orderBy('page_details.show_order', 'ASC')
//                ->get();   
}

if (isset($_POST['role_access_update']) && !empty($_POST['role_access_update'])){
    $role_id        = $_POST['group_id'];
    if(isset($role_id) && !empty($role_id)){
        $table          = 'role_access';
        $where          = 'role_id=' . "'$role_id'";
        if (isDuplicateData($table, $where)) {
            $fieldName      =   "role_id";
            $id             =   $role_id;
            $delete_check   = deleteRecordByTableAndId($table, $fieldName, $id);
        }

        /*====================================================
        * //get all screen page
        * ===================================================
        */
       $table              =   "page_details";
       $order              =   "ASC";
       $column             =   "show_order";
       $all_screen_page    = getTableDataByTableName($table, $order, $column);
       //end of getting page:

       /*
        * ======================================================
        * initialize some array variable
        */        

       $page_access['add']        =   ((isset($_POST['add']) && !empty($_POST['add']))         ? $_POST['add']     : []);
       $page_access['edit']       =   ((isset($_POST['edit']) && !empty($_POST['edit']))       ? $_POST['edit']    : []);
       $page_access['delete']     =   ((isset($_POST['delete']) && !empty($_POST['delete']))   ? $_POST['delete']  : []);
       $page_access['view']       =   ((isset($_POST['view']) && !empty($_POST['view']))       ? $_POST['view']    : []);
       $page_access['print']      =   ((isset($_POST['print']) && !empty($_POST['print']))     ? $_POST['print']   : []);
       foreach($all_screen_page as $screen){
           $add                =   0;
           $edit               =   0;
           $delete             =   0;
           $view               =   0;
           $print              =   0;
           $page_access_op     =   false;

           if(isset($page_access['add']) && !empty($page_access['add']) && in_array($screen->id, $page_access['add'])){
               $add                =   1;
               $page_access_op     =   true;
           }else{
               $add                =   0;
               $page_access_op     =   true;
           }

           if(isset($page_access['edit']) && !empty($page_access['edit']) && in_array($screen->id, $page_access['edit'])){
               $edit               =   1;
               $page_access_op     =   true;
           }else{
               $edit                =   0;
               $page_access_op     =   true;
           }

           if(isset($page_access['delete']) && !empty($page_access['delete']) && in_array($screen->id, $page_access['delete'])){
               $delete             =   1;
               $page_access_op     =   true;
           }else{
               $delete                =   0;
               $page_access_op     =   true;
           }

           if(isset($page_access['view']) && !empty($page_access['view']) && in_array($screen->id, $page_access['view'])){
               $view               =   1;
               $page_access_op     =   true;
           }else{
               $view                =   0;
               $page_access_op     =   true;
           }

           if(isset($page_access['print']) && !empty($page_access['print']) && in_array($screen->id, $page_access['print'])){
               $print              =   1;
               $page_access_op     =   true;
           }else{
               $print                =   0;
               $page_access_op     =   true;
           }

           if($page_access_op){
               $insert_data    =   [
                 'role_id'     => $role_id,
                 'page_id'     => $screen->id,
                 'page_name'   => get_page_short_name_by_id($screen->id),
                 'add_access'         => $add,
                 'edit_access'        => $edit,
                 'delete_access'      => $delete,
                 'view_access'        => $view,
                 'print_access'       => $print
               ]; //end of insert data


               $table          = 'role_access';
               $where          = "role_id=$role_id AND page_id=$screen->id";
               if (isDuplicateData($table, $where)) {
                   global $conn;
                   $sql            = "DELETE FROM $table WHERE role_id=$role_id AND page_id=$screen->id";
                   $conn->query($sql);
               }
               saveData($table, $insert_data);
           }else{

           }
       }//end of for each
       $_SESSION['success']    =   "Data have been successfully Updated.";
       header("location: role_access.php");
       exit();
    }else{
        $_SESSION['error']    =   "Group must need to select.";
       header("location: role_access.php");
       exit();
    }
}