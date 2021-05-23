<?if ($_SESSION['admin']==1){?>
	<script type="text/javascript">
		$(function(){
			$(".glyphicon-pencil").on("click", function(){
				$('html,body').stop().animate({	scrollTop: $('html').offset().top}, 500);
				var tr = $("tr[data-name=task]").has($(this));
				$("form [name=id]").val($(tr).attr("id"));
				$("form [name=text]").val($(tr).find("[data-name=text]").text());
				$("form [name=priority]").val($(tr).find("[data-name=priority]").text());
			})
		})
		function UpdateTasks(id, col, val){
			$.post("/?task=tasks&action=update", "id="+id+"&col="+col+"&val="+val, function(){
				window.location.reload();
			})
		}
	</script>
	<legend>Задачник</legend>
	<div class="col-xs-12 info">
		<form method="POST" action="/?task=tasks&action=add" id="new-task">
			<input type="hidden" name="id" value="" />
			<div class="col-xs-6 deployed">
				<label class="signature">Описание задачи</label>
				<textarea name="text" form="new-task" class="form-control" placeholder="текст задачи" rows="5" cols="80" required="required"></textarea>
			</div>
			<div class="col-xs-2 deployed">
				<label class="signature">Приоритет</label>
				<select name="priority" class="form-control" form="new-task">
					<option value="">приоритет</option>
					<option value="1">1 - самый низкий</option>
					<option value="2">2</option>
					<option value="3">3 - средний</option>
					<option value="4">4</option>
					<option value="5">5 - максимальный</option>
				</select>
			</div>
			<div class="col-xs-2 deployed">	
				<input type="submit" form="new-task" class="form-control btn btn-success" value="Добавить">
			</div>
		</form>
	</div>
	<table id="tasks" class="table table-striped">
		<thead>
			<tr>
				<th>#</th>
				<th>Дата</th>
				<th>Задача</th>
				<th>Приоритет</th>
				<th>Дата начала</th>
				<th>Дата завершения</th>
				<th></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?$count = count($data);
			for($i=0; $count>$i; $i++){?>
					<tr data-name='task' id="<?echo $data[$i]["id"];?>">
						<td><?echo $i+1;?><br /><span class="glyphicon glyphicon-pencil" style="cursor:pointer" aria-hidden="true"></span></td>
						<td><?echo date("H:i d.m.Y", strtotime($data[$i]['date_add']));?></td>
						<td data-name="text"><?=$data[$i]['text'];?></td>
						<td data-name="priority"><?=$data[$i]['priority'];?></td>
						<td><?if(isset($data[$i]['date_start']))echo date("H:i d.m.Y", strtotime($data[$i]['date_start']));?></td>
						<td><?if(isset($data[$i]['date_end']))echo date("H:i d.m.Y", strtotime($data[$i]['date_end']));?></td>
						<td>
							<span class="dropdown" style="display: block;margin-top: 0px;">
								<a href="javascript:void(0)" id="tasks-menu" data-toggle="dropdown" style="">Меню<span class="caret"></span></a>
								<ul class="dropdown-menu" aria-labelledby="tasks-menu">
									<li><a href="javascript:void(0)" onClick="UpdateTasks(<?=$data[$i]["id"]?>, 'in_work', 1)">В работе</a></li>
									<li><a href="javascript:void(0)" onClick="UpdateTasks(<?=$data[$i]["id"]?>, 'active', 0)">Сделано</a></li>	
									<li><a href="javascript:void(0)" onClick="UpdateTasks(<?=$data[$i]["id"]?>, 'archive', 1)">В архив</a></li>
									<li><a href="javascript:void(0)" onClick="Delete('tasks', <?=$data[$i]["id"]?>)">Удалить</a></li>
								</ul>
							</span>
						</td>
						<td><?if($data[$i]['active']==1 && $data[$i]['in_work']==0)
							{echo "<span style='color: #B85C5C;'>Новое!</span>";}
							else if($data[$i]['in_work']==1 && $data[$i]['active']==1){
								echo "<span style='color: #CCBE00;'>В работе...</span>";
							}else if($data[$i]['active']==0){
								echo "<span style='color: #5CB85C;'>Сделано</span>";
							}
							?>
						</td>
					</tr>
			<?}unset($i, $count, $active);?>
		</tbody>	
	</table>
<?}?>