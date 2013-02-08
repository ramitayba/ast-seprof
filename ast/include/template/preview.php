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
    });</script>
<style>#footer .container {
        border-top:0px;
        -moz-box-shadow: none;
        -webkit-box-shadow: none;
        box-shadow:none;
    }</style>
<div class="content-preview">
    <div id="header">
        <div  id="header-container">
            <a href="./"> 
                <img class="logo" src="<?php print $root ?>themes/img/title.png">
            </a>
            <img class="img-header-print" src="<?php print $root ?>themes/slate/nesma_report_hd.png"> 

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
