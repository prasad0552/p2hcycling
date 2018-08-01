<?php 

/*
Plugin Name: P2H Cycling
Description:
Version: 1
Author: p2hcyclng
Author URI: http://p2hcycling.com
*/


add_action('init', function(){    
    include(dirname(__FILE__) . '/includes/class-p2h-admin-menu.php');
    include(dirname(__FILE__) . '/includes/class-ride-list-table.php');
    include(dirname(__FILE__) . '/includes/class-form-handler.php');
    include(dirname(__FILE__) . '/includes/ride-functions.php');
    new P2H_Admin_Menu();
    
    include(dirname(__FILE__) . '/includes/class-p2h-cycles-menu.php');
    include(dirname(__FILE__) . '/includes/class-cycle-list-table.php');
    include(dirname(__FILE__) . '/includes/class-cycle-form-handler.php');
    include(dirname(__FILE__) . '/includes/cycle-functions.php');
    new P2H_Cycles_Menu();
});