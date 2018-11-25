<?php
    /*
     * SEGS - Super Entity Game Server
     * http://www.segs.io/
     * Copyright (c) 2006 - 2018 SEGS Team (see AUTHORS.md)
     * This software is licensed under the terms of the 3-clause BSD License. See LICENSE.md for details.
     */
?>
<div class="modal-dialog" role="document">
    <form id="modal_form_create" novalidate="novalidate" method="post" onsubmit="return doCreate();">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-lock mr-1"></i>LOGIN</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="modal_create_username">Username</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="text-addon1"><i class="fa fa-user-circle"></i></span>
                        </div>
                        <input type="text" id="modal_create_username" name="modal_create_username" class="form-control" placeholder="Enter your username" autocomplete="username" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="modal_create_password">Password</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="text-addon2"><i class="fa fa-unlock-alt"></i></span>
                        </div>
                        <input type="password" id="modal_create_password" name="modal_create_password" class="form-control" placeholder="Create your password" autocomplete="new-password" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="modal_create_verify">Password</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="text-addon3"><i class="fa fa-unlock-alt"></i></span>
                        </div>
                        <input type="password" id="modal_create_verify" name="modal_create_verify" class="form-control" placeholder="Verify your password" autocomplete="new-password" />
                    </div>
                </div>
                <div class="custom-control">
                    <input type="checkbox" class="custom-control-input" value="" id="modal_login_remember" />
                    <label for="modal_login_remember" class="custom-control-label">Remember me</label>
                </div>
                <div class="text-center">
                    <!--
                    <a class="btn btn-info" href="#forgot">Forgot your password?</a>
                    <a class="btn btn-dark " href="#login">Need to login?</a>
                    -->
                    <a class="nav-link" href="#modal-login" data-toggle="modal" data-target="#modal-login">
                        <i class="fa fa-sign-in"></i>Need to register?
                    </a>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
                <button type="submit" class="btn btn-primary">CREATE ACCOUNT</button>
            </div>
        </div>
    </form>
</div>
