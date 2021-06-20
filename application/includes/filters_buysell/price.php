

<div class="btn-group medium" data-toggle="buttons" style="margin-left: 1%;min-width: 250px;text-align: left;">
    Цена  : <div class="input-group interval xl" style = 'margin-right: 10%;'>
    <input type="text" id="pricefrom" name="pricefrom" class="form-control" placeholder="от"  size="11" maxlength="11" aria-describedby="basic-addon1" value="<?php if (Helper::FilterVal('pricefrom')) echo Helper::FilterVal('pricefrom'); ?>" style="max-width: 88px;">
    <input id="priceto" name="priceto" type="text" class="form-control" placeholder="до" size="11" maxlength="11"
           value="<?=Helper::FilterVal('priceto')? Helper::FilterVal('priceto'):''?>" style="max-width: 88px;">
</div>
</div>