<?php if($topic == "Продажа"){ ?>
		<div class="col-xs-2 deployed">
			<label class="signature">Форма собственности</label>>
            <? $own_type = $data_res['own_type'] ? $data_res['own_type'] : Helper::FilterVal('own_type'); ?>
			<select class="form-control" name="own_type" id="own_type" >
                <option value="">не важно</option>
                <option value="частная" <?=$own_type=='частная'?"selected":""?> >
                    Частная
                </option>
                <option value="государственная" <?=$own_type=='государственная'?"selected":""?> >
                    Государственная
                </option>
                <option value="кооперативная" <?=$own_type=='кооперативная'?"selected":""?> >
                    Кооперативная
                </option>
                <option value="не оформлено" <?=$own_type=='не оформлено'?"selected":""?> >
                    Не оформлено
                </option>
			</select>
		</div>
	<?}else if($parent != "Дачи"){ ?>
		<div class="col-xs-1 deployed">
			<label class="signature">Мебель</label>	
			<select name="furn" class="form-control">
				<option value="">мебель</option>
                <option value="1" <?=Helper::FilterVal('furn') == 1 ? "selected":''?>>есть</option>
                <option value="0" <?=Helper::FilterVal('furn') == 0 ? "selected":''?>>нет</option>
			</select>
		</div>
		<div class="col-xs-1 deployed">
			<label class="signature">Хол.</label>	
			<select name="refrig" class="form-control">
				<option value="">хол</option>
                <option value="1" <?=Helper::FilterVal('refrig') == 1 ? "selected":''?>>есть</option>
                <option value="0" <?=Helper::FilterVal('refrig') == 0 ? "selected":''?>>нет</option>
			</select>
		</div>
		<?if($data[0]['user_id'] != 'ngs' && $_GET['action']!="favorites_parse"){?>
			<div class="col-xs-1 deployed">
				<label class="signature">ТВ</label>	
				<select name="tv" class="form-control">
					<option value="">тв</option>
                    <option value="1" <?=Helper::FilterVal('tv') == 1 ? "selected":''?>>есть</option>
                    <option value="0" <?=Helper::FilterVal('tv') == 0 ? "selected":''?>>нет</option>
				</select>
			</div>
			<div class="col-xs-1 deployed">
				<label class="signature">Стир.</label>	
				<select name="washing" class="form-control">
					<option value="">стир</option>
                    <option value="1" <?=Helper::FilterVal('washing') == 1 ? "selected":''?>>есть</option>
                    <option value="0" <?=Helper::FilterVal('washing') == 0 ? "selected":''?>>нет</option>
				</select>
			</div>
		<?}?>
<?}else{?>
	<div class="col-xs-4 deployed">
		<div class="btn-group medium" data-toggle="buttons">
            <label class="btn btn-default <?=Helper::FilterVal('elec') == 1 ? "active" : ''?>">
                <input type="checkbox" name="elec" value="1" <?=Helper::FilterVal('elec') == 1 ? "checked" : ""?>>Свет
			</label>
            <label class="btn btn-default <?=Helper::FilterVal('water') == 1 ? "active" : ""?>">
                <input type="checkbox" name="water" value="1" <?=Helper::FilterVal('water') == 1 ? "checked" : ""?>>Вода
			</label>
            <label class="btn btn-default <?=Helper::FilterVal('wc_type') ? "active" : ""?>">
                <input type="checkbox" name="wc_type" value="1" <?=Helper::FilterVal('wc_type') ? "checked" : ""?>>Туалет
			</label>
            <label class="btn btn-default <?=Helper::FilterVal('banya') == 1 ? "active" : "" ?>">
                <input type="checkbox" name="banya" value="1" <?=Helper::FilterVal('banya') ? "checked" : ""?>>Баня
			</label>
            <label class="btn btn-default <?=Helper::FilterVal('grhouse')==1 ? "active" : ""?>">
                <input type="checkbox" name="grhouse" value="1" <?=Helper::FilterVal('grhouse')==1 ? "checked" : ""?>>Теплица
			</label>			
		</div>	
	</div>		
<?}?>