<?php
/**
 * This is the EventForm
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 * 
 */
?>
<script>
    $(function() {
        $("#datepicker").datepicker({dateFormat: 'mm-dd-yy'+' ' +date_obj_time}); 
    });
</script>
<?php
if (!(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')) :
    ?> <div class="span12">

        <div class="widget widget-table">
        <?php endif;
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
                                <input type="text" class="input-large" name="event_name"  maxlength="50" id="event_name" value="<?php
        if (isset($forms) && !Helper::is_empty_array($forms)):print $forms['event_name'];
        endif;
        ?>">                   
                            </div>
                        </div>

                        <div class="control-group control-min-group">
                            <label class="control-label" for="event-date">Event Date</label>
                            <div class="controls">
                                <input type="text" id="datepicker" name="event_date" class="" value="<?php
        if (isset($forms) && !Helper::is_empty_array($forms)):print $forms['event_date'];
        endif;
        ?>"/>
                            </div>
                        </div>
                        <div class="control-group control-min-group">
                            <label class="control-label" for="invitees-nb">Invitees Number</label>
                            <div class="controls">
                                <input type="text" class="input-large" name="event_invitees_nb" maxlength="9" id="event_invitees_nb" onkeypress="return isNumberKey(event)"
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
                        <div class="clear"></div>
                        <div class="widget-sub-content">
                            <div class="widget-header ">	      				
                                <h3>
                                    <i class="icon-pencil"></i>
                                    Event Items      					
                                </h3>	
                            </div>
                            <div class="widget-content">
                                <div class="control-group control-min-group control-category">
                                    <label class="control-label" for="category">Category Name</label>
                                    <div class="controls">
                                        <?php
                                        $parent = new CategoryBusinessLayer();
                                        print Helper::form_construct_drop_down('category', $parent->getParentCategories(DELETED), '', 'category_name', 'category_id', '', '', ''); // '<script type="text/javascript"> $(".chzn-select").chosen(); $(".chzn-select-deselect").chosen({allow_single_deselect:true}); </script>');
                                        ?> 
                                    </div>
                                </div>              

                                <div class="control-group control-min-group">
                                    <label class="control-label" for="number">Item Quantity</label>
                                    <div class="controls">
                                        <input type="text" class="input-large" maxlength="9" name="number" id="number" onkeypress="return isNumberKey(event)">
                                     <a class="add " id="add-items" href="" title="Add New Record"></a>
                                    </div>
                                 
                                       
                                   
                                </div>

                                <div class="control-group">
                                    <div class="widget widget-table">

<?php print $content ?>
                                    </div> </div>
                            </div>
                        </div>
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

        <?php
        if (!(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')) :
            ?> </div>
    </div>
<?php endif;
?>