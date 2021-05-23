<?php
if($topic == "Продажа"){
?>
	<div class="col-xs-2 deployed">
		<label class="signature">Форма собственности</label>
		<? $own_type = $data_res['own_type'] ? $data_res['own_type'] : $data_res['own_type']; ?>
		<select class="form-control" name="own_type" id="own_type" >
			<option value="">не важно</option>
			<option value="частная" <?php if($own_type == 'частная') echo "selected"; ?> >
				Частная
			</option>
			<option value="государственная" <?php if($own_type == 'государственная') echo "selected"; ?> >
				Государственная
			</option>
			<option value="кооперативная" <?php if($own_type == 'кооперативная') echo "selected"; ?> >
				Кооперативная
			</option>
			<option value="не оформлено" <?php if($own_type == 'не оформлено') echo "selected"; ?> >
				Не оформлено
			</option>
		</select>
	</div>
<?
}else if($parent != "Дачи" && $parent != "Гаражи"){
?>
	<div class="col-xs-4 deployed">
		<div class="btn-group medium" data-toggle="buttons" data-id="furn_list">
			<label class="furn btn btn-default <?php if($data_res['furn'] == 1) echo "active"; ?>" title="Есть мебель">
				<input type="checkbox" data-name="furn" value="1" <?php if($data_res['furn'] == 1) echo "checked"; ?>>
			</label>
			<label class="refrig btn btn-default <?php if($data_res['refrig'] == 1) echo "active"; ?>" title="Есть холодильник">
				<input type="checkbox" data-name="refrig" value="1" <?php if($data_res['refrig'] == 1) echo "checked"; ?>>
			</label>
			<label class="tv btn btn-default <?php if($data_res['tv'] == 1) echo "active"; ?>" title="Есть телевизор">
				<input type="checkbox" data-name="tv" value="1" <?php if($data_res['tv'] == 1) echo "checked"; ?>>
			</label>
			<label class="washing btn btn-default <?php if($data_res['washing'] == 1) echo "active"; ?>" title="Есть стиральная машина">
				<input type="checkbox" data-name="washing" value="1" <?php if($data_res['washing'] == 1) echo "checked"; ?>>
			</label>	
			<!--<label class="wifi btn btn-default <?php if($data_res['inet'] == 1) echo "active"; ?>" title="Проведен интернет">
				<input type="checkbox" data-name="inet" value="1" <?php if($data_res['inet'] == 1) echo "checked"; ?>>
			</label>
			<label class="conditioner btn btn-default <?php if($data_res['conditioner'] == 1) echo "active"; ?>" title="Есть кондиционер">
				<input type="checkbox" data-name="conditioner" value="1" <?php if($data_res['conditioner'] == 1) echo "checked"; ?>>
			</label>-->
		</div>	
	</div>			
<?
}else if ($parent == "Дачи"){
?>
	<div class="col-xs-12 deployed">
		<div class="btn-group medium" data-toggle="buttons" data-id="furn_list">		
			<label class="btn btn-default <?php if($data_res['elec'] == 1) echo "active"; ?>">
				<input type="checkbox" data-name="elec" value="1" <?php if($data_res['elec'] == 1) echo "checked"; ?>>Свет
			</label>
			<label class="btn btn-default <?php if($data_res['water'] == 1) echo "active"; ?>">
				<input type="checkbox" data-name="water" value="1" <?php if($data_res['water'] == 1) echo "checked"; ?>>Вода поливочная
			</label>
			<label class="btn btn-default <?php if($data_res['wc_type'] == 1) echo "active"; ?>">
				<input type="checkbox" data-name="wc_type" value="1" <?php if($data_res['wc_type'] == 1) echo "checked"; ?>>Туалет
			</label>
			<label class="btn btn-default <?php if($data_res['banya'] == 1) echo "active"; ?>">
				<input type="checkbox" data-name="banya" value="1" <?php if($data_res['banya'] == 1) echo "checked"; ?>>Баня
			</label>	
			<label class="btn btn-default <?php if($data_res['grhouse'] == 1) echo "active"; ?>">
				<input type="checkbox" data-name="grhouse" value="1" <?php if($data_res['grhouse'] == 1) echo "checked"; ?>>Теплица
			</label>	
			<label class="btn btn-default <?php if($data_res['posadki'] == 1) echo "active"; ?>">
				<input type="checkbox" data-name="posadki" value="1" <?php if($data_res['posadki'] == 1) echo "checked"; ?>>Посадки
			</label>
			<label class="btn btn-default <?php if($data_res['hole'] == 1) echo "active"; ?>">
				<input type="checkbox" data-name="hole" value="1" <?php if($data_res['hole'] == 1) echo "checked"; ?>>Скважина
			</label>
		</div>	
	</div>		
<?
}else{
?>
	<div class="col-xs-3 deployed">
		<div class="btn-group medium" data-toggle="buttons" data-id="furn_list">		
			<label class="btn btn-default <?php if($data_res['elec'] == 1) echo "active"; ?>">
				<input type="checkbox" data-name="elec" value="1" <?php if($data_res['elec'] == 1) echo "checked"; ?>>Свет
			</label>
			<label class="btn btn-default <?php if($data_res['water'] == 1) echo "active"; ?>">
				<input type="checkbox" data-name="water" value="1" <?php if($data_res['water'] == 1) echo "checked"; ?>>Вода
			</label>
			<label class="btn btn-default <?php if($data_res['hole'] == 1) echo "active"; ?>">
				<input type="checkbox" data-name="hole" value="1" <?php if($data_res['hole'] == 1) echo "checked"; ?>>Яма
			</label>
		</div>	
	</div>	
<?
}if(($parent == "Дома" || $parent == "Квартиры" || $parent == "Комната") && $topic == "Аренда"){
?>
<div class="col-xs-2 deployed">
    <div class="btn-group medium" data-toggle="buttons">
        <label class="btn btn-default <?=$data_res['new_house'] == 1?"active":''?>">
            <input type="checkbox" name="new_house" value="1" <?if($data_res['new_house'] == 1)echo "checked";?>>Новый дом
        </label>
    </div>
</div>
<div class="col-xs-2 deployed">
    <div class="btn-group medium" data-toggle="buttons">
        <label class="btn btn-default <?=$data_res['keys'] == 1?"active":'' ?>">
            <input type="checkbox" name="keys" value="1"  <?if($data_res['keys'] == 1)echo "checked";?>>Ключи
        </label>
    </div>
</div>
<?
}
?>