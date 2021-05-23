<div class="col-xs-2 deployed">
    <label class="signature">Назначение варианта</label>
    <?php
        $copyright = $data_res['copyright'] ? $data_res['copyright'] : $data_res['copyright'];?>
    <select class="form-control"  name="copyright" required id = "val_copyright">
        <option value=""> Выберите назначение </option>
            <option value="1" <?php if($copyright == "1") echo "selected"; ?>>
                Скопированные
            </option>
            <option value="0" <?php if($copyright == "0") echo "selected"; ?>>
                Для агентств
            </option>
    </select>
</div>