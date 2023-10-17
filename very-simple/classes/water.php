<?php

class Base_VSimple_Water{

    protected Base_VSimple_All_Words $all_words;
    protected float $sum_procent;
    protected int $sum_count;
    public array $water_words = array(
        "а", "лишь", "но",
        "что", "когда", "если",
        "зато", "или", "словно",
        "ибо", "так", "чем",
        "же", "как", "тому", "же",
        "без", "к", "под",
        "в", "на", "по",
        "до", "о", "про",
        "для", "об", "с",
        "за", "от", "из-за",
        "как раз", "лишь", "уж",
        "вот", "даже", "бы",
        "вон", "ни", "именно",
        "разве", "же", "и", "ну",
        "только", "ведь", "всё-таки",
        "счастью", "значит", "кроме",
        "наверное", "вероятно", "во-первых",
        "возможно", "кстати", "следовательно",
        "однако", "бесспорно", "пожалуй",
        "очень", "далеко", "уже",
        "сильно", "совсем", "также",
        "немного", "там",
        "давно", "через", "тут",
        "недолго", "почти", "туда"
    );

    function Init(){
        $this->all_words = Base_VSimple_All_Words::getInstance();
        $words = $this->all_words->Init('array');
        $wordCount = [];

        $count_words = count($words);
        foreach($words as $word){
            $word = strtolower($word);
            if (in_array($word, $this->water_words)) {
                if (!array_key_exists($word, $wordCount)) {
                    $wordCount[$word] = [
                        'count' => 0,
                        'procent' => '0.000%',
                    ];
                }
                $wordCount[$word]['count']++;
                $wordCount[$word]['procent'] = round(($wordCount[$word]['count'] / $count_words * 100), 3) . '%';
            } 
        }
        uasort($wordCount, function ($a, $b) {
            return $b['count'] - $a['count'];
        });

        $this->sum_count = 0;
        $this->sum_procent = 0.000;

        foreach ($wordCount as $wordData) {
            $this->sum_count += floatval($wordData['count']);
            $this->sum_procent += floatval($wordData['procent']);
        }
        $wordCount['sum_count'] = $this->sum_count;   
        $wordCount['sum_procent'] = $this->sum_procent . '%';   
        

        return $wordCount;
    }

}