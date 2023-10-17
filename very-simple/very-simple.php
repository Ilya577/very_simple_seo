<?php 

/*
 * Plugin Name: Very Simple
 * Description: СЕО: ключи, вода и заспамленность
 * Author: Ilya
 * Version: 1.0.1
 */


if ( ! defined( 'ABSPATH' ) ) exit;
require_once( 'functions.php');
require_once( 'classes/init.php');

/*
* Путь, включая папку плагина, без слеша
*/
define( 'VSIMPLE_DIRNAME', plugin_dir_path(__FILE__) );

/*
* Путь, в главную папку плагина без слеша
*/
define( 'VSIMPLE_MAIN_DIR',plugins_url('', __FILE__) );
define( 'VSIMPLE_PATH', dirname( __FILE__ ) ); 

if ( !class_exists('Very_Simple') ) :

final class Very_Simple{

    protected Admin_VSimple_Settings $admin_settings;
    protected Base_VSimple_DB_Helper $db_helper;
    protected Base_VSimple_Core $core;
    protected Base_VSimple_All_Words $all_words;
    protected bool $with_numbers = false;
    protected Base_VSimple_Procent_Keys $procent_keys;
    protected Base_VSimple_Water $water;
    protected Base_VSimple_Spam $spam;
    protected string $admin_settings_url;
    public $vsimple_pair_settings_values;
    public array $env;

    function Init()
    {
        //$start = microtime(true);
        if(!is_vsimple_admin() || is_404()){
           return false;
        }

        $this->admin_settings_url = strtolower(__CLASS__);
        $this->admin_settings = new Admin_VSimple_Settings();
        $this->core = new Base_VSimple_Core();
        $this->db_helper = Base_VSimple_DB_Helper::getInstance();

        $this->core->enqueue();

        add_action('admin_menu', function(){
            add_menu_page( 'Страница настроек Very Simple', 'Настройки Very Simple', 'manage_options', $this->admin_settings_url, [$this->admin_settings, 'admin_settings_page'], 'dashicons-text-page', 58);
        });

        $this->set_enviroment();

        if($this->check_post()){
            if($this->env['post']['save_vsimple_settings'] && $this->core->check_nonce('save_vsimple_settings')){
                if(isset($this->env['post']['vsimple_settings'])){
                    $settings = $this->env['post']['vsimple_settings'];
                }
                else{
                    $settings = 'vsimple_settings';
                }
              
                $this->db_helper->save_settings($settings);
            }
        }

        $this->vsimple_pair_settings_values = $this->db_helper->get_settings($this->db_helper->except);
        //echo microtime(true) - $start;
    }


    function set_enviroment(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->env['post'] = $_POST;
        }
        elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->env['get'] = $_GET;
        }
    }

    function check_post(){
        return isset($this->env['post']);
    }

    function init_settings_classes(){
        if(is_admin() || !$this->vsimple_pair_settings_values) return false;

        if($this->db_helper->is_setting_active('with_numbers')){
            $this->with_numbers = true;
        }

        if($this->db_helper->is_setting_active('all_words')){
            $this->all_words = Base_VSimple_All_Words::getInstance();
            if($this->with_numbers){
                $this->all_words->dont_remove_numbers_from_text();
            }
            $all_words_count = $this->all_words->Init();
            $this->vsimple_pair_settings_values['all_words'] = $all_words_count;
        }

        if($this->db_helper->is_setting_active('procent_keys')){
            $this->procent_keys = new Base_VSimple_Procent_Keys();
            $procent_keys_array = $this->procent_keys->set_all_words()->Init();
            $this->vsimple_pair_settings_values['procent_keys'] = $procent_keys_array;
        }

        if($this->db_helper->is_setting_active('water')){
            $this->water = new Base_VSimple_Water();
            $water_array = $this->water->Init();
            $this->vsimple_pair_settings_values['water'] = $water_array;
        }

        if($this->db_helper->is_setting_active('spam')){
            $this->spam = new Base_VSimple_Spam();
            $spam_array = $this->spam->Init();
            $this->vsimple_pair_settings_values['spam'] = $spam_array;
        }
        $this->core->get_panel($this->vsimple_pair_settings_values);
    }

    function add_value_to_option(string $option, array $array){
        if($this->db_helper->is_setting_active($option)){
            $this->vsimple_pair_settings_values[$option] = $array[$option];
            return $this->vsimple_pair_settings_values[$option];
        }
    }



    function vsimple_on_activation(){
        $this->db_helper = Base_VSimple_DB_Helper::getInstance();
        if(!$this->db_helper->get_settings($this->db_helper->except)){
            $default_settings = $this->db_helper->get_default_settings();
            $this->db_helper->save_settings($default_settings);
        }
    }

    function vsimple_on_uninstall(){
        $this->db_helper->delete_settings();
    } 

}

$very_simple = new Very_Simple();

register_activation_hook(__FILE__, [$very_simple, 'vsimple_on_activation']);

register_uninstall_hook(__FILE__, [$very_simple, 'vsimple_on_uninstall']);

add_action('init', [$very_simple, 'Init']);
add_action('template_redirect', [$very_simple, 'init_settings_classes']);

endif;




