//Ajax related all method reside their

/*
 * Following method is reponsible for 
 * adding parent category (1st layer category)
 */
function openModal(modalId) {
    $("label.error").remove();
    if (modalId == 'sub_item_added_form') {
        $.ajax({
            url: baseUrl + "includes/item_process.php?process_type=get_parent_category",
            type: 'POST',
            dataType: 'html',
            success: function(response) {
                $('#' + modalId).modal('show');
                $('#parent_item_id').html(response);
            }
        });
    } else if (modalId == 'item_added_form') {
        $.ajax({
            url: baseUrl + "includes/item_process.php?process_type=get_parent_category",
            type: 'POST',
            dataType: 'html',
            success: function(response) {
                $('#' + modalId).modal('show');
                $('#main_item_id').html(response);
            }
        });
    } else if (modalId == 'parent_item_added_form') {
        $.ajax({
            url: baseUrl + "includes/item_process.php?process_type=get_category_code",
            type: 'POST',
            dataType: 'json',
            data: 'cat_type=parent&data_type=ajax',
            success: function(response) {
                $('#' + modalId).modal('show');
                $('#category_id').val(response.code);
            }
        });
    } else {
        $('#' + modalId).modal('show');
    }
}

function closeModal(modalId) {
    $('#' + modalId).modal('hide');
}

function processParentItems(form_id) {
    var validationResult;
    if (form_id == 'parent_item_added_form_value') {
        $("#parent_item_added_form_value").validate();
        $("#category_id").rules("add", {
            required: true,
            messages: {
                required: "Please specify Category"
            }
        });
        $("#parent_name").rules("add", {
            required: true,
            messages: {
                required: "Please specify Name"
            }
        });
        validationResult = $("#parent_item_added_form_value").valid();
    } else if (form_id == 'parent_item_edit_form_value') {
        $("#parent_item_edit_form_value").valid();
        $("#edit_category_id").rules("add", {
            required: true,
            messages: {
                required: "Please specify Category"
            }
        });
        $("#edit_parent_name").rules("add", {
            required: true,
            messages: {
                required: "Please specify Name"
            }
        });
        validationResult = $("#parent_item_edit_form_value").valid();
    }
    if (validationResult) {
        $.ajax({
            url: baseUrl + "includes/item_process.php?process_type=parent",
            type: 'POST',
            dataType: 'json',
            data: $("#" + form_id).serialize(),
            success: function(response) {
                if (response.status == 'success') {
                    $('#main_item_id').val('');
                    $('#main_sub_item_id').val('');
                    $('#item_code').val('');
                    $('#item_name').val('');
                    $('#qty_unit').val('');
                    $('#material_min_stock').val('');
                    $('#category_id').val('');
                    $('#parent_name').val('');
                    if (form_id == 'parent_item_added_form_value') {
                        $('#parent_item_added_form').modal('hide');
                    } else if (form_id == 'parent_item_edit_form_value') {
                        $('#parent_item_edit_form').modal('hide');
                    }
                    $('#parent_category_body').html(response.data);
                    $("#item_information").accordion({ active: 0 });
                    swal("Success", response.message, "success");
                } else {
                    swal("Failed", response.message, "error");
                }
            }
        });
    }
}

function processSubItems(form_id) {
    var validationResult;
    if (form_id == 'sub_item_added_form_value') {
        $("#sub_item_added_form_value").validate();
        $("#parent_item_id").rules("add", {
            required: true,
            messages: {
                required: "Please specify Category"
            }
        });
        $("#sub_code").rules("add", {
            required: true,
            messages: {
                required: "Please specify Code"
            }
        });
        $("#sub_name").rules("add", {
            required: true,
            messages: {
                required: "Please specify Name"
            }
        });
        validationResult = $("#sub_item_added_form_value").valid();
    } else if (form_id == 'sub_item_update_form_value') {
        $("#sub_item_update_form_value").validate();
        $("#edit_parent_item_id").rules("add", {
            required: true,
            messages: {
                required: "Please specify Category"
            }
        });
        $("#edit_sub_code").rules("add", {
            required: true,
            messages: {
                required: "Please specify Code"
            }
        });
        $("#edit_sub_name").rules("add", {
            required: true,
            messages: {
                required: "Please specify Name"
            }
        });
        validationResult = $("#sub_item_update_form_value").valid();
    }
    if (validationResult) {
        $.ajax({
            url: baseUrl + "includes/item_process.php?process_type=sub_cat",
            type: 'POST',
            dataType: 'json',
            data: $("#" + form_id).serialize(),
            success: function(response) {
                if (response.status == 'success') {
                    $('#parent_item_id').val('');
                    $('#sub_code').val('');
                    $('#sub_name').val('');
                    $('#sub_description').val('');
                    if (form_id == 'sub_item_added_form_value') {
                        $('#sub_item_added_form').modal('hide');
                    } else if (form_id == 'sub_item_update_form_value') {
                        $('#sub_item_edit_form').modal('hide');
                    }
                    $('#sub_category_body').html(response.data);
                    $("#item_information").accordion({ active: 1 });
                    swal("Success", response.message, "success");
                } else {
                    swal("Failed", response.message, "error");
                }
            }
        });
    }
}

function processItems(form_id) {

    var validationResult;
    if (form_id == 'item_added_form_value') {
        $("#item_added_form_value").validate();
        $("#main_item_id").rules("add", {
            required: true,
            messages: {
                required: "Please specify Category"
            }
        });
        $("#main_sub_item_id").rules("add", {
            required: true,
            messages: {
                required: "Please specify Sub Category"
            }
        });
        $("#item_code").rules("add", {
            required: true,
            messages: {
                required: "Please specify Code"
            }
        });
        $("#item_name").rules("add", {
            required: true,
            messages: {
                required: "Please specify Name"
            }
        });
        validationResult = $("#item_added_form_value").valid();
    } else if (form_id == 'item_updated_form_value') {
        $("#item_updated_form_value").validate();
        $("#edit_main_item_id").rules("add", {
            required: true,
            messages: {
                required: "Please specify Category"
            }
        });
        $("#edit_sub_item_id").rules("add", {
            required: true,
            messages: {
                required: "Please specify Sub Category"
            }
        });
        $("#item_edit_code").rules("add", {
            required: true,
            messages: {
                required: "Please specify Code"
            }
        });
        $("#edit_item_name").rules("add", {
            required: true,
            messages: {
                required: "Please specify Name"
            }
        });
        validationResult = $("#item_updated_form_value").valid();
    }
    if (validationResult) {
        $.ajax({
            url: baseUrl + "includes/item_process.php?process_type=item",
            type: 'POST',
            dataType: 'json',
            data: $("#" + form_id).serialize(),
            success: function(response) {
                if (response.status == 'success') {
                    $('#main_item_id').val('');
                    $('#main_sub_item_id').val('');
                    $('#item_code').val('');
                    $('#item_name').val('');
                    $('#item_description').val('');
                    if (form_id == 'item_added_form_value') {
                        $('#item_added_form').modal('hide');
                    } else if (form_id == 'item_updated_form_value') {
                        $('#item_edit_form').modal('hide');
                    }
                    $('#item_category_body').html(response.data);
                    $("#item_information").accordion({ active: 2 });
                    swal("Success", response.message, "success");
                } else {
                    swal("Failed", response.message, "error");
                }
            }
        });
    }
}



function getBuildingByPackage(package_id, selector = false) {
    if (package_id) {
        $.ajax({
            url: baseUrl + "includes/issue_process.php?process_type=get_building_by_package",
            type: 'POST',
            dataType: 'html',
            data: 'package_id=' + package_id,
            success: function(response) {
                if (selector) {
                    $('#' + selector).html(response);
                } else {
                    $('#building_id').html(response);
                }
            }
        });
    } else {
        $('#building_id').html('');
    }
}

function getSubCategoryByParent(parent_id, selector = false) {
    if (parent_id) {
        $.ajax({
            url: baseUrl + "includes/item_process.php?process_type=get_sub_by_parent",
            type: 'POST',
            dataType: 'html',
            data: 'parent_id=' + parent_id,
            success: function(response) {
                if (selector) {
                    $('#' + selector).html(response);
                } else {
                    $('#main_sub_item_id').html(response);
                }
            }
        });
    } else {
        $('#main_sub_item_id').html('');
    }
}



function openMaterialEditForm(edit_id) {
    $.ajax({
        url: baseUrl + "includes/item_process.php?process_type=material_edit",
        type: 'POST',
        dataType: 'html',
        data: 'edit_id=' + edit_id,
        success: function(response) {
            $('#item_edit_form').modal('show');
            $('#material_edit_data_section').html(response);
        }
    });
}

function openSubMaterialEditForm(edit_id) {
    $.ajax({
        url: baseUrl + "includes/item_process.php?process_type=sub_material_edit",
        type: 'POST',
        dataType: 'html',
        data: 'edit_id=' + edit_id,
        success: function(response) {
            $('#sub_item_edit_form').modal('show');
            $('#sub_material_edit_data_section').html(response);
        }
    });
}

function openParentEditForm(edit_id) {
    $.ajax({
        url: baseUrl + "includes/item_process.php?process_type=parent_material_edit",
        type: 'POST',
        dataType: 'html',
        data: 'edit_id=' + edit_id,
        success: function(response) {
            $('#parent_item_edit_form').modal('show');
            $('#parent_material_edit_data_section').html(response);
        }
    });
}

function getSubCodeByParenId(parent_id, selector = false) {
    if (parent_id) {
        $.ajax({
            url: baseUrl + "includes/item_process.php?process_type=get_category_code",
            type: 'POST',
            dataType: 'json',
            data: 'cat_type=sub&data_type=ajax&parent_cat=' + parent_id,
            success: function(response) {
                if (selector) {
                    $('#' + selector).val(response.code);
                } else {
                    $('#sub_code').val(response.code);
                }
            }
        });
    } else {
        $('#sub_code').val('');
    }
}

function getMatCodeBySubId(sub_id, selector = false) {
    if (sub_id) {
        $.ajax({
            url: baseUrl + "includes/item_process.php?process_type=get_category_code",
            type: 'POST',
            dataType: 'json',
            data: 'cat_type=mat&data_type=ajax&parent_cat=' + $('#main_item_id').val() + '&sub_id=' + sub_id,
            success: function(response) {
                if (selector) {
                    $('#' + selector).val(response.code);
                } else {
                    $('#item_code').val(response.code);
                }
            }
        });
    } else {
        $('#item_code').val('');
    }
}

function getItemCodeByParam(id, table, field, selector, qty_unit = '') {
    if (id) {
        $('#quantity0').val('');
        var materialTotalStockId = 'material_total_stock0';
        var paramDetails = {
            id: id,
            table: table,
            field: field,
            qty_unit: qty_unit,
			site_id: (($('#from_site').val())? $('#from_site').val() : '')
        };
        $.ajax({
            url: baseUrl + "includes/item_process.php?process_type=getItemCodeByParam",
            type: 'POST',
            dataType: 'json',
            data: paramDetails,
            success: function(response) {
                $('#' + selector).val(response.data);
                $('#' + materialTotalStockId).val(response.totalStock);
                if (qty_unit) {
                    $('#unit0').val(response.qty_unit);
                }
                if (response.brand_name) {
                    $('#brand0').val(response.brand_name);
                }
            }
        });
    } else {
        $('#quantity0').val('');
        $('#' + selector).val('');
    }
}

function getAppendItemCodeByParam(id, table, field, selector, qty_unit = '') {
    $('#quantity' + id).val('');
    var materialId = $('#material_name' + id).val();
    var fieldSelector = selector + id;
    var materialTotalStockId = 'material_total_stock' + id;
    if (id) {
        var paramDetails = {
            id: materialId,
            table: table,
            field: field,
            qty_unit: qty_unit,
			site_id: (($('#from_site').val())? $('#from_site').val() : '')
        };
        $.ajax({
            url: baseUrl + "includes/item_process.php?process_type=getItemCodeByParam",
            type: 'POST',
            dataType: 'json',
            data: paramDetails,
            success: function(response) {
                $('#' + fieldSelector).val(response.data);
                $('#' + materialTotalStockId).val(response.totalStock);
                if (qty_unit) {
                    $('#unit' + id).val(response.qty_unit);
                }
                if (response.brand_name) {
                    $('#brand' + id).val(response.brand_name);
                }
            }
        });
    } else {
        $('#' + selector).val('');
    }
}

function getSearchTableData(formSelector, tableBodySelector, fieldChecker) {
    var checkMrrNo = $('#' + fieldChecker).val();
    if (checkMrrNo) {
        $.ajax({
            url: baseUrl + "includes/search_process.php?search_data=" + formSelector,
            type: 'POST',
            dataType: 'html',
            data: $("#" + formSelector).serialize(),
            success: function(response) {
                $('#' + tableBodySelector).html(response);
            }
        });
    } else {
        swal("Attention", 'Search item was empty', "error");
    }
}

function getWarehouseSearchTableData(formSelector, tableBodySelector, fieldChecker) {
    var checkMrrNo = $('#' + fieldChecker).val();
    if (checkMrrNo) {
        $.ajax({
            url: baseUrl + "includes/warehouse_search_process.php?search_data=" + formSelector,
            type: 'POST',
            dataType: 'html',
            data: $("#" + formSelector).serialize(),
            success: function(response) {
                $('#' + tableBodySelector).html(response);
            }
        });
    } else {
        swal("Attention", 'Search item was empty', "error");
    }
}

function check_stock_quantity_validation(selector_id) {
    console.log('Bu');
    var stockValue = 0;
    var quantityValue = 0;
    stockValue = parseFloat($('#material_total_stock' + selector_id).val());
    quantityValue = parseFloat($('#quantity' + selector_id).val());

    var commonIssueQuantityTotalValue   =   get_common_issue_quantity_total_value();
    console.log('commonIssueQuantityTotalValue');
    console.log(commonIssueQuantityTotalValue);
    if (stockValue < quantityValue) {
        $('#quantity' + selector_id).val('');
    }
    if(stockValue < commonIssueQuantityTotalValue){
        $('#quantity' + selector_id).val('');
    }
}

function get_common_issue_quantity_total_value(){
    var sumTotal = 0;
    $(".common_issue_quantity").each(function(){
        sumTotal += +$(this).val();
    });
    
    return sumTotal;
}

function showFormIsProcessing(formId) {
    var formCheck = $("#" + formId).valid();
    if (formCheck) {
        swal({
            title: 'Please Wait',
            text: "Form Data is now processing....",
            type: 'warning',
            showCancelButton: false,
            showConfirmButton: false
        })
    }
}