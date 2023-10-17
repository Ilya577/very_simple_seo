<?php

class Base_VSimple_Spam{

    protected Base_VSimple_All_Words $all_words;
    protected Base_VSimple_Water $water;
    protected Base_VSimple_Procent_Keys $procent_keys;
    protected float $spam_procent;

    function Init(){

        $this->procent_keys = new Base_VSimple_Procent_Keys();
        $spamCount = $this->procent_keys->set_all_words($this->words_array_without_water())->dont_consider_single()->Init();
        
        $this->spam_procent = 0.000;

        foreach ($spamCount as $spamData) {
            $this->spam_procent += floatval($spamData['procent']);
        }
        $spamCount['spam_procent'] = $this->spam_procent.'%';   

        return $spamCount;
    }

    function words_array_without_water(){
        $this->all_words = Base_VSimple_All_Words::getInstance();
        $this->water = new Base_VSimple_Water();
        $words_array = $this->all_words->Init('array');
        $water_words = $this->water->water_words;

        $words_array_without_water = array_diff($words_array, $water_words);
        return $words_array_without_water;
    }

}