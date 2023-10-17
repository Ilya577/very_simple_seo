<?php

class Admin_VSimple_Settings{

    protected Base_VSimple_DB_Helper $db_helper;
    protected array $vsimple_pair_settings_text;
    protected  $vsimple_checked_settings;
    protected array $pair_settings;

    function __construct()
    {
        $this->db_helper = Base_VSimple_DB_Helper::getInstance();
        $this->vsimple_pair_settings_text = $this->db_helper->get_vsimple_pair_settings_text();
        $this->vsimple_checked_settings = $this->db_helper->get_settings();
    }

    function is_checked($val){
        if(!isset($this->vsimple_checked_settings[$val])) return false;
        return $this->vsimple_checked_settings[$val] == 'on';
    }

    function generate_checkboxes(){
        foreach($this->vsimple_pair_settings_text as $name => $text){
            $checked = $this->is_checked($name) ? 'checked ' : '';
            echo '<label><input type="checkbox" class="chb_inp" '.$checked.'name="vsimple_settings['.$name.']">'.$text.'</label>';
        }
    }

    function admin_settings_page()
    {
     
        ?>

        <form method="post">

        <p>На всех страницах</p>

        <div class="checkbox_settings">
            <?php
                $this->generate_checkboxes();
            ?>
        </div>
            

            <?php submit_button( 'Сохранить настройки', 'save_vsimple_settings', 'save_vsimple_settings', false );?>
            <?php wp_nonce_field('save_vsimple_settings'); ?>
        </form>

        <?php
    }


}