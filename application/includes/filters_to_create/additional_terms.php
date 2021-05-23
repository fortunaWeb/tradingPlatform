<div class="col-xs-12 deployed">
	<div class="btn-group medium" data-toggle="buttons">
	  <label class="btn btn-default <?php if($data_res['torg'] == 1 || $_POST['torg'] == 1) echo "active"; ?>">
		<input type="checkbox" name="torg" value="1" <?php if($data_res['torg'] == 1 || $_POST['torg'] == 1) echo "checked"; ?>>Торг
	  </label>
	  <label class="btn btn-default <?php if($data_res['chist_prod'] == 1 || $_POST['chist_prod'] == 1) echo "active"; ?>">
		<input type="checkbox" name="chist_prod" value="1" <?php if($data_res['chist_prod'] == 1 || $_POST['chist_prod'] == 1) echo "checked"; ?>>Чистая продажа
	  </label>
	  <label class="btn btn-default <?php if($data_res['obmen'] == 1 || $_POST['obmen'] == 1) echo "active"; ?>">
		<input type="checkbox" name="obmen" value="1" <?php if($data_res['obmen'] == 1 || $_POST['obmen'] == 1) echo "checked"; ?>>Обмен
	  </label>
	  <label class="btn btn-default <?php if($data_res['ipoteka'] == 1 || $_POST['ipoteka'] == 1) echo "active"; ?>">
		<input type="checkbox" name="ipoteka" value="1" <?php if($data_res['ipoteka'] == 1 || $_POST['ipoteka'] == 1) echo "checked"; ?>>Ипотека
	  </label>	 
	</div>
</div> 