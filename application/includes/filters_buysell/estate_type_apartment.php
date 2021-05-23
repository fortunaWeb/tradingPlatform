<div class="col-xs-2 deployed">
    <label class="signature">Тип комнаты</label>
    <select class="form-control" name="type_id">
        <option value="">выберите тип</option>
        <option value="49" <?=Helper::FilterVal('type_id')== "50"?"selected":""?>>
            Комната
        </option>
        <option value="52" <?=Helper::FilterVal('type_id')== "52"?"selected":""?>>
            2 смежные
        </option>
        <option value="53" <?=Helper::FilterVal('type_id')== "53"?"selected":""?>>
            Общежитие
        </option>
    </select>
</div>