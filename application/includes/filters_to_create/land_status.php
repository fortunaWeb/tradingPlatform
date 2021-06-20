
<div class="col-xs-1 deployed" style = 'width: 150px'>
    <label class="signature"> Статус земли:</label>
    <select class="form-control" name="land_status" id="land_status" required>
        <option value=''  >---</option>
        <option value='rent' <?=$data_res['land_status']=='rent'?"selected":''?> >Аренда</option>
        <option value='own' <?=$data_res['land_status']=='own'?"selected":''?>>Собственность</option>
    </select>
</div>
