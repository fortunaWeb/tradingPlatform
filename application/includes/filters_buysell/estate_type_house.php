<div class="col-xs-2 deployed">
    <label class="signature">Тип дома</label>
    <select class="form-control" name="type_id" required>
        <option value="">выберите</option>
        <option value="25" <?=Helper::FilterVal('type_id')==25?"selected":""?>>
            Дом
        </option>
        <option value="26" <?=Helper::FilterVal('type_id')==26?"selected":""?>>
            Часть дома
        </option>
        <option value="27" <?=Helper::FilterVal('type_id')==27?"selected":""?>>
            Коттедж
        </option>
        <option value="28" <?=Helper::FilterVal('type_id')==28?"selected":""?>>
            Часть коттеджа
        </option>
        <option value="29" <?=Helper::FilterVal('type_id')==29?"selected":""?>>
            Таунхаус
        </option>
    </select>
</div>