<?php
/**
 * This is the Master Page
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 */
ob_start();
session_start();
header('Content-type: text/html; charset=utf-8');
define('POS_ROOT', getcwd());
include_once POS_ROOT . '/include/bootstrap.inc';
// Initialize default content page
$pagename = 'index';
if (isset($_GET['contentpage'])) {
    // If the contentpage variable is set, then use it for the page name
    $pagename = $_GET["contentpage"];
}
// the web root
$root = Helper::get_url();

if (strpos($pagename, 'form')):
    $pagename = explode('form', $pagename);
    $pagename = $pagename[0];
endif;

$pagename = Helper::findPage($pagename);
include Helper::load_controller($pagename);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
    <head>
        <meta http-equiv="Content-Type" content="text/html; utf-8">
            <?php
            // If a header file exists for the target content page, then use it. Otherwise
            // use the default header file
            if (isset($_SESSION['user_pos'])):
                require_once("include/header/index.php");
            endif;
            if (Helper::findRealPath("include/header/$pagename.php")):
                require_once("include/header/$pagename.php");
            elseif (!isset($_SESSION['user_pos'])):
                require_once("include/header/login.php");
            else :
                print' <title>Dashboard | POS Nesma Administration</title>';
            endif;
            ?>
    </head>
    <body <?php if (isset($bodyLoad)) echo "onLoad=\"$bodyLoad\""; ?>>

        <?php
        if (isset($_SESSION['user_pos'])):
            // Top header
            require_once("include/template/header.php");
            // navigation menu
            require_once("include/template/nav.php");
            if (!Menu::getInstance()->getAccessMenu($pagename)):
                $pagename = 'index';
            endif;
            ?>
            <div id="content">
                <div class="container">



                    <?php if (isset($_SESSION['messages'])): ?>
                        <div id="system-messages-wrapper" class="clearfix">
                            <div class="container">
                                <?php print $_SESSION['messages']; ?>
                            </div>
                        </div>
                        <!-- //HELP -->
                    <?php endif; ?>
                    <?php
                    $breadcrumb = Helper::set_breadcrumb($pagename);
                    if (!Helper::is_empty_string($breadcrumb)):
                        ?>
                        <div id="page-title" class="clearfix">
                            <?php print $breadcrumb; ?>
                        </div> <!-- /.page-title -->
                    <?php endif; ?>


                    <div class="row">
                        <?php
                        // Inserts the real page content here
                        require("content/$pagename.php");
                        ?>		
                    </div> <!-- /.row -->
                </div> <!-- /.container -->
            </div> <!-- /#content -->
            <?php
            // Footer
            require_once("include/template/footer.php");
        else : require("content/login.php");
        endif;
        ?>
    </body>
</html>

