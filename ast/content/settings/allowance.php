
<div class="span12">
    <div id="validation" class="widget highlight widget-form widget-allowances-form">
        <div class="widget-header">
            <h3>
                <i class="icon-pencil"></i>
                Allowane Form
            </h3>
        </div> <!-- /widget-header -->

        <div class="widget-content">
            <div id="block" class="alert alert-block">
                <a class="close" data-dismiss="alert" href="#">&times;</a>
            </div>
            <form action="#" id="allowances-form" name="allowancesform" class="allowances-form form-horizontal"
                  method="post" accept-charset="UTF-8">
                <fieldset>                  
                    <div class="control-group control-min-group">
                        <label class="control-label" for="number">Max Debit</label>
                        <div class="controls">
                            <input type="text" class="input-large" name="max_debit" id="number" maxlength="18" onkeypress="return isNumberKey(event)" >
                        </div>
                    </div>
                    <div class="control-group control-min-group">
                        <label class="control-label" for="checkall">Check All</label>
                        <div class="controls">
                            <input type="checkbox" name="checkall" onclick="enable_text(this.checked,document.allowancesform.saveallowances)"  >
                        </div>
                    </div>
                   
                    <div class="control-group">
                        <div class="widget widget-table">

                            <?php print $content ?>
                        </div> </div>
                    <div class="form-actions">
                        <button type="submit" id="save-allowances"
                                class="save btn btn-primary btn-large" name="saveallowances">Save changes</button>
                    </div>

                </fieldset>
            </form>

        </div> <!-- /widget-content -->
    </div>

</div>