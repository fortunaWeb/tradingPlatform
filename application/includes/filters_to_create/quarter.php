<div class="col-xs-2 deployed">
    <label class="signature">Квартал:</label>

    <select class="form-control" name="kvartal" id="kvartal" required>
    <option value="0" >---</option>
    <option value="1" <?=$data_res['kvartal'] == '1' ? "selected":''?> >1 (январь-март)</option>
    <option value="2" <?=$data_res['kvartal'] == '2' ? "selected":''?> >2 (апрель-июнь)</option>
    <option value="3" <?=$data_res['kvartal'] == '3' ? "selected":''?> >3 (июль-сентябрь)</option>
    <option value="4" <?=$data_res['kvartal'] == '4' ? "selected":''?> >4 (октябрь-декабрь)</option>
</select>
</div>