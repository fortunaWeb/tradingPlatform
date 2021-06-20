<div class="col-xs-1 deployed">
    <label class="signature">Год сдачи:</label>
    <select class="form-control" name="y_done" id="y_done" >
        <option value=''>
            --
        </option>
        <?php for ($i =2020;  $i <= 2030; $i++): ?>
            <option value='<?=$i?>' <?=$data_res['y_done']==$i?"selected":''?>>
                <?=$i?>
            </option>
        <? endfor; ?>
    </select>
</div>