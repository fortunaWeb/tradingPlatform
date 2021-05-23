<div class="col-xs-2 deployed" style = 'margin-right: <?=$_SESSION['mobile']==1?"auto;'":"auto;"?>'>
    <label class="signature">Источники</label>
    <input type="text" class="form-control" placeholder="Источник" autocomplete="off" name="origin"
           value="<?=Helper::FilterVal('origin') ? Helper::FilterVal('origin') : ''?>">
    <div class="origin_list">
        <?php
        foreach (Translate::getParseBuysellOrigins() as $key => $origin){
            ?>
    <label class="checkbox-inline <?=Helper::FilterVal("origin{$key}")?'active':''?>" style = 'padding-left: 0px;margin-left: 0px;'>
        <img src="<?=Translate::getPayParseIcons()[$origin['origin']]?>" style = 'width:15px; margin-right: 20px;'>
        <input  type="checkbox"
                name='origin<?=$key?>'
                value="<?=$origin['origin']?>"
                onClick="countOrigins($(this))"
            <?=Helper::FilterVal('origin'.$key) ? 'checked="checked"':''?>
        >
        <?=$origin['origin']?>
    </label>
        <? } ?>
    </div>
</div>