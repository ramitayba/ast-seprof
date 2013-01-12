<?php
define('POS_ROOT', getcwd());
include_once POS_ROOT . '/includes/bootstrap.inc';
?>
<html lang="en">
    <head>

    </head>

    <body>
        <?php
        $userbusinesslayer = new UserBusinessLayer();
        /*$res = $userbusinesslayer->getUsers();
       
            print_r($res);*/
        
          $res1 = $userbusinesslayer->addUser('status','','','', '','');
            print_r($res1);
        ?>

    </body>
</html>
