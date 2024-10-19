document.addEventListener("DOMContentLoaded", function () {
  fetchPosts();
});

function checkSessionStatus(callback) {
  $.ajax({
    url: "../Components/getSession.php",
    type: "POST",
    dataType: "json",
    data: {
      action: "getSession",
    },
    success: function (data) {
      if (data.isLoggedIn) {
        console.log("User is logged in.");
        callback(true);
      } else {
        console.log("User is not logged in.");
        callback(false);
      }
    },
    error: function (xhr, status, error) {
      console.error("Error:", error);
      callback(false);
    },
  });
}

function fetchPosts() {
  $.ajax({
    type: "POST",
    url: "../Actions/posts.php",
    data: {
      action: "getPostsLikesComments",
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

$("#searchPost").keyup(function () {
  var search = $(this).val();
  if (search != "") {
    $.ajax({
      url: "../Actions/posts.php",
      method: "POST",
      data: {
        action: "searchPosts",
        value: search,
      },
      success: function (result) {
        const posts = JSON.parse(result);
        displayRecent(posts);
      },
      error: function (error) {
        console.error("Error fetching posts:", error);
      },
    });
  } else {
    loadPosts();
  }
});

function loadPosts() {
  $.ajax({
    url: "../Actions/posts.php",
    method: "POST",
    data: {
      action: "getPostsLikesComments",
    },
    success: function (result) {
      const posts = JSON.parse(result);
      displayRecent(posts);
    },
    error: function (error) {
      alert("Something went wrong.");
    },
  });
}

function displayRecent(posts) {
  const postsContainer = $("#recentPosts");
  postsContainer.empty();

  if (posts.length === 0) {
    postsContainer.append("<p>No posts found.</p>");
  }

  posts.forEach((post) => {
    if (post.status === "published") {
      const postDiv = $("<div></div>");

      const postLink = $("<a></a>")
        .attr("href", `blogPage.php?postId=${post.post_id}`)
        .html(`<h1 class="text-lg my-3">${post.title}</h1>`)
        .attr("aria-label", `Read more about ${post.title}`);

      postDiv.append(postLink);
      postsContainer.append(postDiv);
    }
  });
}

$(document).ready(function () {
  loadPosts();
});

function displayPosts(posts) {
  const postsContainer = document.getElementById("postsContainer");
  postsContainer.innerHTML = "";

  checkSessionStatus((isLoggedIn) => {
    posts.forEach((post) => {
      if (post.status === "published") {
        let postDiv = document.createElement("div");

        postDiv.innerHTML = `
          <div class="md:flex">
              <div class="w-full md:w-64 h-64 flex-shrink-0">
                  <img src="${post.img}" alt="" class="w-full h-full object-cover">
              </div>
              <div>
                  <div class="md:px-3">
                      <div class="badge badge-ghost p-3">${post.category}</div>
                  </div>
                  <div class="md:px-3 md:py-1">
                      <h1 class="text-3xl font-bold">${post.title}</h1>
                  </div>
                  <div class="flex md:px-3">
                      <h1 class="text-sm">${post.author}</h1>
                      <h1 class="text-sm font-bold px-3">.</h1>
                      <h1 class="text-sm">${post.updated_at}</h1> <!-- Date Display -->
                  </div>
                  <div class="md:px-3 md:py-1">
                      <h1 class="text-lg">${post.summary}</h1>
                  </div>
                  <div class="md:px-3 md:py-1">`;

        if (isLoggedIn) {
          console.log(isLoggedIn);
          postDiv.innerHTML += `
                      <button onclick="likePost(${post.post_id})" class="btn">Likes
                          <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
                          <div id="likeCount${post.post_id}" class="badge">${post.total_likes}</div>
                      </button>
                      <button class="btn" onclick="getComments(${post.post_id})">
                          Comments
                          <i class="fa fa-comments" aria-hidden="true"></i>
                          <div id="commentCount${post.post_id}" class="badge">${post.total_comments}</div>
                      </button>`;
        }
        postDiv.innerHTML += `
                      <button onclick="goToPost(${post.post_id})" class="btn">
                          Read More
                          <i class="fa fa-arrow-right" aria-hidden="true"></i>
                      </button>
                      <button onclick="copyToClipboard(${post.post_id})" class="btn">
                          Share
                          <i class="fa fa-share" aria-hidden="true"></i>
                      </button>
                  </div>
              </div>
          </div>
          <hr class="my-3"> <!-- Separator for posts -->
        `;
        postsContainer.appendChild(postDiv);
      }
    });
  });
}


var Post_id = 0;

function getComments(post_id) {
  CommentsModal.showModal();
  Post_id = post_id;

  $.ajax({
    type: "POST",
    url: "../Actions/comments.php",
    data: {
      action: "getComments",
      post_id: post_id,
    },
    dataType: "json",
    success: function (data) {
      if (data.status === "success") {
        displayComments(data.comments);
      } else {
        console.error("Error: " + data.message);
      }
    },
    error: function (errorData) {
      console.error(errorData);
    },
  });
}

function displayComments(comments) {
  const commentsContainer = $("#commentsContainer");
  commentsContainer.empty();

  comments.forEach(function (comment) {
    commentsContainer.append(`
          <div class="outline outline-1 outline-gray-300 inline-block rounded-full px-5 py-3 my-2">
              <p class="block"><strong>${comment.full_name}</strong></p>
              <p class="block">${comment.content}</p>
          </div>
      `);
  });

  commentsContainer.data("post_id", comments[0]?.post_id);
  console.log(commentsContainer.data("post_id"));
}


function addComment() {
  const post_id = Post_id;
  const commentText = $("#commentOnPost").val().trim();

  if (commentText === "") {
    alert("Comment cannot be empty");
    return;
  }

  $.ajax({
    type: "POST",
    url: "../Actions/comments.php",
    data: {
      action: "addComment",
      post_id: post_id,
      content: commentText,
    },
    dataType: "json",
    success: function (response) {
      if (response.status === "success") {
        // document.getElementById("CommentsModal").close();
        $("#commentsContainer").append(`
          <div class="outline outline-1 outline-gray-300 inline-block rounded-full px-5 py-3 my-2">
              <p class="block"><strong>${response.full_name}</strong></p>
              <p class="block">${$("#commentOnPost").val()}</p>
          </div>
        `);
        $("#commentOnPost").val("");
        var commentsCount = Number($(`#commentCount${post_id}`).text());
        $(`#commentCount${post_id}`).text(commentsCount + 1);
      } else {
        console.error("Error adding comment: " + response.message);
      }
    },
    error: function (errorData) {
      console.error("AJAX error: ", errorData);
    },
  });
}


document.getElementById('closeModal').addEventListener('click', hideModal);


function goToPost(post_id) {
  window.location.href = `blogPage.php?postId=${post_id}`;

}

function copyToClipboard(post_id) {
  navigator.clipboard
    .writeText(
      `http://localhost/PHP/BlogSite/Pages/User/blogPage.php?postId=${post_id}`
    )
    .then(() => {
      alert("Text copied to clipboard");
    })
    .catch((error) => {
      console.error("Error copying text to clipboard:", error);
    });
}

function likePost(post_id) {
  $.ajax({
    url: "../Actions/addLike.php",
    type: "POST",
    dataType: "json",
    data: {
      action: "addLike",
      post_id: post_id
    },
    success: function (data) {
      if (data.status === "success") {
        const likeCountElement = $(`#likeCount${post_id}`);
        const newLikeCount = Number(likeCountElement.text()) + 1;
        likeCountElement.text(newLikeCount);
      } else {
        console.error("Error:", data.message);
      }
    },
    error: function (xhr, status, error) {
      console.error("Error:", error);
    },
  });
}
