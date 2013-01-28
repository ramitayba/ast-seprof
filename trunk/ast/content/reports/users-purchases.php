<div class="span12">
    <div class="widget widget-table">
        <div class="widget-header">						
            <h3>
                <i class="icon-th-list"></i>
                Reports	<?php echo isset($_GET['uid'])? 'User #'.$_GET['uid']:'Users'; ?>			
            </h3>
        </div> <!-- /widget-header -->
        <?php if (isset($_GET['uid'])) : ?>
            <iframe width="100%" height="400" src="<?php echo "http://" . $_SERVER['HTTP_HOST'] . $root . "/reports/users-purchases-pdf?uid=" . $_GET['uid'] ?>"></iframe>
            <a href="#">Back</a>
        <?php else: ?>
            <a href="?uid=2">user 2</a><hr>
            <a href="?uid=3">user 3</a><hr>
        <?php endif; ?>
    </div> <!-- /widget-content -->
</div> <!-- /widget -->	
<?php

