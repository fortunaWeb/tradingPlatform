<div class="col-xs-2 deployed">
	<label class="signature">Год постройки:</label>
	<select class="form-control" name="construct_y" id="construct_y">
        <option value=''>
            --
        </option>
        <?php for ($i =1930;  $i <= 2030; $i++): ?>
            <option value='<?=$i?>' <?=$data_res['construct_y']==$i?"selected":''?>>
                <?=$i?>
            </option>
        <? endfor; ?>
	</select>
</div>