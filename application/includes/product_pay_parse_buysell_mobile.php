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

$arr_num = count($data);
if($_SESSION["pay_parse_date_end"] < date("Y-m-d")  ){
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
     //   Helper::unsetVarPhoto($data[$j]['id']);
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
        ($_SESSION["pay_parse_date_end"] > date("Y-m-d")  && ($_GET['action'] == 'pay_parse' || $_GET['action'] == 'check_var'
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
                            <?if($count_photo > 0){
                                ?>
                                <div style="display: inline-block;margin-top: 10px;margin-left: 15px;" >
                                    <a title="есть фото"  data-id = '<?=$data[$j]['id']?>'
                                       data-buysell = 'buysell' style="margin-bottom: <?=!$_SESSION['mobile']?'8':'0'?>px;"
                                       class="pull-left showFotosPayParse" href="#<?=$data[$j]['id']?>" >
                                        <img class="media-object" src="images/zenit_mobile.png"
                                             style="padding: 2px; border: 1px solid silver;">
                                    </a>
                                </div>

                            <?}?>

                        </div>
                    </td>
                    <td>
                        <div style="margin-top: -3px;">
                            <?
                            echo str_replace("0-ком", "",
                                Translate::Var_title_retro_mobile($data[$j]['parent_id'], $data[$j]['topic_id'],
                                    $data[$j]['room_count'], '', $data[$j]['dis'], $data[$j]['street'],
                                    $data[$j]['house'], '',$data[$j]['parent_id'],
                                    $data[$j]['live_point'],
                                    (true)   ));
                            ?>
                            <a href="javascript:void(0)" <?echo "onClick='show_address(\"".$coords."\", ".$j.")' target='_blank' data-toggle='modal' data-target='#modal-win'";?>>
                                <img border="0" src="images/icon/maps.ico"></a>

                        </div>
                        <div>
                            <font style="color: #476BC6;font-size: 16px;">цена: </font>
                            <font style="color:rgb(0, 128, 0)"><?=number_format( $data[$j]['price'],0,'',' ')?></font>
                            <?
                            echo Helper::PriceRetro($data[$j]['price'],$data[$j]['prepayment'],$data[$j]['utility_payment'], 0, $data[$j]['deliv_period'], $topic, $topic_id);
                            ?>

                           <input data-name='favorit' type='hidden' value="<?=$data[$j]['favorit'];?>">

                            <?if($_SESSION['admin']==1){?>
                                <span class="delete right" style="font-size: 14px;margin: 8px;" onClick="Delete('pay_parse', <?=$data[$j]['id'];?>)">удалить вариант</span>
                            <?}?>

                        </div>
                        <div>
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

                            ?>
                        </div>
                        <div style="font-size: 16px;">
                            <?php
                            if(!empty($data[$j]['text']))
                            {
                                ?>
                                <font style='color: #476BC6;font-size: 16px;' onclick = "$(this).next().toggle();" >Описание : </font>
                                <span style='text-transform: lowercase;display: none' class = 'comment' data-name='comment<?=$data[$j]['id']?>'>: <?=$data[$j]['text'];?></span>
                                <?php
                            }
                            ?>
                        </div>
                        <div style="font-size: 16px;">

                            <font style="color: #476bc6;font-size: 14px;font-weight: bold;">тел: </font><font data-name='contacts'><?=$data[$j]['phone']; ?></font>

                        </div>
                        <div style="font-size: 12px;color: grey;font-weight: bold;">
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan = 2>
                        <div data-name='mobile-fotos-<?=$data[$j]['id']?>' style = 'width:100%' ></div>
                    </td>
                </tr>
            </table>
        </div>
        <?
    }
}
?>