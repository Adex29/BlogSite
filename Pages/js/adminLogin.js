$(document).ready(function () {
  $("#loginForm").on("submit", function (event) {
    event.preventDefault();

    var formDataArray = $(this).serializeArray();
    var formData = {};

    formDataArray.forEach(function (item) {
      formData[item.name] = item.value;
    });

    formData["action"] = "Authenticate";

    try {
      $.ajax({
        type: "POST",
        url: "../Actions/adminLogin.php",
        data: formData,
        dataType: "json",
        success: function (response) {
          if (response.status === "success") {
            window.location.href = response.redirectUrl;
          } else if (response.status === "error") {
            $("#error").html(`
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error!</strong> ${response.message}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `);
          } else {
            $("#error").html(`
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error!</strong> An unexpected error occurred. Please try again.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `);
          }
        },

        error: function (jqXHR, textStatus, errorThrown) {
          console.error(
            "AJAX Error:",
            textStatus,
            errorThrown,
            jqXHR.responseText
          );
          $("#error").html(`
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> There was an error processing your request. Please try again.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `);
        },
      });
    } catch (error) {
      console.error("Caught error:", error);
    }
  });

  $("#signUpBtn").on("click", function () {
    window.location.href = "../User/SignUp.php";
  });
});

// Google
function handleGoogleSignIn(response) {
  const idToken = response.credential;

  $.ajax({
    type: "POST",
    url: "../Actions/adminLogin.php",
    data: { idToken },
    dataType: "json",
    success: function (response) {
      if (response.status === "success") {
        $("#error").html(`
          <div class="alert alert-success alert-dismissible fade show" role="alert">
              <strong>Success!</strong> ${response.message} 
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
      `);
        setTimeout(function () {
          window.location.href = response.redirectUrl;
        }, 3000);
      } else {
        $("#error").html(`
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> ${response.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `);
      }
    },
    error: function (data) {
      console.error("Error during AJAX request:", data);
      $("#error").html(`
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> There was an error processing your request. Please try again.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `);
    },
  });
}

// Facebook
window.fbAsyncInit = function () {
  FB.init({
    appId: "579297461342760",
    cookie: true,
    xfbml: true,
    version: "v18.0",
  });

  FB.AppEvents.logPageView();
};

function checkLoginState() {
  FB.getLoginStatus(function (response) {
    var token = response.authResponse.accessToken;
    loginFacebook(response, token);
  });
}

function loginFacebook(response, token) {
  if (response.status === "connected") {
    FB.api(
      "/me",
      { fields: "first_name,last_name,email" },
      function (response) {
        console.log(response);
        $.ajax({
          type: "POST",
          url: "../Actions/adminLogin.php",
          data: {
            action: "FacebookSignIn",
            access_token: token,
          },
          dataType: "json",
          success: function (response) {
            if (response.status === "success") {
              $("#error").html(`
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success!</strong> ${response.message} 
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `);
              setTimeout(function () {
                window.location.href = response.redirectUrl;
              }, 3000);
            } else {
              $("#error").html(`
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error!</strong> ${response.message}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `);
            }
          },
          error: function (data) {
            console.error("Error during AJAX request:", data);
            $("#error").html(`
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> There was an error processing your request. Please try again.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `);
          },
        });
      }
    );
  } else {
    console.log("User not authenticated");
  }
}
