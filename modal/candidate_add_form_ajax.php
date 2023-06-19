<div id="candidate_add_ajax_modal" class="modal fade" role="dialog">
    <div class="modal-dialog" style="width: 70%">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Candidate Add</h4>
            </div>
            <div class="modal-body">
                <form id="candidates_form" role="form" method="post" enctype="multipart/form-data">
                    <div class="box-body" id="candidate_add_ajax_modal_body">
                        <?php
                        get_candidates_form();
                        ?>
                    </div>
                    <div class="box-footer">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button type="button" id="candidate_create_ajax" name="candidate_create" class="btn btn-primary btn-block" onclick="candidate_create_with_ajax();">
                                        Create
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>