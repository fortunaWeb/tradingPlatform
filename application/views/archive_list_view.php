
<?php
	if ($data) {
	$arr_num = count($data);
	$query = mysql_query("SELECT name FROM `re_type_object` where (`id` = '". $_GET['parent_id'] ."')");
	$q_type = mysql_fetch_array($query);
	
	$type_object_str = $q_type['name'] 
						.($_GET['parent_id'] == 1 ? " в Аренду" : " на Продажу");
?>

	<div class="row products-list">		
		<h4>
			Архив <?php echo $type_object_str;?>
		</h4>
		
		<?php 
		//$arr_num = count($data);
		// echo $arr_num;  <?php echo $j+1; 
		for ($j=0; $j<$arr_num; ++$j) {
		?>
			<div class="col-xs-12 product" id="msg<?php echo $j; ?>">		
				<div class="col-xs-3 product-image">			
					<?php
						if($data[$j]['user_id'] == 'ngs') { 
							echo '<a class="pull-left" href="'. $data[$j]['link'] .'" target="_blank">
								<img class="media-object" alt="200x150" src="" style="max-width: 200px; width: 100%;">
								</a>';
						} else {
							if($data[$j]['photo'][0]['photo']) {
								echo "<a class='pull-left' href=''><img  class='media-object' alt='200x150' 	style='max-width: 200px; width: 100%;' src='images/". $data[$j]['photo'][0]['user_id'] ."/". $data[$j]['photo'][0]['var_id'] ."/". $data[$j]['photo'][0]['photo'] ."' /><div id='photo_back'>". count($data[$j]['photo']) ."</div></a>";
							} else {
								echo '<a class="pull-left"  href=""><img class="media-object" alt="200x150" src="" style="max-width: 200px; width: 100%;"></a>';
							}
						}
					?>				
				</div>
				<div class="col-xs-7 product-description">
					<span id="product-view" class="center">
						<?php 
							$query = mysql_query("SELECT name FROM `re_type_object` where (`id` = '". $data[$j]['type_id'] ."')");
							$q_type = mysql_fetch_array($query);
							echo $q_type['name'] . ($data[$j]['topic_id'] == 1 ? " в Аренду" : " на Продажу");
						?>
					</span>
					<span id="price"><?php echo $data[$j]['price']; ?> руб.</span>
					<span id="address">
						<?php echo $data[$j]['live_point'] .", "; ?>	ул. 
						<?php echo $data[$j]['street'] .", "; ?> 
						<?php if ($data[$j]['house']) echo $data[$j]['house'] .""; ?> 
						<?php if($data[$j]['orientir'] != '') 
						echo "<br />Ориентир: ". $data[$j]['orientir']; 
						?>
					</span>
					<span id="description">
						<?php echo mb_strtolower($data[$j]['text'],'utf8'); ?>
					</span>
					<?php if(strlen(mb_strtolower($data[$j]['text'],'utf8')) > 375) { ?>
						<button type="button" class="btn btn-default" onClick="openDescription('msg<?php echo $j; ?>')">
							<span class="glyphicon glyphicon-chevron-down"></span>
						</button>					
					<?php }?>
				</div>
				<div class="col-xs-2">						
					<?php if($data[$j]['user_id'] == 'ngs') { ?>
						<?php echo $data[$j]['contact_name']; ?> <br />
						<?php echo $data[$j]['contact_tel']; ?> <br /> 
						<?php echo $data[$j]['contact_email']; ?>
					<?php } else { ?>
						<?php echo $data[$j]['contact']['company_name']; ?> <br />
						<?php echo $data[$j]['contact']['phone']; ?> <br /> 
						<?php echo $data[$j]['contact']['fio']; ?>
					<?php } ?>				
				</div>
				<div class="col-xs-12">
					<span class="date">
						<?php echo date("d M Y H:m", strtotime($data[$j]['date_last_edit'])); ?>
					</span>					
					<span class="right">
						<?php if($data[$j]['sq_all']) { echo "<span id='span-square'>пл: </span>  ". $data[$j]['sq_all'] ."/". $data[$j]['sq_live'] ."/". $data[$j]['sq_k'] . "  м<sup>2</sup>"; } ?>
					</span>	
					<span class="right">
						<?php 
							if($data[$j]['floor']) echo "<span id='span-floor'>этаж: </span>". $data[$j]['floor'];
							if($data[$j]['floor_count']) echo "/". $data[$j]['floor_count'];
						?>
					</span>	
				</div>	
				
				<div class="col-xs-12">
					<span id="control"><a href="?task=profile&action=edit&topic_id=<?php echo $data[$j]['topic_id']; ?>&id=<?php echo $data[$j]['id']; ?>&type_id=<?php echo $data[$j]['type_id']; ?>">Редактировать</a></span>
					
					<span id="control" class="delete"><a href="?task=profile&action=deletevar&id=<?php echo $data[$j]['id']; ?>">Удалить</a></span>
					
					<span id="control"><a href="?task=profile&action=from_archive&id=<?php echo $data[$j]['id']; ?>">Вынести из архива</a></span>
				</div>
			</div>
		<?php } ?>
	</div>
<?php } 
	else {
		echo '<div id="row">
				<p>У вас пока, что не иммется вариантов данного типа.</p>
			</div>';
	}
?>

