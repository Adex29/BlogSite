<div>
    <div class="container">
        <div class="row justify-content-center align-items-center mt-5">
            <div class="col-md-5 col-sm-8">
                <div class="card bg-light">
                    <div class="card-body">
                        <div id="error"></div>
                        <h4 class="card-title">Login</h4>
                        <form id="loginForm" method="post">
                            <div class="form-group mt-4">
                                <label for="email">Email</label>
                                <input type="text" name="email" id="email" class="form-control mt-2" placeholder="Enter email" required>
                            </div>
                            <div class="form-group mt-2">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password" class="form-control mt-2" placeholder="Enter password" required>
                            </div>
                            <div class="form-group text-center mt-4 d-grid gap-2">
                                <button type="submit" class="btn btn-outline-secondary">Login</button>
                                <button id="signUpBtn" class="btn btn-outline-danger" type="button">Sign Up</button>
                            </div>
                        </form>
                        <div class="d-flex align-items-center my-3">
                            <hr class="flex-grow-1">
                            <p class="mx-3 mb-0">or</p>
                            <hr class="flex-grow-1">
                        </div>


                        <div class="d-flex flex-column align-items-center mt-3">
                            <div
                                class="fb-login-button"
                                data-width="" data-size="large"
                                data-button-type="continue_with"
                                data-layout="default"
                                data-auto-logout-link="false"
                                data-use-continue-as="true"
                                onlogin="checkLoginState()"
                                scope="public_profile">
                            </div>
                            <div class="mt-2">
                                <div id="g_id_onload"
                                    data-client_id="286853462386-49vh36onqvjfej8l121pu3h90uh3pk3v.apps.googleusercontent.com"
                                    data-context="signin"
                                    data-ux_mode="popup"
                                    data-callback="handleGoogleSignIn"
                                    data-auto_prompt="false">
                                </div>

                                <div class="g_id_signin"
                                    data-type="standard"
                                    data-shape="rectangular"
                                    data-theme="outline"
                                    data-text="signin_with"
                                    data-size="large"
                                    data-logo_alignment="left">
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>