//Save the user
$('#userForm').on('submit', function (event) {
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
                action: "saveUser"
            },
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    var table = $('#usersTable').DataTable();
                    table.ajax.reload(null, false);

                    // Display success alert
                    $('#alertContainer').html(`
                        <div class="alert alert-success alert-dismissible fade show position-absolute w-100" role="alert">
                            <strong>Success!</strong> ${response.message}. User ID: ${response.userId}.
                        </div>
                    `);
                    setTimeout(function () {
                        $('#alertContainer').html('');
                    }, 3000);
                    $('#userModal').modal('hide');
                    $('#userForm')[0].reset();
                } else {
                    console.error("Error: " + response.message);
                }
            },
            error: function (data) {
                console.error(data);
            }
        });
    } catch (error) {
        console.error(error);
    }
});


let userIdToDelete = null;
$(document).on('click', '.deleteUserBtn', function () {
    console.log('deleteUserBtn clicked');
    userIdToDelete = $(this).data('user-id');
    $('#deleteConfirmationModal').modal('show');
});

$(document).on('click', '#confirmDeleteBtn', function () {
    if (userIdToDelete) {
        $.ajax({
            type: 'POST',
            url: '../Actions/dashBoard.php',
            data: {
                action: 'deleteUser',
                userId: userIdToDelete
            },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    const table = $('#usersTable').DataTable();
                    table.ajax.reload(null, false);
                } else {
                    console.error(`Error: ${response.message}`);
                }
            },
            error: function (errorData) {
                console.error(errorData.responseText);
            }
        });
        $('#deleteConfirmationModal').modal('hide');
    }
});

  // Handle edit button click
  $(document).on('click', '.editUserBtn', function () {
    const userId = $(this).data('user-id');
    console.log(userId);

    // Fetch the user data by ID (assuming you have an endpoint to fetch user data)
    $.ajax({
      type: "POST",
      url: "../Actions/dashBoard.php",
      data: {
        action: "getUserById",
        userId: userId
    },
      dataType: "json",
      success: function (response) {
        if (response.status === "success") {
          const user = response.data;
          console.log(user);

          // Populate the modal with the user data
          $('#first_name').val(user.first_name);
          $('#last_name').val(user.last_name);
          $('#role').val(user.role);
          $('#email').val(user.email);
          $('#password').val(""); // Clear password

          // Change modal title to "Edit User"
          $('.modal-title').text('Edit User');

          // Show the Update button and hide Save button
          $('#updateBtnContainer').html(`
            <button type="button" class="btn btn-primary" id="updateUserBtn" data-user-id="${user.id}">Update</button>
          `);

          // Open the modal
          $('#userModal').modal('show');
        } else {
          console.error("Error fetching user data: " + response.message);
        }
      },
      error: function (xhr, status, error) {
        console.error("AJAX error: " + error);
      }
    });
  });

  // Handle update button click
  $(document).on('click', '#updateUserBtn', function () {
    const userId = $(this).data('user-id');
    
    // Serialize form data
    const formDataArray = $('#userForm').serializeArray();
    let formData = {};

    formDataArray.forEach(function (item) {
      formData[item.name] = item.value;
    });

    // Send AJAX request to update user
    $.ajax({
      type: "POST",
      url: "../Actions/dashBoard.php",
      data: {
        action: "updateUser",
        userId: userId,
        data: formData
      },
      dataType: "json",
      success: function (response) {
        if (response.status === "success") {
          var table = $('#usersTable').DataTable();
          table.ajax.reload(null, false); // Reload DataTable
          
          // Show success alert
          $('#alertContainer').html(`
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong>Success!</strong> User updated successfully.
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          `);

          // Hide modal and reset form
          $('#userModal').modal('hide');
          $('#userForm')[0].reset();
        } else {
          console.error("Error updating user: " + response.message);
        }
      },
      error: function (xhr, status, error) {
        console.error("AJAX error: " + error);
      }
    });
  });

  // Clear the modal when closed or switching to adding a new user
  $('#userModal').on('hidden.bs.modal', function () {
    $('#userForm')[0].reset(); // Reset the form
    $('.modal-title').text('Add User'); // Reset modal title
    $('#updateBtnContainer').html(''); // Clear update button
  });


