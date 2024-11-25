<div>
    <div class="container">
        <div class="row justify-content-center align-items-center mt-5">
            <div class="col-md-4">
                <div class="card bg-light">
                    <div class="card-body">
                        <div id="error"></div>
                        <h4 class="card-title">Sign Up</h4>
                        <form id="signup" method="post">
                            <div class="form-group mt-4">
                                <label for="first_name">First Name</label>
                                <input type="text" name="first_name" id="first_name" class="form-control mt-2" placeholder="Enter First Name" required>
                            </div>
                            <div class="form-group mt-2">
                                <label for="last_name">Last Name</label>
                                <input type="text" name="last_name" id="last_name" class="form-control mt-2" placeholder="Enter Last Name" required>
                            </div>
                            <div class="form-group mt-2">
                                <label for="email">Email</label>
                                <input type="email" name="email" id="email" class="form-control mt-2" placeholder="Enter email" required>
                            </div>
                            <div class="form-group mt-2">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control mt-2" placeholder="Enter password" required>
                            </div>
                            <div class="form-group mt-2">
                                <label for="confirm_password">Confirm Password</label>
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control mt-2" placeholder="Confirm password" required>
                            </div>
                            <div class="form-group text-center mt-4 d-grid gap-2">
                                <button type="submit" class="btn btn-outline-primary">Sign Up</button>
                                <button id="backToLogin" class="btn btn-outline-secondary" type="button">Back To Login</button>
                            </div>
                        </form>
                        <div class="d-flex align-items-center my-3">
                            <hr class="flex-grow-1">
                            <p class="mx-3 mb-0">or</p>
                            <hr class="flex-grow-1">
                        </div>
                        <div class="form-group text-center mt-4">
                            <!-- <button type="submit" class="btn btn-outline-primary rounded-circle social-btn">
                                <i class="fa fa-facebook" aria-hidden="true"></i>
                            </button> -->
                            <div class="fb-login-button" data-width="" data-size="large" data-button-type="continue_with" data-layout="default" data-auto-logout-link="false" data-use-continue-as="true" onlogin="checkLoginState()" scope="public_profile">></div>

                            <div id="g_id_onload"
                                data-client_id="286853462386-49vh36onqvjfej8l121pu3h90uh3pk3v.apps.googleusercontent.com"
                                data-context="signup"
                                data-ux_mode="popup"
                                data-callback="googleAuth"
                                data-auto_prompt="false">
                            </div>

                            <div class="g_id_signin"
                                data-type="icon"
                                data-shape="circle"
                                data-theme="outline"
                                data-text="signin_with"
                                data-size="large">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>