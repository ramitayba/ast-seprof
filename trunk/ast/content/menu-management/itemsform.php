<?php
/**
 * This is the Items Form
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 * 
 */
?>
<script>

    $(document).ready( function () {

        maxLength = $("textarea#comment").attr("maxlength");
        $("textarea#comment").after("<div><span id='remainingLengthTempId'>"
            + maxLength + "</span> remaining</div>");

        $("textarea#comment").bind("keyup change", function(){checkMaxLength(this.id,  maxLength); } )

    });
</script>

<div id="validation" class="widget highlight widget-form widget-items-form">

    <div class="widget-header">
        <h3>
            <i class="icon-pencil"></i>
            Items Form
        </h3>
    </div> <!-- /widget-header -->

    <div class="widget-content">

        <div id="block"  class="alert alert-block">
            <a class="close" data-dismiss="alert" href="#">&times;</a>
        </div>
        <form action="#" id="items-form" name="items-form" class="items-form form-horizontal"
              method="post" accept-charset="UTF-8"> 
            <fieldset>
                <div class="control-group show-error">
                    <label class="control-label" for="item-name">Item Name</label>
                    <div class="controls">
                        <input type="text" class="input-large" name="item_name" id="item-name"
                               maxlength="100"       value="<?php
if (isset($forms) && array_key_exists('item_name', $forms)):print $forms['item_name'];
endif;
?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="category">Category</label>
                    <div class="controls">
                        <?php
                        $category = new CategoryBusinessLayer();
                        print Helper::form_construct_drop_down('category', $category->getCategoriesForItems(DELETED), isset($forms)&& array_key_exists('category_id', $forms) ? $forms['category_id'] : '', 'category_name', 'category_id');
                        ?> 
                    </div></div>
                <div class="control-group">
                    <label class="control-label" for="item-price">Price</label>
                    <div class="controls">
                        <input type="text" class="input-large" name="item_price" id="item-price"
                            onkeypress="return isNumberKey(event,1)" maxlength="18"  value="<?php
                        if (isset($forms) && array_key_exists('item_price', $forms)):print $forms['item_price'];
                        endif;
                        ?>">
                    </div>
                </div>
               <!-- <div class="control-group">
                    <label class="control-label">Photo</label>
                    <div class="controls">
                        <input type="text" class="input-large" name="item_photo" id="item-photo"
                               value="<?php
                               if (isset($forms)&& array_key_exists('item_photo', $forms)):print $forms['item_photo'];
                               endif;
                        ?>">
                    </div>
                </div>-->
                <div class="control-group">
                    <label class="control-label" for="item-description">Description</label>
                    <div class="controls">
                        <textarea id="comment" maxlength="150" class="input-large" name="item_description" id="item-description"
                              cols="45" rows="5"    ><?php
                               if (isset($forms) && array_key_exists('item_description', $forms)):print $forms['item_description'];
                               endif;
                        ?> </textarea>
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

