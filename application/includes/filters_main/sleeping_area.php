<div class="col-xs-1 deployed">
    <label class="signature">сп.мест</label>
    <select class="form-control"  id="sleeping_area" name="sleeping_area">
        <option value="">-</option>
        <?php
        for ($i = 0; $i < 11; $i++){
            echo "<option value='{$i}' ";
            if(Helper::FilterVal('sleeping_area') === (string)$i)
                echo 'selected';
            echo ">".$i;
            "</option>";
        }
        ?>
    </select>
</div>
