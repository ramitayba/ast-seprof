<div id="validation" class="span12">
    <div class="widget-header">
        <h3>
            <i class="icon-pencil"></i>
            Event Form
        </h3>
    </div> <!-- /widget-header -->

    <div class="widget-content">

        <form action="#" id="event-form" name="event-form" class="event-form form-horizontal"
              method="post" accept-charset="UTF-8">
            <fieldset>
                <div class="control-group">
                    <label class="control-label" for="event-name">Name</label>
                    <div class="controls">
                        <input type="text" class="input-large" name="event_name" id="event_name" value="">
                    </div>
                </div>
               <div class="control-group">
                    <label class="control-label" for="date">Date</label>
                    <div class="controls">
                        <input type="text" id="datepicker" name="datepicker"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="invitees-nb">Invitees Number</label>
                    <div class="controls">
                        <input type="text" class="input-large" name="invitees_nb" id="invitees_nb" value="" onkeypress="return isNumberKey(event)">
                    </div>
                </div>
                 <div class="control-group">
                    <label class="control-label" for="department">Department</label>
                    <div class="controls">
                        <select name="department" id="department">
                            <option value="">Select</option>
                            <option value="1">22</option>
                            <option value="2">33</option>
                            <option value="3">44</option>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="users">Users</label>
                    <div class="controls">
                        <?php
print Helper::form_construct_drop_down('users', LookupBusinessLayer::getInstance()->getEmployees(), isset($forms) && !Helper::is_empty_array($forms) ? $forms['employee_id'] : '', 'employee_name','employee_id','');
?> 
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" id="save-categories-<?php if (isset($forms)): print $forms['category_id'];endif;?>"
                            class="save btn btn-primary btn-large">Save changes</button>
                    <button type="reset" id="cancel-categories" class="cancel btn btn-large">Cancel</button>
                </div>
            </fieldset>
        </form>

    </div> <!-- /widget-content -->
</div>

