<?php
/**
 * This is the Helper
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 * 
 */
?>

<div id="validation" class="widget highlight widget-form widget-permissions-form">

    <div class="widget-header">
        <h3>
            <i class="icon-pencil"></i>
            Permissions Form
        </h3>
    </div> <!-- /widget-header -->

    <div class="widget-content">

        <form action="#" id="permissions-form" name="permissions-form" class="permissions-form form-horizontal"
              method="post" accept-charset="UTF-8"> 
            <fieldset>
                <div class="control-group">
                    <label class="control-label">Permissions List</label>
                    <div class="controls">

                        <?php for ($i = 0; $i <= 5; $i++) { ?>

                            <p><input type="checkbox" name="links" id="links">&nbsp;
                                Link<?php echo $i; ?>
                            </p>

                        <?php }
                        ?>
                    </div>
                </div>
                div class="form-actions">
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