document.addEventListener("DOMContentLoaded", function () {
  fetchPosts();
});

function fetchPosts() {
  $.ajax({
    type: "POST",
    url: "../Actions/posts.php",
    data: {
      action: "getPosts",
    },
    dataType: "json",
    success: function (data) {
      if (data) {
        displayPosts(data);
      } else {
        console.error("Error: " + data.message);
      }
    },
    error: function (errorData) {
      console.error(errorData);
    },
  });
}

function displayPosts(posts) {
    const postsContainer = document.getElementById("postsContainer");
    postsContainer.innerHTML = "";
  
    posts.forEach((post) => {
        if (post.statuss=== "published") {
           
            let postDiv = document.createElement("div"); // Create a new div for each post
  
            postDiv.innerHTML = `
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
              <hr class="my-3">
            `;
            postsContainer.appendChild(postDiv); // Append the new div to the container
        }

      

    });
  }
  
