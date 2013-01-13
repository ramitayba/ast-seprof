<?php

/**
 * This is the include/template/header
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 * 
 */
?>

<div id="header">
    <div class="container">
        <h1><a href="./">&nbsp;Nesma</a></h1>
        <div id="info">				
            <a href="javascript:;" id="info-trigger">
                <i class="icon-cog"></i>
            </a>
            <div id="info-menu">
                <div class="info-details">
                    <h4>Welcome back, <?php $username = isset($_SESSION['user_pos_name']) ? $_SESSION['user_pos_name'] : 'admin';print $username;?></h4>
                    <p>
                        Logged in as Admin.
                    </p>
                </div> <!-- /.info-details -->
            </div> <!-- /#info-menu -->
        </div> <!-- /#info -->
    </div> <!-- /.container -->
</div> <!-- /#header -->