<?php
/**
 * This is the Helper
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 * 
 */
?>

<div id="validation" class="widget highlight widget-form widget-eventitems-form">
    <div class="widget-header">
        <h3>
            <i class="icon-pencil"></i>
            Event Items Form
        </h3>
    </div> <!-- /widget-header -->

    <div class="widget-content">
        <div id="block"  class="alert alert-block">
            <a class="close" data-dismiss="alert" href="#">&times;</a>
        </div>
        <form action="#" id="eventitems-form" name="eventitems-form" class="eventitems-form form-horizontal"
              method="post" accept-charset="UTF-8">
            <fieldset>               
                <div class="control-group">
                    <label class="control-label" for="item">Item Name</label>
                    <div class="controls">
                        <?php
                        $item = new ItemBusinessLayer();
                        print Helper::form_construct_drop_down('item', $item->getItems(), isset($forms) && !Helper::is_empty_array($forms) ? $forms['item_id'] : '', 'item_name', 'item_id');
                        ?> 
                    </div>
                </div>              
               
                 <div class="control-group">
                    <label class="control-label" for="item-quantity">Item Quantity</label>
                    <div class="controls">
                        <input type="text" class="input-large" name="item_quantity" id="item_quantity" onkeypress="return isNumberKey(event)"
                               value="<?php
                               if (isset($forms) && !Helper::is_empty_array($forms)):print $forms['item_quantity'];
                               endif;
                        ?>" >
                    </div>
                </div>
                <div class="form-actions">
                     <input type="hidden" name="event_id"  value="<?php
                               if (isset($forms) && !Helper::is_empty_array($forms)):print $forms['event_id'];
                               endif;
                        ?>" >
                    <button type="submit" id="save-eventitems-<?php
                        if (isset($forms)): print $forms['event_item_id'];
                        endif;
                        ?>"
                            class="save btn btn-primary btn-large">Save changes</button>
                    <button type="reset" id="cancel-eventitems" class="cancel btn btn-large">Cancel</button>
                </div>
            </fieldset>
        </form>

    </div> <!-- /widget-content -->
</div>

