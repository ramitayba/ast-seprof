<?php
/**
 * This is the Helper
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 * 
 */
?>
<div id="validation" class="widget highlight widget-form widget-categories-form">
    <div class="widget-header">
        <h3>
            <i class="icon-pencil"></i>
            Categories Form
        </h3>
    </div> <!-- /widget-header -->

    <div class="widget-content">
        <div id="block"  class="alert alert-block">
            <a class="close" data-dismiss="alert" href="#">&times;</a>
        </div>
        <form action="#" id="categories-form" name="categoriesform" class="categories-form form-horizontal"
              method="post" accept-charset="UTF-8">   
            <fieldset>
                <div class="control-group">
                    <label class="control-label" for="category-name">Name</label>
                    <div class="controls">
                        <input type="text" class="input-large" name="category_name" id="category-name" 
                               value="<?php
if (isset($forms) && !Helper::is_empty_array($forms)):print $forms['category_name'];
endif;
?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="category">Parent</label>
                    <div class="controls">
                        <?php
                        $category = new CategoryBusinessLayer();
                        print Helper::form_construct_drop_down('category', $category->getCategories(), isset($forms) && !Helper::is_empty_array($forms) ? $forms['category_parent_id'] : '', 'category_name', 'category_id', 'disabled');
                        ?>  
                        <input type="checkbox" name="others" onclick="enable_text(this.checked,document.categoriesform.category)" >
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Color Code</label>
                    <div class="controls">
                        <input type="text" class="input-large" name="color_code" id="color"
                               value="<?php
                        if (isset($forms) && !Helper::is_empty_array($forms)):print $forms['color_code'];
                        endif;
                        ?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="category-description">Description</label>
                    <div class="controls">
                        <textarea  class="input-large" name="category_description" id="category-description"
                                   cols="45" rows="5"
                                   ><?php
                               if (isset($forms) && !Helper::is_empty_array($forms)):print $forms['category_description'];
                               endif;
                        ?></textarea>
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
                <div class="control-group">
                    <label class="control-label" for="add-item">Add Item</label>
                    <div class="controls">
                        <input type="checkbox" name="add_item" id="add-item" value="">
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" id="save-categories-<?php
                        if (isset($forms)): print $forms['category_id'];
                        endif;
                        ?>" 
                            class="save btn btn-primary btn-large">Save changes</button>
                    <button type="reset" id="cancel-categories" class="cancel btn btn-large">Cancel</button>
                </div>
            </fieldset>
        </form>

    </div> <!-- /widget-content -->
</div>
