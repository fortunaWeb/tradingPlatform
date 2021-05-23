<?php
$arr_num = count($data);
$getTopicId = 2;
$getRes = '';

if(isset($getRes))
    $getRes = $getRes;

$people_ids_in_an = Get_functions::Get_peoples_ids_in_an($_SESSION['company_id']);
?>
    <script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
    <script src="//yastatic.net/share2/share.js"></script>
<?php
$contacts = (
    Helper::FilterVal('without_cont')!=1 &&
    (
        !isset($_SESSION["post"]) ||
        !isset($_SESSION["post"]["without_cont"]) ||
        $_SESSION["post"]["without_cont"]!=1
    )
);
$lookVars = '';
if(isset($data['lookVars'])) {
    $lookVars = $data['lookVars']['look_vars'];
}

for ($j=0; $j<$arr_num ; ++$j) {

    if (empty($data[$j]['user_id'])) {
        continue;
    }

    // Блокировка из чёрного списка.
    if (ereg("," . $data[$j]['people_id'] . ",", $_SESSION['in_black_list']) && !empty($data[$j]['people_id'])) {
        $people_id_black_show_var = Get_functions::Get_black_list_show_var($data[$j]['people_id']);
        if ($people_id_black_show_var == 0) continue;
    }

    $favorit = !preg_match("/\|" . $_SESSION['people_id'] . "\|/", $data[$j]['favorit']);
    $ngs = $data[$j]['user_id'] == 'ngs' || $data[$j]['user_id'] == 'avito';
    $company_var = $_SESSION["company_name"] == $data[$j]['company_name'];
    $imgUrl = null;

    if (!$ngs) {
        $imgUrl = Helper::checkAgPhotosExists($data[$j]['id'], $data[$j]['people_id']);
    } else if (strlen($data[$j]['photos']) > 5) {
        $photo_arr = glob("images/ngs_parse/" . $data[$j]['id'] . "/*");
        if (count($photo_arr) > 0) {
            $imgUrl = str_replace($_SERVER['DOCUMENT_ROOT'], "", $photo_arr[0]);
        }
        unset($photo_arr);
    }

    if (empty($imgUrl) && Helper::FilterVal('photo')) {
        continue;
    }

    if ($data[$j]['review'] == 1 && !$ngs && $_GET['action'] != "pay_parse")
        $data[$j]['review'] = Helper::UpdateReview($data[$j]['id']);

    $icon = array(
        "ngs" => "/images/icon/source/ngs.png",
        "avito" => "/images/icon/source/avito.ico"
    );
    $date_col = (isset($data[$j]['col_date']) && date("Y-m-d", strtotime($data[$j]['col_date'])) == date("Y-m-d") && $_GET['action'] == "mytype" && $_GET["active"] == "0");
    ?>
    <div class="col-xs-12
		<?
    if (!$ngs && ereg($data[$j]['people_id'] . ",", $_SESSION['in_black_list'])) {
        echo " product ";
    } else {
        echo ' product ';
    } ?>
	  <?php if ($date_col) echo "dateCol";
    if ($data[$j]['review'] == 1 && $_GET['action'] != 'check_var') echo "hasReview";
    ?>"
         style="font-family: arial, verdana;font-size: 18px;line-height: normal;"
         data-coords="<?= $data[$j]['coords']; ?>" id="msg<?= $j; ?>" data-id='<?= $data[$j]['id']; ?>'
         data-addr="НСО, <?= $data[$j]['live_point'] . ", " . $data[$j]['street'] . " д." . $data[$j]['house']; ?>"
         data-col="<?
         if ($date_col) echo 1; ?>"
         data-user="<?= $data[$j]['user_id'] ?>">
        <table style='width: 100%;'>
            <tr>
                <td align="left" style='width: 3%;vertical-align: top;line-height: 0.8;'>
                    <?
                    if (!$ngs) { ?>
                        <font size="2" data-id="last-edit">
                    <?=date("d/m", strtotime($data[$j]['date_last_edit'])); ?>
                    <br/>
                    <?=date("H:i", strtotime($data[$j]['date_last_edit'])); ?>
                        </font>
                    <?
                    } else { ?>
                        <font size="2" style='margin-right: 25px;' data-id="last-edit">
                            <?
                            echo date("d/m/y H:i", strtotime($data[$j]['date_last_edit'])); ?>
                        </font>
                    <?
                    } ?>

                    <?php
                    if(!$ngs){
                        ?>
                        <div style="display: inline-block;float:left;">
                            <?php
                            if(isset($imgUrl)){?>
                                <a title="есть фото" class="fancybox-thumbs pull-left" href="<?=$imgUrl;?>"
                                   data-fancybox-group="msg<?=$data[$j]['id']?>" style="margin-bottom: -8px;margin-top: 15px;">
                                    <img class="media-object" src="images/zenit1.png" style="padding: 2px; border: 1px solid silver;">
                                </a>
                                <?php
                            }?>
                        </div>
                    <?php }
                    if (Helper::FilterVal("action") == "mytype" && Helper::FilterVal("active") == 1
                        && $company_var && Helper::FilterVal('copyright') != 1)
                        echo "<input type='checkbox' onChange='showButtons($(this))' data-id='{$data[$j]['id']}' style='margin: 10px 0;'>"; ?>
                    <br/>
                    <?php
                    if ($data[$j]['status'] == 3) {
                        echo "<img style = '";
                        echo $getTopicId == 3 ? 'display:none;' : '';
                        echo "' title='Гарантия что объекта нет в интернете на прямую от собственника' width='20px' style = 'margin-left: 5px;' src='images/icon/vip.jpg'><br/>";
                    }
                    if (isset($imgUrl) && $ngs) {
                        ?>
                        <a title="есть фото" class="fancybox-thumbs pull-left" href="<?= $imgUrl; ?>"
                           data-fancybox-group="msg<?= $data[$j]['id'] ?>"
                           data-type='<?= $ngs ? 'pri' : '' ?>' style="margin-bottom: -8px;">
                            <img class="media-object" src="images/zenit1.png"
                                 style="padding: 2px; border: 1px solid silver;">

                        </a>
                        <br/>
                        <br/>
                        <?php
                    }
                    if ($_SESSION['email_work'] != NULL && $_SESSION['email_pass'] != NULL) {
                        ?>

                        <div class="send-email-form hidden">
                            <div class="col-xs-4 deployed" style='margin-top: 20px;'>
                                <label class="signature">Отправить клиенту</label>
                                <input class="form-control" data-name="email_for_favor" placeholder="email"
                                       onclick="$('.dropdown-menu').has($(this)).show()">
                            </div>
                            <div class="col-xs-4 deployed" style="margin-top: 20px;">
                                <label class="signature">Комментарий(можно редактировать)</label>
                                <textarea class="form-control" rows="7" data-name="comment"
                                          placeholder="текст комментария"></textarea>
                            </div>
                            <div class="col-xs-2 deployed">
                                <button type="button" onclick="SendVarToEmail($(this), <?= $data[$j]['id']; ?>)"
                                        style="" class="btn btn-success btn-xs ">Отправить
                                </button>
                            </div>
                        </div>
                        <?php
                    }
                    ?>

                </td>
                <td>
                    <div style="margin-top: -3px; <?= $getTopicId == 3 ? 'display:none' : '' ?>">
                        <?php
//                        echo ($_SESSION['login'] == 1 || $_SESSION['login'] == '8197') ? $data[$j]['id'] : ''
                        ?>
                        <?=Translate::Var_title_retro($data[$j]['type_id'], $data[$j]['topic_id'], $data[$j]['room_count'], $data[$j]['planning'], $data[$j]['dis'], $data[$j]['street'], $data[$j]['house'], $data[$j]['ap_layout'], $data[$j]['parent_id'], $data[$j]['live_point']) ?>
                        <a href="javascript:void(0)"
                            <?= "onClick='show_address(\"" . $data[$j]['coords'] . "\", " . $j . ")' target='_blank' data-toggle='modal' data-target='#modal-win'" ?>
                        >
                            <img border="0" src="images/icon/maps.ico"></a>

                        <?= Helper::PriceRetro(
                            $data[$j]['price'],
                            $data[$j]['prepayment'],
                            $data[$j]['utility_payment'],
                            $data[$j]['torg'],
                            $data[$j]['deliv_period'],
                            $topic,
                            $topic_id,
                            [
                                'Чистая продажа' => $data[$j]['chist_prod'],
                                'Обмен' => $data[$j]['obmen'],
                                'Ипотека' => $data[$j]['ipoteka'],
                                'Торг' => $data[$j]['torg']
                            ]
                        ) ?>


                        <?
                        $favorit = !preg_match("/\|" . $_SESSION['people_id'] . "\|/", $data[$j]['favorit']);

                        if ($_SESSION['admin'] == 1 && $ngs) {
                            ?>
                            <span class="delete right" style="font-size: 14px;margin: 8px;"
                                  onClick="Delete('parse', <?= $data[$j]['id']; ?>)">удалить вариант</span>
                        <?
                        } ?>
                    </div>
                    <div style=" <?= $getTopicId == 3 ? 'display:none' : '' ?>">
						<span data-name="view-race">
						</span>
                        <span data-name='deposit'>
                            <?= $data[$j]['deposit'] > 0 ? "<font class='retro-gray'> Депозит: </font><font style='color:#E81010' > {$data[$j]['deposit']}</font>" : '' ?>
                        </span>
                        <?= (!empty($data[$j]['metro_name']))
                            ? "<font class='retro-gray'> Метро:</font><font class='retro-green'>{$data[$j]['metro_name']} {$data[$j]['distance_to_metro']}м.(по прямой)</font>"
                            : ""
                        ?>
                    </div>
                    <div style="<?= $getTopicId == 3 ? 'display:none;' : '' ?>">
                        <font style='color: #476BC6;font-size: 16px;'>Дополнение: </font>
                        <?= (!empty($data[$j]['orientir'])) ? "<font class='retro-gray' > Ориентир : </font><font class='retro-green'>" . $data[$j]['orientir'] . ";</font>" : '' ?>
                        <?php
                        if ($data[$j]['floor'] && $parent != "Дома") {
                            echo "<font class='retro-gray'>Этажность: </font><font class='retro-green' data-name='floor'>{$data[$j]['floor']}";
                            if ($data[$j]['floor_count']) {
                                echo "/{$data[$j]['floor_count']}";
                            }
                            echo "</font>";
                        } else if ($data[$j]['floor_count'] && $parent != "Дома") {
                            echo "<font class='retro-gray'>Этажность: </font><font class='retro-green' data-name='floor'>ср/{$data[$j]['floor_count']}</font>";
                        }
                        if ($data[$j]['floor_count'] && $parent == "Дома") {
                            echo "<font class='retro-gray'>Этажность: </font><font class='retro-green' data-name='floor'>{$data[$j]['floor_count']}</font> ";
                        }
                        if (floatval($data[$j]['sq_all']) || floatval($data[$j]['sq_live']) || floatval($data[$j]['sq_k'])) {
                            echo "<font class='retro-gray'> пл:</font><font class='retro-green' data-name='sq'>";
                            if ($parent != "Гаражи" && $parent != "Дачи") {
                                if ($data[$j]['sq_all']) {
                                    echo $data[$j]['sq_all'] . "/";
                                } else {
                                    echo "-/";
                                }
                                if ($data[$j]['sq_live']) {
                                    echo $data[$j]['sq_live'] . "/";
                                } else {
                                    echo "-/";
                                }
                                if ($data[$j]['sq_k']) {
                                    echo $data[$j]['sq_k'];
                                } else {
                                    echo "-";
                                }
                            } else if (floatval($data[$j]['sq_live']) && !$ngs) {
                                echo $data[$j]['sq_live'];
                            } else {
                                echo $data[$j]['sq_all'];
                            }
                            echo "</font> ";
                        }
                        if ($data[$j]['val_bal'] != 0) {
                            echo "<font class='retro-gray'> Балкон: </font><font class='retro-green'>";
                            echo $data[$j]['val_bal'] == 5 ? "Нет" : $data[$j]['val_bal'];
                            echo "</font>";
                        }
                        if ($data[$j]['val_lodg'] != 0) {
                            echo "<font class='retro-gray'> Лоджии: </font><font class='retro-green'>";
                            echo $data[$j]['val_lodg'] == 5 ? "Нет" : $data[$j]['val_lodg'];
                            echo "</font>";
                        }
                        ?>
                        <?= (floatval($data[$j]['sq_land'])) ?
                            "<font class='retro-gray'> уч: </font><font class='retro-green' data-name='sq'>{$data[$j]['sq_land']}</font>"
                            : '';
                        ?>
                    </div>

                    <?=($data[$j]['ap_layout'])?"<font class='retro-gray'>Тип квартиры: </font><font class='retro-green' data-name='sq'>{$data[$j]['ap_layout']}</font>; ":''?>
                    <?=($data[$j]['wall_type'])?"<font class='retro-gray'>Материал стен: </font><font class='retro-green' data-name='sq'>{$data[$j]['wall_type']}</font>; ":''?>
                    <?=($data[$j]['own_type'])?"<font class='retro-gray'>Форма собственности: </font><font class='retro-green' data-name='sq'>{$data[$j]['own_type']}</font>; ":''?>
                    <?=($data[$j]['y_done'])?"<font class='retro-gray'>Год постройки: </font><font class='retro-green' data-name='sq'>{$data[$j]['y_done']}</font>; ":''?>
                    <?=($data[$j]['developer'])?"<font class='retro-gray'>Застройщик: </font><font class='retro-green' data-name='sq'>{$data[$j]['developer']}</font>; ":''?>

                    <?=($data[$j]['construct_y'] )
                        ? "<font class='retro-gray'>Сдача: </font><font class='retro-green' data-name='sq'>".
                            "{$data[$j]['construct_y']} / {$data[$j]['kvartal']}"."</font>;"
                        :   ''

                    ?>

                    <div style = "<?=$getTopicId==3?'display:none;':''?>">
                        <font style='color: #476BC6;font-size: 16px;'>Удобства: </font>
                        <?=($data[$j]['wc_type'])?"<font class='retro-gray'>Санузел: </font><font class='retro-green' data-name='sq'>{$data[$j]['wc_type']}</font>; ":''?>
                        <?=($data[$j]['heating'])?"<font class='retro-gray'> Отопление: </font><font class='retro-green' data-name='sq'>{$data[$j]['heating']}</font>; ":''?>
                        <?=($data[$j]['water'])?"<font class='retro-gray'> Вода: </font><font class='retro-green' data-name='sq'>{$data[$j]['water']}</font>; ":''?>
                        <?=($data[$j]['sewage'])?"<font class='retro-gray'> Cлив: </font><font class='retro-green' data-name='sq'>{$data[$j]['sewage']}</font>; ":''?>
                        <?=($data[$j]['wash'])?"<font class='retro-gray'> Мыться: </font><font class='retro-green' data-name='sq'>{$data[$j]['wash']}</font>; ":''?>

                    </div>
                    <div style = 'width: 85%'>
                        <font style='color: #476BC6;font-size: 16px;'>
                            <?=($getTopicId ==3)?'Сниму':'Описание'?>	:

                        </font><span style='text-transform: lowercase;' data-name='comment' class = 'comment' ><?=$data[$j]['text'];?></span>
                        <?if(isset($data[$j]['hidden_text']) && $data[$j]['hidden_text']!="" && in_array($data[$j]['people_id'], $people_ids_in_an)){
                            echo "<br /><font style='color: #476BC6;font-size: 16px;'>Скрытое примечание: </font>{$data[$j]['hidden_text']}";
                        }?>
                    </div>
                    <div style="font-size: 16px;">
                        <?php if($ngs){?>
                            <font style="color: #476bc6;font-size: 14px;font-weight: bold;">Имя : </font>
                            <font data-name='contacts'><?=$data[$j]['contact_name'];?></font>
                            <?if($contacts){?>
                                <font style="color: #476bc6;font-size: 14px;font-weight: bold;">тел: </font>
                                <font data-name='contacts'><?=$data[$j]['contact_tel']; ?></font>
                            <?}?>

                        <?}else{ ?>
                            <font class='retro-gray'>тел: </font>
                            <font onclick="$(this).hide(); $(this).next().show();" data-name='contacts'
                                <?=(!$contacts ? 'style="display:none;"' : 'style="display:inline-block;"')?>><?=$data[$j]['phone'];?></font>
                            <font onclick="$(this).hide(); $(this).prev().show();"data-name='contacts-hide' <?=($contacts ? 'style="display:none;"' : 'style="display:inline-block;"')?>>***********</font>
                            <?$owner = ( $_SESSION["user"] == $data[$j]['user_id'] || (isset($data[$j]['user_parent']) && $_SESSION["user"] == $data[$j]['user_parent']));?>

                            <font class='retro-gray'> имя : </font>
                            <font <?if($owner) echo "onClick='EmployeeList(".$data[$j]['id'].",\"".$data[$j]['company_name']."\",".$data[$j]['user_id'].")' "; unset($owner);?> data-people-id='<?=$data[$j]['people_id'];?>' data-name='people'>
                                <?=$data[$j]['name'];?>
                            </font>
                            <font class='retro-gray' > АН : </font><?=$data[$j]['company_name'];?>
                            <?=($data[$j]['premium'] == 1) ? "<img title='статус-премиум' width='14px' style='vertical-align: initial;float: right;    margin: 3px 3px;' src='images/icon/zv.gif'>" : ""?>

                        <?php
                        }
                        ?>
                    </div>
                    <?php
                    if(!$ngs){?>
                        <div style="font-size: 12px;color: grey;font-weight: bold;">
                            <?
                            if(HelpeR::FilterVal("task")=="profile" && HelpeR::FilterVal("action")=="mytype" && $getRes!=1  ){

                                if($_GET['active'] == '1'){?>
                                    <a href="?task=profile&action=edit&topic_id=<?="{$data[$j]['topic_id']}&id={$data[$j]['id']}&parent_id={$data[$j]['parent_id']}"?>" style='color: grey;'>Редактировать | </a>
                                    <a href='javascript:void(0)' style='color: grey;' onClick="DeleteVar(<?=$data[$j]['id']?>)">Удалить | </a>
                                    <a href='javascript:void(0)' style='color: grey;' onclick="VarArchive(<?=$data[$j]['id']?>, 'add')">В архив | </a>

                                    <a href='javascript:void(0)' style='color: grey;' onclick="showModalWin(<?=$data[$j]['id']?>)">Продлить вариант |</a>

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
                                <?php

                                if(empty($_POST['sample_id']) AND Helper::isMobileExists($_SESSION['people_id']) ){
                                    ?>
                                    <span class="dropdown">
                                        | <a href="javascript:void(0)"  style='color: green;' id="check"
                                             data-toggle="dropdown" aria-expanded="false">
                                                     подборка <?=$data[$j]['sample_id']?></a>
                                            <ul class="dropdown-menu" data_sample = '<?=$data[$j]['id']?>'>
                                                <?=Helper::getSampleList($_SESSION['people_id'], $data[$j]['id'], 'ag')?>
                                            </ul>
                                    </span>
                                    <?php
                                }
                                }else if($_GET['active'] == '0' && isset($_GET['active'])){?>
                                    <a href='javascript:void(0)' style='color: grey;' onClick="DeleteVar(<?=$data[$j]['id']?>)">Удалить | </a>
                                    <a href="?task=profile&action=edit&topic_id=<?=("{$data[$j]['topic_id']}&id={$data[$j]['id']}&parent_id={$data[$j]['parent_id']}&active=1")?>" style='color: grey;'>Вынести из архива |</a>
                                    <a href="?task=profile&action=edit&topic_id=<?=("{$data[$j]['topic_id']}&id={$data[$j]['id']}&parent_id={$data[$j]['parent_id']}&active=0")?>" style='color: grey;'>Редактировать |</a>
                                    <?php
                                }
                            }else{
                                if(empty($_POST['sample_id']) && Helper::isMobileExists($_SESSION['people_id'])){
                                    ?>
                                    <span >
                                    <a href='javascript:void(0)' data-name='var_clone'>Сохранить к себе</a>
								</span>

                                <?php
                                }


                                if(!empty($_POST['sample_id'])){ ?>
                                    <span >
										<a href='javascript:void(0)'
                                           style='color: grey;' data-name='del_sample_var'
                                           data-target='#clean-modal-win'>Удалить из подборки</a>
									</span>
                                    <span >
                                        <a href="?task=profile&action=edit&topic_id=<?="{$data[$j]['topic_id']}&id={$data[$j]['id']}&parent_id={$data[$j]['parent_id']}"?>"
                                           style='color: grey;'>| Редактировать  </a>
                                    </span>
                                    <?php
                                }
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
        </table>
    </div>
<?}
?>