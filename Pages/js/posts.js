// Save the post
$("#postForm").on("submit", function (event) {
    event.preventDefault();
  
    var formDataArray = $(this).serializeArray();
    var formData = {};
  
    formDataArray.forEach(function (item) {
      formData[item.name] = item.value;
    });
  
    try {
      $.ajax({
        type: "POST",
        url: "../Actions/dashBoard.php",
        data: {
          data: formData,
          action: "savePost",
        },
        dataType: "json",
        success: function (response) {
          if (response.status === "success") {
            var table = $("#postsTable").DataTable();
            table.ajax.reload(null, false);
  
            // Display success alert
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
      url: "../Actions/dashBoard.php",
      data: {
        action: "getPostById",
        postId: postId,
      },
      dataType: "json",
      success: function (response) {
        if (response.status === "success") {
          const post = response.data[0];
  
          $("#postTitle").val(post.title);
          $("#postCategory").val(post.category);
          $("#postContent").val(post.summary);
          $("#postStatus").val(post.status);
  
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
  
  // Update post
  $(document).on("click", "#updatePostBtn", function () {
    const postId = $(this).data("post-id");
  
    const formDataArray = $("#postForm").serializeArray();
    let formData = {};
  
    formDataArray.forEach(function (item) {
      formData[item.name] = item.value;
    });
  
    $.ajax({
      type: "POST",
      url: "../Actions/dashBoard.php",
      data: {
        action: "updatePost",
        postId: postId,
        data: formData,
      },
      dataType: "json",
      success: function (response) {
        if (response.status === "success") {
          var table = $("#postsTable").DataTable();
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
    $("#deleteConfirmationModal").modal("show");
  });
  
  $(document).on("click", "#confirmDeleteBtn", function () {
    if (postIdToDelete) {
      $.ajax({
        type: "POST",
        url: "../Actions/dashBoard.php",
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
      $("#deleteConfirmationModal").modal("hide");
    }
  });
  
  // Reset modal on close
  $("#postModal").on("hidden.bs.modal", function () {
    $("#postForm")[0].reset();
    $("#postModalLabel").text("Create Post");
    $("#savePostBtn").css("display", "block");
    $("#updateBtnContainer").html("");
  });
  