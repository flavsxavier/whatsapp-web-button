<?php
    if (!defined('WP_UNINSTALL_PLUGIN')) {
        exit;
    }
    // Uninstall scripts
    wp_deregister_script('scripts-wwbtn');
    wp_deregister_script('styles-wwbtn');
    // Uninstall options
    foreach (wp_load_alloptions() as $option => $value) {
        if (strpos($option, 'wwb__') === 0) {
            delete_option($option);
            delete_site_option($option);
        }
    }
?>