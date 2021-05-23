<?
$_SESSION["in_black_list"] = Get_functions::Get_black_list();
$arr_num = count($data);
for ($j=0; $j<$arr_num ; ++$j) {
	$type_obj_arr = array(
		1=>"Квартиры",
		18=>"Комнаты",
		3=>"Коттеджи-дома",
		4=>"Земля",
		6=>"Гаражи/парковки",
		7=>"Коммерческая"
	);
	$message_text = "ВНИМАНИЕ! На объект в разделе {$type_obj_arr[$data[$j]['parent_id']]} по адресу {$data[$j]['live_point']} {$data[$j]['street']} {$data[$j]['house']} за {$data[$j]['price']}р. поступили замечания: ";
	$reviews = DB::Select("CONCAT(if(r.anonymous=0, concat(p.name,' ',p.second_name,' АН: «', c.company_name, '» '), concat(p.id,' ')), DATE_FORMAT(DATE_ADD(r.review_date, INTERVAL -1 hour), '%d.%m.%Y %H:%i:%s'), ' (текст замечание: ',r.review, ')') as content", "re_review as r, re_people as p, re_company as c", "r.people_id = p.id AND p.company_id = c.id AND r.var_id={$data[$j]['id']} AND r.checked=0");
	for($r=0; $r<count($reviews); $r++){
		$message_text.= ($r+1).". ".$reviews[$r]['content'];
	}
	$message_text .=". В связи с этим администратором предприняты следующие меры:";
	$ngs = $data[$j]['user_id'] == 'ngs';
	$my_var = $_SESSION["people_id"]==$data[$j]['people_id'];
	$company_var = $_SESSION["company_name"] == $data[$j]['company_name'];
	/*$url = "?task=var&id=".$data[$j]['id'];
	if($data[$j]['user_id'] == 'ngs'){$url = $url."&ngs=1";}*/		
	if(!$ngs){
		$dh = opendir("images/".$data[$j]['people_id']."/".$data[$j]['id']."");
		$i = 0;
		while($file = readdir($dh)){
			if($file=="main.jpg"){
				$imgUrl = "images/".$data[$j]['people_id']."/".$data[$j]['id']."/main.jpg";
			}
			$i++;
		}
		$i= $i-3;
		unset($file, $dh);
	}
	else if(strlen($data[$j]['photos']) > 5){
		$imgUrl = $data[$j]['link'];
	}
	 
	?>
	<div class="col-xs-12 product" data-coords="<?echo $data[$j]['coords'];?>" id="msg<?php echo $j; ?>" data-id='<?echo $data[$j]['id'];?>' data-addr="НСО, <?echo $data[$j]['live_point'].", ".$data[$j]['street']." д.".$data[$j]['house'];?>">
		<div class="col-xs-12" style="position: absolute;font-size: 12px;color: #767676;">
		<?if($_GET['action'] == "mytype" && $_GET['active'] == 1 && $company_var)
			echo "<input type='checkbox' onChange='showButtons($(this))' data-id='".$data[$j]['id']."' style='float: left;    margin-right: 5px;margin-left: -18px;'>";?>
			<span style='color: #4E8631;' data-id="last-edit">
				<? if(!$ngs) echo $data[$j]['date_last_edit'];?>
			</span> от <span>
				<? echo substr($data[$j]['date_added'], 0, -5); ?>
			</span>
		</div>
		<div style='display: inline-block;float: left;position: absolute;top: 30px;left: 2px; width: 20px;' data-id="<?echo $data[$j]['status'];?>">
			<?if($data[$j]['status'] == 3){
					if(!$phone_enter){
						echo "<img title='VIP-статус' width='20px' src='images/icon/zv_vip.gif'>";
					}else{
						echo "<img title='VIP-статус' width='20px' src='images/icon/vip_phone.png'>";
					}
				}
				if($data[$j]['premium'] == 1){
					if(!$phone_enter){
						echo "<img title='статус-премиум' width='20px' src='images/icon/zv.gif'>";
					}else{
						echo "<img title='VIP-статус' width='20px' src='images/icon/prem_phone.png'>";
					}
				}?>
		</div>
		<div class="col-xs-2 product-image" style="margin-top:20px; margin-right:20px;min-width: 210px;">			
			<a class="<?if (isset($imgUrl) && !$ngs) echo "fancybox-thumbs";?> pull-left" href="<?echo (isset($imgUrl)) ? $imgUrl : 'javascript:void(0)';?>" data-fancybox-group='msg<?php echo $j;?>' <?if($ngs) echo "target='_blank'";?>>
				<?php
					if(isset($imgUrl)) {
						if($ngs) {
							echo '<img class="media-object" alt="180x135" src="/images/ngs.png" style="max-width: 185px; width: 185px;">';
						}else{
							echo "<img  class='media-object' alt='180x135' style='max-width: 200px; width: 185px; height:135px;' src='".$imgUrl."' /><div id='photo_back'>". $i ."</div>";
						}
					}else{
						echo '<img class="media-object" alt="180x135" src="/images/noPhoto.png" style="max-width: 180px; width: 185px;">';
					}
				
				unset($imgUrl, $i);
				?>
			</a>				
		</div>
		<div class="col-xs-7 product-description">
			<span id="product-view">
				<?
				if(!$ngs){
					echo "<input data-name='favorit' type='hidden' value='".$data[$j]['favorit']."'>";
					$favorit = !preg_match("/\|".$_SESSION['people_id']."\|/", $data[$j]['favorit']);
				}
				echo Translate::Var_title($data[$j]['type_id'], $data[$j]['topic_id'], $data[$j]['parent_id'], $data[$j]['room_count'], $data[$j]['planning'], $data[$j]['ap_layout'], $data[$j]['deliv_period']);if($data[$j]['active'] == 0)echo " (в архиве)";?>
			</span>	
			<a href="javascript:void(0)" <?if(!$phone_enter)echo "onClick='show_address(\"".$data[$j]['coords']."\", ".$j.")' target='_blank' data-toggle='modal' data-target='#modal-win'";?>>
				<span id="address" style='display:inline-block;'>
					<?php 
					echo ($data[$j]['live_point'] == "Новосибирск" ? $data[$j]['dis'] : $data[$j]['live_point']);; 					
					if(strlen($data[$j]['street']) > 3){
						echo  ", ".$data[$j]['street'];
					}
					if ($data[$j]['house']) echo " ".$data[$j]['house'] .""; 
					if($data[$j]['orientir'] != '') echo " <span class='gray' style='font-size: 16px;'>(". $data[$j]['orientir'].")</span>"; 
					?>
				</span>
			</a>
			<span id="price"><?php echo Helper::Price($data[$j]['price'],$data[$j]['prepayment'],$data[$j]['utility_payment'], $data[$j]['deposit']); if(intval($data[$j]['torg'])==1) echo"<span class='gray' style='font-size: 16px;vertical-align: text-top;'>(торг)</span>";?></span>
			<? if($topic != 'Продажа' && $parent != "Гаражи" && $parent != "Дачи" &&  !$ngs){?>
				<b style="font-size:18px; color:#1A831E;"><?echo Helper::FurnList($data[$j]['inet'], $data[$j]['furn'], $data[$j]['tv'], $data[$j]['washing'], $data[$j]['refrig'], $data[$j]['conditioner'], $data[$j]['ap_view_date'], $data[$j]['ap_race_date'], $data[$j]['residents']);?></b>
			<?}?>	
			<?if($parent=="Дома" && !$ngs){?><span>
				<b style="color: #1A831E;">Санузел:</b> <?echo $data[$j]["wc_type"];?>
				<b style="color: #1A831E;">Отопление:</b> <?echo $data[$j]["heating"];?>
				<b style="color: #1A831E;">Мыться:</b> <?echo $data[$j]["wash"];?><br />
				<b style="color: #1A831E;">Вода:</b> <?echo $data[$j]["water"];?>
				<b style="color: #1A831E;">Канализация:</b> <?echo $data[$j]["sewage"];?>
			</span><?}?>			
			<span class="description">				
				<div onClick="openDescription('msg<?=$j;?>')" style='cursor:pointer'>
					<? echo $data[$j]['text'];?>
				</div>
			</span>
			<span class="shading"></span>
			<?if ($_GET["action"]=="mytype" && $data[$j]["hidden_text"] !="" && $my_var){?>
				<span class="info" style="margin-top: 10px;">
					<span class="info-title">Скрытое описание</span>
					<?echo $data[$j]["hidden_text"];?>
				</span>
			<?}?>
		</div>
		<?if($_SESSION["post"]["without_cont"]!=1){
			$owner = ($_SESSION["user"] == $data[$j]['user_parent'] || $_SESSION["user"] == $data[$j]['user_id']);?>
			<div class="col-xs-2 right" data-name='people' style="word-wrap: break-word;position: absolute;right: 0px;<?if($owner)echo "cursor:pointer;";?>" <?if(isset($data[$j]['people_id'])) echo "data-people-id='".$data[$j]['people_id']."'";?>
			<?if($owner) echo "onClick='EmployeeList(".$data[$j]['id'].",\"".$data[$j]['company_name']."\",".$data[$j]['user_id'].")'"; unset($owner);?>>						
				<?php if($ngs) { ?>
					<?=$data[$j]['contact_name']; ?> <br />
					<?=$data[$j]['contact_tel']; ?> <br /> 
					<?=$data[$j]['contact_email']; ?>
				<?php } else { ?>
					<b style='color:#1A831E;'><?=$data[$j]['company_name']; ?> </b><br />
					<span data-name="io">
						<?=$data[$j]['name']." ".$data[$j]['second_name']; ?> <br /> 	
						<?=$data[$j]['phone']; ?> <br /> 	
					</span>
					<?if(ereg($data[$j]['people_id'].",", $_SESSION['in_black_list'])){
						echo "<span data-name='black-agent' style='cursor:pointer; color:red; display:inline-block; font-size: 13px; 'target='_blank' data-toggle='modal' data-target='#add-to-black-list-modal-win'>Агент в черном списке</span>";
					}?>
					<?if($data[$j]['ap_view_price'] > 0){
						echo "<span class='gray'>покажу, оформлю за ".$data[$j]['ap_view_price']."</span>";
					}?>
				<?php } ?>	
				<?/*if($parent=="Дома"){?><div style="margin-top: 15px; margin-left: -25px;">
					<b style="color: #1A831E;">Санузел:</b> <?echo $data[$j]["wc_type"];?><br />
					<b style="color: #1A831E;">Отопление:</b> <?echo $data[$j]["heating"];?><br />
					<b style="color: #1A831E;">Мыться:</b> <?echo $data[$j]["wash"];?><br />
					<b style="color: #1A831E;">Вода:</b> <?echo $data[$j]["water"];?><br />
					<b style="color: #1A831E;">Канализация:</b> <?echo $data[$j]["sewage"];?><br />
				</div><?}*/?>	
			</div>
		<?}?>
		<div class="col-xs-12">
			<? if($_GET['active'] == '1' && ($my_var || $_SESSION['parent']==0)){
				echo "<span id='control'><a href='?task=profile&action=edit&topic_id=".$data[$j]['topic_id']."&id=".$data[$j]['id']."&parent_id=".$data[$j]['parent_id']."'>Редактировать</a></span>				
				<span id='control' class='delete'><a href='javascript:void(0)' onClick='DeleteVar(".$data[$j]['id'].")'>Удалить</a></span>
				<span id='control'><a href='javascript:void(0)' onclick='VarArchive(".$data[$j]['id'].", \"add\")'>В архив</a></span>
				<span id='control'><a href='javascript:void(0)' onclick='VarExtendOne(".$data[$j]['id'].")'>Продлить вариант</a></span>";
			 }else if($_GET['active'] == '0' && ($my_var || $_SESSION['parent']==0)){
				echo "<span id='control'><a href='?task=profile&action=edit&topic_id=".$data[$j]['topic_id']."&id=".$data[$j]['id']."&parent_id=".$data[$j]['parent_id']."'>Редактировать</a></span>
				<span id='control' class='delete'><a href='javascript:void(0)' onClick='DeleteVar(".$data[$j]['id'].")'>Удалить</a></span>
				<span id='control'><a href='?task=profile&action=edit&topic_id=".$data[$j]['topic_id']."&id=".$data[$j]['id']."&parent_id=".$data[$j]['parent_id']."'>Вынести из архива</a></span>";
			}else if(($_GET['task']=="main" || !isset($_GET['task'])) && !$ngs){
				echo "<button style='height: 22px;padding: 0px 5px;' class='btn btn-primary' onClick='OpenProductMenu(".$data[$j]['id'].")'>1Меню</button>";
				if($data[$j]['review'] == 1){
					echo "<span data-id='review' class='gray' style='display:inline-block; margin-left: 10px; font-size: 13px; cursor:pointer' 'target='_blank' data-toggle='modal' data-target='#clean-modal-win'>Есть отзывы</span>";
				}
				echo "<div class='product-menu' data-id=''>
					<span class='glyphicon glyphicon-remove right' onClick='$(this).parent().slideUp(\"fast\")' id='close' style='cursor:pointer;   position: absolute;left: 140px;top: -5px;'></span>
					<a href='javascript:void(0)' data-name='an-info' target='_blank' data-toggle='modal' data-target='#clean-modal-win'><div>информация об АН</div></a>
					<a href='javascript:void(0)' data-name='send-review' target='_blank' data-toggle='modal' data-target='#send-review-modal-win'><div>отзыв</div></a>";
					if(!$favorit){
						echo "<a href='javascript:void(0)' onClick='removeFromFavorites(\"".$data[$j]['user_id']."\", ".$data[$j]['id'].")'><div>в избраном</div></a>";
					}else{
						echo "<a href='javascript:void(0)' onClick='addToFavorites(\"".$data[$j]['user_id']."\", ".$data[$j]['id'].")'><div>в избраное</div></a>";
					}
					echo "<a href='javascript:void(0)' data-name='add-to-black-list' target='_blank' data-toggle='modal' data-target='#add-to-black-list-modal-win'><div>в черный список</div></a>
					<a href='javascript:void(0)' data-name='check-var' target='_blank' data-toggle='modal' data-target='#clean-modal-win'><div>проверить</div></a>
				</div>";
			}else if($_GET['action']=='review_list' && $_SESSION['admin'] == 1){?>
				<button style='height: 22px;padding: 0px 5px;' class='btn btn-primary' onClick='OpenProductMenu(<?=$data[$j]['id']?>)'>Меню1</button>
				<span data-id='review' class='gray' style='cursor:pointer; display:inline-block; margin-left: 10px; font-size: 13px;'  onClick='ReviewListForAdmin(<?=$data[$j]['id']?>)' target='_blank' data-toggle='modal' data-target='#clean-modal-win'>Жалобы <span class='gray'><?=($data[$j]['active']==0? ' Вариант в архиве!':'')?></span></span>
				<span class="gray" style="cursor: pointer;display: inline-block;margin-left: 10px;font-size: 13px;" target="_blank" data-toggle="modal" data-target="#messages-modal-win" onclick="Messages('<?=$data[$j]['people_id']?>', '1', '<?=($data[$j]["surname"]." ".$data[$j]["name"]." ".$data[$j]["second_name"])?>')" data-text="<?=$message_text?>">Отпр. сообщение</span>
				<div class='product-menu' data-id=''>
					<span class='glyphicon glyphicon-remove right' onClick='$(this).parent().slideUp(\"fast\")' id='close' style='cursor:pointer; position: absolute;left: 140px;top: -5px;'></span>
					<a href='javascript:void(0)' onClick="CheckedReview(<?=$data[$j]['id']?>, 0)"><div>проверено</div></a>
					<a href='javascript:void(0)' onClick="VarArchive(<?=$data[$j]['id']?>, 'add', '1')" data-name='review_to_archive'><div>в архив</div></a>
					<a href='javascript:void(0)' onClick="DeleteVar(<?=$data[$j]['id']?>, 1)"><div>удалить сообщение</div></a>
					<a href='javascript:void(0)' onClick="DeletePhotos(<?=$data[$j]['id']?>)"><div>удалить фотографии</div></a>
				</div>
			<?}?>
			<span class="right">
				<?php 
					if(floatval($data[$j]['sq_all']) || floatval($data[$j]['sq_live'])|| floatval($data[$j]['sq_k'])) 
					{ 
						echo "<span id='span-square'>пл: </span>  ";
						if($parent != "Гаражи" && $parent != "Дачи"){
							if($data[$j]['sq_all']){echo $data[$j]['sq_all']."/";}else{echo "-/";}
							if($data[$j]['sq_live']){echo $data[$j]['sq_live']."/";}else{echo "-/";}
							if($data[$j]['sq_k']){echo $data[$j]['sq_k'];}else{echo "-";}
						}else if (floatval($data[$j]['sq_live']) && !$ngs){
							echo $data[$j]['sq_live'];
						}else{
							echo $data[$j]['sq_all'];
						}
						echo "  м<sup>2</sup>"; 
					}else{
						echo "<span id='span-square'>пл: </span>Не указана.";
					}
					if(floatval($data[$j]['sq_land'])){
						echo "<span id='span-square'> уч: </span>  ".$data[$j]['sq_land']." сот.";
					}?>
			</span>	
			<span class="right">				
				<?php 
					if($data[$j]['floor'] && $parent != "Дома")
					{
						echo "<span id='span-floor'>этаж: </span>".$data[$j]['floor'];
						if($data[$j]['floor_count']){
							echo "/".$data[$j]['floor_count'];
						}
					}else if($data[$j]['floor_count'] && $parent != "Дома"){
						echo "<span id='span-floor'>этаж: </span>ср/".$data[$j]['floor_count'];
					}
					if($data[$j]['floor_count'] && $parent == "Дома"){
						echo "<span id='span-floor'>этажность: </span>".$data[$j]['floor_count'];
					}
				?>
			</span>	
		</div>			
	</div>
<?}unset($my_var);?>