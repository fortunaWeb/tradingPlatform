<?php
$sq_all = Helper::FilterVal('sq_all');
$sq_live = Helper::FilterVal('sq_live');
$sq_k = Helper::FilterVal('sq_k');
?>
<div class="col-xs-2 deployed">
    <label class="signature">Площади, м<sup>2</sup></label>
    <div class="input-group interval">
        <input type="text" id="sq_all" name="sq_all" class="form-control" placeholder="общ."
               size="3" maxlength="3" value="<?=$sq_all?>" >
        <input type="text" id="sq_live" name="sq_live" class="form-control" placeholder="жил." size="3" maxlength="3"
               value="<?=$sq_live?>" >
        <input type="text" id="sq_k" name="sq_k" class="form-control" placeholder="кух." size="3" maxlength="3"
               value="<?=$sq_k?>" >
    </div>
</div>