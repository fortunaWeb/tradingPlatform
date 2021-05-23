
<?php

?>
<!--end search -->

<div id="spacer" class="spacer-top">Страница <span id="navigation">0</span></div>

<div id="msg-box">
<?php 



$arr_num = count($data);

// echo $arr_num;  <?php echo $j+1; 
for ($j=0; $j<$arr_num; ++$j) {


?>
	<div id="msg<?php echo $j; ?>" class="msg"> 
	
	<ul>
	
		<li id="price"> <?php echo $data[$j]['price']; ?> руб.  <span class="addToFavorites" onclick="addToFavorites(<?php echo $data[$j]['id']; ?>)">Добавить в избранное</span></li>
	</ul>
	<table style="border: none;">
	<tr>
	<td id="left-msg">
		<li id="image">
		<a href="">
<?php

	if($data[$j]['photo'][0]['photo']) {
		echo "<img src='images/". $data[$j]['photo'][0]['user_id'] ."/". $data[$j]['photo'][0]['var_id'] ."/". $data[$j]['photo'][0]['photo'] ."' /><div id='count_photo'><div id='photo_back'>". count($data[$j]['photo']) ."</div></div>";
	} else {
		echo '<image id="image-main" src="" alt="нет фото">';
	}
?>	
		</a>
		<div id="contact-info">
		<?php if($data[$j]['user_id'] == 'ngs') { ?>
			C НГС
		<?php } else { ?>
			Тел: <?php echo $data[$j]['contact']['phone']; ?> <br /> 
			АН: <?php echo $data[$j]['contact']['company_name']; ?> <br />
			<?php echo $data[$j]['contact']['fio']; ?>
		<?php } ?>
		</div>
		</li>
		</ul>
	</td>
	<td id="right-msg">
		<ul>
		<li id="street">
		
		Ул. <?php echo $data[$j]['street'] ." "; ?> <?php if ($data[$j]['house']) echo $data[$j]['house'] .", "; ?> <?php if ($data[$j]['dis']) echo $data[$j]['dis'] ." район, "; ?><?php echo "г. ". $data[$j]['live_point']; ?><?php if($data[$j]['orientir'] != '') echo "<br />Ориентир: ". $data[$j]['orientir']; ?></li> 
		<!--
		<li id="metro"><?php if($data[$j]['metro']) { echo "<image id='image_metro' src='images/tintmetroicon.png'>метро ". $data[$j]['metro']; } ?></li>
		-->
		<li id="square">
			<span id="span-square">
			<?php if($data[$j]['sq_all']) { echo "Пл: ". $data[$j]['sq_all'] ."/". $data[$j]['sq_live'] ."/". $data[$j]['sq_k'] . "  м<sup>2</sup>"; } ?> </span> 
			<span id="span-floor">
			<?php if($data[$j]['floor']) echo "Этаж: ". $data[$j]['floor'];
				  if($data[$j]['floor_count']) echo "/". $data[$j]['floor_count'];
			?>
		</li>
		<li id="type">
<?php
		
		$query = mysql_query("SELECT name FROM `re_type_object` where (`id` = '". $data[$j]['type_id'] ."')");
		$q_type = mysql_fetch_array($query);

        echo $q_type['name'] ." на Продажу";

?>
		</li>

		
		<p id="text_show" style=""><?php echo substr(mb_strtolower($data[$j]['text'],'utf8'), 0 , 290); ?> </p>
		
		
		</ul>
	</td>
	</tr>
	</table>
		
	</div>
 


<?php } ?>
</div>
<div id="spacer" class="spacer-bottom"></div>
<?php
require_once 'application/includes/pagination.php';
 ?>


