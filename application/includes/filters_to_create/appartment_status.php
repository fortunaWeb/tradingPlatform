
<div class="col-xs-2 deployed">
    <label class="signature"> Статус:</label>
    <select class="form-control" name="app_status" id="app_status" required>
        <option value=''  >---</option>
        <option value='new' <?=$data_res['app_status']=='new'?"selected":''?> >Новостройка</option>
        <option value='old' <?=$data_res['app_status']=='old'?"selected":''?>>Вторичка</option>
    </select>
</div>
