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
                    <label for="mindate" class="control-label">From</label>
                    <div class="controls">
                        <input type="text" name="mindate" id="mindate" placeholder="Click for Datepicker" readonly/>
                    </div>
                </div>
                <div class="control-group">
                    <label for="maxdate" class="control-label">To</label>
                    <div class="controls">
                        <input type="text" name="maxdate" id="maxdate" placeholder="Click for Datepicker" readonly/>
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
