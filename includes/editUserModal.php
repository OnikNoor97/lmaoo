<?php include_once(__DIR__ . "/../includes/autoloader.inc.php"); if (!isset($_SESSION['userLoggedIn'])) return; ?>

<link rel="stylesheet" href="../Css/allModals.css">
            
<div class="modal fade" id="view-modal" tabindex="-1" role="dialog" aria-labelledby="view-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h5 class="modal-title modal-title-custom ml-9 mr-auto text-white" id="EditUserModalTitle">Account Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
                
            <div class="modal-body">    
                <label>Upload Profile Picture</label>
                <div class="input-group my-2">
                    <div class="input-group-prepend">
                        <button class="input-group-text" id="uploadImageBtn" disabled onclick="uploadImage()">Upload</button>
                    </div>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="uploadImage" aria-describedby="uploadImageBtn" onchange="validateImage()">
                        <label class="custom-file-label" for="uploadImage">Choose file</label>
                    </div>
                </div>
                <div id="uploadImageText" hidden>
                    <small>Invalid file type.</small>
                </div>
                
                <form action="../User/target.php" method="POST" onkeyup="userEditValidation(); checkUserDup();">
                    <div class="form-group">
                        <label>Forename</label>
                        <input class="form-control" value=<?php echo unserialize($_SESSION['userLoggedIn'])->getForename(); ?>  id="editForename" name="editForename" required>
                    </div>

                    <div class="form-group">
                        <label>Surname</label>
                        <input class="form-control" value=<?php echo unserialize($_SESSION['userLoggedIn'])->getSurname(); ?>  id="editSurname" name="editSurname" required>
                    </div>

                    <div class="form-group">
                        <label>Username</label>
                        <input class="form-control" value=<?php echo unserialize($_SESSION['userLoggedIn'])->getUsername(); ?> id="editUsername" name="editUsername" required>
                        <small id="editUsernameMessage" hidden></small> 
                    </div>

                    <?php GithubController::loadProfile($userLoggedIn); ?>

            </div>
                    <input type="hidden" name="function" value="update">
                    <input type="hidden" name="editUserId" value="<?php echo $userLoggedIn->getId();?>">

                    <div class="modal-footer">
                        <input id="editUserBtn" class="btn btn-primary" type="submit" value="Save Changes" disabled>
                    </div>
                </form>
            </div>
        </div>
    </div> 
</div>
<script type="text/javascript" src="../Script/editUser.js"></script>