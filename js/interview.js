$(document).ready(function() {

    $('#btn_interview_time_details').click(function() {

        var error_date = '';
        var error_location = '';
        // var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

        if ($.trim($('#date').val()).length == 0) {
            error_date = 'Date is required';
            $('#error_date').text(error_date);
            $('#date').addClass('has-error');
        } else {

            error_date = '';
            $('#error_date').text(error_date);
            $('#date').removeClass('has-error');

        }

        if ($.trim($('#location').val()).length == 0) {
            error_location = 'location is required';
            $('#error_location').text(error_location);
            $('#location').addClass('has-error');
        } else {
            error_location = '';
            $('#error_location').text(error_location);
            $('#location').removeClass('has-error');
        }

        if (error_date != '' || error_location != '') {
            return false;
        } else {

            let testData = get_interview_data_by_req();

            $("#candidate_show_area").html(testData);

            $('#list_interview_time_details').removeClass('active active_tab1');
            $('#list_interview_time_details').removeAttr('href data-toggle');
            $('#interview_time_details').removeClass('active');
            $('#list_interview_time_details').addClass('inactive_tab1');


            $('#list_candidate_details').removeClass('inactive_tab1');
            $('#list_candidate_details').addClass('active_tab1 active');
            $('#list_candidate_details').attr('href', '#candidate_details');
            $('#list_candidate_details').attr('data-toggle', 'tab');
            $('#candidate_details').addClass('active in');
        }
    });

    $('#previous_btn_personal_details').click(function() {
        $('#list_personal_details').removeClass('active active_tab1');
        $('#list_personal_details').removeAttr('href data-toggle');
        $('#personal_details').removeClass('active in');
        $('#list_personal_details').addClass('inactive_tab1');
        $('#list_candidate_details').removeClass('inactive_tab1');
        $('#list_candidate_details').addClass('active_tab1 active');
        $('#list_candidate_details').attr('href', '#candidate_details');
        $('#list_candidate_details').attr('data-toggle', 'tab');
        $('#candidate_details').addClass('active in');
    });

    $('#btn_candidate_details').click(function() {
        var error_bom = '';
        var error_last_name = '';


        $('#list_candidate_details').removeClass('active active_tab1');
        $('#list_candidate_details').removeAttr('href data-toggle');
        $('#candidate_details').removeClass('active in');
        $('#list_candidate_details').addClass('inactive_tab1');
        $('#list_personal_details').removeClass('inactive_tab1');
        $('#list_personal_details').addClass('active_tab1 active');
        $('#list_personal_details').attr('href', '#personal_details');
        $('#list_personal_details').attr('data-toggle', 'tab');
        $('#personal_details').addClass('active in');

    });

    $('#previous_btn_candidate_details').click(function() {
        $('#list_candidate_details').removeClass('active active_tab1');
        $('#list_candidate_details').removeAttr('href data-toggle');
        $('#candidate_details').removeClass('active in');
        $('#list_candidate_details').addClass('inactive_tab1');
        $('#list_interview_time_details').removeClass('inactive_tab1');
        $('#list_interview_time_details').addClass('active_tab1 active');
        $('#list_interview_time_details').attr('href', '#personal_details');
        $('#list_interview_time_details').attr('data-toggle', 'tab');
        $('#interview_time_details').addClass('active in');
    });

    $('#btn_personal_details').click(function() {
        var error_candidates = '';
        var error_mobile_no = '';
        var mobile_validation = /^\d{10}$/;
        if ($.trim($('#candidates').val()).length == 0) {
            error_candidates = 'candidates is required';
            $('#error_candidates').text(error_candidates);
            $('#candidates').addClass('has-error');
        } else {
            error_candidates = '';
            $('#error_candidates').text(error_candidates);
            $('#candidates').removeClass('has-error');
        }

        if (error_candidates != '') {
            $('#btn_candidate_details').attr("disabled", "disabled");
            $(document).css('cursor', 'prgress');
            $("#register_form").submit();
        } else {
            $('#btn_candidate_details').attr("disabled", "disabled");
            $(document).css('cursor', 'prgress');
            $("#register_form").submit();
        }

    });

});

function get_interview_data_by_req() {

    let interviewData;

    $.ajax({

        url: baseUrl + "function/interview_register_form_process.php?process_type=get_interviewer",
        type: "POST",
        dataType: 'html',
        data: $("#interview_register_form").serialize(),
        success: function(response) {
            interviewData = response;
        },
        async: false

    });


    return interviewData;

}

$('#add_new_candidate').click(function() {


    $.ajax({

        url: baseUrl + "function/interview_register_form_process.php?process_type=get_ajax_candidates_form",
        type: "POST",
        dataType: 'html',
        success: function(response) {
            $('#candidate_add_ajax_modal').modal('show');
            $("#candidate_add_ajax_modal_body").html(response);
        },
        async: false

    });


});

//

function candidate_create_with_ajax() {

    let myFormData = new FormData(document.getElementById("candidates_form"));
    $.ajax({

        url: baseUrl + "function/candidates_management.php?process_type=create_ajax_candidates",
        type: "POST",
        dataType: 'html',
        data: myFormData,
        processData: false,
        contentType: false,
        success: function(response) {
            $('#candidate_add_ajax_modal_body').html('');
            $('#candidate_add_ajax_modal').modal('hide');
            $("#candidate_show_area").append(response);
        },
        async: false

    });


}