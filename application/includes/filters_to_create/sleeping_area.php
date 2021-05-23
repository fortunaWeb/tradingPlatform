<div class="col-xs-2 deployed" style="max-width: 160px;">
    <?php
    $sleepingArea = $data_res['sleeping_area'];
    if(isset($data_res['sleeping_area']) && $data_res['sleeping_area'] == NULL){
        $sleepingArea = '';
    }
    ?>
    <label class="signature">сп.мест</label>
    <div class="input-group interval">
        <select place class="form-control" id="sleeping_area" name="sleeping_area" required>
            <option value="">-</option>
            <?php
            for ($i = 0; $i < 11; $i++){
                echo "<option value='{$i}' ";
                if( $sleepingArea == $i && $data_res['sleeping_area'] != NULL  ) echo 'selected';
                echo ">".$i;
                "</option>";
            }
            ?>
        </select>
    </div>
</div>