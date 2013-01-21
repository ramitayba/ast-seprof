<?php
/**
 * This is the Helper
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 * 
 */
?>

<div id="validation" class="widget highlight widget-form widget-items-form">

    <div class="widget-header">
        <h3>
            <i class="icon-pencil"></i>
            Items Form
        </h3>
    </div> <!-- /widget-header -->

    <div class="widget-content">

        <div id="block" style="visibility:hidden;" class="alert alert-block">
            <a class="close" data-dismiss="alert" href="#">&times;</a>
        </div>
        <form action="#" id="items-form" name="items-form" class="items-form form-horizontal"
              method="post" accept-charset="UTF-8"> 
            <fieldset>
                <div class="control-group">
                    <label class="control-label" for="item-name">Item Name</label>
                    <div class="controls">
                        <input type="text" class="input-large" name="item_name" id="item-name"
                               value="<?php
if (isset($forms) && !Helper::is_empty_array($forms)):print $forms['item_name'];
endif;
?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="category">Category</label>
                    <div class="controls">
                        <?php
                        $category = new CategoryBusinessLayer();
                        print Helper::form_construct_drop_down('category', $category->getCategories(), isset($forms) && !Helper::is_empty_array($forms) ? $forms['category_id'] : '', 'category_name', 'category_id');
                        ?> 
                    </div></div>
                <div class="control-group">
                    <label class="control-label" for="item-price">Price</label>
                    <div class="controls">
                        <input type="text" class="input-large" name="item_price" id="item-price"
                               value="<?php
                        if (isset($forms) && !Helper::is_empty_array($forms)):print $forms['item_price'];
                        endif;
                        ?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Photo</label>
                    <div class="controls">
                        <input type="text" class="input-large" name="item_photo" id="item-photo"
                               value="<?php
                               if (isset($forms) && !Helper::is_empty_array($forms)):print $forms['item_photo'];
                               endif;
                        ?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="item-description">Description</label>
                    <div class="controls">
                        <textarea class="input-large" name="item_description" id="item-description"
                                  value="<?php
                               if (isset($forms) && !Helper::is_empty_array($forms)):print $forms['item_description'];
                               endif;
                        ?>" />
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
                    <button type="submit" id="save-items-<?php
                        if (isset($forms)): print $forms['item_id'];
                        endif;
                        ?>" class="save btn btn-primary btn-large">Save changes</button>
                    <button type="reset" id="cancel-items" class="cancel btn btn-large">Cancel</button>
                </div>
            </fieldset>
        </form>

    </div> <!-- /widget-content -->

</div>

