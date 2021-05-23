<div class="col-xs-2 deployed">
    <div class="btn-group medium" data-toggle="buttons" style="margin-left: 12%;">
        <label class="btn btn-default <?=Helper::FilterVal('keys') == "now"?"active":''?>">
            <input type="checkbox" name="keys" value="now" <?=Helper::FilterVal('keys')=="now"?"checked":''?>>Ключи
        </label>
    </div>
</div>
