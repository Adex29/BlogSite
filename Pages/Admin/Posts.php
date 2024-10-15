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
                <h3>Posts</h3>
                <div>
                    <?php include_once("../Components/DateTimeNow.php"); ?>
                </div>
            </div>
            <div class="d-flex">
                <div class="col-4 position-relative">
                    <input type="text" placeholder="Search Posts" class="form-control" id="searchPostsInput">
                    <span class="clear-search" id="clearPostsSearch"><i class="fa fa-times" aria-hidden="true"></i></span>
                </div>
                <div class="col-2 px-3">
                    <select class="form-select" name="filter-category" id="filter-category">
                        <option selected value="all">All Categories</option>
                        <option value="news">News</option>
                        <option value="updates">Updates</option>
                        <option value="events">Events</option>
                    </select>
                </div>
                <div class="ml-auto">
                    <button class="btn add-btn align-self-end" data-bs-toggle="modal" data-bs-target="#postModal">Create Post</button>
                </div>
            </div>

            <div id="postsTableContainer" class="data-table-height">
                <table id="postsTable" class="table table-hover"></table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="postModal" tabindex="-1" aria-labelledby="postModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form id="postForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="postModalLabel">Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="carouselExampleSlidesOnly" class="carousel slide" data-interval="false">
                        <div class="carousel-inner">
                            <div class="carousel-item active" style="height: 500px;">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" class="form-control" id="title" name="title" required>
                                </div>
                                <div class="mb-3">
                                    <label for="category" class="form-label">Category</label>
                                    <select class="form-select" name="category" id="category" required>
                                        <option value="news">News</option>
                                        <option value="updates">Updates</option>
                                        <option value="events">Events</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="summary" class="form-label">Summary</label>
                                    <textarea class="form-control" id="summary" name="summary" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" name="status" id="status" required>
                                        <option value="published">Published</option>
                                        <option value="draft">Draft</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="img" class="form-label">Image</label>
                                    <input type="file" class="form-control" id="img" name="img">
                                </div>
                            </div>
                            <div class="carousel-item" style="height: 500px;">
                                <div id="postContentContainer">
                                    <label for="content" class="form-label">Content</label>
                                    <textarea class="form-control" id="content" name="content" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" id="prevBtn" data-bs-target="#carouselExampleSlidesOnly" data-bs-slide="prev" style="visibility: visible;">
                        < Prev
                    </button>
                    
                    <button class="btn btn-secondary" type="button" id="nextBtn" data-bs-target="#carouselExampleSlidesOnly" data-bs-slide="next" style="visibility: visible;">
                        Next >
                    </button>
                    <button type="submit" class="btn btn-success d-none" id="savePostBtn">Save Post</button>
                    <div id=updateBtnContainer></div>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Delete Confirmation Modal for Posts -->
<div class="modal fade" id="deletePostConfirmationModal" tabindex="-1" aria-labelledby="deletePostConfirmationModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deletePostConfirmationModalLabel">Confirm Deletion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div> 
      <div class="modal-body">
        Are you sure you want to delete this post? This action cannot be undone.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" id="confirmDeletePostBtn">Confirm Delete</button>
      </div>
    </div>
  </div>
</div>

<?php include_once("../Components/Footer.php"); ?>
<script src="../js/posts.js"></script>