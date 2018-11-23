<?php
    defined('ABSPATH') or die("Sem scripts kids, por favor.");
    
    /*
    * Plugin name: WhatsApp Web Button
    * Description: Adiciona um botão do whatsapp configurável e estilizável para desktop e mobile. Linkado para o WhatsApp Web.
    * Version: 1.1
    * Author: Flaviano Xavier
    * Author URI: https://github.com/flavisXavier
    */
    
    define('WWBTN_URL', plugins_url('', __FILE__));
    define('WWBTN_DIR', plugin_dir_path(__FILE__));

    $wwbtn = new WWBTN_Engine();
    class WWBTN_Engine {

        function __construct() {
            add_action('admin_menu', array($this, 'add__wwbtn_options_page'));
            add_action('admin_init', array($this, 'load__scripts_js'));
            add_action('admin_init', array($this, 'load__back_scripts_css'));
            add_action('admin_init', array($this, 'register__wwbtn_settings'));
            add_action('wp_enqueue_scripts', array($this, 'load__front_scripts_css'));
            add_action('wp_footer', array($this, 'add__wwbtn_section'));
            add_action('wp_ajax_save__multi_numbers', array($this, 'save__multi_numbers'));
            add_action('wp_ajax_nopriv_save__multi_numbers', array($this, 'save__multi_numbers'));
        }

        function add__wwbtn_options_page() {
            add_menu_page( 'WhatsApp Web Button', 'WhatsApp Web Button', 'edit_posts', 'wwbtn-options', array($this, 'wwbtn__options_page'), 'dashicons-forms', 80 );
        }

        function wwbtn__options_page() {
            require WWBTN_DIR . 'settings.php';
        }

        function load__scripts_js() {
            wp_enqueue_script('jquery');
            wp_enqueue_script('script-maskedinput-wwbtn', WWBTN_URL . '/js/jquery.maskedinput.js', array('jquery'), null, false);
            wp_enqueue_script('script-wwbtn-datatables', WWBTN_URL . '/assets/datatables/datatables.min.js', array('jquery'), null, false);
            wp_enqueue_script('script-wwbtn-page', WWBTN_URL . '/js/wwbtn.scripts.js', array('jquery'), null, false);
            wp_localize_script('script-wwbtn-page', 'wwbtn_ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
        }

        function load__front_scripts_css() {
            wp_enqueue_style('wwbtn-css-icones', WWBTN_URL . '/css/wwbtn.style.css', array(), null, false);
        }

        function load__back_scripts_css() {
            wp_enqueue_style('wwbtn-css-style', WWBTN_URL . '/css/wwbtn.back-style.css', array(), null, false);
            wp_enqueue_style('wwbtn-css-fonts', WWBTN_URL . '/css/font-awesome/css/font-awesome.min.css', array(), null, false);
            wp_enqueue_style('wwbtn-css-datatables', WWBTN_URL . '/assets/datatables/datatables.min.css', array(), null, false);
        }

        function register__wwbtn_settings() {
            register_setting('settings__wwbtn_page', 'wpp__active');
            register_setting('settings__wwbtn_page', 'wpp__telefone');
            register_setting('settings__wwbtn_page', 'wpp__multi_tele');
            register_setting('settings__wwbtn_page', 'wpp__img');
            register_setting("settings__wwbtn_page", "wpp__file", "handle_file_upload");
            register_setting("settings__wwbtn_page", "wpp__style");
            register_setting("settings__wwbtn_page", "wpp__style_mb");
            register_setting("settings__wwbtn_page", "wpp__tooltip");
            register_setting("settings__wwbtn_page", "wpp__tooltip_pos");
            register_setting("settings__wwbtn_page", "wpp__multi_act");
        }

        public function unmask__wwbtn_tel($numero) {
            $tel = array();
            $tel[0] = substr_replace($numero, "", 0, 1);
            $tel[1] = substr_replace($tel[0], "", 2, 1);
            $tel[2] = substr_replace($tel[1], "", 2, 1);
            $tel[3] = substr_replace($tel[2], "", 6, 1);
            return $tel[3];
        }

        function handle_file_upload($option) {
            if(!empty($_FILES["wpp__file"]["tmp_name"])) {
                $urls = wp_handle_upload($_FILES["wpp__file"], array('test_form' => FALSE));
                $temp = $urls["url"];
                return $temp;
            }
            return $option;
        }

        function save__multi_numbers() {
            $multi_numbers = $_POST["data"];
            if (get_option('opt__multi_numbers')) {
                $old_options = get_option('opt__multi_numbers');
                foreach ($old_options as $old_key) {
                    foreach ($multi_numbers as $key) {
                        if ($old_key[0] == $key[0]) {
                            echo "<div class='notice notice-error'><p>O nome definido já está vinculado a outro telefone, tente outro nome.</p></div>";
                            echo $old_key[0] . $key[0];
                            wp_die();
                        } else {
                            print_r($old_key);
                            echo "<div class='notice notice-success'><p>Opções alteradas com sucesso.</p></div>";
                            $old_options[count($old_options)] = array($key[0], $key[1]);
                            // update_option('opt__multi_numbers', $old_options);
                            wp_die();
                        }
                    }     
                }
            } else {
                update_option('opt__multi_numbers', $multi_numbers);
            }
            wp_die();
        }

        public function add__wwbtn_section() {
            if (get_option('wpp__active') === 'active') :
                $html = "";
                $telefone = $this->unmask__wwbtn_tel(get_option('wpp__telefone'));
                if ((get_option('wpp__tooltip')) && !(get_option('wpp__tooltip_pos') == 'none')) :
                    $tooltip = "data-toggle='tooltip' data-placement='". get_option('wpp__tooltip_pos') ."' title='". get_option('wpp__tooltip') ."'";
                endif;
                if (!(get_option('wpp__style') == 'none')) :
                    $html .= "<a href='https://web.whatsapp.com/send?phone=+55$telefone' target='_blank' class='d-none d-md-block'>";
                    if ($wpp__icon = get_option('wpp__file')) :
                        $html .= "<span class='wpp__section desktop ". get_option('wpp__style') ."'><img src='$wpp__icon' $tooltip alt=''></span>";
                    elseif (get_option('wpp__img') == 'wpp__padrao') :
                        $html .= "<span class='wpp__section fab desktop ". get_option('wpp__style') ."' $tooltip><i class='fa fa-whatsapp' aria-hidden='true'></i></span>";
                    else: 
                        $html .= "<span class='wpp__section desktop ". get_option('wpp__style') ."'><img src='". WWBTN_URL . "/images/whatsapp/wpp__businesst.png" ."' $tooltip alt=''></span>";
                    endif;
                    $html .= "</a>";
                endif;
                if (!(get_option('wpp__style_mb') == 'none')) :
                    $html .= "<a href='https://web.whatsapp.com/send?phone=+55$telefone' target='_blank' class='d-md-none'>";
                    if ($wpp__icon = get_option('wpp__file')) :
                        $html .= "<span class='wpp__section mobile ". get_option('wpp__style_mb') ."'><img src='$wpp__icon' $tooltip alt=''></span>";
                        elseif (get_option('wpp__img') == 'wpp__padrao') :
                            $html .= "<span class='wpp__section fab mobile ". get_option('wpp__style_mb') ."' $tooltip><i class='fa fa-whatsapp' aria-hidden='true'></i></span>";
                        else: 
                            $html .= "<span class='wpp__section mobile ". get_option('wpp__style_mb') ."'><img src='". WWBTN_URL . "/images/whatsapp/wpp__business.png" ."' $tooltip alt=''></span>";
                        endif;
                    $html .= "</a>";
                endif;
            endif;
            ?>
            <script>
                $(function () {
                    $('[data-toggle="tooltip"]').tooltip();
                });
            </script>
            <?php
            echo $html;
        }

    }

?>