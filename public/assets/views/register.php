<?php
require '../vendor/autoload.php';
require '../config/config.php';
?>
<div class="card">
    <div class="card-header card-header-<?php echo $site_color; ?>">
        <h4 class="card-title ">Register</h4>
        <p class="card-category">Fill out the form below to register for a new account.</p>
    </div>
    <div class="card-body">
        <div class="container">
            <div class="row">
                <div class="col-7">
                    <form id="form_register" novalidate="novalidate" method="post" onsubmit="return doSignup();">
                        <div class="form-group">
                            <label for="desired_username">Username</label>
                            <input type="text" class="form-control" id="desired_username" aria-describedby="usernameHelp" placeholder="Enter desired username" onBlur="checkUsername(<?php echo $min_username_len; ?>)" required>
                        </div>
                        <p><span id="user-availability-status"></span><img src="/assets/img/LoaderIcon.gif" id="loaderIcon" style="display:none" /></p>
                        <div class="form-group">
                            <label for="password1">Password</label>
                            <input type="password" class="form-control" id="password1" placeholder="Enter your password" required onBlur="checkPasswords()">
                        </div>
                        <div class="form-group">
                            <label for="password2">Confimation Password</label>
                            <input type="password" class="form-control" id="password2" placeholder="Confim your password" required onChange="checkPasswords()">
                        </div>
                        <!--
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Check me out</label>
                        </div>
                        -->
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="col-5">
                    <!--
                    <div id="alert-username" class="alert alert-light"><i class="fas fa-check-square-o"></i> Username is unique</div>
                    -->
                    <div class="list-group">
                        <div id="username-requirements"                  class="list-group-item py-0"><i id="icon-username-requirements"                class="far fa-square"></i> Username requirements:
                            <div class="list-group">
                                <div id="username-requirements-unique"   class="list-group-item py-0"><i id="icon-username-requirements-unique"                class="far fa-square"></i> ...is unique</div>
                                <div id="username-requirements-length"   class="list-group-item py-0"><i id="icon-username-requirements-length"                class="far fa-square"></i> ...is longer that 6 characters</div>
                            </div>
                        </div>
                        <div id="passwords-match"                        class="list-group-item py-0"><i id="icon-passwords-match"                class="far fa-square"></i> Passwords match</div>
                        <div id="password-complex"                       class="list-group-item py-0"><i id="icon-password-complex"               class="far fa-square"></i> Password requirements:
                            <div class="list-group">
                                <div id="password-complex-not-username"  class="list-group-item py-0"><i id="icon-password-complex-not-username"  class="far fa-square"></i> ...is not the same as the username</div>
                                <div id="password-complex-length"        class="list-group-item py-0"><i id="icon-password-complex-length"        class="far fa-square"></i> ...meets length requirement</div>
                                <div id="password-complex-special"       class="list-group-item py-0"><i id="icon-password-complex-special"       class="far fa-square"></i> ...meets character requirements</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.passprotect.io/passprotect.min.js"></script>