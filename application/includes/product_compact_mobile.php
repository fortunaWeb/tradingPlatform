<?php
$arr_num = count($data);

$getTopicId = '';
if(isset($_GET['topic_id']))
	$getTopicId = $_GET['topic_id'];



$people_ids_in_an = Get_functions::Get_peoples_ids_in_an($_SESSION['company_id']);
?>
						<script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
						<script src="//yastatic.net/share2/share.js"></script>

<script type="text/javascript">


	$(document).ready(function(){
    // = Вешаем событие прокрутки к нужному месту
    	//	 на все ссылки якорь которых начинается на #
    	$('a[href^="#"]').bind('click.smoothscroll',function (e) {
    		e.preventDefault();
    
    		var target = this.hash,
    		$target = $(target);
    
    		$('html, body').stop().animate({
    			'scrollTop': $target.offset().top
    		}, 900, 'swing', function () {
    			window.location.hash = target;
    		});
    	});
    
    });

</script>
<br/>
<?php

$lookVars = $data['lookVars']['look_vars'];
for ($j=0; $j<$arr_num ; ++$j) {
    if(empty($data[$j]['user_id'])){
        continue;
    }
	/**
		Блокировка из чёрного списка.
	*/
	if(
		ereg(",".$data[$j]['people_id'].",", $_SESSION['in_black_list']) 
		&& 
		!empty($data[$j]['people_id']) 
		)
	{
		$people_id_black_show_var = Get_functions::Get_black_list_show_var($data[$j]['people_id']);
		if($people_id_black_show_var == 0) continue;		
	}
	unset($photo, $count_photo, $imgUrl);

	$favorit = !preg_match("/\|".$_SESSION['people_id']."\|/", $data[$j]['favorit']);
	$ngs = $data[$j]['user_id'] == 'ngs' || $data[$j]['user_id'] == 'avito';
	$contacts = (Helper::FilterVal('without_cont')!=1 &&  ( !isset($_SESSION["post"]["without_cont"]) || $_SESSION["post"]["without_cont"]!=1) ) ;
	$company_var = $_SESSION["company_name"] == $data[$j]['company_name'];


	if(!$ngs){
		$dir = "images/".$data[$j]['people_id']."/".$data[$j]['id']."/*";
	}else if( !empty(intval($data[$j]['photos']))) {
		$dir = "images/parse/".$data[$j]['photos']."/*";	
	}else if(strlen($data[$j]['photos']) > 5){
		$dir = "images/ngs_parse/".$data[$j]['id']."/*";
		
	}

	$imgUrl = null;
	$photo_arr = glob($dir);
	$count_photo = count($photo_arr);
	if($count_photo > 0){
		$photo = str_replace($_SERVER['DOCUMENT_ROOT'], "", $photo_arr[0]);
		$imgUrl = $photo;
	}


	if(empty($imgUrl)  ){
	//	Helper::unsetVarPhoto($data[$j]['id']);
		if(isset($_GET['photo']) && $_GET['photo'] == 1 ){
			continue;
		}		
	}


	if($data[$j]['review']==1 && !$ngs && $_GET['action']!="pay_parse")
	$data[$j]['review'] = Helper::UpdateReview($data[$j]['id']);
	
	$online = Helper::Online_bool($data[$j]['people_id']);
	unset($dir, $photo_arr);
	$icon = array(
		"ngs"=>"/images/icon/source/ngs.png",
		"avito"=>"/images/icon/source/avito.ico"
	);
		$date_col = (isset($data[$j]['col_date']) && date("Y-m-d", strtotime($data[$j]['col_date'])) == date("Y-m-d") && $_GET['action']=="mytype" && $_GET["active"]=="0") ;
?>

	<div class="col-xs-12
			<?if(!$ngs && ereg($data[$j]['people_id'].",", $_SESSION['in_black_list'])){
			echo " product ";
		}else{
			echo ' product ';
		}?>
	  <?php if($date_col) echo "dateCol"; if($data[$j]['review']==1 && $_GET['action'] != 'check_var') echo "hasReview";?>"
         style="font-family: arial, verdana;font-size: 18px;line-height: normal;
             <?=
             (strstr($lookVars, $data[$j]['id'])) > 0
                 ? "background-color: #BDDA57;"
                 : ''
             ?>
        "
         data-coords="<?= $data[$j]['coords'];?>" id="msg<?= $j; ?>" data-id='<?= $data[$j]['id'];?>' data-addr="НСО, <?= $data[$j]['live_point'].", ".$data[$j]['street']." д.".$data[$j]['house'];?>" data-col="<?if($date_col) echo 1;?>" data-user="<?=$data[$j]['user_id']?>">
		<table id = 'table-<?=$data[$j]['id']?>'>
			<tr>
				<td align="left" style='
				    width: 65px;
				    vertical-align: top;
				    line-height: 0.8;
				    border-right-color: #00;
				    border-right-style: groove;
				    '>
					<?if(!$ngs){?>
						<font size="2" data-id="last-edit" style = 'margin-left: 5px;'>
							<?=date("d/m", strtotime($data[$j]['date_last_edit']));?>
						</font>	<br/>
						<font size="2" data-id="last-edit" style = 'margin-left: 5px;'>
							<?=date("H:i", strtotime($data[$j]['date_last_edit']));?>
						</font>
					<?}else{?>
						<font size="2" style='margin-right: 25px;margin-left: 5px;' data-id="last-edit">
							<?=date("d/m/y", strtotime($data[$j]['date_last_edit']));?>
						</font>
						<font size="2" data-id="last-edit" style = 'margin-left: 5px;'>
							<br/>
							<?=date("H:i", strtotime($data[$j]['date_last_edit']));?>
						</font>
					<?}?>
					<br />
					<?php 
						if($_GET['action'] != "mytype" && $_GET['action'] != 'check_var'){
							?>
						<input data-name='favorit' type='hidden' value="<?=$data[$j]['favorit'];?>">
						<?$favorit = !preg_match("/\|".$_SESSION['people_id']."\|/", $data[$j]['favorit']);
						 ?>
						<br/>
						<br/>

					<?php
				}
						if($_GET['action'] == "mytype" && $_GET['active'] == 1 && $company_var)
							echo "<input type='checkbox' onChange='showButtons($(this))' data-id='{$data[$j]['id']}' style='margin: 10px 0;'>";?>
					<br />
					<?php
					if($data[$j]['status'] == 3){
						echo "<img title='Гарантия что объекта нет в интернете на прямую от собственника' width='20px' style = 'margin-left: 5px;' src='images/icon/vip.jpg'>";
					}
					if(!$ngs && $count_photo){
						?>
						<br />
					<?php 
						//отсутствует email отправки
						if ($_SESSION['email_work'] != NULL && $_SESSION['email_pass'] != NULL  ) {

					?>
							<span class="glyphicon glyphicon-envelope send-email" onClick="Open_send_email_form($(this))" aria-hidden="true" 
							style="cursor: pointer;color: #35AFD4;margin-top: 8px;margin-left: 5px;"></span>
							<div class="send-email-form hidden">
								<div class="col-xs-4 deployed" style='margin-top: 20px;'>
									<label class="signature">Отправить клиенту</label>
									<input class="form-control" data-name="email_for_favor" placeholder="email" onclick="$('.dropdown-menu').has($(this)).show()">
								</div>
								<div class="col-xs-4 deployed" style="margin-top: 20px;">
									<label class="signature">Комментарий(можно редактировать)</label>
									<textarea class="form-control" rows="7" data-name="comment" placeholder="текст комментария"></textarea>
								</div>
								<div class="col-xs-2 deployed">
									<button type="button" onclick="SendVarToEmail($(this), <?=$data[$j]['id'];?>)" style="" class="btn btn-success btn-xs ">Отправить</button>
								</div>
							</div>
					<?php 
						}else{
					?>
						<span class="glyphicon glyphicon-envelope send-email" onClick="No_email_work()" aria-hidden="true" style="cursor: pointer;color: #35AFD4;"></span>
					<?php
						}
					}

					if(isset($data[$j]['people_id'])){
						$prolong_garant = " title = 'Не гарантирую актуальность варианта, выясняю это в момент обращения' src='images/icon/prolong_no_garant.jpg'";
						if(!empty($data[$j]['prolong_garant'])){
							$prolong_garant = " title = 'Гарантирую актуальность варианта на момент последнего продления' src='images/icon/prolong_garant.jpg'";
						}
						echo "<br/><img {$prolong_garant} style = 'margin-top: 5px;margin-left: 5px;' width='20px' >";
					}
					?>
					<br/>
					<?php 
						if($data[$j]['premium'] == 1){
								?>
					<br/>
					<br/>
						<img title='статус-премиум' width='14px
							' style='vertical-align: initial;margin: 3px 10px;' src='images/icon/zv.gif'>
					<?
							}else{
					?>
					<br/>
					<?php
							}
						?>
					<br/>
						<font size="2" class='retro-green' style='margin-right: 25px;margin-left: 5px;' data-id="added">
							<?echo date("d/m", strtotime($data[$j]['date_added']));?>
						</font>
                    <br/>
                <?php
                    if(isset($imgUrl) && $data[$j]['user_id']!='avito'){
                ?>
					<br/>
                    <div style="display: inline-block;float:left;margin-left: 5px;" >
                        <?php
                        if($_GET['action']=='parse' || $_GET['action']=='check_var'){ ?>
                            <a title="есть фото 1"
                                class="pull-left showFotosPayParse" data-id = '<?=$data[$j]['id']?>' data-name = 'ngs' href="#<?=$data[$j]['id']?>" >
                        <? }else{ ?>
                            <a title="есть фото 2"
                                 class="pull-left showFotos" data-id = '<?=$data[$j]['id']?>' href="#<?=$data[$j]['id']?>" >
                        <? } ?>
                                <img class="media-object" src="images/zenit_mobile.png" style="padding: 2px; border: 1px solid silver;">
                                <?php if(isset($data[$j]['user_id'])){ ?>
                                    <img class="media-object" id ='eyemsg<?=$data[$j]['id']?>' src="images/icon/eye.png" style="width: 20px;display:
                                    <?=
                                    (strstr($lookVars, $data[$j]['id']) > 0)
                                        ? 'block'
                                        : 'none'
                                    ?>;">
                                <?php }?>
                            </a>
                        </div>
                    </div>
                <?php
                    }
                ?>
					<?php
						if(Helper::sendWhatsapp($_GET["action"], $getTopicId)  && false){									
						?>
				<br/>
					<br/>
						<div class="ya-share2" data-services="whatsapp<?=$_SESSION['login']=='8737'?',telegram':''?>" data-limit="2" style = 'margin-left: 5px;'
						 data-title="<?php
							if($_GET['task']!="profile"){
								echo Translate::Var_title_Telegram($data[$j]['type_id'], 
								 	$data[$j]['topic_id'], $data[$j]['room_count'], $data[$j]['planning'], $data[$j]['dis'], 
								 	$data[$j]['street'], $data[$j]['house'], $data[$j]['ap_layout'],$data[$j]['parent_id'], $data[$j]['live_point'],
								 	$data[$j]['price'], $data[$j]['utility_payment'],
								 	$data[$j]['furn'], $data[$j]['tv'], $data[$j]['washing'], $data[$j]['refrig'],
								 	$data[$j]['ap_race_date'], $data[$j]['ap_view_date'], $data[$j]['deliv_period'],
								 	$data[$j]['residents'], $data[$j]['floor'], $data[$j]['floor_count'],
								 	$data[$j]['sq_all'],$data[$j]['sq_live'], $data[$j]['sq_k'], $data[$j]['prepayment']
								 	);
								if(isset($imgUrl)){
									echo ' Фото';	
								}
								
							}else{
								echo Translate::Var_title_Telegram_LK($data[$j]['type_id'], 
								 	$data[$j]['topic_id'], $data[$j]['room_count'], $data[$j]['planning'], $data[$j]['dis'], 
								 	$data[$j]['street'], $data[$j]['house'], $data[$j]['ap_layout'],$data[$j]['parent_id'], $data[$j]['live_point'],
								 	$data[$j]['price'], $data[$j]['utility_payment'],
								 	$data[$j]['furn'], $data[$j]['tv'], $data[$j]['washing'], $data[$j]['refrig'],
								 	$data[$j]['ap_race_date'], $data[$j]['ap_view_date'], $data[$j]['deliv_period'],
								 	$data[$j]['residents'], $data[$j]['floor'], $data[$j]['floor_count'],
								 	$data[$j]['sq_all'],$data[$j]['sq_live'], $data[$j]['sq_k'], $data[$j]['prepayment']
								 	);

								if(isset($imgUrl)){
									echo ' фото в личку по запросу';	
								}
							}
						 	
							?>" data-url=' '> </div>
						<?php
						}/**/
						?>
				</td>
				<td style = " padding-left: 5px">				
					<div style="margin-top: -3px; <?=$getTopicId==3?'display:none':''?>">
						<?=Translate::Var_title_retro_mobile($data[$j]['type_id'], $data[$j]['topic_id'], $data[$j]['room_count'], $data[$j]['planning'], $data[$j]['dis'], $data[$j]['street'], $data[$j]['house'], $data[$j]['ap_layout'],$data[$j]['parent_id'], $data[$j]['live_point'])?>
						<a href="javascript:void(0)" 
								<?
								echo "onClick='show_address(\"".$data[$j]['coords']."\", ".$j.")' target='_blank' data-toggle='modal' data-target='#modal-win'";
								?>
							>
								<img border="0" src="images/icon/maps.ico"></a>
                        <?=!empty($data[$j]['metro_name'])?
                            "<font class='retro-gray'> Метро:</font><font class='retro-green'>{$data[$j]['metro_name']} {$data[$j]['distance_to_metro']}м.(по прямой)</font>":''
                        ?>
						<br/>
						<?=($topic != "Продажа" && $parent!="Коммерческая" && $parent!="Гаражи" && $data[$j]['user_id']!="avito")
						?Helper::FurnListRetro(
                                    $data[$j]['furn'], $data[$j]['tv'],
                                    $data[$j]['washing'], $data[$j]['refrig'],
                                    $data[$j]['residents'], $ngs, $parent_id
                                )
                        :""?>
						<?=Helper::PriceRetroMobile($data[$j]['price'],$data[$j]['prepayment'],$data[$j]['utility_payment'], $data[$j]['torg'], $data[$j]['deliv_period'], $topic, $topic_id)?>

<!--                        --><?//=(!empty($data[$j]['warning']) && $data[$j]['warning']==1)
//                            ? "<a href='/?task=profile&action=caution&type=1&an={$data[$j]['company_name']}'
//                                class='warning' target='_blank' title='данный риелтор был занесен в раздел ОСТОРОЖНО!'>!</a>"
//                            :""?>

						<span data-name = "view-race"  style=" <?=$getTopicId==3?'display:none':''?>">
						<?if(isset($data[$j]['ap_view_date']) && isset($data[$j]['ap_race_date'])){
							if(date("Y-m-d", strtotime($data[$j]['ap_race_date'])) < date("Y-m-d")){
								echo "<br/><font class='retro-green'>Смотреть и заезжать сегодня!</font>";
							}else{
								echo "<br/><font class='retro-gray'>Смотреть c : </font>
								<font  style='color: rgb(255, 0, 0);'>".date("d.m", strtotime($data[$j]['ap_view_date']))."</font>
								<font class='retro-gray'> заезд c : </font><font  style='color: rgb(255, 0, 0);'>".date("d.m", strtotime($data[$j]['ap_race_date']))."</font>";
							}
						}
						?>
						</span>
					</div>
					<div  style=" <?=$getTopicId==3?'display:none':''?>">
						<?php
						echo "<span data-name = 'deposit'>";
						if($data[$j]['deposit']>0){
							echo "<font class='retro-gray'> Депозит: </font><font style='color:#E81010' > {$data[$j]['deposit']}</font>";
						}
						echo "</span>";
						if($data[$j]['deliv_period'] > 0 && $data[$j]['deliv_period'] < 13){
							$deliv_period_str = "На {$data[$j]['deliv_period']} мес.";
							echo "<font class='retro-gray'> ".($topic_id!=3 && $topic_id!=4 ? "Период сдачи" : "Срок аренды").": </font>
									  <font ".($data[$j]['deliv_period'] == 12 ? "class='retro-green'" : "style='color:#E81010'").">".
									  	 $deliv_period_str."</font>";

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
								case '16':
									$deliv_period_str = "Сутки";
									break;
							}
							echo "<font class='retro-gray'> ".($topic_id!=3 && $topic_id!=4 ? "Период сдачи" : "Срок аренды").": </font>
								  <font ".($data[$j]['deliv_period'] == 14 ? "class='retro-green'" : "style='color:#E81010'").">".$deliv_period_str."</font>";
						}
						?>
					</div>
					<div  style=" <?=$getTopicId==3?'display:none':''?>" >
						<?php
							if(!$ngs && $topic!="Продажа" && $parent!="Коммерческая" && $data[$j]['topic_id']!=3){ ?>
								<font class='retro-gray' data-name='contacts' <?=(!$contacts ? 'style="display:none;"' : 'style="display:inline-block;"')?>>С этой сделки наши </font>
								<font class='retro-green' data-name='contacts' <?=(!$contacts ? 'style="display:none;"' : 'style="display:inline-block;"')?>><?=floatval($data[$j]['price'])/100 * floatval($data[$j]['commission']) / 2;?></font>
								<font class='retro-gray' data-name='contacts' <?=(!$contacts ? 'style="display:none;"' : 'style="display:inline-block;"')?>>руб.</font>
								<?=($data[$j]['keys']!=0)?"<font class='retro-red'>КЛЮЧИ</font>":""?>
								<font class='retro-gray' data-name='contacts' >
								<?php 
								$residents = Helper::ResidentsRetro($data[$j]['residents'], $topic_id);
									if($residents==''){ echo '';}else{ echo "<br/>".$residents;}
								?>
								</font>
								<?php
								if(!empty($data[$j]['owner'])){
									echo "<br/><font class='retro-gray'>, проживает : </font><font class='retro-green'>{$data[$j]['owner']}</font>";
								}
							}else if($data[$j]['topic_id']==3){

								$residents = Helper::ResidentsRetro($data[$j]['residents'], $topic_id);
									if($residents==''){ echo '';}else{ echo "<br/>".$residents;}
							}?>
							</div>
							<div>
						<?php 
							if($data[$j]['floor'] && $parent != "Дома")
							{
								echo "<font class='retro-gray'>Этажность: </font><font class='retro-green' data-name='floor'>{$data[$j]['floor']}";
								if($data[$j]['floor_count']){
									echo "/{$data[$j]['floor_count']}";
								}
								echo "</font>";
							}else if($data[$j]['floor_count'] && $parent != "Дома"){
								echo "<font class='retro-gray'>Этажность: </font><font class='retro-green' data-name='floor'>ср/{$data[$j]['floor_count']}</font>";
							}

							if($data[$j]['floor_count'] && $parent == "Дома"){
								echo "<font class='retro-gray'>Этажность: </font><font class='retro-green' data-name='floor'>{$data[$j]['floor_count']}</font>";
							}


							if(floatval($data[$j]['sq_all']) || floatval($data[$j]['sq_live'])|| floatval($data[$j]['sq_k'])) 
							{ 
								echo "<font class='retro-gray'> пл:</font><font class='retro-green' data-name='sq'>";
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
                            if($data[$j]['val_bal'] !=0){
                                echo "<font class='retro-gray'> Балкон: </font><font class='retro-green'>";
                                echo $data[$j]['val_bal']==5 ?"Нет":$data[$j]['val_bal']. "</font>";
                            }
                            if($data[$j]['val_lodg'] !=0){
                                echo "<font class='retro-gray'> Лоджии: </font><font class='retro-green'>";
                                echo $data[$j]['val_lodg']==5 ?"Нет":$data[$j]['val_lodg']. "</font>";
                            }
							if($data[$j]['sleeping_area']!=0){
                                echo "<font class='retro-gray'> сп.мест: </font><font class='retro-green'>{$data[$j]['sleeping_area']}</font>";
                            }

							if(floatval($data[$j]['sq_land'])){
								echo "<font class='retro-gray'> уч: </font><font class='retro-green' data-name='sq'>{$data[$j]['sq_land']}</font>";
							}
						?>
					</div>
					<?if(!$ngs && $data[$j]['parent_id']==3 && $data[$j]['topic_id']!=3 && $data[$j]['topic_id']!=4){?>
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
						<?php
						 if(!empty($data[$j]['text']))
						 {
						 	?>						 
							<font style='color: #476BC6;font-size: 16px;' onclick = "$(this).next().toggle();" >

							<?=$getTopicId==3?'Сниму ':'Описание развернуть'?>

									  : </font>
								<span  class = 'comment' style='text-transform: lowercase;display:<?=($getTopicId==3)?'':'none;'?>' 
									data-name='comment<?=$data[$j]['id']?>'>:<?php
										if(!empty($data[$j]['orientir'])){
											echo "<font class='retro-gray' > Ориентир : </font><font class='retro-green'>" . $data[$j]['orientir'].";</font>";
										}
									?><?=$data[$j]['text'];?>
								</span>

							<?php
						}
						if(isset($data[$j]['hidden_text']) && $data[$j]['hidden_text']!="" && in_array($data[$j]['people_id'], $people_ids_in_an)){
							echo "<br /><font style='color: #476BC6;font-size: 16px;'>Скрытое примечание: </font>{$data[$j]['hidden_text']}";
						}?>
					</div>
					<div style="font-size: 16px;">
						<?if($ngs){?>
							<font style="color: #476bc6;font-size: 14px;font-weight: bold;">Имя : </font><font data-name='contacts'><?=$data[$j]['contact_name'];?></font>
							<?php
								if($contacts){?>
									<br/>
									<font style="color: #476bc6;font-size: 14px;font-weight: bold;">
									тел:</font>
									<font data-name='contacts'>
										<a href="tel:<?=$data[$j]['contact_tel']; ?>" ><?=$data[$j]['contact_tel']; ?></a>
									</font>


							<?}?>
						<?}else{?>
							<font class='retro-gray' > АН : </font>
							<font data-name='contacts' <?=(!$contacts ? 'style="display:none;"' : 'style="display:inline-block;"')?> >
								<?=$data[$j]['company_name'];?>
							</font>
							<?php
							 unset($owner);
								if($topic=="Аренда"){
									?><br/>

							<?php $owner = ( $_SESSION["user"] == $data[$j]['user_id'] || (isset($data[$j]['user_parent']) && $_SESSION["user"] == $data[$j]['user_parent']));?>
							<font class='retro-gray'>имя : </font>
							<font <?=($owner)?"onClick='EmployeeList(".$data[$j]['id'].",\"".$data[$j]['company_name']."\",".$data[$j]['user_id'].")' ":""?> 
								data-people-id='<?=$data[$j]['people_id'];?>' data-name='contacts' <?=(!$contacts ? 'style="display:none;"' : 'style="display:inline-block;"')?>>
								<?=$data[$j]['name'];?>
							</font>
							<font  data-name='people' data-people-id='<?=$data[$j]['people_id'];?>'>
								
							</font>
							<?php
								if(ereg($data[$j]['people_id'].",", $_SESSION['in_black_list'])){?>
								<span data-name='black-agent' style='cursor:pointer; color:red; display:inline-block;font-size: 13px;
										 'target='_blank' data-toggle='modal' data-target='#add-to-black-list-modal-win'>
										Агент в черном списке</span>
								<?}else if(ereg($data[$j]['user_id'].",", $_SESSION['white_list'].",")){?>
									<span data-name='white-agent' style='cursor:pointer; display:inline-block;font-size: 13px;'><a href="?task=profile&action=lists&type=white" class="retro-green" target="_blank">
										Агент в белом списке</a></span>
								<?}else{?>
								<span class="dropdown"
								data-name='contacts' <?=(!$contacts ? 'style="display:none;"' : 'style="display:inline-block;"')?> >
									<?php
										if($_GET["action"]!="mytype" ){
									?>
									<a href="javascript:void(0)"  
									style='color: grey; text-decoration: underline;font-size: 12px;font-weight:bold'
									 id="people-status" data-toggle="dropdown" aria-expanded="false">
											пометить </a> 
									<?php } ?>
									<ul class="dropdown-menu" aria-labelledby="people-status">
										<li><a href='javascript:void(0)' data-name='add-to-black-list' target='_blank' data-toggle='modal'
											 data-target='#add-to-black-list-modal-win'>В черный список</a></li>

										<li><a href="javascript:void(0)" onClick="AddListFromMain('<?=$data[$j]['people_id'];?>')">
												В белый список</a></li>	
									</ul>
								</span>
						
								<?}?>
								<br/><font class='retro-gray'>тел: </font> 
								<font 
								 data-name='contacts'
								 	 <?=(!$contacts ? 'style="display:none;"' : 'style="display:inline-block;"')?>>

								 	<a href="tel:<?=$data[$j]['phone'];?>" ><?=$data[$j]['phone'];?></a></font>

								<font onclick="$(this).hide(); $(this).prev().show();"
										data-name='contacts-hide' <?=($contacts ? 'style="display:none;"' : 'style="display:inline-block;"')?>>***********</font>
								<?php
									if(!empty($data[$j]['commission'])){
								?>
									<br/><font class='retro-gray'> Услуги АН не менее :</font><?=$data[$j]['commission'];?>%
									<!--<font style="font-size:12px;color:grey;font-weight:bold">(50 на 50)</font>-->
								<?php
									}
							}
						}

//					if($data[$j]['ap_view_price']>0){
//						echo "<br/><div style='font-size: 12px;color: grey;font-weight: bold;'>
//						Если показываю и оформляю в одиночку, с вашей комиссии - <font style='color:#E81010'>
//								{$data[$j]['ap_view_price']} pублей
//						</font></div>";
//					}else if($data[$j]['ap_view_price']<0){
//						echo "<br/><div style='font-size: 12px;color: grey;font-weight: bold;'>
//						Если показываю и оформляю в одиночку, с вашей комиссии - <font style='color:#E81010'>
//								В одиночку не показываю!</font></div>";
//					}
					if(!$ngs){?>
						<div style="font-size: 12px;color: grey;font-weight: bold;line-height: 20px;">
							<?
							if($_GET['task']=="profile" && $_GET["action"]=="mytype" && $_GET['res']!=1  ){
								if($_GET['active'] == '1'){ ?>
									<span class="dropdown">
										<a href="javascript:void(0)"  style='color: #286090;text-decoration: underline; margin-left: 5px; margin-right: 5px; ' id="check" data-toggle="dropdown" aria-expanded="false">Проверить</a> | 
										<ul class="dropdown-menu" aria-labelledby="check">
											<li><a href='javascript:void(0)' data-name='check-var' data-id='parse' target='_blank' data-toggle='modal' data-target='#clean-modal-win'>Частники</a></li>
											<li><a href='javascript:void(0)' data-name='check-var' data-id='pay_parse' target='_blank' data-toggle='modal' data-target='#clean-modal-win'>Частники 2</a></li>	

										</ul>
									</span>								
									<a href='javascript:void(0)' style='color: #286090;text-decoration: underline; margin-left: 5px; margin-right: 5px; ' onClick="DeleteVar(<?=$data[$j]['id']?>)">Удалить</a>
									<br/>
                                    <?php
                                    if(empty($_POST['sample_id']) AND Helper::isMobileExists($_SESSION['people_id']) ){
                                        ?>
                                        <span class="dropdown">
											| <a href="javascript:void(0)"  style='color: green;' id="check"
                                                 data-toggle="dropdown" aria-expanded="false">
														 подборка</a>
												<ul class="dropdown-menu" data_sample = '<?=$data[$j]['id']?>'>
													<?=Helper::getSampleList($_SESSION['people_id'], $data[$j]['id'], 'ag')?>
												</ul>
										</span>
                                <?php } ?>
									<a href='javascript:void(0)' style='color: #286090;text-decoration: underline; margin-left: 5px; margin-right: 5px; ' onclick="showModalWin(<?=$data[$j]['id']?>)">Продлить</a> | 								
									<a href="?task=profile&action=edit&topic_id=<?=("{$data[$j]['topic_id']}&id={$data[$j]['id']}&parent_id={$data[$j]['parent_id']}")?>" style='color: #286090;text-decoration: underline; margin-left: 5px; margin-right: 5px; '>Редактировать</a> |								
									<a href='javascript:void(0)' style='color: #286090;text-decoration: underline; margin-left: 5px; margin-right: 5px; ;' onclick="VarArchive(<?=$data[$j]['id']?>, 'add')">В архив</a>

									<div style="text-align: center" id="popupProlong<?=$data[$j]['id']?>" class="modalwin">
									<?php									
									$prolongAcessCount = Helper::varProlongAcess($data[$j]['id']);
									if(!empty($prolongAcessCount))
									{
									?>
										<span style = 'color:#000;'>
											Отметьте «Актуален» если вариант на момент продления действительно актуален и «Прозвон» если актуальность данного варианта проверяется в момент обращения!
											</span><br/>
											<?php
												if(Helper::checkProlongExists($_SESSION['user'])){
											?>
												<button href='javascript:void(0)' 
													style='font-weight:normal;margin-top:10px; display:inline-block;color: #fff;border-radius:10px; background-color:#5cb85c ; border-color:#5cb85c  ;' onclick="VarExtendOne(<?=$data[$j]['id']?>,1)">
													Актуален </button>
											<?php } ?>
												<button href='javascript:void(0)' 
													style='font-weight:normal;margin-top:10px; display:inline-block;color: #fff;border-radius:10px; background-color:#d9534f; border-color:#d9534f ;' onclick="VarExtendOne(<?=$data[$j]['id']?>,0)">
													Прозвон </button>
									<?php
									} else {
										echo "<br/><br/><span style = 'color: red;'>Продление возможно не чаще <br/><br/>1 раз в час!</span><br/>";
									}
									?>
								     </div>
								 <?}else if($_GET['active'] == '0' && isset($_GET['active'])){?>
									<span class="dropdown">
										<a href="javascript:void(0)"  style='color: #286090;text-decoration: underline; margin-left: 5px; margin-right: 5px; ' id="check" data-toggle="dropdown" aria-expanded="false">Проверить</a> |
										<ul class="dropdown-menu" aria-labelledby="check">
											<li><a href='javascript:void(0)' data-name='check-var' data-id='parse' target='_blank' data-toggle='modal' data-target='#clean-modal-win'>Частники</a></li>
											<li><a href='javascript:void(0)' data-name='check-var' data-id='pay_parse' target='_blank' data-toggle='modal' data-target='#clean-modal-win'>Частники 2</a></li>	

										</ul>
									</span>

									<a href='javascript:void(0)' style='color: #286090;text-decoration: underline; margin-left: 5px; margin-right: 5px; ' onClick="DeleteVar(<?=$data[$j]['id']?>)">Удалить</a>
									<br/>

									<a href="?task=profile&action=edit&topic_id=<?=("{$data[$j]['topic_id']}&id={$data[$j]['id']}&parent_id={$data[$j]['parent_id']}&active=1")?>" style='color: #286090;text-decoration: underline; margin-left: 5px; margin-right: 5px; '>Активировать</a> |
									<a href="?task=profile&action=edit&topic_id=<?=("{$data[$j]['topic_id']}&id={$data[$j]['id']}&parent_id={$data[$j]['parent_id']}&active=0")?>" style='color: #286090;text-decoration: underline; margin-left: 5px; margin-right: 5px; '>Редактировать</a>
									
								<?php
							}
							}else{?>
								<a href='javascript:void(0)' style='color: grey;    text-decoration: underline;' data-name='an-info' target='_blank' data-toggle='modal' data-target='#clean-modal-win'>Об АН</a> | 
								<?php
									if($_SESSION["block_com_an"]==0){?>
										<a href='javascript:void(0)' style='color: grey;    text-decoration: underline;' data-name='send-review' target='_blank' data-toggle='modal'
											 data-target='#send-review-modal-win'>отзыв</a> | 
								<?
									}

                                if($_SESSION["sell_date_end"] >=  date("Y-m-d") ) {
                                    ?>
                                    <span class="dropdown">
									<a href="javascript:void(0)" style='color: grey;    text-decoration: underline;'
                                       id="check" data-toggle="dropdown" aria-expanded="false">Проверить</a>
									<ul class="dropdown-menu" aria-labelledby="check">
										<li><a href='javascript:void(0)' data-name='check-var' data-id='pay_parse'
                                               target='_blank' data-toggle='modal' data-target='#clean-modal-win'>Частники</a></li>
                                        <?php
                                        if ($_SESSION["sell_date_end"] > date("Y-m-d") && $_SESSION["isMobAllow"] == 1
                                        ) {
                                            ?>
                                            <li><a href='javascript:void(0)' data-name='check-var' data-id='archive'
                                                   target='_blank' data-toggle='modal' data-target='#clean-modal-win'>Частники Архив</a></li>
                                        <?php } ?>
									</ul>
								</span>
                                    <?php
                                }

                                    if(empty($_POST['sample_id']) AND Helper::isMobileExists($_SESSION['people_id']) ){
                                        ?>
                                        <span class="dropdown">
											| <a href="javascript:void(0)"  style='color: green;' id="check"
                                                 data-toggle="dropdown" aria-expanded="false">
														 подборка</a>
												<ul class="dropdown-menu" data_sample = '<?=$data[$j]['id']?>'>
													<?=Helper::getSampleList($_SESSION['people_id'], $data[$j]['id'], 'ag')?>
												</ul>
										</span>
                                        <?php
                                    }
								}

                            if(!empty($_POST['sample_id'])){ ?>
                                <span >
										<a href='javascript:void(0)'
                                           style='color: grey;' data-name='del_sample_var'
                                           data-target='#clean-modal-win'>Удалить из подборки</a>
									</span>
                                <?php
                            }
							if($data[$j]['review'] == 1)
							{
								echo " | <a href='javascript:void(0)' style='color:#E81010' data-id='review' target='_blank' data-toggle='modal' data-target='#clean-modal-win'>Есть отзывы</a>";
							}

							?>
						</div>
					<?}else{?>
						<div style="font-size: 12px;color: grey;font-weight: bold;">
							<?if($_SESSION["block_com_parse"]==0 && $_GET['action'] != 'check_var'){?>
								<a href='javascript:void(0)' style='color: grey;' data-name='send-review' target='_blank' data-toggle='modal' data-target='#send-review-modal-win'>оставить отзыв</a>
							<?}if($data[$j]['review'] == 1 && $_GET['action'] != 'check_var'){?>								
								 | <a href='javascript:void(0)' style='color:#E81010' data-id='review' target='_blank' data-toggle='modal' data-target='#clean-modal-win'>Есть отзывы</a>
							<?}?>
						</div>
					<?}?>

				</td>
			</tr>
			<tr>
				<td colspan = 2>
					<div data-name='mobile-fotos-<?=$data[$j]['id']?>' style = 'width:100%' ></div>
				</td>
			</tr>
		</table>
	</div>
<?}
?>