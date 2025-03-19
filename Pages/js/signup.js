$(document).ready(function () {
  $("#signup").on("submit", function (event) {
    // Corrected form ID
    event.preventDefault();

    var formDataArray = $(this).serializeArray();
    var formData = {};

    formDataArray.forEach(function (item) {
      formData[item.name] = item.value;
    });

    formData["action"] = "SignUp"; 

    try {
      $.ajax({
        type: "POST",
        url: "../Actions/signup.php",
        data: formData,
        dataType: "json",
        success: function (response) {
          if (response.status === "success") {
            window.location.href = response.redirectUrl; 
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
    } catch (error) {
      console.error("Caught error:", error);
    }
  });

  $("#backToLogin").on("click", function () {
    window.location.href = "../User/Login.php";
  });
});

function decodeJwtResponse(jwt) {
  const base64Url = jwt.split(".")[1];
  const base64 = base64Url.replace(/-/g, "+").replace(/_/g, "/");
  const jsonPayload = decodeURIComponent(
    atob(base64)
      .split("")
      .map(function (c) {
        return "%" + ("00" + c.charCodeAt(0).toString(16)).slice(-2);
      })
      .join("")
  );

  return JSON.parse(jsonPayload);
}

//Googlee
function googleAuth(response) {
  // Decode the JWT to get the user information
  const responsePayload = decodeJwtResponse(response.credential);
  console.log(responsePayload);

  // console.log("ID: " + responsePayload.sub);
  // console.log('Full Name: ' + responsePayload.name);
  // console.log('Given Name: ' + responsePayload.given_name);
  // console.log('Family Name: ' + responsePayload.family_name);
  // console.log("Image URL: " + responsePayload.picture);
  // console.log("Email: " + responsePayload.email);

  $.ajax({
    type: "POST",
    url: "../Actions/signup.php",
    data: {
      action: "GoogleSignUp",
      id_token: response.credential,
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
        }, 2000);
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
    statusChangeCallback(response, token);
  });
}

function statusChangeCallback(response , token) {
    if (response.status === 'connected') {
        FB.api('/me', {fields: 'first_name,last_name,email'}, function(response) {
            console.log(response);
            $.ajax({
                type: "POST",
                url: "../Actions/signup.php",
                data: {
                    action: "FacebookSignUp",
                    access_token: token
                },
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        $("#error").html(`
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success!</strong> ${response.message} 
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `);
                        setTimeout(function () {
                          window.location.href = response.redirectUrl;
                        }, 2000);
                    } else {
                        $("#error").html(`
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error!</strong> ${response.message}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `);
                    }
                },
                error: function(data) {
                    console.error("Error during AJAX request:", data);
                    $("#error").html(`
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> There was an error processing your request. Please try again.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `);
                },
            });
        });
    } else {
        console.log('User not authenticated');
    }
}

  
  
  
