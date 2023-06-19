jQuery(document).delegate('a.add-record', 'click', function (e) {
    e.preventDefault();
    var content     = jQuery('#sample_table tr'),
            size    = jQuery('#tbl_posts >tbody >tr').length + 1,
            element = null,
            element = content.clone();
    element.attr('id', 'rec-' + size);
    element.find('.delete-record').attr('data-id', size);
    element.appendTo('#tbl_posts_body');
    element.find('.sn').html(size);
});

jQuery(document).delegate('a.delete-record', 'click', function (e) {
    e.preventDefault();
    var didConfirm = confirm("Are you sure You want to delete");
    if (didConfirm == true) {
        var id = jQuery(this).attr('data-id');
        var targetDiv = jQuery(this).attr('targetDiv');
        jQuery('#rec-' + id).remove();

        //regnerate index number on table
        $('#tbl_posts_body tr').each(function (index) {
            //alert(index);
            $(this).find('span.sn').html(index + 1);
        });
        return true;
    } else {
        return false;
    }
});
$(function () {
    $("#rlpdate").datepicker({
        inline: true,
        dateFormat: "yy-mm-dd",
        yearRange: "-50:+10",
        changeYear: true,
        changeMonth: true
    });
});
$(function () {
    $("#date").datepicker({
        inline: true,
        dateFormat: "yy-mm-dd",
        yearRange: "-50:+10",
        changeYear: true,
        changeMonth: true
    });
});

$(function () {
    $("#fromdate").datepicker({
        inline: true,
        dateFormat: "yy-mm-dd",
        yearRange: "-50:+10",
        changeYear: true,
        changeMonth: true
    });
});$(function () {
    $("#todate").datepicker({
        inline: true,
        dateFormat: "yy-mm-dd",
        yearRange: "-50:+10",
        changeYear: true,
        changeMonth: true
    });
});

function rlp_quick_view(rlp_id){
    $.ajax({
        url: baseUrl + "function/rlp_process.php?process_type=rlp_quick_view",
        type: 'POST',
        dataType: 'html',
        data: 'rlp_id=' + rlp_id,
        success: function (response) {
            $("#rlp_quick_view_modal").modal('show');
            $("#rlp_quick_view_modal_body").html(response);
        }
    });
}

function rrr_quick_view(rrr_id){
    $.ajax({
        url: baseUrl + "function/rrr_processing.php?process_type=rrr_quick_view",
        type: 'POST',
        dataType: 'html',
        data: 'rrr_id=' + rrr_id,
        success: function (response) {
            $("#rrr_quick_view_modal").modal('show');
            $("#rrr_quick_view_modal_body").html(response);
        }
    });
}

function notesheet_quick_view(rrr_id){
    $.ajax({
        url: baseUrl + "function/notesheet_processing.php?process_type=notesheet_quick_view",
        type: 'POST',
        dataType: 'html',
        data: 'rrr_id=' + rrr_id,
        success: function (response) {
            $("#notesheet_quick_view_modal").modal('show');
            $("#notesheet_quick_view_modal_body").html(response);
        }
    });
}

function execute_rlp_sa_update_form(form_id, process_type='rlp_sa_update_execute'){
    $.ajax({
        url: baseUrl + "function/rlp_process.php?process_type="+process_type,
        type: 'POST',
        dataType: 'json',
        data: $("#"+form_id).serialize(),
        success: function (response) {
            if(response.status == "success"){
                swal("Success", response.message, "success");
                setTimeout(function () {
                    location.reload();
                }, 2000);                
            }else{
                swal("Failed", response.message, "error");
            }
        }
    });
}
function execute_wo_update_form(form_id, process_type='wo_update_execute'){
    $.ajax({
        url: baseUrl + "function/workorder_processing.php?process_type="+process_type,
        type: 'POST',
        dataType: 'json',
        data: $("#"+form_id).serialize(),
        success: function (response) {
            if(response.status == "success"){
                swal("Success", response.message, "success");
                setTimeout(function () {
                    location.reload();
                }, 2000);                
            }else{
                swal("Failed", response.message, "error");
            }
        }
    });
}

function execute_notesheet_sa_update_form(form_id, process_type='notesheet_sa_update_execute'){
    $.ajax({
        url: baseUrl + "function/notesheet_processing.php?process_type="+process_type,
        type: 'POST',
        dataType: 'json',
        data: $("#"+form_id).serialize(),
        success: function (response) {
            if(response.status == "success"){
                swal("Success", response.message, "success");
                setTimeout(function () {
                    location.reload();
                }, 2000);                
            }else{
                swal("Failed", response.message, "error");
            }
        }
    });
}
function execute_notesheet_dh_update_form(form_id, process_type='notesheet_dh_update_execute'){
    $.ajax({
        url: baseUrl + "function/notesheet_processing.php?process_type="+process_type,
        type: 'POST',
        dataType: 'json',
        data: $("#"+form_id).serialize(),
        success: function (response) {
            if(response.status == "success"){
                swal("Success", response.message, "success");
                setTimeout(function () {
                    location.reload();
                }, 2000);                
            }else{
                swal("Failed", response.message, "error");
            }
        }
    });
}
function execute_notesheet_ab_update_form(form_id, process_type='notesheet_ab_update_execute'){
    $.ajax({
        url: baseUrl + "function/notesheet_processing.php?process_type="+process_type,
        type: 'POST',
        dataType: 'json',
        data: $("#"+form_id).serialize(),
        success: function (response) {
            if(response.status == "success"){
                swal("Success", response.message, "success");
                setTimeout(function () {
                    location.reload();
                }, 2000);                
            }else{
                swal("Failed", response.message, "error");
            }
        }
    });
}
function execute_rrr_dh_update_form(form_id, process_type='rrr_dh_update_execute'){
    $.ajax({
        url: baseUrl + "function/rrr_processing.php?process_type="+process_type,
        type: 'POST',
        dataType: 'json',
        data: $("#"+form_id).serialize(),
        success: function (response) {
            if(response.status == "success"){
                swal("Success", response.message, "success");
                setTimeout(function () {
                    location.reload();
                }, 2000);                
            }else{
                swal("Failed", response.message, "error");
            }
        }
    });
}

function execute_rrr_sa_update_form(form_id, process_type='rrr_sa_update_execute'){
    $.ajax({
        url: baseUrl + "function/rrr_processing.php?process_type="+process_type,
        type: 'POST',
        dataType: 'json',
        data: $("#"+form_id).serialize(),
        success: function (response) {
            if(response.status == "success"){
                swal("Success", response.message, "success");
                setTimeout(function () {
                    location.reload();
                }, 2000);                
            }else{
                swal("Failed", response.message, "error");
            }
        }
    });
}
function execute_rrr_ab_update_form(form_id, process_type='rrr_ab_update_execute'){
    $.ajax({
        url: baseUrl + "function/rrr_processing.php?process_type="+process_type,
        type: 'POST',
        dataType: 'json',
        data: $("#"+form_id).serialize(),
        success: function (response) {
            if(response.status == "success"){
                swal("Success", response.message, "success");
                setTimeout(function () {
                    location.reload();
                }, 2000);                
            }else{
                swal("Failed", response.message, "error");
            }
        }
    });
}
function execute_rlp_supplier_update_form(form_id, process_type='rlp_sa_supplier_update_execute'){
    $.ajax({
        url: baseUrl + "function/rlp_process.php?process_type="+process_type,
        type: 'POST',
        dataType: 'json',
        data: $("#"+form_id).serialize(),
        success: function (response) {
            if(response.status == "success"){
                swal("Success", response.message, "success");
                setTimeout(function () {
                    location.reload();
                }, 2000);                
            }else{
                swal("Failed", response.message, "error");
            }
        }
    });
}