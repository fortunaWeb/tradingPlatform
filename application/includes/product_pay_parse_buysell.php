<?
$icon = array( 
	"ngs.ru" => "/images/icon/source/ngs.ico",
	"avito.ru" => "/images/icon/source/avito.ico",
	"domofond.ru" => "/images/icon/source/domofond.ico",
	"vk.com" => "/images/icon/source/vk.com.ico",
	"irr.ru" => "/images/icon/source/irr.ico",
	"cian.ru" => "/images/icon/source/cian.ico",
	"reforum.ru" => "/images/icon/source/reforum.ru.ico",
	"russianrealty.ru" => "/images/icon/source/russianrealty.ico",
	"dmir.ru" => "/images/icon/source/dmir.ru.ico",
	"realty.yandex.ru" => "/images/icon/source/ya.ico",
	"n-s-k.net" => "/images/icon/source/n-s-k.net.png",
	"nn-baza.ru" => "/images/icon/source/nn-baza.ru.ico",
	"kvadroom.ru" => "/images/icon/source/kvadroom.ico",
	"do.ru" => "/images/icon/source/do.ru.ico",
	"realty.mail.ru" => "/images/icon/source/mail.ru.ico",
	"dorus.ru" => "/images/icon/source/dorus.ru.ico",
	//"mirkvartir.ru" => "/images/icon/source/mirkvartir.ico",
	"move.su" => "/images/icon/source/move.su.ico",
	"move.ru" => "/images/icon/source/move.ico",
	"domex.ru" => "/images/icon/source/domex.ru.ico",
	"nndv.ru" => "/images/icon/source/nndv.ru.ico",
	"net-agenta.ru" => "/images/icon/source/net-agenta.ru.ico",
	"rosrealt.ru" => "/images/icon/source/rosrealt.ru.ico",
	"barahla.net" => "/images/icon/source/barahla.net.ico",
	"egent.ru" => "/images/icon/source/egent.ru.ico",
	"sibdomo.ru" => "/images/icon/source/sibdomo.ru.gif",
	"mynedv.ru" => "/images/icon/source/mynedv.ru.ico",
	"mlsn.ru" => "/images/icon/source/mlsn.gif",
	"kvadrat54.ru" => "/images/icon/source/kvadrat54.ru.ico",
	"novosibirsk.n1.ru" => "/images/icon/source/novosibirskN1.ico",
	"youla.io" => "/images/icon/source/youla.ico",
    "youla.ru" => "/images/icon/source/youla.ico",
    "multilisting.su" => "/images/icon/source/multilisting.ico",
);

if($_SESSION["sell_date_end"] < date("Y-m-d")  ){
	/* ?>
	<script type="text/javascript">
		$(function(){
			alertify.alert("У Вас не оплачен даный раздел, поэтому фильтр и переход по страницам недоступны, 
					но Вы можете ознакомиться с количеством вариантов приходящих в частники 2");
		})
	</script>	
	<?php /**/
}


	foreach ($data as $j => $value) {

		$favorit = !preg_match("/\|".$_SESSION['people_id']."\|/", $data[$j]['favorit']);
		$company_var = $_SESSION["company_name"];
		$coords = $data[$j]['coords'];

		if($coords!=""){
			$coordsArr = explode(",", $coords);
			$coords = $coordsArr[1].",".$coordsArr[0];
		}
		$dir = $_SERVER['DOCUMENT_ROOT']."images/parse_buysell/".$data[$j]['id']."/*";
		$imgUrl = null;
		$photo_arr = glob($dir);
		$count_photo = count($photo_arr);
		if($count_photo > 0){
			$photo = str_replace($_SERVER['DOCUMENT_ROOT'], "", $photo_arr[0]);
			$imgUrl = $photo;
		}

		if(empty($imgUrl)  ){
			//Helper::unsetVarPhoto($data[$j]['id']);
			if(isset($_GET['photo']) && $_GET['photo'] == 1 ){
				continue;
			}		
		}
		unset($dir, $photo_arr);
		

		$iconImage = '';
		foreach ($icon as $key => $value) {
			if(strpos($data[$j]['link'], $key))
				$iconImage = $key;
		}

if(
	($_SESSION["sell_date_end"] > date("Y-m-d")  && ($_GET['action'] == 'pay_parse' || $_GET['action'] == 'check_var'
			|| $_GET['action'] == 'sample'|| $_GET['action'] == 'mysample' ) )|| 
		Helper::isPayParseAccertableBuysell($data[$j]['link']) 
	){

	?>
		<div class="col-xs-12 product <?if($data[$j]['review']==1) echo "hasReview"?>" 
			style="font-family: arial, verdana;font-size: 18px;line-height: normal;"
			 data-coords="<?= $coords;?>" id="msg<?= $j; ?>" data-id='<?= $data[$j]['id'];?>'
			  data-addr="НСО, <?=$data[$j]['live_point'].", ".$data[$j]['street']." д.".$data[$j]['house'];?>" 
			  data-user="pay_parse">
			<table style="font-family: arial, verdana;font-size: 18px;line-height: normal;">
				<tr>
					<td align="left" style='width: 4%;vertical-align: top;line-height: 1.4;'>
						<font size="2" style='margin-right: 25px;' data-id="last-edit"><?echo date("d/m/y", strtotime($data[$j]['date_last_edit']));?></font>
						<br />
						<?

						if(isset($data[$j]['link'])){?>
							<a href="<?=$data[$j]['link'];?>" data-name='contacts' data-id='new-window' style='font-size: 12px;margin-left: 15px;'>
								<img src="<?=$icon[$iconImage]?>" width="15"></a>
						<?}?>
						<br />
						<div style="display: inline-block;margin-top: 10px;margin-left: 15px;">	
							<?php
								if(isset($imgUrl)){?>
								<a title="есть фото" class="fancybox-thumbs pull-left" href="<?=$imgUrl;?>" 
								data-fancybox-group="msg<?=$data[$j]['id']?>" data-type='pri' style="margin-bottom: -8px;">
									<img class="media-object" src="images/zenit1.png" style="padding: 2px; border: 1px solid silver;">
								</a>								
								<?php
								}
							?>

						</div>
					</td>
					<td>
						<div style="margin-top: -3px;">
							<?=str_replace("0-ком", "",
									Translate::Var_title_retro($data[$j]['parent_id'], 
										$data[$j]['topic_id'], $data[$j]['room_count'],
                                        isset($data[$j]['planning'])?$data[$j]['planning']:null,
                                        $data[$j]['dis'],
										$data[$j]['street'], $data[$j]['house'],
                                        isset($data[$j]['ap_layout'])?$data[$j]['ap_layout']:null,
                                        $data[$j]['parent_id'],
										$data[$j]['live_point'], 
										($_GET['action'] == 'pay_parse' || $_GET['action'] == 'parse' || $_GET['action'] == 'check_var' )  )
                            )?>

							<a href="javascript:void(0)" <?echo "onClick='show_address(\"".$coords."\", ".$j.")' target='_blank' data-toggle='modal' data-target='#modal-win'";?>>
								<img border="0" src="images/icon/maps.ico"></a>
								<font style="color: #476BC6;font-size: 16px;">цена: </font>
							<font style="color:rgb(0, 128, 0)"><?=number_format( $data[$j]['price'],0,'',' ')?></font>


                            <?=Helper::PriceRetro($data[$j]['price'],
                                isset($data[$j]['prepayment'])?$data[$j]['prepayment']:null,
                                isset($data[$j]['utility_payment'])?$data[$j]['utility_payment']:null,
                                0,
                                isset($data[$j]['deliv_period'])?$data[$j]['deliv_period']:null,
                                $topic,
                                $topic_id
                            )?>


							<input data-name='favorit' type='hidden' value="<?=$data[$j]['favorit'];?>">
                            <?=($_SESSION['admin']==1) ? "<span class='delete right' style='font-size: 14px;margin: 8px;' onClick='Delete(\"pay_parse\", {$data[$j]['id']})'>удалить вариант</span>":''?>
						</div>
						<div>
							<font style='color: #476BC6;font-size: 16px;'>Описание: </font>
							<?
								if($data[$j]['floor'] && $parent != "Дома")
								{
									echo "<font class='retro-gray'>Этажн </font><font class='retro-green'>{$data[$j]['floor']}";
									if($data[$j]['floor_count']){
										echo "/{$data[$j]['floor_count']}";
									}
									echo "</font>";
								}else if($data[$j]['floor_count'] && $parent != "Дома"){
									echo "<font class='retro-gray'>Этаж </font><font class='retro-green'>ср/{$data[$j]['floor_count']}</font>";
								}
								if($data[$j]['floor_count'] && $parent == "Дома"){
									echo "<font class='retro-gray'>Этаж </font><font class='retro-green'>{$data[$j]['floor_count']}</font>";
								}
								if(floatval($data[$j]['sq_all']) || floatval($data[$j]['sq_live'])|| floatval($data[$j]['sq_k'])) 
								{ 
									echo "<font class='retro-gray'> пл:</font><font class='retro-green'>";
									if($parent != "Гаражи" && $parent != "Дачи"){
										if($data[$j]['sq_all']){echo $data[$j]['sq_all']."/";}else{echo "-/";}

										echo  isset($data[$j]['sq_live'] )
                                            ? $data[$j]['sq_live']."/"
                                            : "-/";

										echo isset($data[$j]['sq_k'])
                                            ? $data[$j]['sq_k']
                                            : '-';

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

								?>
								<span style='text-transform: lowercase;'  class = 'comment'><?=$data[$j]['text'];?></span>						
						</div>
						<div style="font-size: 16px;">
							
								<font style="color: #476bc6;font-size: 14px;font-weight: bold;">1тел: </font><font data-name='contacts'><?=$data[$j]['phone']; ?></font>
							
						</div>
						<div style="font-size: 12px;color: grey;font-weight: bold;">
							<?
							/*if($_SESSION["block_com_parse"]==0 && $_GET['action'] != 'check_var'){?>
								<a href='javascript:void(0)' style='color: grey;' data-name='send-review' target='_blank' data-toggle='modal' data-target='#send-review-modal-win'>оставить отзыв</a>
							<?}if($data[$j]['review'] == 1){?>
								 | <a href='javascript:void(0)' style='color:#E81010' data-id='review' data-name="pay_parse" target='_blank' data-toggle='modal' data-target='#clean-modal-win'>Есть отзывы</a>
							<?}
							/**/

                            if(empty($_POST['sample_id']) AND Helper::isMobileExists($_SESSION['people_id']) ){
                                ?>
                                <span class="dropdown">
                                                | <a href="javascript:void(0)"  style='color: green;' id="check" data-toggle="dropdown" aria-expanded="false">
                                                             1подборка</a>
                                                    <ul class="dropdown-menu" data_sample = '<?=$data[$j]['id']?>'>
                                                        <?=Helper::getSampleList($_SESSION['people_id'], $data[$j]['id'], 'pri', 'buysell')?>
                                                    </ul>
                                            </span>
                                <?php
                            }
						/*
							if(!empty($_POST['sample_id'])){ ?>
								<span >
									<a href='javascript:void(0)'
									 style='color: grey;' data-name='del_sample_var'
									  data-target='#clean-modal-win'>Удалить из подборки</a>
								</span>
							<?php
							}
						*/
							?>
						</div>
					</td>
				</tr>
			</table>
		</div>
	<?

}else{
	/*?>
		<div class="col-xs-12 product" style="font-family: arial, verdana;font-size: 18px;line-height: normal;" id="msg<?= $j; ?>" data-id='<?= $data[$j]['id'];?>' >
			<table style="font-family: arial, verdana;font-size: 18px;line-height: normal;">
				<tr>
					<td align="left" style='width: 4%;vertical-align: top;line-height: 1.4;'>
						<font size="2" style='margin-right: 25px;' data-id="last-edit"><?echo date("d/m/y", strtotime($data[$j]['date_last_edit']));?></font>
					</td>
					<td>
						<div style="margin-top: -3px;">
							<?echo str_replace("0-ком", "", Translate::Var_title_retro($data[$j]['type_id'], $data[$j]['topic_id'], $data[$j]['room_count'], $data[$j]['planning'], $data[$j]['dis'], "", "", $data[$j]['ap_layout'],$data[$j]['parent_id'], $data[$j]['live_point']));
							echo Helper::PriceRetro($data[$j]['price'],$data[$j]['prepayment'],$data[$j]['utility_payment'], $data[$j]['torg'], $data[$j]['rent_type'], $topic, $topic_id);?>			
						</div>
						<div style="font-size: 16px;">
							<font style="color: #476bc6;font-size: 14px;font-weight: bold;">тел: </font>
							<?if($_SESSION['parent']==0){
								echo "<span>Ваша оплата данного раздела закончилась. Вам необходимо продлить 'частники 2' <a href='?task=profile&action=services'>в личном кабинете</a>.</span>";
							}else{
								echo "<span>Ваша оплата данного раздела закончилась. Вам необходимо продлить 'частники 2' в личном кабинете директора.</span>";
							}?>
						</div>
					</td>
				</tr>
			</table>
		</div>
		<? /**/
	}
}
?>