
                            <?php if(hasAccessPermission($user_id_session, 'crlp', 'edit_access')){ ?>
                            <a title="Edit User" class="btn btn-sm btn-info" href="user_update.php?user_id=<?php echo $adata->id; ?>">
                                <span class="fa fa-pencil"></span>
                            </a>
                            <?php } ?>
                            <?php 
                                if(hasAccessPermission($user_id_session, 'crlp', 'delete_access')){
                                    if($user_id_session!=$adata->id){
                                ?>
                            <a title="Delete User" class="btn btn-sm btn-danger" href="javascript:void(0)" onclick="commonDeleteOperation('<?php echo $delUrl ?>', '<?php echo $adata->id ?>');">
                                <span class="fa fa-close"></span>
                            </a>
                                <?php }} ?>
                            <?php 
                                if(is_super_admin($user_id_session)){
                                    if($user_id_session!=$adata->id){
                            ?>
                            <a title="Login As" class="btn btn-sm btn-warning" href="javascript:void(0)" onclick="loginAsAnotherUser('<?php echo $adata->id ?>', '<?php echo $user_id_session; ?>');">
                                <span class="fa fa-user-secret"></span>
                            </a>
                                <?php }} ?>