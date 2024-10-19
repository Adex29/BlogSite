<?php include_once("../Components/Header.php"); ?>

<div class="d-flex">
    <?php include_once("../Components/Navigation.php"); ?>

    <div class="container-fluid background p-0">
        <div class="text-white b-secondary w-100 py-3">
            <h3 class="text-center m-auto h-5">PointDex</h3>
        </div>
        <div class="p-4">
            <div class="d-flex justify-content-between my-3">
                <h3>Comments</h3>
                <div>
                    <?php include_once("../Components/DateTimeNow.php"); ?>
                </div>
            </div>
            <div class="d-flex">
                <div class="col-4 position-relative">
                    <input type="text" placeholder="Search" class="form-control" id="searchCommentsInput">
                    <span class="clear-search" id="clearCommentsSearch"><i class="fa fa-times" aria-hidden="true"></i></span>
                </div>
                <div class="col-2 px-3">
                    <select class="form-select" name="filter-status" id="filter-status">
                        <option selected value="all">All</option>
                        <option value="approved">Approved</option>
                        <option value="pending">Pending</option>
                    </select>
                </div>
                <!-- <div class="ml-auto">
                    <button class="btn btn-primary align-self-end" data-bs-toggle="modal" data-bs-target="#commentModal">Add Comment</button>
                </div> -->
            </div>

            <div id="commentsTableContainer">
                <table id="commentsTable" class="data-table-height"></table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
        <form id="commentForm">
            <div class="modal-header">
                <h5 class="modal-title" id="commentModalLabel">Comment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="commentAuthor" class="form-label">Author</label>
                    <input type="text" class="form-control" id="commentAuthor">
                </div>
                <div class="mb-3">
                    <label for="commentText" class="form-label">Comment</label>
                    <textarea class="form-control" id="commentText"></textarea>
                </div>
                <div class="mb-3">
                    <label for="commentStatus" class="form-label">Status</label>
                    <select class="form-select" name="commentStatus" id="commentStatus">
                        <option value="approved">Approved</option>
                        <option value="pending">Pending</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save Comment</button>
            </div>
        </form>
    </div>
  </div>
</div>

<?php include_once("../Components/Footer.php"); ?>
