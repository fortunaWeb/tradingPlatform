<div class="col-xs-2 deployed">
    <label class="signature">Тип недвижемости</label>
    <select class="form-control" name="type_id" required>
        <option value="">выберите тип</option>
        <option value="39" <?=Helper::FilterVal('type_id')==39?"selected":""?>>
            Бизнес-центр
        </option>
        <option value="40" <?=Helper::FilterVal('type_id')==40?"selected":""?>>
            Готовый бизнес
        </option>
        <option value="41" <?=Helper::FilterVal('type_id')==41?"selected":""?>>
            Отдельно строящиеся зданиео
        </option>
        <option value="42" <?=Helper::FilterVal('type_id')==42?"selected":""?>>
            Офисное помещение
        </option>
        <option value="43" <?=Helper::FilterVal('type_id')==43?"selected":""?>>
            Производственное помещение
        </option>
        <option value="44" <?=Helper::FilterVal('type_id')==44?"selected":""?>>
            Складское помещение
        </option>
        <option value="45" <?=Helper::FilterVal('type_id')==45?"selected":""?>>
            Производственно-складское помещение
        </option>
        <option value="46" <?=Helper::FilterVal('type_id')==46?"selected":""?>>
            Торговая площадь
        </option>
        <option value="47" <?=Helper::FilterVal('type_id')==47?"selected":""?>>
            Универсальное
        </option>
    </select>
</div>