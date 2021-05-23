<div class="col-xs-2 deployed">
    <?php
        $deposit =  $data_res['deposit'];
        if(!isset($data_res['deposit']) && $data_res['deposit'] == NULL) {
            $deposit = '';
        }
    ?>
	<label class="signature">Депозит</label>
    <select place class="form-control" id="deposit" name="deposit" required>
        <option value="0">-</option>
        <?php

        for ($i = 500; $i < 50000; $i+=500){
            echo "<option value='{$i}' ";
            if( $deposit == $i && $data_res['deposit'] != NULL  ) echo 'selected';
            echo ">".$i;
            "</option>";
        }
        ?>
    </select>

</div>