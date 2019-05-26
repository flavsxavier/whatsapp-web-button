<?php defined('ABSPATH') or die("Sem scripts kids, por favor."); ?>
<div class="wrap">
    <div id="wwb__notices">
        <?php if (isset($_GET['settings-updated'])) : ?>
            <div class="updated" id="message">
                <p><strong><?php _e("Alterações salvas."); ?></strong></p>
            </div>
        <?php endif; ?>
    </div>
    <h1><span class="dashicons dashicons-forms"></span> Configurações do WhatsApp Web Button</h1>
    <form method="post" action="options.php" enctype="multipart/form-data">
        <?php $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'config-options'; ?>
        <h2 class="nav-tab-wrapper">
            <a href="?page=wwbtn-options&tab=config-options" class="nav-tab <?php echo $active_tab == 'config-options' ? 'nav-tab-active' : ''; ?>">Configuração</a>
            <a href="?page=wwbtn-options&tab=layout-options" class="nav-tab <?php echo $active_tab == 'layout-options' ? 'nav-tab-active' : ''; ?>">Layout</a>
            <?php if (get_option('wwb__multi_status') == 'activated') : ?>
                <a href="?page=wwbtn-options&tab=multi-numbers-options" class="nav-tab <?php echo $active_tab == 'multi-numbers-options' ? 'nav-tab-active' : ''; ?>">Múltiplos Números</a>
            <?php endif; ?>
        </h2>
        <?php
            if ($active_tab == 'config-options') {
                settings_fields('wwb__settings');
                do_settings_sections('wwb__settigns');
                include_once WWBTN_DIR . 'sections/config.php';
            }
            if ($active_tab == 'layout-options') {
                settings_fields('wwb__layout');
                do_settings_sections('wwb__layout');
                include_once WWBTN_DIR . 'sections/layout.php';
            }
            if ($active_tab == 'multi-numbers-options' && get_option('wwb__multi_status') == 'activated') {
                include_once WWBTN_DIR . 'sections/multi.php';
            }
            if ($active_tab == 'config-options' || $active_tab == 'layout-options') {
                submit_button();
            }
        ?>
    </form>
</div>