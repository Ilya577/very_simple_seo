<?php

class Base_VSimple_DB_Helper{

    protected Base_VSimple_Core $core;
    protected static $instance;
    protected string $settings_field = 'vsimple_settings';
    protected array $vsimple_pair_settings_text = [
        'all_words' => 'Подсчет всех слов',
        'with_numbers' => 'Учитывать цифры и числовые значения? Может работать не точно, еще в разработке',
        'procent_keys' => 'Проводить анализ и % соотношение ключевых слов',
        'water' => 'Проверка на воду',
        'spam' => 'Проверка на заспамленность',
    ];
    protected array $default_settings = [];

    /*
    * Какие опции не включать по умолчанию
    */
    public array $except = ['with_numbers'];

    function save_settings($option)
    {
        if(update_option($this->settings_field, $option)){
            $this->core = new Base_VSimple_Core();
            $this->core->redirect_to_settings_page();
        }
    }

    function set_default_settings()
    {
        foreach ($this->vsimple_pair_settings_text as $key => $value) {
            if(in_array($key, $this->except)) continue;
            $this->default_settings[$key] = 'on';
        }
    }

    function get_default_settings()
    {
        return $this->default_settings;
    }

    function get_vsimple_pair_settings_text()
    {
        return $this->vsimple_pair_settings_text;
    }

    function get_settings(array $except = [])
    {
        $option = get_option($this->settings_field, $this->default_settings);

        if(!is_array($option)) {
            return false;
        }

        if(!empty($except)){
            foreach($except as $key){
                unset($option[$key]);
            }
        }
        return $option;
    }

    function delete_settings()
    {
        delete_option( $this->settings_field );
    }

    function is_setting_active(string $setting_name) : bool { 
        $options = $this->get_settings();
        if(!isset($options[$setting_name])) return false;
        return $options[$setting_name] == 'on';
    }


    public static function getInstance(){
		if(static::$instance === null){
			static::$instance = new static();
		}
        if(empty(static::$instance->default_settings)){
            static::$instance->set_default_settings();
        }
		return static::$instance;
	}

    private function __construct(){}

   
}