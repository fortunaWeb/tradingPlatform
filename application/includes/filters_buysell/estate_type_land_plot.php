<div class="col-xs-2 deployed">
    <label class="signature">Тип земли</label>
    <select class="form-control" name="type_id" required>
        <option value="">выберите</option>
        <option value="32" <?=Helper::FilterVal('type_id')==32?"selected":""?>>
            Земельный участок
        </option>
        <option value="33" <?=Helper::FilterVal('type_id')==33?"selected":""?>>
            Землеотвод
        </option>
        <option value="34" <?=Helper::FilterVal('type_id')==34?"selected":""?>>
            Коммерческая земля
        </option>
    </select>
</div>