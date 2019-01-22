<?php
    defined('ABSPATH') or die("Sem scripts kids, por favor.");
    
    /*
    * Plugin name:  WhatsApp Web Button
    * Description:  Adiciona um botão do whatsapp configurável e estilizável para desktop e mobile. Linkado para o WhatsApp Web.
    * Version:      2.0
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
            add_action('admin_init', array($this, 'load__scripts_css'));
            add_action('admin_init', array($this, 'load__scripts_js'));
            add_action('wp_enqueue_scripts', array($this, 'load__scripts_css'));
            add_action('wp_enqueue_scripts', array($this, 'load__front_js'));
            add_action('wp_footer', array($this, 'add__wwbtn_section'));
            add_action('wp_ajax_save__multi_numbers', array($this, 'save__multi_numbers'));
            add_action('wp_ajax_nopriv_save__multi_numbers', array($this, 'save__multi_numbers'));
            add_action('wp_ajax_delete__number', array($this, 'delete__number'));
            add_action('wp_ajax_nopriv_delete__number', array($this, 'delete__number'));
        }

        function add__wwbtn_page() {
            add_menu_page( 'WhatsApp Web Button', 'WhatsApp Web Button', 'edit_posts', 'wwbtn-options', array($this, 'page'), 'dashicons-forms', 80 );
        }

        function page() {
            require WWBTN_DIR . 'settings.php';
        }

        function load__scripts_css() {
            wp_enqueue_style('styles-wwbtn', WWBTN_URL . '/css/style.min.css', array(), null, false);
        }

        function load__scripts_js() {
            wp_enqueue_script('jquery');
            wp_enqueue_script('scripts-wwbtn', WWBTN_URL . '/js/scripts.min.js', array('jquery'), null, false);
            wp_localize_script('scripts-wwbtn', 'wwbtn_ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
        }

        function load__front_js() {
            wp_enqueue_script('jquery');
            wp_enqueue_script('scripts-wwbtn', WWBTN_URL . '/js/scripts.min.js', array('jquery'), null, false);
        }        

        function register__wwbtn_settings() {
            register_setting('wwb__settings', 'wwb__status');
            register_setting('wwb__settings', 'wwb__icon');
            register_setting("wwb__settings", "wwb__file", "custom_icon_upload");
            register_setting("wwb__settings", "wwb__position");
            register_setting("wwb__settings", "wwb__mbposition");
            register_setting("wwb__settings", "wwb__tooltip");
            register_setting("wwb__settings", "wwb__tooltip_pos");
            register_setting("wwb__settings", "wwb__multi_status");
            register_setting('wwb__settings', 'wwb__telefone');
        }

        public function unmask__wwbtn_tel($numero) {
            $tel = array();
            $tel[0] = substr_replace($numero, "", 0, 1);
            $tel[1] = substr_replace($tel[0], "", 2, 1);
            $tel[2] = substr_replace($tel[1], "", 2, 1);
            $tel[3] = substr_replace($tel[2], "", 6, 1);
            return $tel[3];
        }

        function custom_icon_upload($option) {
            if(!empty($_FILES["wwb__file"]["tmp_name"])) {
                $urls = wp_handle_upload($_FILES["wwb__file"], array('test_form' => FALSE));
                $temp = $urls["url"];
                return $temp;
            }
            return $option;
        }

        function save__multi_numbers() {
            $multi_numbers = $_POST["data"];
            if (!empty(get_option('wwb__multi_numbers'))) {
                $labelInval = false;
                $old_options = get_option('wwb__multi_numbers');
                for ($i = 0; $i < count(get_option('wwb__multi_numbers')); $i++) {
                    if ($multi_numbers[$i][0] == $old_options[$i][0]) {
                        $labelInval = true;
                    }
                }
                if ($labelInval == true) {
                    echo "<div class='notice notice-error'><p>O nome definido já está vinculado a outro telefone, tente outro nome.</p></div>";
                } else {
                    foreach ($multi_numbers as $key) {
                        echo "<div class='notice notice-success'><p>Opções alteradas com sucesso.</p></div>";
                        $old_options[count($old_options)] = array($key[0], $key[1]);
                        update_option('wwb__multi_numbers', $old_options);
                    }
                }
            } else {
                echo "<div class='notice notice-success'><p>Opções alteradas com sucesso.</p></div>";
                update_option('wwb__multi_numbers', $multi_numbers);
            }
            wp_die();
        }

        function delete__number() {
            $del_number = $_POST["data"];
            $numbers = get_option('wwb__multi_numbers');
            for ($i = 0; $i < count(get_option('wwb__multi_numbers')); $i++) {
                if ($del_number == $numbers[$i][0]) {
                    unset($numbers[$i]);
                    $numbers = array_values($numbers);
                    echo "<div class='notice notice-success'><p>Opções alteradas com sucesso.</p></div>";
                    update_option('wwb__multi_numbers', $numbers);
                }
            }
            wp_die();
        }

        public function add__wwbtn_section() {
            if (get_option('wwb__status') === 'activated') :
                $img = "";
                $telefone = $this->unmask__wwbtn_tel(get_option('wwb__telefone'));
                if ((get_option('wwb__tooltip')) && !(get_option('wwb__tooltip_pos') == 'none')) :
                    $tooltip = "data-toggle='tooltip' data-placement='". get_option('wwb__tooltip_pos') ."' title='". get_option('wwb__tooltip') ."'";
                endif;
                if ((get_option('wwb__position') !== 'none')) :
                    if (get_option('wwb__icon') == 'wpp__padrao') :
                        $img = WWBTN_URL . '/images/p60x60.png';
                    elseif (get_option('wwb__icon') == 'wpp__business') :
                        $img = WWBTN_URL . '/images/b60x60.png';
                    elseif (get_option('wwb__icon') == 'wpp__custom' && get_option('wwb__file')) :
                        $img = get_option('wwb__file');
                    endif;
                    if (get_option('wwb__multi_status') === 'deactivated') :
                        ?>
                        <a href="https://wa.me/55<?php echo $telefone; ?>" target="_blank" rel="external noopener noreferrer" class="d-none d-md-block">
                            <span class="desktop <?php echo get_option('wwb__position'); ?>" id="wwb__section">
                                <img src="<?php echo $img; ?>" <?php echo $tooltip; ?> alt="WhatsApp Web Button">
                            </span>
                        </a>
                        <?php  
                    elseif (get_option('wwb__multi_status') === 'activated') :
                        ?>
                        <a href="#" target="_blank" data-toggle="modal" data-target="#wwbModal" rel="external noopener noreferrer" class="d-none d-md-block">
                            <span class="desktop <?php echo get_option('wwb__position'); ?>" id="wwb__section">
                                <img src="<?php echo $img; ?>" <?php echo $tooltip; ?> alt="WhatsApp Web Button">
                            </span>
                        </a>
                        <?php 
                    endif;
                endif;
                if ((get_option('wwb__mbposition') !== 'none')) :
                    if (get_option('wwb__icon') == 'wpp__padrao') :
                        $img = WWBTN_URL . '/images/p47x47.png';
                    elseif (get_option('wwb__icon') == 'wpp__business') :
                        $img = WWBTN_URL . '/images/b47x47.png';
                    elseif (get_option('wwb__icon') == 'wpp__custom' && get_option('wwb__file')) :
                        $img = get_option('wwb__file');
                    endif;
                    if (get_option('wwb__multi_status') === 'deactivated') :
                        ?>
                        <a href="https://wa.me/55<?php echo $telefone; ?>" target="_blank" rel="external noopener noreferrer" class="d-md-none">
                            <span class="mobile <?php echo get_option('wwb__mbposition'); ?>" id="wwb__section">
                                <img src="<?php echo $img; ?>" <?php echo $tooltip; ?> alt="WhatsApp Web Button">
                            </span>
                        </a>
                        <?php 
                    elseif (get_option('wwb__multi_status') === 'activated') :
                        ?>
                        <a href="#" target="_blank" data-toggle="modal" data-target="#wwbModal" rel="external noopener noreferrer" class="d-md-none">
                            <span class="desktop <?php echo get_option('wwb__mbposition'); ?>" id="wwb__section">
                                <img src="<?php echo $img; ?>" <?php echo $tooltip; ?> alt="WhatsApp Web Button">
                            </span>
                        </a>
                        <?php  
                    endif;
                endif;
                ?>
                <!-- Modal -->
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
                                        <?php
                                            $multi_numbers = get_option("wwb__multi_numbers");
                                            foreach ($multi_numbers as $key) {
                                                echo "<option value='". $key[1] ."'>". $key[0] ."</option>";
                                            }
                                        ?>
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
                <!-- Modal end -->
                <?php
            endif;
        }
    }

?>