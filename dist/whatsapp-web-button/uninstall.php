<?php
    if (!defined('WP_UNINSTALL_PLUGIN') || !WP_UNINSTALL_PLUGIN || dirname(WP_UNINSTALL_PLUGIN) !== dirname(plugin_basename(__FILE__))) {
        exit;
    }
    function uninstall__scripts() {
        wp_deregister_script('scripts-wwbtn');
        wp_deregister_script('styles-wwbtn');
    }
    foreach (wp_load_alloptions() as $option => $value) {
        if (strpos($option, 'wwb__') === 0) {
            delete_option($option);
            delete_site_option($option);
        }
    }
?>