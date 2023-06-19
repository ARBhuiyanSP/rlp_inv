<?php


/* if(isset($_GET['process_type']) && $_GET['process_type'] == 'interview_process'){ */
	if (isset($_POST['interview_create']) && !empty($_POST['interview_create'])){

    /* print '<pre>';
    print_r($_POST);
    print '</pre>'; */
	
	    $code          = (isset($_POST['code']) && !empty($_POST['code']) ? mysqli_real_escape_string($conn,$_POST['code']) : '');
    /*
        *  Update Data Into inv_receive Table:
    */
    $table          = 'interviews';
    if(isset($_POST['edit_id']) && !empty($_POST['edit_id'])){
        $id             = $_POST['edit_id'];
        $where          = "code='$code' AND id!=$id";
    }else{
        $where          = 'code=' . "'$code'";
    }    
    if (!isDuplicateData($table, $where)) {
        if(isset($_POST['edit_id']) && !empty($_POST['edit_id'])){
            $res    =   update_interview();
            $_SESSION['success']    =   "Data have been successfully Updated.";
        }else{
            $res    =   create_interview();
			execute_interview_rrr_count($code);
			execute_interview_candidate_count($code);
			execute_interview_bom_count($code);
            $_SESSION['success']    =   "Data have been successfully Saved.";
        }
    }else{
        $_SESSION['error']                  =   "Duplicate data found!.";
    }
    header("location: interview_list.php");
    exit();

}
function create_interview(){
    global $conn;
    $code		= (isset($_POST['code']) && !empty($_POST['code']) ? mysqli_real_escape_string($conn,$_POST['code']) : 'NULL');
    $date		= (isset($_POST['date']) && !empty($_POST['date']) ? mysqli_real_escape_string($conn,$_POST['date']) : '');
    $time		= (isset($_POST['time']) && !empty($_POST['time']) ? mysqli_real_escape_string($conn,$_POST['time']) : '');
    $location	= (isset($_POST['location']) && !empty($_POST['location']) ? mysqli_real_escape_string($conn,$_POST['location']) : '');
	
    $dataParam      =   [
        'code'		=>  $code,
        'date'		=>  $date,
        'time'		=>  $time,
        'location'	=>  $location,
    ];
    $res    =   saveData('interviews', $dataParam);  
    return $res;
}
function execute_interview_rrr_count($code){
    global $conn;
    /*
     * *****************************rrr_details table operation********************
     */
    for($count 		= 0; $count<count($_POST['requisition']); $count++){        
        $requisition	= (isset($_POST['requisition'][$count]) && !empty($_POST['requisition'][$count]) ? trim(mysqli_real_escape_string($conn,$_POST['requisition'][$count])) : '');
		
        $dataParam     =   [
            'id'			=>  get_table_next_primary_id('interview_requisition'),
            'interview_id'	=>  $code,
            'rrr_id'     	=>  $requisition,
        ];
    
        saveData("interview_requisition", $dataParam);
    }
}
function execute_interview_candidate_count($code){
    global $conn;
    /*
     * *****************************rrr_details table operation********************
     */
    for($count 		= 0; $count<count($_POST['assign_candidates']); $count++){        
        $assign_candidates	= (isset($_POST['assign_candidates'][$count]) && !empty($_POST['assign_candidates'][$count]) ? trim(mysqli_real_escape_string($conn,$_POST['assign_candidates'][$count])) : '');
		$requisition	= (isset($_POST['requisition'][$count]) && !empty($_POST['requisition'][$count]) ? trim(mysqli_real_escape_string($conn,$_POST['requisition'][$count])) : '');
		
		
        $dataParam     =   [
            'id'                =>  get_table_next_primary_id('interview_candiate'),
            'interview_id'      =>  $code,
            'rrr_id'      		=>  $requisition,
            'candidate_id'      =>  $assign_candidates,
        ];
    
        saveData("interview_candiate", $dataParam);
    }
}
function execute_interview_bom_count($code){
    global $conn;
    /*
     * *****************************rrr_details table operation********************
     */
    for($count 		= 0; $count<count($_POST['bom']); $count++){        
        $bom	= (isset($_POST['bom'][$count]) && !empty($_POST['bom'][$count]) ? trim(mysqli_real_escape_string($conn,$_POST['bom'][$count])) : '');
		
        $dataParam     =   [
            'id'                =>  get_table_next_primary_id('interview_bom'),
            'interview_id'       =>  $code,
            'emp_id'          =>  $bom,
        ];
    
        saveData("interview_bom", $dataParam);
    }
}
if(isset($_GET['process_type']) && $_GET['process_type'] == 'assign_candidate'){
    $user_id    =   $_POST['candidate_id'];
    $user_name  =   $_POST['candidate_name'];
    ?>
    <tr id="candidate_tr_<?php echo $user_id; ?>">
        <td>
            <?php echo $user_name; ?>
            <input type="hidden" class="form-control" name="assign_candidates[]" value="<?php echo $user_id; ?>">
        </td>
        <td><a href="javascript:void(0);" onclick="deleteUserAssignTr('<?php echo $user_id; ?>');" class="btn btn-danger"><i class="fa fa-times-circle"></i></a></td>
    </tr>
<?php } 

if(isset($_GET['process_type']) && $_GET['process_type'] == 'get_interviewer'){

    include '../connection/connect.php';
    include '../helper/utilities.php';

    $candidates     =   "";

    if(isset($_POST['requisition']) && !empty($_POST['requisition'])){
        $candidates =   get_interviewer_data($_POST['requisition']);
    }

    make_candidates_list_view($candidates);


}

function get_interviewer_data($requisition){

    $rrr_no     =   implode(",", $requisition);

    $table_sql  =  "SELECT id, candidate_id, name, email FROM candidates WHERE rrr_no IN ($rrr_no)";
    
    $candidates     =   getDataRowIdAndTableBySQL($table_sql);
    return $candidates;
}



function make_candidates_list_view($candidates){

    if(isset($candidates) && !empty($candidates)){ ?>

        <div class="checkbox">
            <label><input type="checkbox" value="">Check All</label>
        </div>

        <?php foreach($candidates as $cdata){ ?>            
            <div class="checkbox">
                <label>
                    <input onclick="assignThisCandidate('<?php echo $cdata->id; ?>');" type="checkbox" class="candidate_checkbox_style" value="<?php echo $cdata->id ?>">
                    <span id="candidate_name_<?php echo $cdata->id ?>">
                        <?php echo $cdata->name."(".$cdata->email.")" ?>
                    </span>
                </label>
            </div>

        <?php }


    }else{ ?>

        <div class="alert alert-warning">
            <strong>Warning!</strong> No data found.
        </div>

    <?php }

}


if(isset($_GET['process_type']) && $_GET['process_type'] == 'get_ajax_candidates_form'){

    session_start();
    include '../connection/connect.php';
    include "../Class/Database/Database.php";
    include '../function/global_connection.php';    
    include "../helper/utilities.php";
    include "../Class/Employee.php";
    include '../function/candidates_management.php';
    include '../function/rrr_processing.php';
    include '../function/rlp_process.php';
    include '../function/user_management.php';

    get_candidates_form();

}
?>