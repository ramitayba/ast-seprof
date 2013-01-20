<?php
/**
 * This is the Helper
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 * 
 */
?>

<div id="validation" class="widget highlight widget-form widget-roles-form">

    <div class="widget-header">	      				
        <h3>
            <i class="icon-pencil"></i>
            Roles Form      					
        </h3>	
    </div> <!-- /widget-header -->

    <div class="widget-content">
        <div id="block" style="visibility:hidden;" class="alert alert-block">
              <a class="close" data-dismiss="alert" href="#">&times;</a>
        </div>
        <form action="#" id="roles-form" name="roles-form" class="roles-form form-horizontal"
             method="post" accept-charset="UTF-8">    
            <fieldset>
                <div class="control-group">
                    <label class="control-label" for="role-name">Role Name</label>
                    <div class="controls">
                        <input type="text" class="input-large" name="role_name" id="role_name" value="<?php
if (isset($forms) && !Helper::is_empty_array($forms)):print $forms['role_name'];
endif;
?>">
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" id="save-roles-<?php
if (isset($forms)): print $forms['role_id'];
endif;
?>" class="save btn btn-primary btn-large">Save changes</button>
                    <button type="reset" id="cancel-roles" class="cancel btn btn-large">Cancel</button>
                </div>
            </fieldset>
        </form>

    </div> <!-- /widget-content -->

</div>
