
<?php
$land_status = Helper::FilterVal('land_status');
?>
<div class="col-xs-1 deployed">
    <div class="input-group interval xm">
        <label class="signature">Статус  земли</label>
        <select  class="form-control" name="land_status" id="land_status" style="border-radius: 4px; ">
            <option value="">---</option>
            <option value="rent" <?=$land_status  == 'new'?"selected":''?> >
                Аренда
            </option>
            <option value="own" <?=$land_status  == 'old'?"selected":''?> >
                Собственность
            </option>
        </select>
    </div>
</div>
