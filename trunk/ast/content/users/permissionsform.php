<?php
/**
 * This is the Permission Form
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 * 
 */
?>
<script> var $checktree;
            $(function(){
                $checktree = $("ul.tree").checkTree({collapseAll:true});
            });</script>
<div id="validation" class="widget highlight widget-form widget-permission-form">

    <div class="widget-header">
        <h3>
            <i class="icon-pencil"></i>
            Permissions Form
        </h3>
    </div> <!-- /widget-header -->

    <div class="widget-content">
        <div id="block" class="alert alert-block">
            <a class="close" data-dismiss="alert" href="#">&times;</a>
        </div>
        <form action="#" id="permissions-form" name="permissions-form" class="permissions-form form-horizontal"
              method="post" accept-charset="UTF-8"> 
            <fieldset>
                <div class="control-group">
                    <label class="control-label">Permissions List</label>
                    <div class="controls">
                        
                        <div class="PermLinks">
                            <?php print Helper::fill_list_permission($forms['permissions']); ?>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" id="save-permissions-<?php
                            if (isset($forms)): print $forms['role_id'];
                            endif;
                            ?>" class="save btn btn-primary btn-large">Save changes</button>
                    <button type="reset" id="cancel-permissions" class="cancel btn btn-large">Cancel</button>
                </div>
            </fieldset>
        </form>

    </div> <!-- /widget-content -->

</div>