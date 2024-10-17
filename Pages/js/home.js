document.addEventListener("DOMContentLoaded", function () {
  fetchPosts();
  checkSessionStatus();
});

var isLoggedIn = false;

function checkSessionStatus() {
  $.ajax({
    url: '../Actions/session.php',
    type: 'POST',
    dataType: 'json',
    data: {
      action: 'getSession',
    },
    success: function (data) {
      if (data.isLoggedIn) {
        console.log("User is logged in.");
        console.log("Email:", data.email);
        isLoggedIn = true;
      } else {
        console.log("User is not logged in.");
        isLoggedIn = false;
      }
    },
    error: function (xhr, status, error) {
      console.error('Error:', error);
    }
  });
}



console.log(isLoggedIn);

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

function displayPosts(posts) {
  const postsContainer = document.getElementById("postsContainer");
  postsContainer.innerHTML = '';


  
  

  posts.forEach((post) => {
    if (post.status === "published") {
      let postDiv = document.createElement("div"); // Create a new div for each post

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
                          <h1 class="text-sm">Jay-ar Baniqued</h1>
                          <h1 class="text-sm font-bold px-3">.</h1>
                          <h1 class="text-sm">Oct 24, 2024</h1>
                      </div>
                      <div class="md:px-3 md:py-1">
                          <h1 class="text-lg">${post.summary}</h1>
                      </div>
                      <div class="md:px-3 md:py-1">
                          

                            <button class="btn">Likes
                                <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
                                <div class="badge">${post.total_likes}</div>
                            </button>
                          
                            <button class="btn" onclick="getComments(${post.post_id})">
                                Comments
                                <i class="fa fa-comments" aria-hidden="true"></i>
                                <div class="badge">${post.total_comments}</div>
                            </button>
              
                          
                   
                          
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
              <hr class="my-3">
            `;
      postsContainer.appendChild(postDiv); // Append the new div to the container
    }
  });
}


function getComments(post_id) {

  CommentsModal.showModal();
  

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

  commentsContainer.data('post_id', comments[0]?.post_id); 
}


// Function to add a new comment
function addComment() {
  const commentsContainer = $("#commentsContainer");
  const post_id = commentsContainer.data('post_id'); 
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
          content: commentText, // The comment text to be added
      },
      dataType: "json",
      success: function (response) {
          if (response.status === "success") {
              displayComments(response.comments); // Update comments display with the new comment
              $("#commentOnPost").val(""); // Clear the input field
          } else {
              console.error("Error adding comment: " + response.message); // Log error if the response is not successful
          }
      },
      error: function (errorData) {
          console.error("AJAX error: ", errorData); // Log any AJAX errors
      },
  });
}




function goToPost(post_id) {
  window.location.href = `blogPage.php?postId=${post_id}`;
//   http://localhost/PHP/BlogSite/Pages/User/blogPage.php?postId=15
}

function copyToClipboard(post_id) {
  navigator.clipboard
    .writeText(`http://localhost/PHP/BlogSite/Pages/User/blogPage.php?postId=${post_id}`)
    .then(() => {
      alert("Text copied to clipboard");
    })
    .catch((error) => {
      console.error("Error copying text to clipboard:", error);
    });
  }


// function isLoggedIn() {
//   // This could be replaced by an actual AJAX call to check session status.
//   return !!sessionStorage.getItem("loggedIn"); // Assume you set 'loggedIn' in sessionStorage upon login.
// }
// sessionStorage.setItem("loggedIn", true);
// console.log(isLoggedIn());

// function displayComments(comments) {
//   const commentsContainer = document.getElementById("commentsContainer");
//   commentsContainer.innerHTML = "";

//   comments.forEach((comment) => {
//     let commentDiv = document.createElement("div");
//     commentDiv.innerHTML = `