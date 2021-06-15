<div class="col-xs-2 deployed">
    <label class="signature">Назначение варианта</label>
    <?php
        $copyright = !empty($data_res['copyright']) ? $data_res['copyright'] : 0?>
    <select class="form-control"  name="copyright" required id = "val_copyright">
        <option value="1" <?=$copyright == "1"?"selected":''?>>
            Скопированные
        </option>
        <option value="0" <?=$copyright == "0"?"selected":''?>>
            Для агентств
        </option>
    </select>
</div>