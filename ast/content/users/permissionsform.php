<?php
/**
 * This is the Helper
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 * 
 */
?>

<div id="validation" class="widget highlight widget-form widget-permissions-form">

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
                    <select name="links" id="links">
                    <option value="">Select</option>
                    <option value="calendar" data-image="icons/icon_calendar.gif">Calendar</option>
                    <option value="shopping_cart" data-image="icons/icon_cart.gif">Shopping Cart</option>
                    <option value="cd" data-image="icons/icon_cd.gif">CD</option>
                    <option value="email"  selected="selected" title="icons/icon_email.gif">Email</option>
                    <option value="faq" data-image="icons/icon_faq.gif">FAQ</option>
                    <option value="games" data-image="icons/icon_games.gif">Games</option>
                    </select>
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