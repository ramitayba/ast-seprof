<?php
/**
 * This is the Helper
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 * 
 */
?>

<div id="validation" class="widget highlight widget-form widget-events-form">
    <div class="widget-header">
        <h3>
            <i class="icon-pencil"></i>
            Events Form
        </h3>
    </div> <!-- /widget-header -->

    <div class="widget-content">
        <div id="block" class="alert alert-block">
            <a class="close" data-dismiss="alert" href="#">&times;</a>
        </div>
        <form action="#" id="events-form" name="events-form" class="events-form form-horizontal"
              method="post" accept-charset="UTF-8">
            <fieldset>               
                <div class="control-group control-min-group">
                    <label class="control-label" for="event-name">Event Name</label>
                    <div class="controls">
                        <input type="text" class="input-large" name="event_name" id="event_name" value="<?php
if (isset($forms) && !Helper::is_empty_array($forms)):print $forms['event_name'];
endif;
?>">                   
                    </div>
                </div>
                <div class="control-group control-min-group">
                    <label class="control-label" for="event-date">Event Date</label>
                    <div class="controls">
                        <input type="text" id="event_date" class="datepicker" name="event_date" value="<?php
                               if (isset($forms) && !Helper::is_empty_array($forms)):print $forms['event_date'];
                               endif;
?>"/>
                    </div>
                </div>
                <div class="control-group control-min-group">
                    <label class="control-label" for="invitees-nb">Invitees Number</label>
                    <div class="controls">
                        <input type="text" class="input-large" name="event_invitees_nb" id="event_invitees_nb" onkeypress="return isNumberKey(event)"
                               value="<?php
                               if (isset($forms) && !Helper::is_empty_array($forms)):print $forms['event_invitees_nb'];
                               endif;
?>" >
                    </div>
                </div>
                <div class="control-group control-min-group">
                    <label class="control-label" for="department">Department</label>
                    <div class="controls">
                        <?php
                        print Helper::form_construct_drop_down('department', LookupBusinessLayer::getInstance()->getDepartments(), isset($forms) && !Helper::is_empty_array($forms) ? $forms['department_id'] : '', 'department_name', 'department_id');
                        ?> 
                    </div>
                </div>
                <div class="control-group control-min-group">
                    <label class="control-label" for="employee">Employee</label>
                    <div class="controls">
                        <?php
                        print Helper::form_construct_drop_down('employee', LookupBusinessLayer::getInstance()->getEmployees(), isset($forms) && !Helper::is_empty_array($forms) ? $forms['employee_id'] : '', 'employee_name', 'employee_id');
                        ?> 
                    </div>
                </div>            
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
                    <button type="submit" id="add" class="add btn btn-primary btn-large">Add New Row</button>
                </div>
            </fieldset>
        </form>
                <div class="form-actions">
                    <button type="submit" id="save-events-<?php
                        if (isset($forms)): print $forms['event_id'];
                        endif;
                        ?>"
                            class="save btn btn-primary btn-large">Save changes</button>
                    <button type="reset" id="cancel-events" class="cancel btn btn-large">Cancel</button>
                </div>
            </fieldset>
        </form>

    </div> <!-- /widget-content -->
</div>

