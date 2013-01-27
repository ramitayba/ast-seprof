<?php $url = "http://" . $_SERVER['HTTP_HOST'] . $root . "reports/cafeteria-balance"; ?>
<div class="span12">
    <div class="widget widget-table">
        <div class="widget-header">						
            <h3>
                <i class="icon-th-list"></i>
                Reports: Cafeteria Balance
        </div> <!-- /widget-header -->
        <div class="widget-content">
            <?php if (isset($_POST['submit'])): ?>
                <iframe style="border:none" width="100%" height="400" src="<?php echo $url . "-pdf?cid=" . $_POST['cid']; ?>"></iframe>
                <div class="form-actions">
                    <a class="btn btn-inverse" href="<?php echo $url; ?>">Back</a>
                </div>
                <?php
            else:
                include_once POS_ROOT . '/businessLayer/CafeteriaBusinessLayer.php';
                $cafeteriaBusinessLayer = new CafeteriaBusinessLayer();
                $cafeteriaDataTable = $cafeteriaBusinessLayer->getCafeterias(1);
                ?>
                <form method="post" class="form-horizontal" action="<?php echo $url; ?>">
                    <div class="control-group">
                        <label for="cid" class="control-label">Select Cafeteria</label>
                        <div class="controls">
                            <select name="cid" id="validateSelect">
                                <option value="">Select...</option>
                                <?php
                                foreach ($cafeteriaDataTable as $caf):
                                    echo '<option value="' . $caf['cafeteria_id'] . '">' . $caf['cafeteria_name'] . '</option>';
                                endforeach;
                                ?>
                            </select>
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
