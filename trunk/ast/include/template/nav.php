<div id="nav">

    <div class="container">

        <a href="javascript:;" class="btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <i class="icon-reorder"></i>
        </a>

        <div class="nav-collapse">

            <ul class="nav">

                <li class="nav-icon active">
                    <a href="./">
                        <i class="icon-home"></i>
                        <span>Home</span>
                    </a>	    				
                </li>

                <li class="dropdown">					
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-th"></i>
                        Cafeterias
                        <b class="caret"></b>
                    </a>	

                    <ul class="dropdown-menu">
                        <li><a href="<?php echo $root; ?>cafeterias/">List</a></li>
                        <li><a href="<?php echo $root; ?>cafeterias/pos">POS Manager</a></li>
                    </ul>    				
                </li>

                <li class="dropdown">					
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-copy"></i>
                        Products
                        <b class="caret"></b>
                    </a>	

                    <ul class="dropdown-menu">
                        <li><a href="<?php echo $root; ?>products/">List</a></li>
                        <li><a href="<?php echo $root; ?>products/items">Items</a></li>
                        <li><a href="<?php echo $root; ?>products/categories">Categories</a></li>
                    </ul>    				
                </li>

                <li class="dropdown">					
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-external-link"></i>
                        Users
                        <b class="caret"></b>
                    </a>	

                    <ul class="dropdown-menu">							
                        <li><a href="<?php echo $root; ?>users/roles">Roles</a></li>
                        <li><a href="<?php echo $root; ?>users/permissions">Permissions</a></li>
                        <li><a href="<?php echo $root; ?>users/">List</a></li>
                        <li class="dropdown">
                            <a href="javascript:;">
                                Dropdown Menu									
                                <i class="icon-chevron-right sub-menu-caret"></i>
                            </a>

                            <ul class="dropdown-menu sub-menu">
                                <li><a href="javascript:;">Dropdown #1</a></li>
                                <li><a href="javascript:;">Dropdown #2</a></li>
                                <li><a href="javascript:;">Dropdown #3</a></li>
                                <li><a href="javascript:;">Dropdown #4</a></li>
                            </ul>
                        </li>
                    </ul>    				
                </li>



            </ul>


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