<?php
    /*
     * SEGS - Super Entity Game Server
     * http://www.segs.io/
     * Copyright (c) 2006 - 2018 SEGS Team (see AUTHORS.md)
     * This software is licensed under the terms of the 3-clause BSD License. See LICENSE.md for details.
     */
    require '../vendor/autoload.php';
    require '../config/config.php';
    
    $page_title = "Register";
    $page_summary = "Fill out the form below to register for a new account.";

    require "partials/page_top.php";
?>
            <form id="form_register" novalidate="novalidate" method="post" onsubmit="return doSignup();">
                <div class="row">
                    <div class="col-lg-7 col-md-12">
                            <div class="form-group">
                                <label for="desired_username">Username</label>
                                <input type="text" class="form-control" id="desired_username" aria-describedby="usernameHelp" placeholder="Enter desired username" onBlur="checkUsername(<?php echo $min_username_len; ?>)" required>
                            </div>
                            <p><span id="user-availability-status"></span><img src="/assets/img/LoaderIcon.gif" id="loaderIcon" style="display:none" /></p>
                            <div class="form-group">
                                <label for="password1">Password</label>
                                <input type="password" class="form-control" id="password1" placeholder="Enter your password" required onBlur="checkPasswords(<?php echo $min_password_len; ?>, <?php echo $complex_password; ?>)">
                            </div>
                            <div class="form-group">
                                <label for="password2">Confimation Password</label>
                                <input type="password" class="form-control" id="password2" placeholder="Confim your password" required onChange="checkPasswords(<?php echo $min_password_len; ?>, <?php echo $complex_password; ?>)">
                            </div>
                            <!--
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label" for="exampleCheck1">Check me out</label>
                            </div>
                            -->
                    </div>
                    <div class="w-100 d-lg-none d-sm-block"></div>
                    <div class="col-lg-5 col-md-12">
                        <!--
                        <div id="alert-username" class="alert alert-light"><i class="fas fa-check-square-o"></i> Username is unique</div>
                        -->
                        <div class="list-group">
                            <div id="username-requirements" class="list-group-item py-0"><i id="icon-username-requirements" class="far fa-square"></i> Username requirements:
                                <div class="list-group">
                                    <div id="username-requirements-unique" class="list-group-item py-0"><i id="icon-username-requirements-unique" class="far fa-square"></i> ...is unique.</div>
                                    <?php if($min_username_len > 1) { ?>
                                    <div id="username-requirements-length" class="list-group-item py-0"><i id="icon-username-requirements-length" class="far fa-square"></i> ...is equal to or longer than <?php echo $min_username_len; ?> characters.</div>
                                    <?php } ?>
                                </div>
                            </div>
                            <div id="passwords-match" class="list-group-item py-0"><i id="icon-passwords-match" class="far fa-square"></i> Passwords match</div>
                            <div id="password-complex" class="list-group-item py-0"><i id="icon-password-complex" class="far fa-square"></i> Password requirements:
                                <div class="list-group">
                                    <div id="password-complex-not-username" class="list-group-item py-0"><i id="icon-password-complex-not-username"  class="far fa-square"></i> ...is not the same as the username.</div>
                                    <?php if($min_password_len > 1) { ?>
                                    <div id="password-complex-length" class="list-group-item py-0"><i id="icon-password-complex-length" class="far fa-square"></i> ...is equal to or longer than <?php echo $min_password_len; ?> characters.</div>
                                    <?php } ?>
                                    <?php if($complex_password) { ?>
                                    <div id="password-complex-special" class="list-group-item py-0"><i id="icon-password-complex-special" class="far fa-square"></i> ...meets character requirements.</div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
<?php require_once "partials/page_bottom.php"; ?>

<?php if($warn_pwned_password) { ?>
<script src="https://cdn.passprotect.io/passprotect.min.js"></script>
<?php } ?>