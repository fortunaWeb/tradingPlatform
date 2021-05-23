<script type="text/javascript">
	function UpdateSaveSearch(id, col){
		if(id!="" && col!=""){
			var confirmText = "После обновления даты заявки счетчик новых вариантов обнулится. Обновить дату заявки?";
			if(col=="delete")confirmText="Удалить заявку?"
			if(confirm(confirmText)){
				$.post("?task=var&action=update_save_search", "id="+id+"&col="+col, function(){
					window.location = location;
				})
			}
		}
	}
</script>
<div class="col-xs-12">
	<h4>Список заявок</h4>
	<?
	$searches = Helper::Save_search();
	$search_count = count($searches);
	if($search_count>0){?>
		<span style="color: #D9534F;">ВНИМАНИЕ! Если новых вариантов по вашей заявке более 100, то просмотр данной заявки возможен только на главной странице. Создать можно не более 5 заявок!</span>
	<?}?>
	<?for($i=0; $search_count>$i; $i++){
		$link_to_main = "?task=main&action={$searches[$i]["action"]}&{$searches[$i]["search_str"]}&order=date_added";
		$search = Helper::New_var_by_filter($searches[$i]["search_str"], $searches[$i]["action"], $searches[$i]["date"]);
		
		$func = $search["count"] < 100 ? "OpenRecipient('{$search["ids"]}', {$searches[$i]["id"]}, 'searches')" : "window.open('{$link_to_main}')";
		?>
		<div class='row products-list searches' data-id='<?=$searches[$i]["id"];?>' style='margin-top:5px'>
			<span style='float:left;margin-right:10px'><?=$searches[$i]["search_name"];?></span>
			<span style='float:left'><?=$searches[$i]["client"];?></span>
			<span style="float:right"><?=(date("d.m.Y H:i", strtotime($searches[$i]["date"])));?></span>
			<br />
			<button type="button" class="btn btn-default left" style='margin-left:10px;padding: 0px 12px; margin-bottom: 4px;' onclick="<?=$func?>">
				<span style="float:right; margin-right:10px;color: #D9534F;">Новых вариантов: <?=$search["count"];?>
					<span class="glyphicon glyphicon-chevron-down"></span>
				</span>
			</button>
			<a href="javascript:void(0)" style="float:right;margin-right:10px;color: #D9534F;" onClick="UpdateSaveSearch(<?=$searches[$i]["id"];?>, 'delete')">Удалить заявку</a>
			<a href="javascript:void(0)" style="float:right;margin-right:10px;" onClick="UpdateSaveSearch(<?=$searches[$i]["id"];?>, 'date')">Обновить дату заявки</a>
			<a href="<?=$link_to_main?>" style="float:right;margin-right:10px;" target="_blank">Просмотр всех вариантов по заданным параметрам</a>
		</div>
	<?}?>
</div>