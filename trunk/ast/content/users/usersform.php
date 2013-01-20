<?php
/**
 * This is the Helper
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
                    <label class="control-label" for="username">Username</label>
                    <div class="controls">
                        <input type="text" class="input-large" name="user_name" id="username"
         value="<?php if (isset($forms) && !Helper::is_empty_array($forms)):print $forms['user_name'];
endif;
?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="password">Password</label>
                    <div class="controls">
                        <input type="password" class="input-large" name="user_password" id="password"
                               value="<?php if (isset($forms) && !Helper::is_empty_array($forms)):print $forms['user_password'];
                               endif;
?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="pincode">Pincode</label>
                    <div class="controls">
                        <input type="text" class="input-large" name="user_pin" id="pincode"
                               value="<?php if (isset($forms) && !Helper::is_empty_array($forms)):print $forms['user_pin'];
                               endif;
?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="roles">Roles</label>
                    <div class="controls">
                        <?php
                        $role = new RoleBusinessLayer();
                        print Helper::form_construct_drop_down('roles', $role->getRoles(), isset($forms) && !Helper::is_empty_array($forms) ? $forms['role_id'] : '', 'role_name','role_id');
                        ?> 
                    </div>
                </div>
                    <div class="control-group">
                        <label class="control-label" for="employees">Employees</label>
                        <div class="controls">
<?php
print Helper::form_construct_drop_down('employees', LookupBusinessLayer::getInstance()->getEmployees(), isset($forms) && !Helper::is_empty_array($forms) ? $forms['employee_id'] : '', 'employee_name','employee_id');
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



