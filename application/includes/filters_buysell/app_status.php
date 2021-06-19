
<?php
$app_status = Helper::FilterVal('app_status');
?>
<div class="col-xs-1 deployed">
    <div class="input-group interval xm">
        <label class="signature">Статус</label>
        <select  class="form-control" name="app_status" id="app_status">
            <option value="">---</option>
            <option value="new" <?=$app_status  == 'new'?"selected":''?> >
                 Новостройка
            </option>
            <option value="old" <?=$app_status  == 'old'?"selected":''?> >
                Вторичка
            </option>
        </select>
    </div>
</div>