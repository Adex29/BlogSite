//Save the user
$("#userForm").on("submit", function (event) {
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
        action: "saveUser",
      },
      dataType: "json",
      success: function (response) {
        if (response.status === "success") {
          var table = $("#usersTable").DataTable();
          table.ajax.reload(null, false);

          // Display success alert
          $("#alertContainer").html(`
                        <div class="alert alert-success alert-dismissible fade show position-absolute w-100" role="alert">
                            <strong>Success!</strong> ${response.message}. User ID: ${response.userId}.
                        </div>
                    `);
          setTimeout(function () {
            $("#alertContainer").html("");
          }, 3000);
          $("#userModal").modal("hide");
          $("#userForm")[0].reset();
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

let userIdToDelete = null;
$(document).on("click", ".deleteUserBtn", function () {
  console.log("deleteUserBtn clicked");
  userIdToDelete = $(this).data("user-id");
  $("#deleteConfirmationModal").modal("show");
});

$(document).on("click", "#confirmDeleteBtn", function () {
  if (userIdToDelete) {
    $.ajax({
      type: "POST",
      url: "../Actions/dashBoard.php",
      data: {
        action: "deleteUser",
        userId: userIdToDelete,
      },
      dataType: "json",
      success: function (response) {
        if (response.status === "success") {
          const table = $("#usersTable").DataTable();
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


$(document).on("click", ".editUserBtn", function () {
  const userId = $(this).data("user-id");
  console.log(userId);

  $.ajax({
    type: "POST",
    url: "../Actions/dashBoard.php",
    data: {
      action: "getUserById",
      userId: userId,
    },
    dataType: "json",
    success: function (response) {
      if (response.status === "success") {
        const user = response.data[0];
        console.log(user);

        $("#first_name").val(user.first_name);
        $("#last_name").val(user.last_name);
        $("#role").val(user.role);
        $("#email").val(user.email);
        $("#password").val(user.password);

        $("#userModalLabel").text("Edit User");
        $("#saveUserBtn").hide();

        $("#updateBtnContainer").html(`
            <button type="button" class="btn btn-primary" id="updateUserBtn" data-user-id="${user.id}">Update</button>
          `);

        $("#userModal").modal("show");
      } else {
        console.error("Error fetching user data: " + response.message);
      }
    },
    error: function (xhr, status, error) {
      console.error("AJAX error: " + error);
    },
  });
});


$(document).on("click", "#updateUserBtn", function () {
  const userId = $(this).data("user-id");

  const formDataArray = $("#userForm").serializeArray();
  let formData = {};

  formDataArray.forEach(function (item) {
    formData[item.name] = item.value;
  });


  $.ajax({
    type: "POST",
    url: "../Actions/dashBoard.php",
    data: {
      action: "updateUser",
      userId: userId,
      data: formData,
    },
    dataType: "json",
    success: function (response) {
      if (response.status === "success") {
        var table = $("#usersTable").DataTable();
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

        $("#userModal").modal("hide");
        $("#userForm")[0].reset();
      } else {
        console.error("Error updating user: " + response.message);
      }
    },
    error: function (xhr, status, error) {
      console.error("AJAX error: " + error);
    },
  });
});


$("#userModal").on("hidden.bs.modal", function () {
  $("#userForm")[0].reset();
  $("#userModalLabel").text("Add User");
  $("#saveUserBtn").css("display", "block");
  $("#updateBtnContainer").html("");
});
