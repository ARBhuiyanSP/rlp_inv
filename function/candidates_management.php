<?php

if(isset($_GET['process_type']) && $_GET['process_type'] == 'create_ajax_candidates'){

    session_start();
    include '../connection/connect.php';
    include "../Class/Database/Database.php";
    include '../function/global_connection.php';
    include "../helper/utilities.php";
    include "../Class/Employee.php";

    $cv_path    = "../uploads/cv/";    
    $res    =   create_candidate($cv_path);

    $candidate_data =   getCandidateDataByid($res['last_id']);

    ?>

<div class="checkbox">
    <label>
        <input onclick="assignThisCandidate('<?php echo $candidate_data->id; ?>');" type="checkbox" class="candidate_checkbox_style" value="<?php echo $candidate_data->id; ?>">
        <span id="candidate_name_<?php echo $candidate_data->id; ?>">
        <?php echo $candidate_data->name; ?>(<?php echo $candidate_data->email; ?>)                    
        </span>
    </label>
</div>


<?php }

//Create Supplier:
if (isset($_POST['candidate_create']) && !empty($_POST['candidate_create'])) {
    $phone          = (isset($_POST['phone']) && !empty($_POST['phone']) ? mysqli_real_escape_string($conn, $_POST['phone']) : '');
    /*
        *  Update Data Into inv_receive Table:
    */
    $table          = 'candidates';
    if (isset($_POST['edit_id']) && !empty($_POST['edit_id'])) {
        $id             = $_POST['edit_id'];
        $where          = "phone='$phone' AND id!=$id";
    } else {
        $where          = 'phone=' . "'$phone'";
    }
    if (!isDuplicateData($table, $where)) {
        if (isset($_POST['edit_id']) && !empty($_POST['edit_id'])) {
            $res    =   update_candidate();
            $_SESSION['success']    =   "Data have been successfully Updated.";
        } else {
            $res    =   create_candidate();
            $_SESSION['success']    =   "Data have been successfully Saved.";
        }
    } else {
        $_SESSION['error']                  =   "Duplicate data found!.";
    }
    header("location: candidates_create.php");
    exit();
}
function create_candidate($cv_path = "uploads/cv/")
{
    global $conn;
    $candidate_id    = (isset($_POST['candidate_id']) && !empty($_POST['candidate_id']) ? mysqli_real_escape_string($conn, $_POST['candidate_id']) : 'NULL');
    $name            = (isset($_POST['name']) && !empty($_POST['name']) ? mysqli_real_escape_string($conn, $_POST['name']) : '');
    $phone           = (isset($_POST['phone']) && !empty($_POST['phone']) ? mysqli_real_escape_string($conn, $_POST['phone']) : '');
    $email           = (isset($_POST['email']) && !empty($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : '');
    $dob           = (isset($_POST['dob']) && !empty($_POST['dob']) ? mysqli_real_escape_string($conn, $_POST['dob']) : '');
    $referred_by           = (isset($_POST['referred_by']) && !empty($_POST['referred_by']) ? mysqli_real_escape_string($conn, $_POST['referred_by']) : '');
    $last_degree_title           = (isset($_POST['last_degree_title']) && !empty($_POST['last_degree_title']) ? mysqli_real_escape_string($conn, $_POST['last_degree_title']) : '');
    $last_degree_sub           = (isset($_POST['last_degree_sub']) && !empty($_POST['last_degree_sub']) ? mysqli_real_escape_string($conn, $_POST['last_degree_sub']) : '');
    $last_degree_ins           = (isset($_POST['last_degree_ins']) && !empty($_POST['last_degree_ins']) ? mysqli_real_escape_string($conn, $_POST['last_degree_ins']) : '');
    $pasing_year           = (isset($_POST['pasing_year']) && !empty($_POST['pasing_year']) ? mysqli_real_escape_string($conn, $_POST['pasing_year']) : '');
    $total_exp           = (isset($_POST['total_exp']) && !empty($_POST['total_exp']) ? mysqli_real_escape_string($conn, $_POST['total_exp']) : '');
    $exp_with_ddc           = (isset($_POST['exp_with_ddc']) && !empty($_POST['exp_with_ddc']) ? mysqli_real_escape_string($conn, $_POST['exp_with_ddc']) : '');
    $rrr_no           = (isset($_POST['rrr_no']) && !empty($_POST['rrr_no']) ? mysqli_real_escape_string($conn, $_POST['rrr_no']) : '');
    $designation           = (isset($_POST['designation']) && !empty($_POST['designation']) ? mysqli_real_escape_string($conn, $_POST['designation']) : '');
    $expected_salary           = (isset($_POST['expected_salary']) && !empty($_POST['expected_salary']) ? mysqli_real_escape_string($conn, $_POST['expected_salary']) : '');
    $remarks           = (isset($_POST['remarks']) && !empty($_POST['remarks']) ? mysqli_real_escape_string($conn, $_POST['remarks']) : '');

    $cv     =   candidate_cv_upload($cv_path);

    $dataParam      =   [
        'candidate_id'    	=>  $candidate_id,
        'name'            	=>  $name,
        'email'           	=>  $email,
        'phone'           	=>  $phone,
        'dob'				=>  $dob,
        'referred_by'		=>  $referred_by,
        'last_degree_title'	=>  $last_degree_title,
        'last_degree_sub'	=>  $last_degree_sub,
        'last_degree_ins'	=>  $last_degree_ins,
        'pasing_year'		=>  $pasing_year,
        'total_exp'			=>  $total_exp,
        'exp_with_ddc'		=>  $exp_with_ddc,
        'rrr_no'			=>  $rrr_no,
        'designation'		=>  $designation,
        'expected_salary'		=>  $expected_salary,
        'remarks'			=>  $remarks,
        'cv'            	=>  $cv,
    ];
    $res    =   saveData('candidates', $dataParam);
    return $res;
}

function candidate_cv_upload($cv_path){

    if (is_uploaded_file($_FILES['sn_prt_cv']['tmp_name'])) {
        $temp_file = $_FILES['sn_prt_cv']['tmp_name'];
        $cv = time() . $_FILES['sn_prt_cv']['name'];
        move_uploaded_file($temp_file, $cv_path . $cv);
        // move_uploaded_file($temp_file, "uploads/cv/" . $cv);
    } else {
        $cv = $_POST["sn_prt_cv"];
    }

    return $cv;
}

function update_candidate()
{
    global $conn;
    $candidate_id    = (isset($_POST['candidate_id']) && !empty($_POST['candidate_id']) ? mysqli_real_escape_string($conn, $_POST['candidate_id']) : 'NULL');
    $name        = (isset($_POST['name']) && !empty($_POST['name']) ? mysqli_real_escape_string($conn, $_POST['name']) : '');
    $address        = (isset($_POST['address']) && !empty($_POST['address']) ? mysqli_real_escape_string($conn, $_POST['address']) : '');
    $contact_person    = (isset($_POST['contact_person']) && !empty($_POST['contact_person']) ? mysqli_real_escape_string($conn, $_POST['contact_person']) : '');
    $phone            = (isset($_POST['phone']) && !empty($_POST['phone']) ? mysqli_real_escape_string($conn, $_POST['phone']) : '');
    $email            = (isset($_POST['email']) && !empty($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : '');



    $param['fields'] = [
        'candidate_id'        =>  $candidate_id,
        'name'            =>  $name,
        'address'            =>  $address,
        'contact_person'    =>  $contact_person,
        'phone'                =>  $phone,
        'email'                =>  $email,
    ];
    $param['where'] = [
        'id'    =>  $_POST['edit_id']
    ];
    $res     =   updateData('suppliers', $param['fields'], $param['where']);
    return $res;
}
if (isset($_GET['process_type']) && $_GET['process_type'] == "candidate_delete") {
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

function getCandidateDataByid($id)
{
    $data   = getDataRowByTableAndId("candidates", $id);
    return $data;
}


function get_candidates_form()
{ 
    
    $emp_ob     =   new  Employee;
    $all_employees  =   $emp_ob->get_all_employees();
    
    ?>

    

        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <label for="exampleId">ID</label>
                    <?php $candidate_id    =   get_candidate_id(); ?>
                    <div class="rlpno_style"><?php echo $candidate_id; ?></div>
                    <input type="hidden" name="candidate_id" value="<?php echo $candidate_id; ?>">
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleInputEmail1">Candidate Name</label>
                    <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" required>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleInputEmail1">Candidate Email</label>
                    <input type="text" class="form-control" id="email" placeholder="Enter phone" name="email" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="exampleInputEmail1">Candidate Phone</label>
                    <input type="text" class="form-control" id="phone" placeholder="Enter phone" name="phone" required>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="exampleInputEmail1">Date of Birth</label>
                    <input name="dob" type="text" class="form-control" id="rlpdate" value="<?php echo date("Y-m-d"); ?>" size="30" autocomplete="off" required />
                </div>
            </div>
        </div>
        <div class="row" style="background-color:#222D32;margin:1px;padding:5px;border-radius:5px;color:#fff;">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="exampleId">Forwarded/Referred By:</label>
                    <select class="all_emplyees form-control" name="referred_by" id="req_by" onchange="get_requested_by_information();" required>
                        <option value="">Please select</option>
                        <?php
                        if (isset($all_employees) && !empty($all_employees)) {
                            foreach ($all_employees as $emp) { ?>
                                <option value="<?php echo $emp->emp_id ?>"><?php echo $emp->emp_name . ' (' . $emp->emp_id . ')'; ?></option>
                        <?php }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="division/company">Division/Company</label>
                    <input class="form-control" type="text" id="req_by_division" name="req_by_division">
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="division/company">Department</label>
                    <input class="form-control" type="text" id="department_id" name="req_by_department">
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="division/company">Designation</label>
                    <input class="form-control" type="text" id="designation" name="req_by_designation">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2">
                <div class="form-group">
                    <label for="division/company">Last Exam/Degree Title</label>
                    <input class="form-control" type="text" id="designation" name="last_degree_title">
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label for="division/company">Last Degree Subject</label>
                    <input class="form-control" type="text" id="designation" name="last_degree_sub">
                </div>
            </div>
            <div class="col-sm-4">
                <div class="form-group">
                    <label for="division/company">Last Degree Institution</label>
                    <input class="form-control" type="text" id="designation" name="last_degree_ins">
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label for="division/company">Passing Year</label>
                    <input class="form-control" type="text" id="designation" name="pasing_year">
                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label for="division/company">Total Experience</label>
                    <input class="form-control" type="text" id="designation" name="total_exp">
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="division/company">Experience With DDC</label>
                    <input class="form-control" type="text" id="designation" name="exp_with_ddc">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="exampleId">Upload CV</label>
                    <input class="form-control" type="file" id="" name="sn_prt_cv" required>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                    <label for="division/company">RRR No</label>

                    <select class="form-control select2" id="rrr_no" name="rrr_no" required>
                        <option value="">Please select</option>
                        <?php
                        $rrrListData = getApprovedRRRListData();
                        if (isset($rrrListData) && !empty($rrrListData)) {
                            foreach ($rrrListData as $adata) {
                        ?>
                                <option value="<?php echo $adata->id; ?>"><?php echo $adata->rrr_no; ?> || Post Name - <?php echo getDesignationNameById($adata->req_designation) ?></option>
                        <?php }
                        } ?>
                    </select>

                </div>
            </div>
            <div class="col-sm-2">
                <div class="form-group">
                    <label for="division/company">Designation</label>
					<select class="form-control" id="designation" name="designation">
						<option value="">Please select</option>
						<?php
						$table = "designations";
						$order = "ASC";
						$column = "name";
						$datas = getTableDataByTableName($table, $order, $column);
						foreach ($datas as $data) {
							?>
							<option value="<?php echo $data->id; ?>"><?php echo $data->name; ?></option>
	<?php } ?>
                </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label for="exampleId">Expected Salary</label>
                    <input class="form-control" type="text" id="" name="expected_salary">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="exampleId">Remarks</label>
                    <textarea class="form-control" id="" name="remarks"></textarea>
                </div>
            </div>
        </div>
        <!-- /.box-body -->

<?php }?>
