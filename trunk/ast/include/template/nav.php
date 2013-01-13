<div id="nav">

    <div class="container">

        <a href="javascript:;" class="btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <i class="icon-reorder"></i>
        </a>

        <div class="nav-collapse">
            <?php print Menu::getInstance()->constructMenu($role_id) ?>

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