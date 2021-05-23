<script>
	$(window).resize(function(){
			var img = $(".photos_list .img-thumbnail");
			border_remove(img);	
	});
	$(function(){		
		setTimeout(function(){
			var img = $(".photos_list .img-thumbnail");
			border_remove(img);	
		}, 100);
		
		$(".photos_list img").mouseover(function(){
			if(!$(this).hasClass("active")){
				border_remove($(this));			
			}
		});
		
		$("img.border").on("click", function(){	
			$(".photos_list img.active").removeClass("active");				
			$("#open_photo").attr("src", $(this).attr("data-src"));
			$(".photos_list img[src='"+ $(this).attr("data-src") +"']").addClass("active");
		});
		
		<?if ($_GET['ngs']=='1'){
			header("Content-Type: text/html; charset=UTF-8");
			$to = $data['link']; // страница донор
			$ref = "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']; // откуда пришли на страницу-донора
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $to);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36 IE/edge');
			curl_setopt($ch, CURLOPT_REFERER, $ref);
			$content = curl_exec($ch);
			curl_close($ch);		
		?>
			var ngs_content = $(<?echo $content;?>).html;
		<?}?>
	});
	
	function border_remove(img){		
		var width = $(img).width();
		var height = $(img).height();
		var top = $(img).offset().top +1;
		var left = $(img).offset().left + 2;
		$("img.border").height(height);
		$("img.border").width(width);
		$("img.border").attr("data-src", $(img).attr("src"));
		$("img.border").offset({'top':top, 'left':left});		
	}	
</script>

<?php	
	$_SESSION['cur_var'] = "";	
	preg_match('#<a class="card__photo-link" rel="card-photo" href="(.*)" title="#', $content, $m); // между какими тегами берем контент
	echo count($m);
	//echo $to;
	$num_photo = count($data['photo']);
	if($_GET['id']){
?>

<div class="row" id="var_view">
	<div class="col-xs-6">
		<div class="photo">
			<?if($num_photo > 0){?>
				<img src="/images/<? echo $data['user_id']."/".$data['id']."/".$data['photo'][0]['photo']; ?>" class="img-thumbnail" id="open_photo">				
			<?}if($num_photo > 1){?>			
				<div class="photos_list">
					<?for($j=0; $num_photo > $j; ++$j){?>				
						<img src="/images/<? echo $data['user_id']."/".$data['id']."/".$data['photo'][$j]['photo']; ?>" class="img-thumbnail">					
					<?}?>								
				</div>		
				<img src="" class="border" data-src="">	
			<?}else if($num_photo == 0){?>
				<span><img src="/images/noPhoto.png" class="img-thumbnail" id="open_photo"></span>
			<?}?>
		</div>
	</div>
	<div class="col-xs-6">
		<span id="product-view"><?php 
			$query = mysql_query("SELECT name FROM `re_type_object` where (`id` = '". $data['type_id'] ."')");
			$q_type = mysql_fetch_assoc($query);
			echo $q_type['name'] . ($data['topic_id'] == 1 ? " в Аренду" : " на Продажу");
		?></span>
		<span id="address">
			<?php echo $data['live_point'] .", "; ?>
			<?php if ($data['dis']) echo "р-он.: ". $data['dis'] .", "; ?> ул. 
			<?php echo $data['street'] .", "; ?> 
			<?php if ($data['house']) echo $data['house'] .""; ?> 
			<?php if($data['orientir'] != '') 
			echo "<br />Ориентир: ". $data['orientir']; 
			?>
		</span>		
		<span id="price"><?php echo number_format($data['price'], 0, ',', ' ')." руб."; ?></span>
		<div class="info">		
			<legend>Информация по объекту</legend>		
			<?php if($data['floor']) echo "<span id='span-floor'>этаж/этажность: ". $data['floor'];
				  if($data['floor_count']){echo "/". $data['floor_count']."</span>";}else{echo "</span>";}
			?>
			
			<?php if($data['sq_all']) { echo "<span id='span-square'>площади: ". $data['sq_all'] ."/". $data['sq_live'] ."/". $data['sq_k'] . "  м<sup>2</sup></span>"; } ?> 
			
			<?php if($data['val_bal']) { echo "<span id='bal_lodg'>балконы/лоджии: ". $data['val_bal'] ."/". $data['val_bal']."</span>"; } ?> 
			<div class="btn-group medium multi-active" id="furniture">
				<button type="button" name="inet" class="btn btn-default <?php if($data['conditioner'] == 1) echo "active"; ?>">
					Интернет
				</button>
				<button type="button" name="furn" class="btn btn-default <?php if($data['furn'] == 1) echo "active"; ?>">
					Мебель
				</button>
				<button type="button" name="tv" class="btn btn-default <?php if($data['tv'] == 1) echo "active"; ?>">
					Телевизор
				</button>
				<button type="button" name="washing" class="btn btn-default <?php if($data['washing'] == 1) echo "active"; ?>">
					Стиральная машина
				</button>
				<button type="button" name="refrig" class="btn btn-default <?php if($data['refrig'] == 1) echo "active"; ?>">
					Холодильник
				</button>
				<button type="button" name="conditioner" class="btn btn-default <?php if($data['conditioner'] == 1) echo "active"; ?>">
					Кондиционер
				</button>				
			</div> 
		</div>	
	</div>
	<div class="col-xs-6">
		<div class="info">	
			<legend>Контактная информация</legend>
			<span>ФИО: <?php echo $data['fio']; ?></span>
			<span>Телефон <?php echo $data['phone']; ?></span>
			<span>АН или группа: <?php echo $data['company_name']; ?></span>
			<span>Email: <?php echo $data['email']; ?></span>
		</div>
	</div>
</div>

<?}?>