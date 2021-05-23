<script type="text/javaScript">
    //для сохранения
    var confirmStr = "Обновить информацию?";
    var postUrl = '?task=profile&action=change_user';
</script>
<div class='col-xs-9'>
    <legend>Список оплат</legend>
    <?php
        $activeStyle = 'color:green; font-weight:bold';
        $passiveStyle = 'color:grey;';
        $archive = Helper::FilterVal('archive');
        $active = Helper::FilterVal('active');
    ?>
    <div class='col-xs-9'>
        <div class='col-xs-2'><a style = '<?=$archive!=1&&$active!=1 ? $activeStyle : $passiveStyle?>' href="?task=admin&action=order">Все</a></div>
        <div class='col-xs-2'><a style = '<?=$active==1 ? $activeStyle : $passiveStyle?>' href="?task=admin&action=order&active=1">Активные</a></div>
        <div class='col-xs-2'><a style = '<?=$archive==1 ? $activeStyle : $passiveStyle?>'href="?task=admin&action=order&archive=1">Архив</a></div>
    </div>

    <table class="table table-striped list" style = 'font-size: 10px'>
        <thead>
        <tr><th>#</th>

            <th>АН</th>
            <th>Коммент</th>
            <th>Сумма</th>
            <th>Дата</th>
            <th>Дата <br />платежа</th>
            <th></th></tr>
        </thead>
        <tbody>
        <?
        foreach ($data as $payment) {
            $active = $payment['active'] == 0 ? "" : "color:#4CAE4C";?>
            <tr class="an" data-name='order' id="<?=$payment["company_id"]?>" style = 'background-color:
                <?=($payment['success']==0)? '#F5CC6B' : '#B4F43E'?> ;'
                data-list-id="<?=$payment["id"]?>">
                <td><?=$payment['id']?></td>
                <td data-name='an' onclick="ShowEmployees('<?=$payment["company_id"]?>')"> <?=$payment["company_name"];?></td>
                <td data-tinkoff='<?=$payment["id"]?>' ><span class="dropdown"><?=$payment["comment"]?></span></td>
                <td><?=$payment["sum"]?></td>
                <td style="width: 100px;"><?=date("d.m.Y H:i:s", strtotime($payment["created"]));?></td>
                <td style="width: 100px;"><?=!empty($payment['pay_date']) ? date("d.m.Y H:i:s", strtotime($payment['pay_date'])):'';?></td>
                <td style="<?=$active?>"><?php if($active!="") {echo "Новый!";}else{?>
                        <span class="dropdown">
							<a href="javascript:void(0)" id="orderMenu" data-toggle="dropdown">Меню<span class="caret"></span></a>
							<ul class="dropdown-menu" aria-labelledby="orderMenu" style='margin-left: -115px;'>
                                <li><a href="javascript:void(0)" onClick="ToArchive('order', <?=$payment['id']?>)">В архив</a></li>
                                <li><a href="javascript:void(0)" onClick="Delete('order', <?=$payment['id']?>)">Удалить</a></li>
                            </ul>
						</span>
                    <?}?></td>
            </tr>
        <?}?>
        </tbody>
    </table>
</div>