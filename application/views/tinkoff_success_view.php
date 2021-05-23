 <link rel="stylesheet" type="text/css" href="css/style.css" />
<?php
//var_dump($data);
if(isset($data['fail'])){
?>
    <br/>
    <div style="width: 100%;display: inline-block;float: left;">
        <legend style="color:rgb(205, 24, 24);">Ошибка при оплате заказа.</legend>
    <?
} elseif($data != false){

?>
<div class="col-xs-9 deployed"  style="width: 100%;display: inline-block;float:left; padding:20px">

<div style="width: 250px;display: inline-block;float: left;">
    <legend>Оплаченные услуги</legend>
    <? if(isset($data['rent_month_count']) && $data['rent_month_count'] >0){ ?>
    <div class="col-xs-3 deployed"> Аренда : <span id = 'pay_success'><?=$data['rent_month_count']?> мес.</span> </div>
    <?php } ?>
    <? if(isset($data['rent_premium_period']) && $data['rent_premium_period'] >0){ ?>
        <div class="col-xs-3 deployed"> Премиум :
            <span id = 'pay_success'> <?=$data['rent_premium_count']?> на <?=$data['rent_premium_period']?> дней</span> </div>
    <?php } ?>
    <? if(isset($data['pay_parse_days_count']) &&  $data['pay_parse_days_count'] >0){ ?>
        <div class="col-xs-3 deployed"> Частники 2  : <span id = 'pay_success'><?=$data['pay_parse_days_count']?> дней</span> </div>
    <?php } ?>
    <? if(isset($data['buysell_month_count']) && $data['buysell_month_count'] >0){ ?>
        <div class="col-xs-3 deployed"> Продажа от частников  : <span id = 'pay_success'><?=$data['buysell_month_count']?> мес.</span> </div>
    <?php } ?>
    <div class="col-xs-3 deployed"> Общая сумма : <span id = 'pay_success'><?=$data['price']?> р.</span> </div>
</div>

<div style="width: 250px;display: inline-block;float: left;">
    <legend>Текущее состояние доступа</legend>
    <div class="col-xs-3 deployed">
        Аренда до: <span data-id="sell_date_end" style="<?=Helper::Warn($data["sell_date_end"])?>">
            <?=date("d.m.Y", strtotime($data["sell_date_end"]))?>
        </span>
    </div>
    <div class="col-xs-2 deployed">
        Премиумы: <span data-id="rent_premium"><?=$data["rent_premium"]?></span>
    </div>
    <div class="col-xs-4 deployed">
        Частники 2 до: <span data-id="pay_parse_date_end" style="<?=Helper::Warn($_SESSION["pay_parse_date_end"])?>"><?=date("d.m.Y", strtotime($_SESSION["pay_parse_date_end"]))?></span>
    </div>
<?if($_SESSION['group_topic_id'] != 1){?>
    <div class="col-xs-4 deployed">
        Продажа от частников до: <span data-id="sell_date_end" style="<?=Helper::Warn($data["sell_date_end"])?>"><?=date("d.m.Y", strtotime($data["sell_date_end"]))?></span>
    </div>
<?}?>
</div>
<div class=" deployed info" style="width: 250px;display: inline-block;float: left; margin-left: 40px">
    <label class="signature">Даты списания премиумов</label>
    <?
    foreach ($data["prem_end_date"] as $prem_end_date ){
        $diff = ($data["rent_premium"] -  $prem_end_date["prem_sum"]);
        echo "<span>".date(Translate::MYSQL_DATE_TIME, strtotime( $prem_end_date["date_finish"]))."<br/>
                    cпишется.{$prem_end_date["prem_sum"]} премиумов, остаток составит {$diff}</span><br />";
    }
    ?>
</div>
</div>
<br/>
<div style="width: 250px;display: inline-block;float: left;">
<?php
}else{ ?>
<br/>
<div style="width: 250px;display: inline-block;float: left;">
    <legend>Cчёт уже оплачен</legend>
<?php } ?>
    <a href='javascript:void(0)' tabindex="-1" class = 'btn btn-warning right' style=' color: black;'
       onclick="window.location = '?task=profile&action=services'"> Вернуться </a>
</div>