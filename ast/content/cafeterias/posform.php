<?php
/**
 * This is the Pos
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 * 
 */
?>

<div id="validation" class="widget highlight widget-form widget-pos-form">

    <div class="widget-header">
        <h3>
            <i class="icon-pencil"></i>
            Pos Form
        </h3>
    </div> <!-- /widget-header -->

    <div class="widget-content">

        <div id="block"  class="alert alert-block">
              <a class="close" data-dismiss="alert" href="#">&times;</a>
        </div>
        <form action="#" id="pos-form" name="pos-form" class="pos-form form-horizontal"
              method="post" accept-charset="UTF-8"> 
            <fieldset>
                <div class="control-group show-error">
                    <label class="control-label" for="key">Key</label>
                    <div class="controls">
                        <input type="text" class="input-large" name="pos_key" id="pos-key" maxlength="150"
                               value="<?php
if (isset($forms)&& array_key_exists('pos_key', $forms) && !Helper::is_empty_array($forms)):print $forms['pos_key'];
endif;
?>">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="cafeteria">Cafeteria</label>
                    <div class="controls">
                        <?php
                        $cafeteria = new CafeteriaBusinessLayer();
                        print Helper::form_construct_drop_down('cafeteria', $cafeteria->getCafeterias(DELETED), isset($forms) && !Helper::is_empty_array($forms) ? $forms['cafeteria_id'] : '', 'cafeteria_name', 'cafeteria_id');
                        ?> 
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="status">Status</label>
                    <div class="controls">
                        <?php
                        print Helper::form_construct_drop_down('status', LookupBusinessLayer::getInstance()->getActivityStatus(), isset($forms) && !Helper::is_empty_array($forms) ? $forms['status_id'] : '', 'status_name', 'status_id');
                        ?> 
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" id="save-pos-<?php
                        if (isset($forms)): print $forms['pos_id'];
                        endif;
                        ?>" class="save btn btn-primary btn-large">Save changes</button>
                    <button type="reset" id="cancel-pos" class="cancel btn btn-large">Cancel</button>
                </div>
            </fieldset>
        </form>

    </div> <!-- /widget-content -->

</div>

