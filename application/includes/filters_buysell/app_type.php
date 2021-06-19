
<?php
$app_type = Helper::FilterVal('app_type');
?>
<div class="col-xs-1 deployed">
    <div class="input-group interval xm">
        <label class="signature">Тип</label>
        <select  class="form-control" name="app_type" id="app_type">
            <option value="">---</option>
            <option value="flat" <?=$app_type  == 'flat'?"selected":''?> >
                Квартира
            </option>
            <option value="appartment" <?=$app_type  == 'appartment'?"selected":''?> >
                Аппартаменты
            </option>

        </select>
    </div>
</div>