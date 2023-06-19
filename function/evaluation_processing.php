<?php

//Evaluation:
if (isset($_POST['evaluation_submit']) && !empty($_POST['evaluation_submit'])){
    /* $date		= (isset($_POST['date']) && !empty($_POST['date']) ? trim(mysqli_real_escape_string($conn,$_POST['date'])) : date("Y-m-d")); */
    $int_id		= (isset($_POST['int_id']) && !empty($_POST['int_id']) ? trim(mysqli_real_escape_string($conn,$_POST['int_id'])) : "");
    $can_id		= (isset($_POST['can_id']) && !empty($_POST['can_id']) ? trim(mysqli_real_escape_string($conn,$_POST['can_id'])) : "");
    $education		= (isset($_POST['education']) && !empty($_POST['education']) ? trim(mysqli_real_escape_string($conn,$_POST['education'])) : "");
    $salary_expectation		= (isset($_POST['salary_expectation']) && !empty($_POST['salary_expectation']) ? trim(mysqli_real_escape_string($conn,$_POST['salary_expectation'])) : "");
    
    /*  ***************************** rrr_info table operation ******************** */ 
	
    $evaluation_info_response  =   execute_evaluation_table();
    if(isset($evaluation_info_response) && $evaluation_info_response['status'] == "success"){
        $evaluation_info_id    =   $evaluation_info_response['last_id'];
        /*
         *****************************rrr_details table operation********************
        */    
        //$rrr_details_response  =   execute_rrr_details_table($rrr_info_id);
        
        //$ackParam['acknowledge_user']   =   $_POST['assign_users_order'];
       // $ackParam['rrr_info_id']        =   $rrr_info_id;
        $ackParam['created_by']         =   $_SESSION['logged']['user_id'];
        //process_rrr_acknowledgement($ackParam);
        
        $_SESSION['success']    =   "Your data have been successfully procced.";
    }else{
        $_SESSION['error']    =   "Failed to save data";
    }
    header("location: evaluation.php?int_id=$int_id&evaluation_create=Next");
    exit();
}
function execute_evaluation_table(){
    global $conn;
    /* $date		= (isset($_POST['date']) && !empty($_POST['date']) ? trim(mysqli_real_escape_string($conn,$_POST['date'])) : date("Y-m-d")); */
    $int_id		= (isset($_POST['int_id']) && !empty($_POST['int_id']) ? trim(mysqli_real_escape_string($conn,$_POST['int_id'])) : "");
    $can_id		= (isset($_POST['can_id']) && !empty($_POST['can_id']) ? trim(mysqli_real_escape_string($conn,$_POST['can_id'])) : "");
    $education		= (isset($_POST['education']) && !empty($_POST['education']) ? trim(mysqli_real_escape_string($conn,$_POST['education'])) : "");
	
	$experience		= (isset($_POST['experience']) && !empty($_POST['experience']) ? trim(mysqli_real_escape_string($conn,$_POST['experience'])) : "");
	$presentation		= (isset($_POST['presentation']) && !empty($_POST['presentation']) ? trim(mysqli_real_escape_string($conn,$_POST['presentation'])) : "");
	$know_com_pos		= (isset($_POST['know_com_pos']) && !empty($_POST['know_com_pos']) ? trim(mysqli_real_escape_string($conn,$_POST['know_com_pos'])) : "");
	$communication		= (isset($_POST['communication']) && !empty($_POST['communication']) ? trim(mysqli_real_escape_string($conn,$_POST['communication'])) : "");
	$attitude		= (isset($_POST['attitude']) && !empty($_POST['attitude']) ? trim(mysqli_real_escape_string($conn,$_POST['attitude'])) : "");
	$teamwork		= (isset($_POST['teamwork']) && !empty($_POST['teamwork']) ? trim(mysqli_real_escape_string($conn,$_POST['teamwork'])) : "");
	$leadership		= (isset($_POST['leadership']) && !empty($_POST['leadership']) ? trim(mysqli_real_escape_string($conn,$_POST['leadership'])) : "");
	$technical_know		= (isset($_POST['technical_know']) && !empty($_POST['technical_know']) ? trim(mysqli_real_escape_string($conn,$_POST['technical_know'])) : "");
	$willingness		= (isset($_POST['willingness']) && !empty($_POST['willingness']) ? trim(mysqli_real_escape_string($conn,$_POST['willingness'])) : "");
	$remarks		= (isset($_POST['remarks']) && !empty($_POST['remarks']) ? trim(mysqli_real_escape_string($conn,$_POST['remarks'])) : "");
	$final_score		= (isset($_POST['final_score']) && !empty($_POST['final_score']) ? trim(mysqli_real_escape_string($conn,$_POST['final_score'])) : "");
	
    $salary_expectation		= (isset($_POST['salary_expectation']) && !empty($_POST['salary_expectation']) ? trim(mysqli_real_escape_string($conn,$_POST['salary_expectation'])) : "");
	
	$other_req		= (isset($_POST['other_req']) && !empty($_POST['other_req']) ? trim(mysqli_real_escape_string($conn,$_POST['other_req'])) : "");
	$notice_period		= (isset($_POST['notice_period']) && !empty($_POST['notice_period']) ? trim(mysqli_real_escape_string($conn,$_POST['notice_period'])) : "");
	$final_recommendation		= (isset($_POST['final_recommendation']) && !empty($_POST['final_recommendation']) ? trim(mysqli_real_escape_string($conn,$_POST['final_recommendation'])) : "");
	
	
    /*
     * *****************************evaluation_details table operation********************
     */
    $table_sql     =   "evaluation_details";
    $dataParam     =   [
        'id'                    =>  get_table_next_primary_id($table_sql),
        'int_id'                =>  $int_id,
        'can_id'           		=>  $can_id,
        'education'          	=>  $education,
		
        'experience'          	=>  $experience,
        'presentation'          =>  $presentation,
        'know_com_pos'          =>  $know_com_pos,
        'communication'         =>  $communication,
        'attitude'          	=>  $attitude,
        'teamwork'          	=>  $teamwork,
        'leadership'          	=>  $leadership,
        'technical_know'        =>  $technical_know,
        'willingness'          	=>  $willingness,
        'remarks'          		=>  $remarks,
        'final_score'          	=>  $final_score,
		
        'salary_expectation'	=>  $salary_expectation,
        'other_req'				=>  $other_req,
        'notice_period'			=>  $notice_period,
        'final_recommendation'	=>  $final_recommendation,
        /* 'status'            	=>  '1', */
        'created_at'            =>  date('Y-m-d h:i:s')
    ];
    
    $response   =   saveData("evaluation_details", $dataParam);
    return $response;
}
