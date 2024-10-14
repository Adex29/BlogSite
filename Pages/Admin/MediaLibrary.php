<?php include_once("../Components/Header.php"); ?>

<div class="d-flex">
    <?php include_once("../Components/Navigation.php"); ?>

    <div class="container-fluid background p-0">
        <div class="text-white b-secondary w-100 py-3">
            <h3 class="text-center m-auto h-5">PointDex</h3>
        </div>
        <div class="p-4">
            <div class="d-flex justify-content-between my-3">
                <h3>Media Library</h3>
                <div>
                    <?php include_once("../Components/DateTimeNow.php"); ?>
                </div>
            </div>
            <div class="d-flex">
                <div class="col-4 position-relative">
                    <input type="text" placeholder="Search Media" class="form-control" id="searchMediaInput">
                    <span class="clear-search" id="clearMediaSearch"><i class="fa fa-times" aria-hidden="true"></i></span>
                </div>
                <div class="col-2 px-3">
                    <select class="form-select" name="filter-media-type" id="filter-media-type">
                        <option selected value="all">All Media</option>
                        <option value="image">Images</option>
                        <option value="video">Videos</option>
                    </select>
                </div>
                <div class="ml-auto">
                    <button class="btn add-btn align-self-end" data-bs-toggle="modal" data-bs-target="#mediaModal">Upload Media</button>
                </div>
            </div>

            <div id="mediaTableContainer">
                <table id="mediaTable" class="data-table-height"></table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="mediaModal" tabindex="-1" aria-labelledby="mediaModalLabel" aria-hidden="true" data-bs-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
        <form id="mediaForm" enctype="multipart/form-data">
            <div class="modal-header">
                <h5 class="modal-title" id="mediaModalLabel">Upload Media</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="mediaTitle" class="form-label">Title</label>
                    <input type="text" class="form-control" id="mediaTitle">
                </div>
                <div class="mb-3">
                    <label for="mediaFile" class="form-label">Choose File</label>
                    <input type="file" class="form-control" id="mediaFile" accept="image/*,video/*">
                </div>
                <div class="mb-3">
                    <label for="mediaType" class="form-label">Type</label>
                    <select class="form-select" name="mediaType" id="mediaType">
                        <option value="image">Image</option>
                        <option value="video">Video</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="mediaDescription" class="form-label">Description</label>
                    <textarea class="form-control" id="mediaDescription"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Upload</button>
            </div>
        </form>
    </div>
  </div>
</div>

<?php include_once("../Components/Footer.php"); ?>
