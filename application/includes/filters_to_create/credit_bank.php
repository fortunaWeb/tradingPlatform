<div class="col-xs-2 deployed">
    <label class="signature">Ипотека:</label>
    <select class="form-control" name="credit_bank" id="credit_bank" >
        <option value="" <?=empty($data_res['credit_bank'])? "selected":''?> >Без ипотеки</option>
        <option value="SBER" <?=$data_res['credit_bank'] == 'SBER' ? "selected":''?> >СБЕР</option>
        <option value="VTB" <?=$data_res['credit_bank'] == 'VTB' ? "selected":''?> >ВТБ</option>
        <option value="OTHER" <?=$data_res['credit_bank'] == 'OTHER' ? "selected":''?> >остальные</option>

    </select>
</div>
