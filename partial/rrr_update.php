<?php
    $currentUserId  =   $_SESSION['logged']['user_id'];
    $rrr_id         =   $_GET['rrr_id'];    
    $rrr_details    =   getRRRDetailsData($rrr_id);   
    $rrr_info       =   $rrr_details['rrr_info'];
    $rrr_details    =   $rrr_details['rrr_info'];
?>
<!-- Main content -->
<section class="invoice">
    <!-- title row -->
    <div class="row">
        <div class="col-xs-12">
            <h2 class="page-header">
                <i class="fa fa-file"></i> Recruitment Requisition Request Details.
                <small class="pull-right">Priority: <?php echo getPriorityNameDiv($rrr_info->priority) ?></small>
            </h2>
        </div>
        <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-md-4 invoice-col">
            From
            <address>
                <strong>Name:&nbsp;<?php echo $rrr_info->request_person ?></strong><br>
                Designation:&nbsp;<?php echo getDesignationNameById($rrr_info->designation) ?><br>
                Division:&nbsp;<?php echo getDivisionNameById($rrr_info->request_division) ?><br>
                Department:&nbsp;<?php echo getDepartmentNameById($rrr_info->request_department) ?><br>
            </address>
        </div>
        <!-- /.col -->
        <div class="col-md-8 invoice-col">
            <div class="pull-right">
                <b>RRR NO: &nbsp;<span class="rlpno_style"><?php echo $rrr_info->rrr_no ?></span></b><br>
                <b>Request Date:</b> <?php echo human_format_date($rrr_info->created_at) ?><br>
            </div>            
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <form id="rlp_product_supplier_assign_form">
        <div class="row">
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Requested Post</th>
                            <th>Type</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody id="tbl_posts_body">
                        <tr id="rec-1">
                            <td><?php echo getDesignationNameById($rrr_info->req_designation) ?></td>
                            <td><?php echo $rrr_info->emp_type; ?></td>
                            <td><?php echo $rrr_info->req_number; ?></td>
                        </tr>           
                    </tbody>
                </table>
            </div>
            <!-- /.col -->
        </div>
    </form>
    <!-- /.row -->
    <?php
    $role       =   get_role_group_short_name();
    
    if(is_super_admin($currentUserId)){
        //include 'rlp_update_view_sa.php';
        include 'rrr_update_view_sa.php';
    }elseif($role    ==  "member"){
        //include 'rlp_update_view_member.php';
        include 'rrr_update_view_member.php';
    }elseif($role    ==  "dh"){
        //include 'rlp_update_view_dh.php';
        include 'rrr_update_view_dh.php';
    }elseif($role    ==  "ab"){
        //include 'rlp_update_view_ab.php';
        include 'rrr_update_view_ab.php';
    }else{
        //include 'rlp_update_view_dh.php';
        include 'rrr_update_view_dh.php';
    }
    ?>
</section>
<!-- /.content -->
<div class="clearfix"></div>