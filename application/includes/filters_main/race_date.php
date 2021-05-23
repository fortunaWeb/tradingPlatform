<div class="col-xs-1 deployed" style = 'margin-right: <?=$_SESSION['mobile']==1?"auto;'":"auto;"?>'>
    <label class="signature">Заезд не позднее</label>

    <input type="text" class="form-control" data-id="date" name="ap_race_date"
           placeholder='<?=(Helper::FilterVal('ap_race_date'))
                ? Helper::FilterVal('ap_race_date')
                : ''?>'
           value="<?=(Helper::FilterVal('ap_race_date'))
               ? Helper::FilterVal('ap_race_date')
                : ''?>">
</div>
