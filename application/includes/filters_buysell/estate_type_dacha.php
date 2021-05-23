<div class="col-xs-2 deployed">
<label class="signature">Тип дачи</label>
<select class="form-control" name="type_id" required>
    <option value="">выберите</option>
    <option value="30" <?=Helper::FilterVal('type_id')==30?"selected":""?>>
        Участок с домиком
    </option>
    <option value="31" <?=Helper::FilterVal('type_id')==31?"selected":""?>>
        Садовый участок
    </option>
</select>
</div>