<?php
if (ob_get_level()) { ob_end_clean(); }
global $wpdb;

function rewriteDie(){
    global $wpdb;

    $message = ob_get_contents();
    ob_end_clean();
    header('Content-Type: application/json');
    echo json_encode([
        'status' => isset($wpdb) ? $wpdb->check_connection(false) : false,
        'out' => $message,
        'm' => round(memory_get_usage()/1048576,2). 'MB',
        't' => timer_stop().'s',
    ]);
    die();
}

register_shutdown_function('rewriteDie');

if (!defined('WP_USE_THEMES')) {
    define('WP_USE_THEMES', false);
}

ob_start();
define( 'SHORTINIT', true );
require('wp-load.php');
ob_end_clean();
