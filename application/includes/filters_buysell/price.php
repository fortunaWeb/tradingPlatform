Цена  : <div class="input-group interval xl" style = 'margin-right: 10%;'>
    <input type="text" id="pricefrom" name="pricefrom" class="form-control" placeholder="от"  size="11" maxlength="11" aria-describedby="basic-addon1" value="<?php if (Helper::FilterVal('pricefrom')) echo Helper::FilterVal('pricefrom'); ?>" style="max-width: 88px;">
    <input id="priceto" name="priceto" type="text" class="form-control" placeholder="до" size="11" maxlength="11"value="<?php if (Helper::FilterVal('priceto')) echo Helper::FilterVal('priceto'); ?>" style="max-width: 88px;">
</div>
