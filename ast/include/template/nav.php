<?php

/**
 * This is the include/template/nav
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 * 
 */
?>
<div id="nav">

    <div class="container">

        <a href="javascript:;" class="btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <i class="icon-reorder"></i>
        </a>

        <div class="nav-collapse">
            <?php
            $role_id=$_SESSION['user_pos_role'];
            print Menu::getInstance()->constructMenu($role_id) ?>

            <ul class="nav pull-right">

                <li class="">
                    <form class="navbar-search pull-left">
                        <input type="text" class="search-query" placeholder="Search">
                        <button class="search-btn"><i class="icon-search"></i></button>
                    </form>	    				
                </li>

            </ul>

        </div> <!-- /.nav-collapse -->

    </div> <!-- /.container -->

</div> <!-- /#nav -->