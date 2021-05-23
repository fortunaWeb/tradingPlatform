<div class="col-xs-2 deployed">
	<? $wall_type = $data_res['wall_type'] ? $data_res['wall_type'] : Helper::FilterVal('wall_type'); ?>
	<select class="form-control" name="wall_type" id="wall_type">
		<option value="">материал стен</option>
		<option value="кирпич" <?php if($wall_type == 'кирпич') echo "selected"; ?>>
			Кирпич
		</option>
		<option value="панель" <?php if($wall_type == 'панель') echo "selected"; ?>>
			Панель
		</option>
		<option value="дерево"<?php if($wall_type == 'дерево') echo "selected"; ?>>
			Дерево
		</option>
		<option value="монолит"<?php if($wall_type == 'монолит') echo "selected"; ?>>
			Монолит
		</option>
	</select>	
</div>