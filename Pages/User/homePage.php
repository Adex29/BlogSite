<?php include_once("../Components/UserHeader.php"); ?>
<?php include_once("../Components/UserNavbar.php"); ?>
<?php 

?>
<div class="wrapper">
    <div class="md:flex md:items-start">
        <div class=" md:w-4/5">
            <div id="postsContainer">
            </div>
            <div id="postsContainer">
                <div class="md:flex">
                    <div class="w-full md:w-64 h-64 flex-shrink-0">
                        <img src="https://static.remove.bg/sample-gallery/graphics/bird-thumbnail.jpg" alt="" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <div class="md:px-3">
                            <div class="badge badge-ghost p-3">News</div>
                        </div>
                        <div class="md:px-3 md:py-1">
                            <h1 class="text-3xl font-bold">Ang pulis sa tulay nadapa</h1>
                        </div>
                        <div class="flex md:px-3">
                            <h1 class="text-sm">Jay-ar Baniqued</h1>
                            <h1 class="text-sm font-bold px-3">.</h1>
                            <h1 class="text-sm">Oct 24, 2024</h1>
                        </div>
                        <div class="md:px-3 md:py-1">
                            <h1 class="text-lg">Lorem ea est fugiat mollit irure eiusmod proident sit elit labore elit proident aute voluptate. Minim aliquip ut ea esse voluptate qui eu quis qui voluptate ex magna adipisicing. Non esse Lorem eu veniam aliqua dolor cupidatat adipisicing sit cillum veniam et fugiat. Irure nostrud labore ea tempor id do et duis enim. Quis veniam nisi ea do Lorem laborum occaecat.</h1>
                        </div>
                        <div class="md:px-3 md:py-1">
                            <div class="badge badge-ghost px-5 btn">Likes<i class="fa fa-thumbs-o-up" aria-hidden="true"></i></div>
                            <button class="btn">
                                Comments
                                <i class="fa fa-comments" aria-hidden="true"></i>
                                <div class="badge">+99</div>
                            </button>
                            <button class="btn">
                                Read More
                                <i class="fa fa-arrow-right" aria-hidden="true"></i>
                            </button>
                            <button class="btn">
                                Share
                                <i class="fa fa-share" aria-hidden="true"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="my-3"> -->
            <!-- <div>
                <div class="md:flex">
                    <div class="w-full md:w-64 h-64 flex-shrink-0">
                        <img src="https://static.remove.bg/sample-gallery/graphics/bird-thumbnail.jpg" alt="" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <div class="md:px-3">
                            <div class="badge badge-ghost p-3">News</div>
                        </div>
                        <div class="md:px-3 md:py-1">
                            <h1 class="text-3xl font-bold">Ang pulis sa tulay nadapa</h1>
                        </div>
                        <div class="flex md:px-3">
                            <h1 class="text-sm">Jay-ar Baniqued</h1>
                            <h1 class="text-sm font-bold px-3">.</h1>
                            <h1 class="text-sm">Oct 24, 2024</h1>
                        </div>
                        <div class="md:px-3 md:py-1">
                            <h1 class="text-lg">Lorem ea est fugiat mollit irure eiusmod proident sit elit labore elit proident aute voluptate. Minim aliquip ut ea esse voluptate qui eu quis qui voluptate ex magna adipisicing. Non esse Lorem eu veniam aliqua dolor cupidatat adipisicing sit cillum veniam et fugiat. Irure nostrud labore ea tempor id do et duis enim. Quis veniam nisi ea do Lorem laborum occaecat.</h1>
                        </div>
                        <div class="md:px-3 md:py-1">
                            <div class="badge badge-ghost px-5 btn">Likes<i class="fa fa-thumbs-o-up" aria-hidden="true"></i></div>
                            <button class="btn">
                                Comments
                                <i class="fa fa-comments" aria-hidden="true"></i>
                                <div class="badge">+99</div>
                            </button>
                        </div>
                    </div>

                </div>
            </div>

        </div>


        <div class="bg-gray-200 mt-3 md:w-1/5 md:ml-3 md:mt-0">
            <h1 class="text-3xl font-bold ml-3">Recent Posts</h1>
            <div>
                <div class="md:px-3 md:py-1">
                    <div class="flex">
                        <input id="searchPost" class="input" type="text" placeholder="Search posts...">
                        <button id="searchPostBtn" class="btn">Search</button>
                    </div>
                    <div id="recentPosts">
                        <!-- Recent posts will be appended here -->
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>




<dialog id="CommentsModal" class="modal">
  <div class="modal-box">
    <form method="dialog">
      <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
    </form>
    <h3 class="text-lg font-bold mb-3">Comments</h3>
    <div class="flex flex-col w-3/4" id="commentsContainer">
        <div class="outline outline-1 outline-gray-300 inline-block rounded-full px-5 py-3 my-2">
            <p class="block"><strong>Jay-ar Baniqued</strong></p>
            <p class="block">This is good jsdnfjkdsfnkdn sjdn.</p>
        </div>
        <div class="outline outline-1 outline-gray-300 inline-block rounded-full px-5 py-3 my-2">
            <p class="block"><strong>Jay-ar Baniqued</strong></p>
            <p class="block">This is good jsdnfjkdsfnkdn sjdn.</p>
        </div>
        <div class="outline outline-1 outline-gray-300 inline-block rounded-full px-5 py-3 my-2">
            <p class="block"><strong>Jay-ar Baniqued</strong></p>
            <p class="block">This is good jsdnfjkdsfnkdn sjdn.</p>
        </div>
    </div>
    <div class="w-full mt-5">
    <hr class="mb-3">
    <form id="commentForm" onsubmit="event.preventDefault(); addComment();">
        <div class="flex">
            <input class="input input-bordered w-full" type="text" placeholder="Write a comment" name="commentOnPost" id="commentOnPost"> <!-- Corrected spelling -->
            <button type="submit" class="btn pl-5">Post</button>
        </div>
    </form>
</div>

  </div>
</dialog>



<?php include_once("../Components/userFooter.php"); ?>
<?php include_once("../Components/Footer.php"); ?>
<script src="../js/home.js"></script>