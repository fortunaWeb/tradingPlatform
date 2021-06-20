
<div class="col-xs-2 deployed"  style = 'width: 150px'>
    <label class="signature"> Тип:</label>
    <select class="form-control" name="app_type" id="app_type" required>
<?php   if($parent != 'ЖП'){    ?>
        <option value='flat' <?=$data_res['app_type']=='flat'?"selected":''?> >Квартира</option>
        <option value='appartment' <?=$data_res['app_type']=='appartment'?"selected":''?>>Аппартаменты</option>
<?php   }else{  ?>
        <option value='ls' <?=$data_res['app_type']=='appartment'?"selected":''?>>ЖП</option>
<?php   }   ?>
    </select>
</div>
