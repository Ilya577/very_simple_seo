<?php

class Base_VSimple_Core{

    protected string $admin_settings_url = 'very_simple';

    function redirect_to_settings_page()
    {
        $redirect_url = admin_url('options-general.php?page='.$this->admin_settings_url); 
        wp_redirect($redirect_url);
    }

    function check_nonce(string $action_name, string $name_of_nonce = '_wpnonce'){
        return isset($_POST[$name_of_nonce]) && wp_verify_nonce($_POST[$name_of_nonce], $action_name);
    }

    function admin_scripts_styles() {
        wp_enqueue_style('custom-admin-styles', VSIMPLE_MAIN_DIR . '/assets/admin/css/vsimple-style.css');
        
        wp_enqueue_script('custom-admin-scripts', VSIMPLE_MAIN_DIR . '/assets/admin/js/vsimple-main.js', array('jquery'), '', true);
    }

    function front_scripts_styles() {
        wp_enqueue_style('custom-styles', VSIMPLE_MAIN_DIR . '/assets/front/css/vsimple-style.css');
        
        wp_enqueue_script('custom-scripts', VSIMPLE_MAIN_DIR . '/assets/front/js/vsimple-main.js', array('jquery'), '', true);
    }

    function enqueue(){
        add_action('admin_enqueue_scripts', [$this, 'admin_scripts_styles']);
        add_action( 'wp_enqueue_scripts', [$this, 'front_scripts_styles'] );
    }

    function get_panel($params){
        if(is_admin()) return false;
        require VSIMPLE_PATH . '/templates/panel.php';
    }
}