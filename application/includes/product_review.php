<?
$arr_num = count($data);
for ($j=0; $j<$arr_num ; ++$j) {

	$favorit = !preg_match("/\|".$_SESSION['people_id']."\|/", $data[$j]['favorit']);
	$ngs = $data[$j]['user_id'] == 'ngs' || $data[$j]['user_id'] == 'avito';
	$contacts = $_SESSION["post"]["without_cont"]!=1;
	$company_var = $_SESSION["company_name"] == $data[$j]['company_name'];

    $imgUrl = null;
    if(!$ngs){
        $imgUrl = Helper::checkAgPhotosExists($data[$j]['id'], $data[$j]['people_id']);
    }else if(strlen($data[$j]['photos']) > 5){
        $photo_arr = glob("images/ngs_parse/".$data[$j]['id']."/*");
        if(count($photo_arr) > 0){
            $imgUrl = str_replace($_SERVER['DOCUMENT_ROOT'], "", $photo_arr[0]);
        }
        unset($photo_arr);
    }
	if($data[$j]['review']==1)
	$data[$j]['review'] = Helper::UpdateReview($data[$j]['id']);
		$online = Helper::Online_bool($data[$j]['people_id']);
?>
	<div class="col-xs-12 product <?if($data[$j]['review']==1) echo "hasReview"?>" style="font-family: arial, verdana;font-size: 18px;line-height: normal;" data-coords="<?= $data[$j]['coords'];?>" id="msg<?= $j; ?>" data-id='<?= $data[$j]['id'];?>' data-addr="НСО, <?= $data[$j]['live_point'].", ".$data[$j]['street']." д.".$data[$j]['house'];?>">
		<table>
			<tr>
				<td align="left" style='width: 4%;vertical-align: top;line-height: 0.8;'>
					<font size="2" data-id="last-edit"><?echo date("d/m H:i", strtotime($data[$j]['date_last_edit']));?></font>
					<br />
					<?
                    if($data[$j]['status'] == 3){
							echo "<img title='Гарантия что объекта нет в интернете на прямую от собственника' width='20px' style = 'margin-left: 5px;' src='images/icon/vip.jpg'>";	
					}

					if(isset($data[$j]['link'])){?>
						<br/><a href="<?=$data[$j]['link'];?>" data-id='new-window' style='font-size: 12px;margin-left: 15px;display: inline-block;margin-top: 10px;'><img src="<?=$icon[$data[$j]['user_id']]?>" width="15"></a>
					<?}

						$prolong_garant = " title = 'Не гарантирую актуальность варианта, выясняю это в момент обращения' 
									src='images/icon/prolong_no_garant.jpg'";	
						if(!empty($data[$j]['prolong_garant'])){
							$prolong_garant = " title = 'Гарантирую актуальность варианта на момент последнего продления' 
									src='images/icon/prolong_garant.jpg'";
						}
						echo "<br/><img {$prolong_garant} style = 'margin-top: 5px;margin-left: 5px;' width='20px' >";

					
					if(!empty($imgUrl)){?>
						<br />
						<br />
						<span class="glyphicon glyphicon-envelope send-email" onClick="$(this).next().toggleClass('hidden')" aria-hidden="true" style="cursor: pointer;color: #35AFD4;"></span>
						<div class="send-email-form hidden">
							<div class="col-xs-4 deployed" style='margin-top: 20px;'>
								<label class="signature">Отправить клиенту</label>
								<input class="form-control" data-name="email_for_favor" placeholder="email" onclick="$('.dropdown-menu').has($(this)).show()">
							</div>
							<div class="col-xs-2 deployed">
								<button type="button" onclick="SendVarToEmail($(this), <?=$data[$j]['id'];?>)" style="" class="btn btn-success btn-xs ">Отправить</button>
							</div>
						</div>
					<?}?>
				</td>
				<td>
					<div style="margin-top: -3px;">
						<?echo Translate::Var_title_retro($data[$j]['type_id'], $data[$j]['topic_id'], $data[$j]['room_count'], $data[$j]['planning'], $data[$j]['dis'], $data[$j]['street'], $data[$j]['house'], $data[$j]['ap_layout'],$data[$j]['parent_id'], $data[$j]['live_point']);
						if($topic != "Продажа" && $parent!="Коммерческая" && $data[$j]['user_id']!="avito"){?>
							<font style="font-weight: normal;font-weight: bold;"> 
								<?echo Helper::FurnListRetro($data[$j]['furn'], $data[$j]['tv'], $data[$j]['washing'], $data[$j]['refrig'],  $data[$j]['residents'], $ngs);?>
							</font>
						<?}?>
						<?echo Helper::PriceRetro($data[$j]['price'],$data[$j]['prepayment'],$data[$j]['utility_payment'], $data[$j]['torg'], $data[$j]['rent_type'], $topic, $topic_id);
						/*if(ereg($data[$j]['user_id'].",", $_SESSION['white_list'].",")){?>
							<div class="white-user" title="риелтор в белом списке"></div>
						<?}*/?>
						<input data-name='favorit' type='hidden' value="<?=$data[$j]['favorit'];?>">
						<?$favorit = !preg_match("/\|".$_SESSION['people_id']."\|/", $data[$j]['favorit']);

						if($data[$j]['warning']==1){?>
							<a href="/?task=profile&action=caution&type=1&an=<?=$data[$j]['company_name']?>" class="warning" target="_blank" title="данный риелтор был занесен в раздел 'осторожно'">!</a>
						<?}?>
					</div>
					<div>
						<?if(isset($data[$j]['ap_view_date']) && isset($data[$j]['ap_race_date'])){
							$view_arr = explode('-', $data[$j]['ap_view_date']);
							$race_arr = explode('-', $data[$j]['ap_race_date']);
							$view = "{$view_arr[2]}.{$view_arr[1]}";
							$race = "{$race_arr[2]}.{$race_arr[1]}";
							if(($race_arr[2]<=date('d') && $race_arr[1] <= date('m')) || $race_arr[0] == '0000'){
								echo "<font class='retro-green'>Смотреть и заезжать сегодня!</font>";
							}else{
								echo "<font class='retro-gray'>Смотреть c : </font><font  style='color: rgb(255, 0, 0);'>{$view}</font><font class='retro-gray'> заезд c : </font><font  style='color: rgb(255, 0, 0);'>{$race}</font>";
							}
						}
						if($data[$j]['deposit']>0){
							echo "<font class='retro-gray'> Депозит: </font><font style='color:#E81010'> {$data[$j]['deposit']}</font>";
						}
						if($data[$j]['deliv_period'] > 0 && $data[$j]['deliv_period'] < 13){
							$deliv_period_str = "На {$data[$j]['deliv_period']} мес.";
							echo "<font class='retro-gray'> ".($topic_id!=3 && $topic_id!=4 ? "Период сдачи" : "Срок аренды").": </font><font ".($data[$j]['deliv_period'] == 12 ? "class='retro-green'" : "style='color:#E81010'").">".$deliv_period_str."</font>";
						}else if($data[$j]['deliv_period'] > 12){
							switch ($data[$j]['deliv_period'])
							{
								case '13':
									$deliv_period_str = "Лето";
									break;
								case '14':
									$deliv_period_str = "Длительно";
									break;
								case '15':
									$deliv_period_str = "На продаже";
									break;
							}
							echo "<font class='retro-gray'> ".($topic_id!=3 && $topic_id!=4 ? "Период сдачи" : "Срок аренды").": </font><font ".($data[$j]['deliv_period'] == 14 ? "class='retro-green'" : "style='color:#E81010'").">".$deliv_period_str."</font>";
						}
						?>
					</div>
					<div>
						<font style='color: #476BC6;font-size: 16px;'>Дополнение: </font>
						<?if(!$ngs && $topic!="Продажа" && $parent!="Коммерческая" && $data[$j]['topic_id']!=3){?>
							<font class='retro-gray' data-name='contacts' <?=(!$contacts ? 'style="display:none;"' : 'style="display:inline-block;"')?>>С этой сделки наши </font>
							<font class='retro-green' data-name='contacts' <?=(!$contacts ? 'style="display:none;"' : 'style="display:inline-block;"')?>><?=floatval($data[$j]['price'])/100 * floatval($data[$j]['commission']) / 2;?></font><font class='retro-gray' data-name='contacts' <?=(!$contacts ? 'style="display:none;"' : 'style="display:inline-block;"')?>>руб.</font>
							<?
							if($parent=="Комната"){
								echo "<font class='retro-gray'>метры : </font><font class='retro-green'>{$data[$j]['sq_live']}</font>";
							}
							echo Helper::ResidentsRetro($data[$j]['residents'], $topic_id);
							if($parent=="Комната" && isset($data[$j]['owner'])){
								echo "<font class='retro-gray'>, проживает : </font><font class='retro-green'>{$data[$j]['owner']}</font>";
							}
						}else if($data[$j]['topic_id']==3){
							echo Helper::ResidentsRetro($data[$j]['residents'], $topic_id);
						}?>
							
						<?php 
							if($data[$j]['floor'] && $parent != "Дома")
							{
								echo "<font class='retro-gray'>Этажность: </font><font class='retro-green'>{$data[$j]['floor']}";
								if($data[$j]['floor_count']){
									echo "/{$data[$j]['floor_count']}";
								}
								echo "</font>";
							}else if($data[$j]['floor_count'] && $parent != "Дома"){
								echo "<font class='retro-gray'>Этажность: </font><font class='retro-green'>ср/{$data[$j]['floor_count']}</font>";
							}
							if($data[$j]['floor_count'] && $parent == "Дома"){
								echo "<font class='retro-gray'>Этажность: </font><font class='retro-green'>{$data[$j]['floor_count']}</font>";
							}
							if(floatval($data[$j]['sq_all']) || floatval($data[$j]['sq_live'])|| floatval($data[$j]['sq_k'])) 
							{ 
								echo "<font class='retro-gray'> пл:</font><font class='retro-green'>";
								if($parent != "Гаражи" && $parent != "Дачи"){
									if($data[$j]['sq_all']){echo $data[$j]['sq_all']."/";}else{echo "-/";}
									if($data[$j]['sq_live']){echo $data[$j]['sq_live']."/";}else{echo "-/";}
									if($data[$j]['sq_k']){echo $data[$j]['sq_k'];}else{echo "-";}
								}else if (floatval($data[$j]['sq_live']) && !$ngs){
									echo $data[$j]['sq_live'];
								}else{
									echo $data[$j]['sq_all'];
								}
								echo "</font>"; 
							}
								if(floatval($data[$j]['sq_land'])){
									echo "<font class='retro-gray'> уч: </font><font class='retro-green'>{$data[$j]['sq_land']}</font>";
								}
						
							if(($data[$j]['parent_id']==18 || $data[$j]['parent_id']==3) && $data[$j]['room_count']>0){
								echo "<font class='retro-gray'> комнат в ".($data[$j]['parent_id']==18 ? 'кв' : 'доме')." - </font><font class='retro-green'>{$data[$j]['room_count']}</font>";
							}?>
					</div>
					<?if($data[$j]['parent_id']==3 && $data[$j]['topic_id']!=3 && $data[$j]['topic_id']!=4){?>
						<div style='font-size: 12px;'>
							<span style="color: blue; font-size: 13px;">Удобства: </span>
							<font class='retro-gray'>Отопление: </font><font class="retro-green"><?=$data[$j]['heating'];?> </font>
							<font class='retro-gray'>| Вода: </font><font class="retro-green"><?=$data[$j]['water'];?> </font>
							<font class='retro-gray'>| Cлив: </font><font class="retro-green"><?=$data[$j]['sewage'];?> </font>
							<font class='retro-gray'>| Туалет: </font><font class="retro-green"><?=$data[$j]['wc_type'];?> </font>
							<font class='retro-gray'>| Место под машину: </font><font class="retro-green"><?=$data[$j]['park'];?> </font>
							<font class='retro-gray'>| Мыться: </font><font class="retro-green"><?=$data[$j]['wash'];?> </font>
						</div>
					<?}?>
					<div>
						<font style='color: #476BC6;font-size: 16px;'>Описание: </font><span style='text-transform: lowercase;'><?=$data[$j]['text'];?></span>
					</div>
					<div style="font-size: 16px;">
						<font class='retro-gray'>тел: </font> 
						<font onclick="$(this).hide(); $(this).next().show();" data-name='contacts' <?=(!$contacts ? 'style="display:none;"' : 'style="display:inline-block;"')?>><?=$data[$j]['phone'];?></font>
						<font onclick="$(this).hide(); $(this).prev().show();"data-name='contacts-hide' <?=($contacts ? 'style="display:none;"' : 'style="display:inline-block;"')?>>***********</font>
						<?$owner = ($_SESSION["user"] == $data[$j]['user_parent'] || $_SESSION["user"] == $data[$j]['user_id']);?>
						<font class='retro-gray'> имя : </font>
						<font <?if($owner) echo "onClick='EmployeeList(".$data[$j]['id'].",\"".$data[$j]['company_name']."\",".$data[$j]['user_id'].")' "; unset($owner);?> data-people-id='<?=$data[$j]['people_id'];?>' data-name='people'>
							<?=$data[$j]['name'];?>
						</font>
						<font class='retro-gray'> АН : </font><?=$data[$j]['company_name'];?>
						<?
						if($topic=="Аренда")
						{  ?>
							<span data-name='contacts_comission' <?=(!$contacts ? 'style="display:none;"' : 'style="display:inline-block;"')?>>
								<font class='retro-gray'> Услуги АН не менее :</font><?=$data[$j]['commission'];?>%
								<font style="font-size:12px;color:grey;font-weight:bold">(50 на 50)</font>
							</span><?
						}


							if(!empty($data[$j]['last_call_date']) && $data[$j]['last_call_date'] != '0000-00-00')
							  	{							  		
							  		echo date('Y-m-d',strtotime($data[$j]['last_call_date']));
							  	}else if(!empty($data[$j]['last_call_date_ts'])) {
							  		echo date('Y-m-d',strtotime($data[$j]['last_call_date_ts']));
							  	}else{
							  		echo date('Y-m-d',strtotime($data[$j]['date_added']));
							  	}

						if($data[$j]['premium'] == 1){
							if(!$phone_enter){?>
								<img title='статус-премиум' width='14px' style='vertical-align: initial;float: right;    margin: 3px 3px;' src='images/icon/zv.gif'>
							<?}else{?>
								<img title='VIP-статус' width='14px' style='vertical-align: initial;float: right; margin: 3px 3px;' src='images/icon/prem_phone.png'>
							<?}
						}?>
					
						<font class="retro-green" style="float:right;margin-top: 3px; margin-left: 55px;" size="2"><?=date("d/m", strtotime($data[$j]['date_added']));?></font>
						
						<div style="display: inline-block;float:right;margin-left: 15px;">
                            <?php
                            if(isset($imgUrl)){?>
                                <a title="есть фото" class="fancybox-thumbs pull-left" href="<?=$imgUrl;?>"
                                   data-fancybox-group="msg<?=$data[$j]['id']?>" style="margin-bottom: -8px;">
                                    <img class="media-object" src="images/zenit1.png" style="padding: 2px; border: 1px solid silver;">
                                </a>
                                <?php
                            }?>
						</div>
						<a href="javascript:void(0)" style="float:right" <?echo "onClick='show_address(\"".$data[$j]['coords']."\", ".$j.")' target='_blank' data-toggle='modal' data-target='#modal-win'";?>><img border="0" src="images/icon/maps.ico"></a>
					</div>
					<?if($data[$j]['ap_view_price']>0){
						echo "<div style='font-size: 12px;color: grey;font-weight: bold;'>Если показываю и оформляю в одиночку, с вашей комиссии - <font style='color:#E81010'>{$data[$j]['ap_view_price']} pублей</font></div>";
					}?>
						<div style="font-size: 12px;color: grey;font-weight: bold;">
							<?if($_GET['action']=='review_list' && $_SESSION['admin'] == 1){?>
								<button style='height: 22px;padding: 0px 5px;' class='btn btn-primary' onClick='OpenProductMenu(<?=$data[$j]['id']?>)'>Меню</button>
								<span data-id='review' class='gray' style='cursor:pointer; display:inline-block; margin-left: 10px; font-size: 13px;'  onClick='ReviewListForAdmin(<?=$data[$j]['id']?>)' target='_blank' data-toggle='modal' data-target='#clean-modal-win'>Жалобы <span class='gray'><?=($data[$j]['active']==0? ' Вариант в архиве!':'')?></span></span>
								<span class="gray" style="cursor: pointer;display: inline-block;margin-left: 10px;font-size: 13px;" target="_blank" data-toggle="modal" data-target="#messages-modal-win" onclick="Messages('<?=$data[$j]['people_id']?>', '1', '<?=($data[$j]["surname"]." ".$data[$j]["name"]." ".$data[$j]["second_name"])?>')" data-text="<?=$message_text?>">Отпр. сообщение | </span>
								<div class='product-menu' data-id=''>
									<span class='glyphicon glyphicon-remove right' onClick='$(this).parent().slideUp(\"fast\")' id='close' style='cursor:pointer; position: absolute;left: 140px;top: -5px;'></span>
									<a href='javascript:void(0)' onClick="CheckedReview(<?=$data[$j]['id']?>, 0)"><div>проверено</div></a>
									<a href='javascript:void(0)' onClick="VarArchive(<?=$data[$j]['id']?>, 'add', '1')" data-name='review_to_archive'><div>в архив</div></a>
									<a href='javascript:void(0)' onClick="DeleteVar(<?=$data[$j]['id']?>, 1)"><div>удалить сообщение</div></a>
									<a href='javascript:void(0)' onClick="DeletePhotos(<?=$data[$j]['id']?>)"><div>удалить фотографии</div></a>
								</div>
							<?}?>
							<a href='javascript:void(0)' style='color: grey;' data-name='an-info' target='_blank' data-toggle='modal' data-target='#clean-modal-win'>Инфо об агентстве | </a>
							<?if($_SESSION["block_com_an"]==0){?>
								<a href='javascript:void(0)' style='color: grey;' data-name='send-review' target='_blank' data-toggle='modal' data-target='#send-review-modal-win'>оставить отзыв | </a>
							<?}?>
							<?if(ereg($data[$j]['people_id'].",", $_SESSION['in_black_list'])){?>
								<span data-name='black-agent' style='cursor:pointer; color:red; display:inline-block;font-size: 13px; 'target='_blank' data-toggle='modal' data-target='#add-to-black-list-modal-win'>Агент в черном списке</span>
							<?}else if(ereg($data[$j]['user_id'].",", $_SESSION['white_list'].",")){?>
								<span data-name='white-agent' style='cursor:pointer; display:inline-block;font-size: 13px;'><a href="?task=profile&action=lists&type=white" class="retro-green" target="_blank">Агент в белом списке</a></span>
							<?}else{?>
							<!--<a href='javascript:void(0)' style='color: grey;' data-name='add-to-black-list' target='_blank' data-toggle='modal' data-target='#add-to-black-list-modal-win'>Присвоить статус риелтору | </a>-->
							
							<span class="dropdown">
								<a href="javascript:void(0)"  style='color: grey;' id="people-status" data-toggle="dropdown" aria-expanded="false">1Присвоить статус риелтору | </a>
								<ul class="dropdown-menu" aria-labelledby="people-status">
									<li><a href='javascript:void(0)' data-name='add-to-black-list' target='_blank' data-toggle='modal' data-target='#add-to-black-list-modal-win'>В черный список</a></li>
									<li><a href="javascript:void(0)" onClick="AddListFromMain('<?=$data[$j]['people_id'];?>')">В белый список</a></li>	
								</ul>
							</span>
					
							<?}?>
							<span class="dropdown">
								<a href="javascript:void(0)"  style='color: grey;' id="check" data-toggle="dropdown" aria-expanded="false">Проверить</a>
								<ul class="dropdown-menu" aria-labelledby="check">
									<li><a href='javascript:void(0)' data-name='check-var' data-id='parse' target='_blank' data-toggle='modal' data-target='#clean-modal-win'>Частники</a></li>
									<li><a href='javascript:void(0)' data-name='check-var' data-id='pay_parse' target='_blank' data-toggle='modal' data-target='#clean-modal-win'>Частники 2</a></li>	
								</ul>
							</span>
							<?if($online==1){?>
								<span class="right" style="color:#337ab7;font-weight: normal;" title="Данные обновляются раз в минуту">Сейчас на сайте</span>
							<?}?>
							<?if($data[$j]['review'] == 1){?>								
								 | <a href='javascript:void(0)' style='color:#E81010' data-id='review' target='_blank' data-toggle='modal' data-target='#clean-modal-win'>Есть отзывы</a>
							<?}?>
						</div>
					
				</td>
			</tr>
		</table>
	</div>
<?}
?>