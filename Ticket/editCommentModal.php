<?php if (!isset($userLoggedIn))  { return; } else { ?>
            <div class="modal fade" id="editCommentModal" tabindex="-1" role="dialog" aria-labelledby="view-modal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLongTitle"><b>Edit Comment</b></h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                   <div class="modal-body">
                    <div class="form-group">
                        <label class="CenterText">Edit Comment Here</label>
                        <script type="text/javascript" src="../Script/commentController.js"></script>
						<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css" rel="stylesheet">
						<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js"></script>
						<textarea id="createComment" class=createComment name="editordata" required>Insert PHP/JS/Power of god & anime to load comments from DB inside. not sure how to currently.</textarea>
                    </div>
                    <input type="hidden" name="function" value="update">
                 <div class="modal-footer">
                 <input class="btn btn-primary" type="submit" value="Save Changes">
                </div>
                 </div>
            </div>
</div> <?php } ?>
        </div>