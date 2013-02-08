<?php
/**
 * This is the preview
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 * 
 */
?>
<script>
    $(function () {	
        $('#header').hide();
        $('#nav').hide();
        $('#page-title').hide();
        $('#footer').hide();
    });</script>
<div class="content-preview">
    <div id="header">
        <div class="container" id="header-container">
             <a href="./"> 
                <img src="<?php print $root ?>themes/img/title.png">
            </a>
        </div> <!-- /.container -->
    </div>
    <div id="content">
        <div class="container">
            <div class="span12">
                <div class="widget widget-table">
                    <div id="validation" class="widget highlight widget-form">

                        <div  class="form-horizontal">
                            <?php
                            $data_report = isset($_SESSION['data_report']) ? $_SESSION['data_report'] : array();
                            print $content = Helper::construct_template_view($data_report, array('Category Name', 'Item Name', 'Item Quantity'), array('category_name', 'item_name', 'item_quantity'));
                            ?>

                        </div>
                    </div>

                </div>

            </div> <!-- /.row -->
        </div> <!-- /.container -->
    </div> <!-- /#content -->
    <div class="form-actions">
        <a href="" id="print" class="print btn btn-primary btn-large">Print</a>
        <a href="" id="back-<?php print $data_report['action'] ?>" class="back-preview btn btn-primary btn-large">Back</a>
    </div>
</div>
