<div class="span12">
    <div class="widget widget-table">
        <div class="widget-header">						
            <h3>
                <i class="icon-th-list"></i>
                Reports: Detailed Event
        </div> <!-- /widget-header -->
        <div class="widget-content">

            <form method="post" id="detailed-event-form" name="detailed-event-form" class="detailed-event-form form-horizontal" action="#">

                <div class="control-group">
                    <label for="cid" class="control-label">Select Event</label>
                    <div class="controls">
                        <?php
                        include_once POS_ROOT . '/businessLayer/EventBusinessLayer.php';
                        $eventBusinessLayer = new EventBusinessLayer();
                        print Helper::form_construct_drop_down('filter_select', $eventBusinessLayer->getEvents(DELETED), '', 'event_name', 'event_id');
                        ?> </div>
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
