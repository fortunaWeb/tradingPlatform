
<?php
$credit_bank = Helper::FilterVal('credit_bank');
?>
<div class="col-xs-2 deployed">
    <div class="input-group interval xm">
        <label class="signature">Ремонт</label>
        <select  class="form-control" name="credit_bank" id="credit_bank">
            <option value="">Без ипотеки</option>
            <option value="SBER" <?=$credit_bank=='SBER'?"selected":''?> >
                СБЕР
            </option>
            <option value="ВТБ" <?=$credit_bank=='ВТБ'?"selected":''?> >
                ВТБ
            </option>
            <option value="OTHER" <?=$credit_bank=='OTHER'?"selected":''?> >
                остальные
            </option>

        </select>
    </div>
</div>