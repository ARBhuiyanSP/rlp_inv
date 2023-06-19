$(function() {
    $('#rlp_chain_list').DataTable();
    get_user_list_data_table();
})

function get_user_list_data_table(division_id = '', department_id = '') {
    var url = baseUrl + "function/user_management.php?process_type=getDataTableUserList";
    var userListDataTable = $('#user_list_table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: url,
            type: 'POST',
            dataType: 'json',
            data: {
                division_id: division_id,
                department_id: department_id
            }
        },
        "aoColumnDefs": [
            { "bSortable": false, "aTargets": [-1, 2, 3] }
        ],
        "lengthMenu": [
            [10, 100, 250, 500, -1],
            [10, 100, 250, 500, "All"]
        ]
    });
}

function get_user_list_data_division_department(division_id = '', department_id = '') {
    var userListTable = $('#user_list_table').DataTable().destroy();

    $('#container').css('display', 'block');
    userListTable.columns.adjust().draw();
    $('#user_list_table').css('display', 'table');
    $('#user_list_table').attr('width', 500);

    get_user_list_data_table(division_id, department_id);
}


function loginAsAnotherUser(login_as_user_id, current_user_id, is_login_as = 1) {
    swal({
            title: 'Are you sure?',
            text: "You want to login as this User",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-warning",
            confirmButtonText: "Yes",
            cancelButtonText: 'Cancel',
            closeOnConfirm: false,
            showLoaderOnConfirm: true
        },
        function() {
            var url = baseUrl + "function/login_process.php?process_type=loginAsAnotherUser";
            $.ajax({
                url: url,
                type: "POST",
                dataType: "json",
                data: "user_id=" + login_as_user_id + "&su_id=" + current_user_id + "&is_login_as=" + is_login_as,
                success: function(response) {
                    if (response.status == 'success') {
                        swal("Logged in", response.message, "success");
                        setTimeout(function() {
                            var lggin_as_location = baseUrl + response.location;
                            window.open(lggin_as_location, '_self');
                        }, 3000);
                    }
                }
            });
        });
}

function commonDeleteOperation(del_url, delete_id) {
    swal({
            title: 'Confirmed?',
            text: "You will not be able to recover the data again!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Confirm",
            cancelButtonText: 'Cancel',
            closeOnConfirm: false,
            showLoaderOnConfirm: true
        },
        function() {
            setTimeout(function() {
                $.ajax({
                    url: baseUrl + del_url,
                    type: 'GET',
                    dataType: 'json',
                    data: 'delete_id=' + delete_id,
                    success: function(response) {
                        if (response.status == 'success') {
                            $("#row_id_" + delete_id).hide("slow");
                            swal("Deleted", response.message, "success");
                        } else {
                            swal("Failed!", response.message, "error");
                        }
                    },
                    async: false // <- this turns it into synchronous
                });
            }, 2000);
        });
}

function commonApproveOperation(approve_url, approve_id, user_id) {
    swal({
            title: 'Confirmed?',
            text: "Want To Approve This Requisition!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-success",
            confirmButtonText: "Confirm",
            cancelButtonText: 'Cancel',
            closeOnConfirm: false,
            showLoaderOnConfirm: true
        },
        function() {
            setTimeout(function() {
                $.ajax({
                    url: baseUrl + approve_url,
                    type: 'GET',
                    dataType: 'json',
                    data: 'approve_id=' + approve_id + "&user_id=" + user_id,
                    success: function(response) {
                        if (response.status == 'success') {
                            $("#row_id_" + approve_id).hide("slow");
                            swal("Approved", response.message, "success");
                        } else {
                            swal("Failed!", response.message, "error");
                        }
                    },
                    async: false // <- this turns it into synchronous
                });
            }, 500);
        });
}

function getRoleAccessDetails(role_id) {
    $.ajax({
        url: baseUrl + "function/role_access_management.php?process_type=getRoleAccessByGroupId",
        type: 'POST',
        dataType: 'html',
        data: 'role_id=' + role_id,
        success: function(response) {
            $("#page_assign_body").html(response);
        }
    });
}

function getDepartmentByBranch(branch_id, department_id = 'department_id') {
    if (branch_id) {
        $.ajax({
            url: baseUrl + "function/rlp_process.php?process_type=getDepartmentByBranch",
            type: 'POST',
            dataType: 'html',
            data: 'branch_id=' + branch_id,
            success: function(response) {
                $("#" + department_id).html(response);
            }
        });
    }
}

function getDepartmentByBranches(reqdivision, reqdepartment = 'reqdepartment') {
    if (reqdivision) {
        $.ajax({
            url: baseUrl + "function/rlp_process.php?process_type=getDepartmentByBranches",
            type: 'POST',
            dataType: 'html',
            data: 'reqdivision=' + reqdivision,
            success: function(response) {
                $("#" + reqdepartment).html(response);
            }
        });
    }
}

function getDepartmentWiseUsers(branch = 'branch_id', department = 'department_id', form_type = 'chain_create_form', select_id = 'user_list_section') {
    var division_id = $("#" + branch).val();
    var department_id = $("#" + department).val();
    $.ajax({
        url: baseUrl + "function/user_management.php?process_type=getDepartmentusers",
        type: 'POST',
        dataType: 'html',
        data: 'division_id=' + division_id + "&department_id=" + department_id + '&form_type=' + form_type,
        success: function(response) {
            $("#" + select_id).html(response);
        }
    });
}

function getProjectWiseUsers(branch = 'branch_id', department = 'department_id', project = 'project_id', form_type = 'chain_create_form', select_id = 'user_list_section') {
    var division_id = $("#" + branch).val();
    var department_id = $("#" + department).val();
    var project_id = $("#" + project).val();
    $.ajax({
        url: baseUrl + "function/user_management.php?process_type=getProjectusers",
        type: 'POST',
        dataType: 'html',
        data: 'division_id=' + division_id + "&department_id=" + department_id + '&project_id=' + project_id + "&form_type=" + form_type,
        success: function(response) {
            $("#" + select_id).html(response);
        }
    });
}

function assignThisUserToChain(user_id) {
    var user_name = $("#assign_user_name_" + user_id).html();
    $.ajax({
        url: baseUrl + "function/user_management.php?process_type=assignThisUserToChain",
        type: 'POST',
        dataType: 'html',
        data: 'user_id=' + user_id + "&user_name=" + user_name,
        success: function(response) {
            $("#assign_user_label_" + user_id).html(user_name);
            $("#user_assign_common_check_" + user_id).show();
            $("#user_chain_section").append(response);
        }
    });
}


function assignThisCandidate(candidate_id) {
    var candidate_name = $("#candidate_name_" + candidate_id).html();
    $.ajax({
        url: baseUrl + "function/interview_register_form_process.php?process_type=assign_candidate",
        type: 'POST',
        dataType: 'html',
        data: 'candidate_id=' + candidate_id + "&candidate_name=" + candidate_name,
        success: function(response) {
            $("#candidate_selection").append(response);
        }
    });
}



function assignThisUserToDefaultChain(user_id) {
    var user_name = $("#assign_user_name_" + user_id).html();
    $.ajax({
        url: baseUrl + "function/user_management.php?process_type=assignThisUserToDefaultChain",
        type: 'POST',
        dataType: 'html',
        data: 'user_id=' + user_id + "&user_name=" + user_name,
        success: function(response) {
            $("#default_rlp_user_chain_section").append(response);
        }
    });
}

function deleteUserAssignTr(delete_id) {
    swal({
            title: 'Confirmed?',
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Confirm",
            cancelButtonText: 'Cancel',
            closeOnConfirm: false,
            showLoaderOnConfirm: true
        },
        function() {
            $("#user_assign_tr_" + delete_id).fadeOut(400, function() { $(this).remove(); });
            swal.close();
        });
}