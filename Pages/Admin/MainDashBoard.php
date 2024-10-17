<?php include_once("../Actions/session.php"); ?>
<?php include_once("../Components/Header.php"); ?>

<div class="d-flex">
    <?php include_once("../Components/Navigation.php"); ?>

    <div class="container-fluid background p-0">
        <div class="text-white b-secondary w-100 py-3">
            <h3 class="text-center m-auto h-5">PointDex</h3>
        </div>
        
        <div id="alertContainer">
        </div>

        <div class="p-4">
            <div class="d-flex justify-content-between my-3">
                <h3>Users</h3>
                <div>
                    <?php include_once("../Components/DateTimeNow.php"); ?>
                </div>
            </div>
            <div class="d-flex">
                <div class="col-4 position-relative">
                    <input type="text" placeholder="Search" class="form-control" id="searchInput">
                    <span class="clear-search" id="clearSearch"><i class="fa fa-times" aria-hidden="true"></i></span>
                </div>
                <div class="col-2 px-3">
                    <select class="form-select" name="filter-role" id="filter-role">
                        <option selected value="all">All</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                </div>
                <div class="ml-auto">
                    <button class="btn add-btn align-self-end" data-bs-toggle="modal" data-bs-target="#userModal">Create User</button>
                </div>
            </div>
            <!-- <div class="row">
   
            </div> -->


            <div id="usersTableContainer" class="data-table-height">
                <table id="usersTable" class="table table-hover"></table>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="userForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" name="role" id="role" required>
                            <option value="admin">Admin</option>
                            <option value="user">User</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <div id="updateBtnContainer"></div>
                    <button type="submit" id="saveUserBtn" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Deletion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this user? This action cannot be undone.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Confirm Delete</button>
      </div>
    </div>
  </div>
</div>



<?php include_once("../Components/Footer.php"); ?>
<script src="../js/dashBoard.js"></script>