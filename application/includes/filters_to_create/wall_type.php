<div class="col-xs-2 deployed">			
	<label class="signature">Материал стен</label>		
	<? $wall_type = $data_res['wall_type']; ?>
	<select class="form-control" name="wall_type" id="wall_type">
		<option value="">выберите</option>
		<option value="кирпич" <?php if($wall_type == 'кирпич') echo "selected"; ?>>
			Кирпич
		</option>
		<option value="панель" <?php if($wall_type == 'панель') echo "selected"; ?>>
			Панель
		</option>
		<option value="дерево" <?php if($wall_type == 'дерево') echo "selected"; ?>>
			Дерево
		</option>
		<option value="монолит" <?php if($wall_type == 'монолит') echo "selected"; ?>>
			Монолит
		</option>
		<?if($parent=="Дома"){?>
			<option value="сибит" <?php if($wall_type == 'сибит') echo "selected"; ?>>
				Сибит
			</option>
			<option value="шлакоблок" <?php if($wall_type == 'шлакоблок') echo "selected"; ?>>
				Шлакоблок
			</option>
			<option value="каркасно-засыпной" <?php if($wall_type == 'каркасно-засыпной') echo "selected"; ?>>
				Каркасно-засыпной
			</option>
		<?}?>
	</select>	
</div>	