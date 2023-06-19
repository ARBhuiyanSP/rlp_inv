<?php
$rlpListData = getRLPListData();
if (isset($rlpListData) && !empty($rlpListData)) {
    ?>
    <div class="table-responsive">
        <table id="rlp_list_table" class="table table-bordered table-striped list-table-custom-style">
            <thead>
                <tr>
                    <th>SLN#</th>
                    <th>RLP No</th>
                    <th>Request Date</th>
                    <th>RLP User</th>
                    <th>Division</th>
                    <th>Department</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sl = 0;
                $delUrl =   "function/rlp_process.php?process_type=rlp_delete";
                foreach ($rlpListData as $adata) {
                    ?>
                    <tr id="row_id_<?php echo $adata->id; ?>">
                        <td><?php echo ++$sl; ?></td>
                        <td>
                            <div title="RLP quick view" onclick="rlp_quick_view('<?php echo $adata->id ?>');" style="cursor: pointer;padding: 2% 2%; font-weight: bold; background-color: <?php echo get_status_color($adata->rlp_status); ?>">
                                <span>
                                    <?php echo (isset($adata->rlp_no) && !empty($adata->rlp_no) ? $adata->rlp_no : 'No data'); ?>
                                </span>
                            </div>
                        </td>
                        <td><?php echo (isset($adata->request_date) && !empty($adata->request_date) ? human_format_date($adata->created_at) : 'No data'); ?></td>
                        <td><?php echo (isset($adata->rlp_user_id) && !empty($adata->rlp_user_id) ? getUserNameByUserId($adata->rlp_user_id) : 'No data'); ?></td>
                        <td><?php echo (isset($adata->request_division) && !empty($adata->request_division) ? getDivisionNameById($adata->request_division) : 'No data'); ?></td>
                        <td><?php echo (isset($adata->request_department) && !empty($adata->request_department) ? getDepartmentNameById($adata->request_department) : 'No data'); ?></td>
                        <td><?php echo (isset($adata->priority) && !empty($adata->priority) ? getPriorityNameDiv($adata->priority) : 'No data'); ?></td>
                        <td>
                            <div style="padding: 2% 10%; font-weight: bold; background-color: <?php echo get_status_color($adata->rlp_status); ?>">
                                <?php echo get_status_name($adata->rlp_status); ?>
                            </div>
                        </td>
                        <td>
                            <?php if(hasAccessPermission($user_id_session, 'crlp', 'edit_access')){ ?>
                            <a title="Edit RLP" class="btn btn-sm btn-info" href="rlp_update.php?rlp_id=<?php echo $adata->id; ?>">
                                <span class="fa fa-pencil"></span>
                            </a>
                            <?php } ?>
							
                            <?php if(hasAccessPermission($user_id_session, 'crlp', 'delete_access')){ ?>
                            <a title="Delete RLP" class="btn btn-sm btn-danger" href="javascript:void(0)" onclick="commonDeleteOperation('<?php echo $delUrl ?>', '<?php echo $adata->id ?>');">
                                <span class="fa fa-close"></span>
                            </a>
                            <?php } ?>  
							
							<?php if(hasAccessPermission($user_id_session, 'crlp', 'edit_access')){ ?>
                            <a title="Print RLP History" class="btn btn-sm btn-info bg-olive" href="rlp_view.php?rlp_id=<?php echo $adata->id; ?>">
                                <span class="fa fa-print"></span>
                            </a>
                            <?php } ?>  

							<?php if(hasAccessPermission($user_id_session, 'crlp', 'edit_access')){ ?>
                            <a title="Print RLP" class="btn btn-sm btn-info bg-blue" href="rlp_print.php?rlp_id=<?php echo $adata->id; ?>">
                                <span class="fa fa-print"></span>
                            </a>
                            <?php } ?>							
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
<?php } else { ?>
    <div class="alert alert-warning">
        <strong>Sorry there is no data!</strong>
    </div>
<?php } ?>