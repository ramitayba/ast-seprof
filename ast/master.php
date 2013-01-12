<?php
/**
 * This is the Master Page
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 */
header('Content-type: text/html; charset=utf-8');

/**
 * Check if a file exists under the webroot or include path
 * And if it does, return the absolute path.
 * @param string $filename - Name of the file to look for
 * @return string|false - The absolute path if file exists, false if it does not
 */
//die('..'.$_GET['contentpage']);
function findRealPath($filename) {
    // Check for absolute path
    if (realpath($filename) == $filename) {
        return $filename;
    }

    // Otherwise, treat as relative path
    $paths = explode(PATH_SEPARATOR, get_include_path());
    foreach ($paths as $path) {
        if (substr($path, -1) == DIRECTORY_SEPARATOR) {
            $fullpath = $path . $filename;
        } else {
            $fullpath = $path . DIRECTORY_SEPARATOR . $filename;
        }

        if (file_exists($fullpath)) {
            return $fullpath;
        }
    }

    return false;
}

// Initialize default content page
$pagename = 'index';
if (isset($_GET['contentpage'])) {
    // If the contentpage variable is set, then use it for the page name
    $pagename = $_GET["contentpage"];
}
// the web root
$root = '/ast/';

if (file_exists($pagename . '.php')) {
    // URL refers to a page existing under the webroot, so just display page w/o using master page
    require_once($pagename . '.php');
} else {
    // Look for a PHP file matching the desired page name under the include/content folder
    if (!findRealPath("content/$pagename.php")) {
        // The page name might represent a folder, so look for the index.php file in such
        // a folder under the include/page folder
        if (findRealPath("content/$pagename/index.php")) {
            // Page name is a folder, so change page name to the index file in that folder
            $pagename = $pagename . '/index';
        } else {
            // Failed to find the page file, so display the 404 content page instead
            $pagename = '404';
        }
    }
    ?>
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml" >
        <head>
            <meta http-equiv="Content-Type" content="text/html; utf-8">
                <link href="<?php echo $root; ?>style/site.css" rel="Stylesheet" type="text/css" />
                <?php
                // If a header file exists for the target content page, then use it. Otherwise
                // use the default header file
                if (!findRealPath("header/$pagename.php")) {
                    require_once("include/header/index.php");
                } else {
                    require_once("include/header/$pagename.php");
                }
                ?>
        </head>
        <body <?php if (isset($bodyLoad)) echo "onLoad=\"$bodyLoad\""; ?>>

            <?php //if(isset($_SESSION['user'])):?>
            <?php
            // Top header
            require_once("include/template/header.php");
            // navigation menu
            require_once("include/template/nav.php");
            ?>
            <div id="content">
                <div class="container">
                    <div class="row">
                        <div class="span12">
                            <div class="widget widget-table">
                                <div class="widget-header">
                                    <h3>
                                        <i class="icon-th-list"></i> 
                                        Home
                                    </h3>		
                                </div> <!-- /.widget-header -->
                                <div class="widget-content">
                                    <?php
                                    // Inserts the real page content here
                                    require("content/$pagename.php");
                                    ?>		
                                </div> <!-- /.widget-content -->
                            </div> <!-- /.widget -->
                        </div> <!-- /.span8 -->
                    </div> <!-- /.row -->
                </div> <!-- /.container -->
            </div> <!-- /#content -->
            <?php
            // Footer
            require_once("include/template/footer.php");
            ?>
        </body>
    </html>
    <?php
}
