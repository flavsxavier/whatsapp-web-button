<?php
    if (!defined('WP_UNINSTALL_PLUGIN') || !WP_UNINSTALL_PLUGIN || dirname(WP_UNINSTALL_PLUGIN) !== dirname(plugin_basename(__FILE__))) {
        exit;
    }
    foreach (wp_load_alloptions() as $option => $value) {
        if (strpos($option, 'wpp__') === 0) {
            delete_option($option);
        }
    }
?>