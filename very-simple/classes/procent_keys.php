<?php

class Base_VSimple_Procent_Keys{

    protected Base_VSimple_All_Words $all_words;
    protected array $words;
    protected bool $consider_single = true;

    function Init(){
      
        $words = $this->words;
        $keyCount = [];
     
        $count_words = count($words);
        foreach($words as $word){
            $word = strtolower($word);
            if (array_key_exists($word, $keyCount)) {
                $keyCount[$word]['count']++;
                $keyCount[$word]['procent'] = round(($keyCount[$word]['count'] / $count_words * 100), 3) . '%';
            } 
            else {
                $procent = $this->consider_single ? round((1/$count_words * 100), 3) : 0.000;
                $keyCount[$word] = [
                    'count' => 1,
                    'procent' => $procent. '%',
                ];
            }
        }

        if(!$this->consider_single){
            foreach ($keyCount as $key => $value) {
                if ($value['count'] == 1) {
                    unset($keyCount[$key]);
                }
            }
        }

        uasort($keyCount, function ($a, $b) {
            return $b['count'] - $a['count'];
        });           
        

        return $keyCount;
    }

    function set_all_words($all_words = null){
        if(is_null($all_words)){
            $this->all_words = Base_VSimple_All_Words::getInstance();
            $this->words = $this->all_words->Init('array');
        }
        else{
            $this->words = $all_words;
        }
        return $this;
    }

    function dont_consider_single(){
        $this->consider_single = false;
        return $this;
    }

}