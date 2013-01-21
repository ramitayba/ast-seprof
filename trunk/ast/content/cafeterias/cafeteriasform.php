<?php
/**
 * This is the Helper
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 * 
 */
?>

<div id="validation" class="widget highlight widget-form widget-cafeterias-form">

    <div class="widget-header">	      				
        <h3>
            <i class="icon-pencil"></i>
            Cafeteria Form      					
        </h3>	
    </div> <!-- /widget-header -->

    <div class="widget-content">

        <div id="block" class="alert alert-block">
            <a class="close" data-dismiss="alert" href="#">&times;</a>
        </div>
        <form action="#" id="cafeterias-form" name="cafeterias-form" class="cafeterias-form form-horizontal"
              method="post" accept-charset="UTF-8">    
            <fieldset>
                <div class="control-group">
                    <label class="control-label" for="cafeterianame">Cafeteria Name</label>
                    <div class="controls">
                        <input type="text" class="input-large" name="cafeteria_name" id="cafeterianame" value="<?php
if (isset($forms) && !Helper::is_empty_array($forms)):print $forms['cafeteria_name'];
endif;
?>">
                    </div>
                </div>
               
                <div class="form-actions">
                    <button type="submit" id="save-cafeterias-<?php
                        if (isset($forms)): print $forms['cafeteria_id'];
                        endif;
                        ?>" class="save btn btn-primary btn-large">Save changes</button>
                    <button type="reset" id="cancel-cafeterias" class="cancel btn btn-large">Cancel</button>
                </div>
            </fieldset>
        </form>

    </div> <!-- /widget-content -->

</div>

