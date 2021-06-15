
<div class="col-xs-2 deployed">
    <label class="signature"> Тип:</label>
    <select class="form-control" name="app_type" id="app_type" required>
        <option value='flat' <?=$data_res['app_type']=='flat'?"selected":''?> >Квартира</option>
        <option value='appartment' <?=$data_res['app_type']=='appartment'?"selected":''?>>Аппартаменты</option>
    </select>
</div>
