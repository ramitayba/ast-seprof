<?php $url = "http://" . $_SERVER['HTTP_HOST'] . $root . "reports/users-purchases"; ?>
<div class="span12">
    <div class="widget widget-table">
        <div class="widget-header">						
            <h3>
                <i class="icon-th-list"></i>
                Reports: Users Purchases
        </div> <!-- /widget-header -->
        <div class="widget-content">
            <?php if (isset($_POST['submit'])): //if (isset($_GET['uid'])) : ?>
                <iframe style="border:none" width="100%" height="400" src="<?php echo $url . "-pdf?mindate=" . $_POST['mindate'] . "&maxdate=", $_POST['maxdate'] ?>"></iframe>
                <div class="form-actions">
                    <a class="btn btn-inverse" href="<?php echo $url; ?>">Back</a>
                </div>
            <?php else: ?>
                <form method="post" class="form-horizontal" action="<?php echo $url; ?>">
                    <div class="control-group">
                        <label for="datepicker-inline-mindate" class="control-label">From</label>
                        <div class="controls">
                            <input type="text" name="mindate" id="datepicker-inline-mindate" placeholder="Click for Datepicker" />
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="ddatepicker-inline-maxdate" class="control-label">To</label>
                        <div class="controls">
                            <input type="text" name="maxdate" id="datepicker-inline-maxdate" placeholder="Click for Datepicker" />
                        </div>
                    </div>
                    <div class="form-actions">
                        <button class="btn btn-primary btn-medium" name="submit" type="submit">Show Report</button>
                    </div>
                </form>
            <?php endif; ?>
        </div> <!-- /widget-content -->
    </div> <!-- /widget -->
</div>
