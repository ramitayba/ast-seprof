<?php
/**
 * This is the Helper
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 * 
 */
?>

<div id="validation" class="span12">

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
                        <div class="PermLinks">
                        <ul class="tree">
                        <li>
                        <input type='checkbox' name='ids[]' id='p_1'value='1'>
                        <label>
                            Hardware
                        </label>
						<ul>
							<li>
		                        <input type='checkbox' name='ids[]' id='p_10'value='10'>
		                        <label>
		                            CPU
		                        </label>
		                    </li>
							<li>
		                        <input type='checkbox' name='ids[]' id='p_11'value='11'>
		                        <label>
		                            RAM
		                        </label>
		                    </li>
							<li>
		                        <input type='checkbox' name='ids[]' id='p_12'value='12'>
		                        <label>
		                            HDD
		                        </label>
		                    </li>
						</ul>
                    </li>
                            <li>
                                <input type='checkbox' name='ids[]' id='p_20'value='20'>
                                <label>
                                    OS
                                </label>
                                <ul>
                                    <li>
                                        <input type='checkbox' name='ids[]' id='p_200'value='200'>
                                        <label>
                                            Windows
                                        </label>
                                    </li>
                                    <li>
                                        <input type='checkbox' name='ids[]' id='p_201'value='201'>
                                        <label>
                                            Linux
                                        </label>
                                    </li>
                                    <li>
                                        <input type='checkbox' name='ids[]' id='p_202'value='202'>
                                        <label>
                                            Unix
                                        </label>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <input type='checkbox' name='ids[]' id='p_21'value='21'>
                                <label>
                                    Application
                                </label>
								<ul>
                                    <li>
                                        <input type='checkbox' name='ids[]' id='p_210'value='210'>
                                        <label>
                                            MS Word
                                        </label>
                                    </li>
                                    <li>
                                        <input type='checkbox' name='ids[]' id='p_211'value='211'>
                                        <label>
                                            MS Excel
                                        </label>
                                    </li>
				</ul>
                            </li>
                        </ul>
                </div>
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