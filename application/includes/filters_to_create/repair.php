<div class="col-xs-2 deployed">
    <label class="signature">Ремонт:</label>
    <select class="form-control" name="repair" id="repair" required >
        <option value="" <?=empty($data_res['repair'])  ? "selected":''?> >---</option>
        <option value="CLEAR" <?=$data_res['repair'] == 'CLEAR' ? "selected":''?> >Чистовая</option>
        <option value="ROUGH" <?=$data_res['repair'] == 'ROUGH' ? "selected":''?> >Черновая</option>
        <option value="RMT" <?=$data_res['repair'] == 'RMT' ? "selected":''?> >РМТ</option>
    </select>
</div>
