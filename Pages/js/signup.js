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
});
