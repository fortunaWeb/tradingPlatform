<div class="col-xs-5 deployed">
	<div class="btn-group medium" data-toggle="buttons">
	  <label class="btn btn-default <?php if($data_res['torg'] == 1 || $_POST['torg'] == 1) echo "active"; ?>">
		<input type="checkbox" name="torg" value="1" <?php if($data_res['torg'] == 1 || $_POST['torg'] == 1) echo "checked"; ?>>Торг
	  </label>
        <label class="btn btn-default <?php if($data_res['full_price'] == 1 || $_POST['full_price'] == 1) echo "active"; ?>">
            <input type="checkbox" name="full_price" value="1"
                <?php if($data_res['full_price'] == 1 || $_POST['full_price'] == 1) echo "checked"; ?>>Вся стоимость в договоре
        </label>
	</div>
</div> 