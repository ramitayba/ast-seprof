<div class="span12">
    <div class="widget widget-table">
        <div class="widget-header">						
            <h3>
                <i class="icon-th-list"></i>
                Reports: Events Listing
        </div> <!-- /widget-header -->
        <div class="widget-content">

            <form method="post" id="events-listing-form" name="events-listing-form" class="events-listing-form form-horizontal" action="#">
               
                    <div class="control-group">
                    <label for="datepicker-inline-mindate" class="control-label">From</label>
                    <div class="controls">
                         <div id="datetimepickermin" class="input-append date">
                                    <input type="text" data-format="dd/MM/yyyy" id="mindate" name="mindate" class="" readonly/><span class="add-on">
                                        <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                        </i>
                                    </span>
                                </div> 
                    </div>
                </div>
                <div class="control-group">
                    <label for="datepicker-inline-maxdate" class="control-label">To</label>
                    <div class="controls">
                       <div id="datetimepickermax" class="input-append date">
                                    <input type="text" data-format="dd/MM/yyyy" id="maxdate" name="maxdate" class="" readonly/><span class="add-on">
                                        <i data-time-icon="icon-time" data-date-icon="icon-calendar">
                                        </i>
                                    </span>
                                </div> 
                    </div>
                </div>
                <div class="form-actions">
                    <button type="submit" id="<?php
                        print $action;
                        ?>"
                            class="show-reports btn btn-primary btn-large">Show Report</button>
                </div>
            </form>
        </div> <!-- /widget-content -->
    </div> <!-- /widget -->
</div>
