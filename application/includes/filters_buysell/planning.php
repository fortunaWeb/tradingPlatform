<div class="col-xs-1 deployed">
	<label class="signature">Планировка</label>
	<?php $planning = Helper::FilterVal('planning') ? Helper::FilterVal('planning') : "";?>
	<select class="form-control"  name="planning" >
		<option value="">выберите планировку</option>
		<?if($_SESSION['search_user_id'] == "site"){  ?>

			<option value="студия" <?=$planning == "студия" ?"selected":''?>>
                студия
			</option>
			<option value="свободная" <?=$planning == "свободная"?"selected":''?>>
                свободная
			</option>
			<option value="изолированная" <?=$planning == "изолированная" ?"selected":''?>>
                Изолированная
			</option>
			<option value="смежная" <?=$planning == "смежная" ?"selected":''?>>
                Смежная
			</option>
			<option value="евродвушка" <?=$planning == "евродвушка"?"selected":'' ?>>
                Евродвушка
			</option>
			<?php }
			?>
	</select>
</div>