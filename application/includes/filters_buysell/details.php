<div class="col-xs-3 deployed">
    <label class="signature">Описание.</label>
    <div class="input-group interval xl">
        <div class="btn-group medium" data-toggle="buttons" style="min-width: 340px;">
            <input id="details" name="text" type="text" class="form-control"
                   placeholder="Пара слов" size="11" maxlength="11"
                   value="<?=Helper::FilterVal('text')?Helper::FilterVal('text'):''?>"
                    style="max-width: 160px;">
        </div>
    </div>
</div>