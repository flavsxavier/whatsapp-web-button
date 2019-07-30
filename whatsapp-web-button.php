<?php
    defined('ABSPATH') or die("Sem scripts kids, por favor.");
    
    /**    
     * Plugin name:     WhatsApp Web Button
     * Plugin URI:      https://github.com/flavisXavier/whatsapp-web-button
     * Description:     Adiciona um botão do whatsapp configurável e estilizável para desktop e mobile. Linkado para o WhatsApp Web.
     * Version:         2.1.1
     * Author:          Flaviano Xavier
     * Author URI:      https://github.com/flavisXavier
     * License:         GPL2
     * License URI:     https://www.gnu.org/licenses/gpl-2.0.html
     */
    
    define('WWBTN_URL', plugins_url('', __FILE__));
    define('WWBTN_DIR', plugin_dir_path(__FILE__));
    define('WWBTN_VER', '2.1.1');

    $wwbtn = new WWBTN_Engine();
    if (!class_exists('WWBTN_Engine')) {
        class WWBTN_Engine {
            function __construct() {
                add_action('admin_menu', array($this, 'add__wwbtn_page'));
                add_action('admin_init', array($this, 'register__wwbtn_settings'));
                if (isset($_GET['page']) && ($_GET['page'] === 'wwbtn-options')) {
                    add_action('admin_print_styles', array($this, 'load__scripts'));
                    add_filter('admin_footer_text', array($this,'change_footer_admin'));
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
                require WWBTN_DIR . 'core/settings.php';
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
                register_setting('wwb__settings', "wwb__multi_status");
                register_setting('wwb__layout', 'wwb__icon');
                register_setting('wwb__layout', 'wwb__icon_size');
                register_setting('wwb__layout', 'wwb__file');
                register_setting('wwb__layout', 'wwb__position');
                register_setting('wwb__layout', 'wwb__mbposition');
                register_setting('wwb__layout', 'wwb__tooltip');
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
    
            function change_footer_admin () {
                echo '<span id="footer-thankyou">Versão '. WWBTN_VER .'. Desenvolvido por <a href="https://github.com/flavisXavier" target="_blank">Flaviano Xavier</a>.</span>';
            }
    
            function unmask__wwbtn_tel($numero) {
                $tel = array();
                $tel[0] = substr_replace($numero, "", 0, 1);
                $tel[1] = substr_replace($tel[0], "", 2, 1);
                $tel[2] = substr_replace($tel[1], "", 2, 1);
                $tel[3] = substr_replace($tel[2], "", 6, 1);
                return $tel[3];
            }
    
            function get__layout($args) {
                $html = '';
                if ($args['device'] == 'desktop' && get_option('wwb__tooltip') && get_option('wwb__tooltip_pos') !== 'none') {
                    $tooltip = 'tooltip" data-tooltip="'. get_option('wwb__tooltip') .'"';
                } else {
                    $tooltip = '"';
                }
                if ($args['icon'] !== 'custom') {
                    if ($args['size'] == 'small') {
                        $file = substr($args['icon'], 0, 1) . '38x38.png';
                    } elseif ($args['size'] == 'default') {
                        $file = substr($args['icon'], 0, 1) . '47x47.png';
                    } elseif ($args['size'] == 'large') {
                        $file = substr($args['icon'], 0, 1) . '60x60.png';
                    }
                    $file_path = WWBTN_URL . '/images/' . $file;
                } elseif ($args['icon'] == 'custom' && get_option('wwb__file')) {
                    $file_path = get_option('wwb__file');
                }
                if ($args['status'] == 'deactivated') {
                    $html .= '
                        <a href="https://wa.me/55'. $args['number'] .'" target="_blank" rel="external noopener noreferrer">
                            <span class="'. $args['device'] .' '. $args['size'] .' '. $args['position'] .' '. $tooltip .' id="wwb__section">
                                <img src="'. $file_path .'" alt="WhatsApp Web Button">
                            </span>
                        </a>
                    ';
                } elseif ($args['status'] == 'activated') {
                    $html .= '
                        <label class="wwb__modal_btn" for="wwb__modal_trigger">
                            <span class="'. $args['device'] .' '. $args['size'] .' '. $args['position'] .' '. $tooltip .' id="wwb__section">
                                <img src="'. $file_path .'" alt="WhatsApp Web Button">
                            </span>
                        </label>
                    ';
                }
                return $html;
            }
    
            function add__wwbtn_section() {
                if (get_option('wwb__status') === 'activated') {
                    $telefone = $this->unmask__wwbtn_tel(get_option('wwb__telefone'));
                    $icon = get_option('wwb__icon');
                    $size = get_option('wwb__icon_size');
                    if (get_option('wwb__position') !== 'none') {
                        $pos = get_option('wwb__position');
                        echo $this->get__layout(array(
                            'device' => 'desktop',
                            'number' => $telefone,
                            'position' => $pos,
                            'icon' => $icon,
                            'size' => $size,
                            'status' => get_option('wwb__multi_status')
                        ));
                    }
                    if (get_option('wwb__mbposition') !== 'none') {
                        $pos = get_option('wwb__mbposition');
                        echo $this->get__layout(array(
                            'device' => 'mobile',
                            'number' => $telefone,
                            'position' => $pos,
                            'icon' => $icon,
                            'size' => $size,
                            'status' => get_option('wwb__multi_status')
                        ));                
                    }
                    if (get_option('wwb__multi_status') == 'activated') {
                        $select_options = '';
                        $numbers = get_option('wwb__multi_numbers');
                        foreach ($numbers as $key) {
                            $select_options .= '<option value="'. $key[1] .'">'. $key[0] .'</option>';
                        }
                        echo '
                            <input type="checkbox" id="wwb__modal_trigger">
                            <div id="wwb__modal">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1>'. get_option('wwb__tooltip') .'</h1>
                                    </div>
                                    <div class="modal-body">
                                        <div class="input-group">
                                            <div class="input-group-icon">+55</div>
                                            <div class="input-group-area">
                                                <select id="wwbSelect">
                                                    <option value="" selected>Escolha...</option>
                                                    '. $select_options .'
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <label class="modal-close wwb__btn wwb__close" for="wwb__modal_trigger">Fechar</label>
                                        <a href="#!" target="_self" class="wwb__btn wwb__primary">Enviar</a> 
                                    </div>
                                </div>
                            </div>
                        ';
                    }
                }
            }
        }
    }
?>