<?php
/**
 * This is the User Form
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 * 
 */
?>

<div id="validation" class="widget highlight widget-form widget-users-form">

    <div class="widget-header">	      				
        <h3>
            <i class="icon-pencil"></i>
            Register Form      					
        </h3>	
    </div> <!-- /widget-header -->

    <div class="widget-content">
        <div id="block" style="visibility:hidden;" class="alert alert-block">
            <a class="close" data-dismiss="alert" href="#">&times;</a>
        </div>
        <form action="#" id="users-form" name="users-form" class="users-form form-horizontal"
              method="post" accept-charset="UTF-8">    


            <fieldset>
                <div class="control-group">
                    <label class="control-label" for="roles">Roles</label>
                    <div class="controls">
                        <?php
                        $role = new RoleBusinessLayer();
                        $role_id = isset($forms) && array_key_exists('role_id', $forms) ? $forms['role_id'] : '';
                        print Helper::form_construct_drop_down('roles', $role->getRoles(DELETED), $role_id, 'role_name', 'role_id');
                        ?> 
                        <script>    
                            $(function() {
                                 $('#roles').trigger('change');
                            });</script>
                    </div>
                </div>
                <div class="control-group show-error">
                    <label class="control-label" for="username">Username</label>
                    <div class="controls">
                        <input type="text" class="input-large" name="user_name" id="username" maxlength="50"
                          onkeypress="return denySpace(event)"     value="<?php
                        if (isset($forms) && array_key_exists('user_name', $forms)):print $forms['user_name'];
                        endif;
                        ?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="password">Password</label>
                    <div class="controls">
                        <input type="password" class="input-large" name="user_password" id="password" maxlength="50"
                               onkeypress="return denySpace(event)"
                               value="">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="pincode">Pincode</label>
                    <div class="controls">
                        <input type="text" class="input-large" name="user_pin" id="pincode" maxlength="4"
                               value="<?php
                               if (isset($forms) && array_key_exists('user_pin', $forms)):print $forms['user_pin'];
                               endif;
                        ?>">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="employees">Employees</label>
                    <div class="controls">
                        <?php
                        $userid = isset($forms) && array_key_exists('user_id', $forms) ? $forms['user_id'] : '';
                        $array = !Helper::is_empty_string($userid) ? LookupBusinessLayer::getInstance()->getEmployeesWithActiveUser($userid, DELETED) : LookupBusinessLayer::getInstance()->getEmployeesNotHaveUsers(DELETED);
                        print Helper::form_construct_drop_down('employees', $array, isset($forms) && array_key_exists('employee_id', $forms) && !Helper::is_empty_array($forms) ? $forms['employee_id'] : '', 'employee_name', 'employee_id');
                        ?> 
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="status">Status</label>
                    <div class="controls">
                        <?php
                        print Helper::form_construct_drop_down('status', LookupBusinessLayer::getInstance()->getActivityStatus(), isset($forms) && array_key_exists('status_id', $forms) ? $forms['status_id'] : '', 'status_name', 'status_id');
                        ?> 
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" id="save-users-<?php
                        if (isset($forms)): print $forms['user_id'];
                        endif;
                        ?>" class="save btn btn-primary btn-large">Save changes</button>
                    <button type="reset" id="cancel-users" class="cancel btn btn-large">Cancel</button>
                </div>
            </fieldset>
        </form>

    </div> <!-- /widget-content -->

</div>



