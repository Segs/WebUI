<?php
    /*
     * SEGS - Super Entity Game Server
     * http://www.segs.io/
     * Copyright (c) 2006 - 2019 SEGS Team (see AUTHORS.md)
     * This software is licensed under the terms of the 3-clause BSD License. See LICENSE.md for details.
     */

    if(!empty($_POST))
    {
        // TODO: Figure out what I meant to do here.
    }
    
?>
<div class="modal-dialog" role="document">
    <form id="modal_form_login" novalidate="novalidate" method="post" onsubmit="return doLogin();">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-lock mr-1"></i>LOGIN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="modal_login_username">Username</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="text-addon1"><i class="fa fa-user-circle"></i></span>
                        </div>
                        <input type="text" id="modal_login_username" name="modal_login_username" class="form-control" placeholder="Enter your username" autocomplete="username" />
                    </div>
                </div>
                <!-- Not collecting email
                <div class="form-group">
                    <label for="modal_login_email">Email address</label>
                    <div class="input-group"><span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                        <input type="email" id="modal_login_email" name="modal_login_email" class="form-control" placeholder="Enter your email" />
                    </div>
                    <small class="form-text text-muted">We'll never share your email with anyone else.</small>
                </div>
                -->
                <div class="form-group">
                    <label for="modal_login_password">Password</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="text-addon2"><i class="fa fa-unlock-alt"></i></span>
                        </div>
                        <input type="password" id="modal_login_password" name="modal_login_password" class="form-control" placeholder="Enter your password" autocomplete="current-password" />
                    </div>
                </div>
                <div class="custom-control">
                    <input type="checkbox" class="custom-control-input" value="" id="modal_login_remember" />
                    <label for="modal_login_remember" class="custom-control-label">Remember me</label>
                </div>
                <div class="text-center">
                    <a class="btn btn-info" href="?page=reset">Forgot your password?</a>
                    <a class="btn btn-dark " href="?page=register">Need to register?</a>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
                <button type="submit" class="btn btn-primary">SIGN-IN</button>
            </div>
        </div>
    </form>
</div>
