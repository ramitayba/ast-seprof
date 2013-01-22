<?php
/**
 * This is the content/login
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 *
 */
?>
<div id="validation" class="widget highlight widget-form">

    <div class="account-container login">

        <div class="content clearfix">

            <form id="login-form" action="./login" method="post" class="login_form  form-horizontal"
                onClick="javascript:return validate_login();">
                <h1>Sign In</h1>

                <div class="login-fields">

                    <p>Sign in using your registered account:</p>

                    <div class="field">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" value="" placeholder="Username" class="login username-field" />
                        <p align="center" id="login_message_username" class="message"></p>
                    </div> <!-- /field -->

                    <div class="field">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" value="" placeholder="Password" class="login password-field"/>
                        <p align="center" id="login_message_password" class="message"></p>
                    </div> <!-- /password -->

                </div> <!-- /login-fields -->

                <div class="login-actions">

                   

                    <button class="button btn btn-secondary btn-large">Sign In</button>

                </div> <!-- .actions -->

            </form>

        </div> <!-- /content -->

    </div> <!-- /account-container -->
</div>