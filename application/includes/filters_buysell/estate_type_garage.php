<div class="col-xs-2 deployed">
    <label class="signature">Тип гаража</label>
    <select class="form-control" name="type_id" required>
        <option value="">выберите тип</option>
        <option value="35" <?=Helper::FilterVal('type_id')==35?"selected":""?>>
            Капитальный
        </option>
        <option value="36" <?=Helper::FilterVal('type_id')==26?"selected":""?>>
            Металлический
        </option>
        <option value="37" <?=Helper::FilterVal('type_id')==27?"selected":""?>>
            Парковочное место
        </option>
        <option value="38" <?=Helper::FilterVal('type_id')==28?"selected":""?>>
            Овощехранилище
        </option>
    </select>
</div>