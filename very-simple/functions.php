<?php

if(!function_exists('i')){
	function i($v){
		echo '<pre>' . print_r($v, true) . '</pre>';
	}
}

function is_vsimple_admin(){
	return current_user_can('administrator');
}

function get_url(){
	return ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}

function panel_block($pb_title, $pb_second_title, $params, $array_key, $pb_first_text = '', $sum_array_key = '', $pb_second_text = '', $sum2_array_key = ''){ 
	if(!isset($params[$array_key])) return false;
	$array_key = $params[$array_key];
	ob_start();
	?>
	<div class="panel_block">
                    <h2><?=$pb_title?></h2>
						<?= $pb_first_text != '' ? '<p>'.$pb_first_text.' '.$array_key[$sum_array_key].'</p>' : '' ?>
						<?= $pb_second_text != '' ? '<p>'.$pb_second_text.' '.$array_key[$sum2_array_key].'</p>' : '' ?>
                        <h4><?=$pb_second_title?></h4>
                        <table class="vsimple_table">
							<thead>
								<tr>
									<th>Слово</th>
									<th>Кол-во</th>
									<th>Процент</th>
								</tr>
							</thead>
								
                            <tbody>
                                <?php foreach($array_key as $key => $arr){ 
                                    if($key == $sum_array_key) continue;
									if($key == $sum2_array_key) continue;
                                    ?>
                                    <tr>
                                    <td><?=$key?></td>
                                   <?php  foreach ($arr as $info => $val){ ?>
                               
                                    <td><?=$val?></td>
                                
                                <?php } ?>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                </div>
<?php 
return ob_get_clean();
}