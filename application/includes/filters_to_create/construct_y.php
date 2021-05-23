<div class="col-xs-2 deployed">
	<label class="signature">Год Постройки:</label>
	<select class="form-control" name="y_done" id="park">
        <option value=''>
            --
        </option>
        <?php for ($i =1930;  $i <= 2020; $i++): ?>
            <option value='<?=$i?>' <?=$data_res['y_done']==$i?"selected":''?>>
                <?=$i?>
            </option>
        <? endfor; ?>
	</select>
</div>