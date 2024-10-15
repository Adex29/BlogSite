document.addEventListener("DOMContentLoaded", function () {
  
})

const endpoint = "../Actions/Posts.php";

// Initialize Quill editor
const postContent = new Quill("#postContentContainer", {
  theme: "snow",
  modules: {
    toolbar: [
      [{ header: [1, 2, 3, false] }],
      ["bold", "italic", "underline", "strike"],
      [{ list: "ordered" }, { list: "bullet" }],
      ["blockquote", "code-block"],
      [{ script: "sub" }, { script: "super" }],
      [{ indent: "-1" }, { indent: "+1" }],
      [{ direction: "rtl" }],
      [{ color: [] }, { background: [] }],
      [{ align: [] }],
      ["link", "image", "video"],
      ["clean"],
    ],
  },
});

// Save the post

$("#postForm").on("submit", function (event) {
  event.preventDefault();

  var formData = new FormData(this);
  formData.append("action", "savePost");
  
  // Get the content from Quill editor
  const content = postContent.root.innerHTML;
  
  // Check if there's any content before appending
  if (postContent.getLength() > 1) {
    formData.append("content", content);
  }
  
  try {
    $.ajax({
      type: "POST",
      url: "../Actions/posts.php",
      data: formData,
      contentType: false, // Important to tell jQuery not to process the data
      processData: false, // Important to tell jQuery not to convert the FormData object into a string
      dataType: "json",
      success: function (response) {
        if (response.status === "success") {
          var table = $("#postsTable").DataTable();
          table.ajax.reload(null, false);

          $("#alertContainer").html(`
            <div class="alert alert-success alert-dismissible fade show position-absolute w-100" role="alert">
              <strong>Success!</strong> ${response.message}. Post ID: ${response.postId}.
            </div>
          `);
          setTimeout(function () {
            $("#alertContainer").html("");
          }, 3000);
          $("#postModal").modal("hide");
          $("#postForm")[0].reset();
        } else {
          console.error("Error: " + response.message);
        }
      },
      error: function (data) {
        console.error(data);
      },
    });
  } catch (error) {
    console.error(error);
  }
});


  
  // Handle edit post
  $(document).on("click", ".editPostBtn", function () {
    const postId = $(this).data("post-id");
  
    $.ajax({
      type: "POST",
      url: endpoint,
      data: {
        action: "getPostById",
        postId: postId,
      },
      dataType: "json",
      success: function (response) {
        if (response.status === "success") {
          const post = response.data[0];
  
          $("#title").val(post.title);
          $("#category").val(post.category);
          $("#content").val(post.summary);
          $("#status").val(post.status);
          $("#summary").val(post.summary);
          postContent.root.innerHTML = post.content;
  
          $("#postModalLabel").text("Edit Post");
          $("#savePostBtn").hide();
  
          $("#updateBtnContainer").html(`
            <button type="button" class="btn btn-primary" id="updatePostBtn" data-post-id="${post.id}">Update</button>
          `);
  
          $("#postModal").modal("show");
        } else {
          console.error("Error fetching post data: " + response.message);
        }
      },
      error: function (xhr, status, error) {
        console.error("AJAX error: " + error);
      },
    });
  });
  
  $(document).on("click", "#updatePostBtn", function () {
    const postId = $(this).data("post-id");
  
    let formData = new FormData($("#postForm")[0]); 
    formData.append("action", "updatePost");
    formData.append("postId", postId);
  
    const content = postContent.root.innerHTML;
    if (postContent.getLength() > 1) {
      formData.append("content", content);
    }
  
    $.ajax({
      type: "POST",
      url: endpoint,
      data: formData,
      contentType: false, // Prevent jQuery from automatically setting the content type
      processData: false, // Prevent jQuery from processing the data into a query string
      dataType: "json",
      success: function (response) {
        if (response.status === "success") {
          // Reload the table with updated data
          var table = $("#postsTable").DataTable();
          table.ajax.reload(null, false);
  
          // Display success message
          $("#alertContainer").html(`
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong>Success!</strong> ${response.message}.
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          `);
  
          // Clear the alert after a few seconds
          setTimeout(function () {
            $("#alertContainer").html("");
          }, 3000);
  
          // Close the modal and reset the form
          $("#postModal").modal("hide");
          $("#postForm")[0].reset();
        } else {
          console.error("Error updating post: " + response.message);
        }
      },
      error: function (xhr, status, error) {
        console.error("AJAX error: " + error);
      },
    });
  });
  
  
  // Handle delete post
  let postIdToDelete = null;
  $(document).on("click", ".deletePostBtn", function () {
    postIdToDelete = $(this).data("post-id");
    $("#deletePostConfirmationModal").modal("show");
  });
  
  $(document).on("click", "#confirmDeletePostBtn", function () {
    if (postIdToDelete) {
      $.ajax({
        type: "POST",
        url: endpoint,
        data: {
          action: "deletePost",
          postId: postIdToDelete,
        },
        dataType: "json",
        success: function (response) {
          if (response.status === "success") {
            const table = $("#postsTable").DataTable();
            table.ajax.reload(null, false);
            $("#alertContainer").html(`
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> ${response.message}.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            `);
            setTimeout(function () {
              $("#alertContainer").html("");
            }, 3000);
          } else {
            console.error(`Error: ${response.message}`);
          }
        },
        error: function (errorData) {
          console.error(errorData.responseText);
        },
      });
      $("#deletePostConfirmationModal").modal("hide");
    }
  });
  
  // Reset modal on close
  $("#postModal").on("hidden.bs.modal", function () {
    $("#postForm")[0].reset();
    $("#postModalLabel").text("Create Post");
    $("#savePostBtn").css("display", "block");
    $("#updateBtnContainer").html("");
    postContent.setText('');
  });
  