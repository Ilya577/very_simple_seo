<?php

class Base_VSimple_All_Words{

    protected DOMDocument $dom;
    protected string $url;
    protected bool $with_numbers = false;
    protected static $instance;
    protected string $all_text = '';

    public function set_default_settings()
    {
        $this->dom = new DOMDocument();
        libxml_use_internal_errors(true);
    }

    public function load_page_content(){
        $this->set_default_settings();
        $this->url = get_url();
        $page_content = file_get_contents($this->url);
        $this->dom->loadHTML($page_content);
    }

    public function dont_remove_numbers_from_text(){
        $this->with_numbers = true;
    }

    public function get_textContent()
    {
        $this->load_page_content();
        $this->remove_tags_content(['style', 'script', 'meta', 'title', 'link']);
        $all_text = $this->dom->textContent;
        $all_text = preg_replace('/[^\p{L}\p{N}\s]+/u', ' ', $all_text);
        $all_text = preg_replace('/([A-ZА-Я][a-zа-я]+)/u', ' $1', $all_text);
        if(!$this->with_numbers){
            $all_text = preg_replace('/\d+/u', '', $all_text);
        }
        $this->all_text = $all_text;
    }

    public function Init(string $return = 'count') 
    {
        if($this->all_text == ''){
            $this->get_textContent();
        }
        $all_text = $this->all_text;
        $result = [];
        
            $string = preg_replace('/\s+/', ' ', trim($all_text));
            $length = mb_strlen($string, "UTF-8");
            $words = explode(" ", $string);
            $words = array_filter($words, function ($value) {
                return !preg_match('/^\s*$/u', $value);
            });
            
            switch ($return) {
                case 'count':
                    $result = ['words' => count($words), 'symbols' => $length];
                    break;
                case 'array':
                    $result = $words;
                    break;
                default:
                    $result['count'] = count($words);
                    $result['list'] = $words;
                    break;
            }
        
       
	    return $result;
    }

    public function remove_tags_content(array $tag_names = [])
    {
        foreach ($tag_names as $tag_name) {
            $tags = $this->dom->getElementsByTagName($tag_name);
            foreach ($tags as $tag) {
                $tag->nodeValue = '';
            }
        }
    }

    public static function getInstance(){
		if(static::$instance === null){
			static::$instance = new static();
		}

		return static::$instance;
	}

    private function __construct(){}

}