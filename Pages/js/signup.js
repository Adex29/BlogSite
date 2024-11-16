$(document).ready(function () {
    $("#signup").on("submit", function (event) { // Corrected form ID
        event.preventDefault();

        var formDataArray = $(this).serializeArray();
        var formData = {};

        formDataArray.forEach(function (item) {
            formData[item.name] = item.value;
        });

        formData['action'] = 'SignUp'; // Set action to SignUp

        try {
            $.ajax({
                type: "POST",
                url: "../Actions/signup.php", // URL to the sign-up PHP file
                data: formData,
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        window.location.href = response.redirectUrl; // Redirect on successful sign-up
                    } else {
                        $("#alertContainer").html(`
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error!</strong> ${response.message}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `);
                    }
                },
                error: function (data) {
                    console.error("Error during AJAX request:", data);
                    $("#alertContainer").html(`
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> There was an error processing your request. Please try again.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `);
                }
            });
        } catch (error) {
            console.error("Caught error:", error);
        }
    });

    $('#backToLogin').on('click', function () {
        window.location.href = '../User/Login.php';
    });
    


    // // Load the Google API script and initialize Google sign-in
    // window.onload = function () {
    //     gapi.load('auth2', function () {
    //         gapi.auth2.init({
    //             client_id: '#####.apps.googleusercontent.com'
    //         }).then(function () {
    //             console.log("Google API initialized successfully.");
    //         }).catch(function (error) {
    //             console.error("Google API initialization failed: ", error);
    //         });
    //     });

    //     $('#googleSignUpButton').on('click', function () {
    //         gapi.auth2.getAuthInstance().signIn().then(function (googleUser) {
    //             var profile = googleUser.getBasicProfile();
    //             var idToken = googleUser.getAuthResponse().id_token;
    //             console.log("Signed in as: " + profile.getName());
    
    //             $.ajax({
    //                 type: "POST",
    //                 url: "../Actions/signup.php",
    //                 data: {
    //                     action: "GoogleSignUp",
    //                     id_token: idToken,
    //                 },
    //                 dataType: "json",
    //                 success: function (response) {
    //                     if (response.status === "success") {
    //                         window.location.href = response.redirectUrl;
    //                     } else {
    //                         $("#alertContainer").html(`
    //                             <div class="alert alert-danger alert-dismissible fade show" role="alert">
    //                                 <strong>Error!</strong> ${response.message}
    //                                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    //                             </div>
    //                         `);
    //                     }
    //                 },
    //                 error: function (data) {
    //                     console.error("Error during AJAX request:", data);
    //                     $("#alertContainer").html(`
    //                         <div class="alert alert-danger alert-dismissible fade show" role="alert">
    //                             <strong>Error!</strong> There was an error processing your request. Please try again.
    //                             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    //                         </div>
    //                     `);
    //                 }
    //             });
    //         });
    //     });
    // };


});

function decodeJwtResponse(jwt) {
    const base64Url = jwt.split('.')[1];
    const base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/'); // Replacing URL-safe characters
    const jsonPayload = decodeURIComponent(atob(base64).split('').map(function(c) {
        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
    }).join(''));

    return JSON.parse(jsonPayload);
}

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
                window.location.href = response.redirectUrl;
            } else {
                $("#alertContainer").html(`
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> ${response.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `);
            }
        },
        error: function (data) {
            console.error("Error during AJAX request:", data);
            $("#alertContainer").html(`
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> There was an error processing your request. Please try again.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `);
        }
    });
}

