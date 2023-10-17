<div class="vsimple_panel">
        <button class="toggle-button">СЕО-отчет</button>
        <div class="panel-content">

            <?php if(isset($params['all_words'])):?>
                <div class="panel_main">
                    <h2>Количество слов и символов</h2>
                        <p>Слов: <?=$params['all_words']['words']?></p>
                        <p>Символов: <?=$params['all_words']['symbols']?></p>
                </div>
            <?php endif;?>

            <div class="panel-flex">  
                <?=panel_block('Ключевые слова', 'Список всех ключей:', $params, 'procent_keys')?>
                <?=panel_block('Вода в тексте', 'Слова - "паразиты":', $params, 'water', 'Процент воды:','sum_procent', 'Всего слов - "паразитов":','sum_count')?>
                <?=panel_block('Заспамленность', 'Часто используемые слова:', $params, 'spam', 'Процент заспамленности:','spam_procent')?>
            </div>

        </div>
    </div>
    