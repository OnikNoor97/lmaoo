            <!-- Modal -->
            <div class="modal fade" id="view-modal" tabindex="-1" role="dialog" aria-labelledby="view-modal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLongTitle">Account Details</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <form action="../User/userController.php" method="POST">
                   <div class="modal-body">
                    <div class="form-group">
                        <label>Forename</label>
                        <input class="form-control" value=<?php echo $userLoggedIn->getForename(); ?>  name="editForename" >
                    </div>
                    <div class="form-group">
                        <label>Surname</label>
                        <input class="form-control" value=<?php echo $userLoggedIn->getSurname(); ?>  name="editSurname">
                    </div>
                    <div class="form-group">
                        <label>Username</label>
                        <input class="form-control" value=<?php echo $userLoggedIn->getUsername(); ?> name="editUsername">
                    </div>
                    </div>
                    <input type="hidden" name="function" value="update">
                 <div class="modal-footer">
                 <input class="btn btn-primary" type="submit" value="Save Changes">
                </div>
                </form>
                 </div>
            </div>
        </div>