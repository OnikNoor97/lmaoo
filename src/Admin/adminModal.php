<?php if(!defined('directAccessValidator')) { die(file_get_contents('../../includes/notFound.php')); return; } ?>

<div class="modal fade" id="admin-modal" tabindex="-1" role="dialog" aria-labelledby="view-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title modal-title-custom ml-9 mr-auto text-white" id="admin-modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span></button>
            </div>

            <div id="admin-modal-header"></div>

            <div class="modal-body" id="admin-modal-body"></div>

            <div class="modal-footer" id="admin-modal-footer"></div>

        </div>
    </div>
</div>