<?php
    defined('ABSPATH') or die("Sem scripts kids, por favor.");
    
    /*
    * Plugin name:  WhatsApp Web Button
    * Description:  Adiciona um botão do whatsapp configurável e estilizável para desktop e mobile. Linkado para o WhatsApp Web.
    * Version:      2.1.0
    * Author:       Flaviano Xavier
    * Author URI:   https://github.com/flavisXavier
    * License:      GPL2
    * License URI:  https://www.gnu.org/licenses/gpl-2.0.html
    */
    
    define('WWBTN_URL', plugins_url('', __FILE__));
    define('WWBTN_DIR', plugin_dir_path(__FILE__));

    $wwbtn = new WWBTN_Engine();
    class WWBTN_Engine {

        function __construct() {
            add_action('admin_menu', array($this, 'add__wwbtn_page'));
            add_action('admin_init', array($this, 'register__wwbtn_settings'));
            if (isset($_GET['page']) && ($_GET['page'] === 'wwbtn-options')) {
                add_action('admin_print_styles', array($this, 'load__scripts'));
                add_filter('admin_footer_text', array($this,'remove_footer_admin'));
            }
            add_action('wp_enqueue_scripts', array($this, 'load__scripts_front'));
            add_action('wp_ajax_save__multi_numbers', array($this, 'save__multi_numbers'));
            add_action('wp_ajax_nopriv_save__multi_numbers', array($this, 'save__multi_numbers'));
            add_action('wp_ajax_delete__number', array($this, 'delete__number'));
            add_action('wp_ajax_nopriv_delete__number', array($this, 'delete__number'));
            add_action('wp_footer', array($this, 'add__wwbtn_section'));
        }

        function add__wwbtn_page() {
            add_menu_page( 'WhatsApp Web Button', 'WhatsApp Web Button', 'edit_posts', 'wwbtn-options', array($this, 'page'), 'dashicons-forms', 80 );
        }

        function page() {
            require WWBTN_DIR . 'settings.php';
            add_action('admin_print_styles-$hook', 'my_enqueue_style');
        }

        function load__scripts() {
            if (function_exists('wp_enqueue_media')) {
                wp_enqueue_media();
            } else {
                wp_enqueue_style('thickbox');
                wp_enqueue_script('media-upload');
                wp_enqueue_script('thickbox');
            }
            wp_enqueue_style('dashicons');
            wp_enqueue_style('wwb-style', WWBTN_URL . '/css/wwb.admin.min.css', array(), null, false);
            // JS
            wp_enqueue_script('jquery');
            wp_enqueue_script('wwb-scripts', WWBTN_URL . '/js/wwb.admin.min.js', array('jquery'), null, false);
            wp_localize_script('wwb-scripts', 'wwbtn_ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
        }

        function load__scripts_front() {
            wp_enqueue_style('wwb-front-style', WWBTN_URL . '/css/wwb.style.min.css', array(), null, false);
            // JS
            wp_enqueue_script('wwb-front-scripts', WWBTN_URL . '/js/wwb.scripts.min.js', array(), null, false);
        }      

        function register__wwbtn_settings() {
            register_setting('wwb__settings', 'wwb__status');
            register_setting('wwb__settings', 'wwb__telefone');
            register_setting("wwb__settings", "wwb__multi_status");
            register_setting('wwb__layout', 'wwb__icon');
            register_setting("wwb__layout", "wwb__file");
            register_setting("wwb__layout", "wwb__position");
            register_setting("wwb__layout", "wwb__mbposition");
            register_setting("wwb__layout", "wwb__tooltip");
            register_setting("wwb__layout", "wwb__tooltip_pos");
        }

        function save__multi_numbers() {
            $multi_numbers = $_POST['data'];
            if (!empty(get_option('wwb__multi_numbers'))) {
                $labelInval = false;
                $old_options = get_option('wwb__multi_numbers');
                foreach ($multi_numbers as $i) {
                    foreach ($old_options as $j) {
                        if ($i[0] == $j[0]) {
                            $labelInval = true;
                        }
                    }
                }
                if ($labelInval) {
                    echo 'fail';
                } else {
                    foreach ($multi_numbers as $key) {
                        $old_options[count($old_options)] = array($key[0], $key[1]);
                        update_option('wwb__multi_numbers', $old_options);
                        echo 'success';
                    }
                }
            } else {
                update_option('wwb__multi_numbers', $multi_numbers);
                echo 'success';
            }
            wp_die();
        }

        function delete__number() {
            $del_number = $_POST["data"];
            $numbers = get_option('wwb__multi_numbers');
            for ($i = 0; $i < count($numbers); $i++) {
                if ($del_number == $numbers[$i][0]) {
                    unset($numbers[$i]);
                    $numbers = array_values($numbers);
                    update_option('wwb__multi_numbers', $numbers);
                    echo 'success';
                }
            }
            wp_die();
        }

        function remove_footer_admin () {
            echo '<span id="footer-thankyou">Desenvolvido por <a href="https://github.com/flavisXavier" target="_blank">Flaviano Xavier</a>.</span>';
        }

        function unmask__wwbtn_tel($numero) {
            $tel = array();
            $tel[0] = substr_replace($numero, "", 0, 1);
            $tel[1] = substr_replace($tel[0], "", 2, 1);
            $tel[2] = substr_replace($tel[1], "", 2, 1);
            $tel[3] = substr_replace($tel[2], "", 6, 1);
            return $tel[3];
        }

        function get__layout($dev, $tel, $pos, $icon, $tool, $multi) {
            $html = '';
            if ($icon == 'default') {
                $img = WWBTN_URL . '/images/p60x60.png';
            } elseif ($icon == 'business') {
                $img = WWBTN_URL . '/images/b60x60.png';
            } elseif ($icon == 'custom' && get_option('wwb__file')) {
                $img = get_option('wwb__file');
            }
            if ($multi == 'deactivated') {
                $html .= '
                    <a href="https://wa.me/55'. $tel .'" target="_blank" rel="external noopener noreferrer">
                        <span class="'. $dev .' '. $pos .'" id="wwb__section">
                            <img src="'. $img .'" '. $tool .' alt="WhatsApp Web Button">
                        </span>
                    </a>
                ';
            } elseif ($multi == 'activated') {
                $select_options = '';
                $numbers = get_option('wwb__multi_numbers');
                foreach ($numbers as $key) {
                    $select_options .= '<option value="'. $key[1] .'">'. $key[0] .'</option>';
                }
                $html .= '
                    <a target="_blank" data-toggle="modal" data-target="#wwbModal" rel="external noopener noreferrer">
                        <span class="'. $dev .' '. $pos .'" id="wwb__section">
                            <img src="'. $img .'" '. $tool .' alt="WhatsApp Web Button">
                        </span>
                    </a>
                    <div class="modal fade" id="wwbModal" tabindex="-1" role="dialog" aria-labelledby="wwbModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="wwbModalLabel">WhatsApp Web Button</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <label for="wwbSelect" class="input-group-text">Entre em contato com...</label>
                                        </div>
                                        <select id="wwbSelect" class="custom-select">
                                            <option value="" selected>Escolha...</option>
                                            '. $select_options .'
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <a href="#" class="btn btn-primary" target="_blank" rel="noopener noreferrer">Entrar em Contato</a>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                ';
            }
            return $html;
        }

        public function add__wwbtn_section() {
            if (get_option('wwb__status') === 'activated') {
                $telefone = $this->unmask__wwbtn_tel(get_option('wwb__telefone'));
                $icon = get_option('wwb__icon');
                if (get_option('wwb__position') !== 'none') {
                    $pos = get_option('wwb__position');
                    if (get_option('wwb__tooltip') && get_option('wwb__tooltip_pos') !== 'none') {
                        $tooltip = 'data-toggle="tooltip" data-placement="'. get_option('wwb__tooltip_pos') .'" title="'. get_option('wwb__tooltip') .'"';
                    }
                    echo $this->get__layout('desktop', $telefone, $pos, $icon, $tooltip, get_option('wwb__multi_status'));
                }
                if (get_option('wwb__mbposition') !== 'none') {
                    $pos = get_option('wwb__mbposition');
                    echo $this->get__layout('mobile', $telefone, $pos, $icon, '', get_option('wwb__multi_status'));
                }
            }
        }
    }
?>