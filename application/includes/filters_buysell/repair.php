
<?php
$repair = Helper::FilterVal('repair');
?>
<div class="col-xs-1 deployed">
    <div class="input-group interval xm">
        <label class="signature">Ремонт</label>
        <select  class="form-control" name="repair" id="repair" style="border-radius: 4px; ">
            <option value="">---</option>
            <option value="CLEAR" <?=$repair=='CLEAR'?"selected":''?> >
                Чистовой
            </option>
            <option value="ROUGH" <?=$repair=='ROUGH'?"selected":''?> >
                Черновой
            </option>
            <option value="RMT" <?=$repair=='RMT'?"selected":''?> >
                 РМТ
            </option>

        </select>
    </div>
</div>