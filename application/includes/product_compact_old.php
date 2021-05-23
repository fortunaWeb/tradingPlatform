<script type="text/javascript">
	$(function(){
		$(document).on("click", "[data-name=another_view]", function(){
			var obj = $(this),
				url = $(obj).data("url"),
				product = $(".product").has($(obj)),
				id = $(product).data("id"),
				msg = $(product).attr("id");
			$.post(url, "id="+id, function(html){
				html = html.replace(/msg0/g, msg);
				var newProduct = $(product).empty().append($(html).find(".product>"));
				if($(obj).hasClass("dropup")){
					$(newProduct).find(".col-xs-12").last().append("<a href='javascript:void(0)' data-name='another_view' data-url='?task=main&action=advanced_view'>Расширенный вид<span class='caret'></span></a>");
				}else{
					$(newProduct).find(".col-xs-12").last().append("<a href='javascript:void(0)' data-name='another_view' data-url='?task=main&action=compact_view' class='dropup'>Компактный вид<span class='caret'></span></a>");
				}
			})
		})
	})
</script>
<?
// fotki
$arr_num = count($data);
for ($j=0; $j<$arr_num ; ++$j) {
	$dir = $_SERVER['DOCUMENT_ROOT']."/images/".$data[$j]['people_id']."/".$data[$j]['id']."/*";
	$photo_arr = glob($dir);
	$count_photo = count($photo_arr);
	if($count_photo > 0){
		$photo = str_replace("/var/www/", "", $photo_arr[0]);
	}

	unset($dir, $photo_arr);
?>
	<div class="col-xs-12 product" data-coords="<?= $data[$j]['coords'];?>" id="msg<?= $j; ?>" data-id='<?= $data[$j]['id'];?>' data-addr="НСО, <?= $data[$j]['live_point'].", ".$data[$j]['street']." д.".$data[$j]['house'];?>">
		<div style="margin-top: -10px;">
			<?
			if($data[$j]['status'] == 3){
				if(!$phone_enter){
					echo "<img title='VIP-статус' width='20px' style='vertical-align: initial;width:20px'  src='images/icon/zv_vip.gif'>";
				}else{
					echo "<img title='VIP-статус' width='20px' style='vertical-align: initial;width:20px'  src='images/icon/vip_phone.png'>";
				}
			}
			if($data[$j]['premium'] == 1){
				if(!$phone_enter){
					echo "<img title='статус-премиум' width='20px' style='vertical-align: initial;width:20px' src='images/icon/zv.gif'>";
				}else{
					echo "<img title='VIP-статус' width='20px' style='vertical-align: initial;width:20px' src='images/icon/prem_phone.png'>";
				}
			}?>
			<span style='color: #4E8631;font-size: 12px;'>
				<? if($data[$j]['user_id'] != 'ngs') echo $data[$j]['date_last_edit'];?>
			</span><span style='font-size: 12px;color: #767676;'> от 
				<? echo substr($data[$j]['date_added'], 0, -5); ?>
			</span>
			<a href="javascript:void(0)" data-name="another_view" data-url="?task=main&action=advanced_view">Расширенный вид<span class="caret"></span></a>
			<div style="float:right">	
				<?if($count_photo > 0){?>
					<a title="есть фото" class="fancybox-thumbs pull-left" href="<?=$photo;?>" data-fancybox-group="msg<?=$j;?>" style="margin-top: 2px;">
						<img class="media-object" src="images/zenit1.png">
					</a>
				<?}?>
			</div>
			<?
			$view_arr = explode('-', $data[$j]['ap_view_date']);
			$race_arr = explode('-', $data[$j]['ap_race_date']);
			$view = $view_arr[2].".".$view_arr[1].".".$view_arr[0];
			$race = $race_arr[2].".".$race_arr[1].".".$race_arr[0];
			if(date('d.m.y', strtotime($race)) < date('d.m.y') || $race_arr[0] == '0000'){
				echo "<span style='font-size: 12px;float: right;color: #1A831E;margin-right: 5px;'>просмотр и заезд сегодня</span>";
			}else{
				echo "<span style='font-size: 12px;float: right;color: #1A831E;margin-right: 5px;'> просмотр: ".$view.", заезд: ".$race."</span>";
			}
			?>
		</div>
		<div data-id="<?echo $data[$j]['status'];?>">
			<span id="product-view">
				<?
				echo "<input data-name='favorit' type='hidden' value='".$data[$j]['favorit']."'>";
				$favorit = !preg_match("/\|".$_SESSION['people_id']."\|/", $data[$j]['favorit']);
				echo Translate::Var_title($data[$j]['type_id'], $data[$j]['topic_id'], $data[$j]['parent_id'], $data[$j]['room_count'], $data[$j]['planning'], $data[$j]['ap_layout'], $data[$j]['deliv_period']);if($data[$j]['active'] == 0)echo " (в архиве)";?>
			</span>	
			<span>
				<a href="javascript:void(0)" <?if(!$phone_enter)echo "onClick='show_address(\"".$data[$j]['coords']."\", ".$j.")' target='_blank' data-toggle='modal' data-target='#modal-win'";?>>
					<span style="font-size: 17px;">
						<?php 
						echo ($data[$j]['live_point'] == "Новосибирск" ? $data[$j]['dis'] : $data[$j]['live_point']);; 					
						if(strlen($data[$j]['street']) > 3){
							echo  ", ".$data[$j]['street'];
						}
						if ($data[$j]['house']) echo " ".$data[$j]['house'] .""; 
						?>
					</span>
				</a>
				<span style='font-size: 20px;'><?php echo Helper::Price($data[$j]['price'],$data[$j]['prepayment'],$data[$j]['utility_payment'], $data[$j]['deposit']); if(intval($data[$j]['torg'])==1) echo"<span class='gray' style='font-size: 16px;vertical-align: text-top;'>(торг)</span>";?></span>
			</span>	
		</div>
		
		<div class="product-description">
			<? if($topic != 'Продажа' && $parent != "Гаражи" && $parent != "Дачи" &&  $data[$j]['user_id'] != "ngs"){?>
				<b style="font-size:18px; color:#1A831E;"><?echo Helper::FurnList($data[$j]['inet'], $data[$j]['furn'], $data[$j]['tv'], $data[$j]['washing'], $data[$j]['refrig'], $data[$j]['conditioner'], $data[$j]['ap_view_date'], $data[$j]['ap_race_date'], $data[$j]['residents']);?></b>			
			<?}?>
		</div>	
		<?/*?>
		<div style='margin-top: 5px;'>
			<?echo "<button style='height: 22px;padding: 0px 5px;' class='btn btn-primary' onClick='OpenProductMenu(".$data[$j]['id'].")'>Меню</button>";				
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
				</div>";?>
					<b style='color:#1A831E;'><?=$data[$j]['company_name']; ?> </b>
					<?echo $data[$j]['name']." ".$data[$j]['second_name']." ".$data[$j]['phone'];
					if(ereg($data[$j]['people_id'].",", $_SESSION['in_black_list'])){
						echo "<span data-name='black-agent' style='cursor:pointer; color:red; display:inline-block; font-size: 13px; 'target='_blank' data-toggle='modal' data-target='#add-to-black-list-modal-win'>Агент в черном списке</span>";
					}if($data[$j]['ap_view_price'] > 0){
						echo "<span class='gray'>покажу, оформлю за ".$data[$j]['ap_view_price']."</span>";
					}?>
					<span style="float:right"><?
						if(floatval($data[$j]['sq_all']) || floatval($data[$j]['sq_live'])|| floatval($data[$j]['sq_k'])) 
						{ 
							echo "<span id='span-square'>пл: </span>  ";
							if($parent != "Гаражи" && $parent != "Дачи"){
								if($data[$j]['sq_all']){echo $data[$j]['sq_all']."/";}else{echo "-/";}
								if($data[$j]['sq_live']){echo $data[$j]['sq_live']."/";}else{echo "-/";}
								if($data[$j]['sq_k']){echo $data[$j]['sq_k'];}else{echo "-";}
							}else if (floatval($data[$j]['sq_live']) && $data[$j]['user_id'] !="ngs"){
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
						}
						echo "<span style='margin-left: 5px;'>";
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
						echo "</span>";?>
					</span>
		</div>
		<?*/?>
	</div>
<?}
unset($photo, $count_photo);
?>