<?php
/**
 * This is the Helper
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 * 
 */
?>

<div id="validation" class="span12">

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
                        <div class="PermLinks">
                        <input type="checkbox" name="links" id="links" value="Link 1"/> Link 1 <br />
                        <input type="checkbox" name="links" id="links" value="Link 2"/> Link 2 <br />
                        <input type="checkbox" name="links" id="links" value="Link 3"/> Link 3 <br />
                        <input type="checkbox" name="links" id="links" value="Link 4"/> Link 4 <br />
                        <input type="checkbox" name="links" id="links" value="Link 5"/> Link 5 <br />
                        <input type="checkbox" name="links" id="links" value="Link 6"/> Link 6 <br />
                        <input type="checkbox" name="links" id="links" value="Link 7"/> Link 7 <br />
                        <input type="checkbox" name="links" id="links" value="Link 8"/> Link 8 <br />
                        <input type="checkbox" name="links" id="links" value="Link 9"/> Link 9 <br />
                        <input type="checkbox" name="links" id="links" value="Link 10"/> Link 10 <br />
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