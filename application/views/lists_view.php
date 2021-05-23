<?
	$type = $_GET["type"]=='white' ? "белый" : "черный";
?>
<script type="text/javascript">
	var phone="",
		an="";
	$(function(){
		$(".btn-group label").on("click", function(){
			window.location = "/?task=profile&action=lists&type="+$(this).data("type");
		});
		
		$("[name=phone]").on("keyup", function(){
			if($(this).val().match(/\d\W\(\d{3}\)\W\d{3}-\d{4}/) != null){
				if(phone!=$(this).val()){
					phone = $(this).val();
					POST("phone="+phone);
				}
			}
		});
		
		$(document).on("click", "#str_list li", function(){
			if(an!=$("[name=company_id]").val()){
				an = $("[name=company_id]").val();				
			}
			POST("an_id="+an);
		})
	});
	
	function POST(searchString){
		$.post("?task=profile&action=lists", searchString+"&type=search", function(html){
			$("tbody").empty().prepend($(html).find("tbody tr"));
		})
	}
	
	function ShowMessages(id,show,show_mess){
		$.post("?task=profile&action=lists", "id="+id+"&mess_view="+show_mess+"&show="+show+"&list_type="+QueryString('type'), function(){window.location.reload(); });
	}

	function AddList(id){
		$.post("?task=profile&action=lists", "id="+id+"&type=add&list_type="+QueryString('type'), function(){
			$("tr[data-id="+id+"] td").last().text('удалить').attr("onClick", "DeleteList("+id+")");
		})
	}
	
	function DeleteList(id){
		$.post("?task=profile&action=lists", "id="+id+"&type=delete&list_type="+QueryString('type'), function(){
			$("tr[data-id="+id+"] td").slideUp();
		});
	}
</script>
	<div class="col-xs-9">
		<legend>Черный и белый список риэлтеров</legend>
		<div class="btn-group" data-toggle="buttons" style="width:100%;">
			<label class="btn btn-default <?if($_GET["type"]=="white") echo 'active';?>" style="width:50%;" data-type="white">
				<input type="radio" autocomplete="off" checked="checked"> Белые риелторы
			</label>
			<label class="btn btn-default <?if($_GET["type"]=="black") echo 'active';?>" style="width:50%;" data-type="black">
				<input type="radio" autocomplete="off"> Черные риелторы
			</label>
		</div>
		<div class="row" style="margin-top: 15px;">
			<div class="col-xs-2 deployed">
				<label class="signature">Телефон</label>
				<input type="text" class="form-control" placeholder="телефон" name="phone" data-id="phone">
			</div>
			<div class="col-xs-4 deployed">
				<label class="signature">АН риелтора</label>
				<input type="text" class="form-control" data-name="an-list" placeholder="все АН">
				<div class="an_list" style="display: none;height: 300px;overflow: auto;"></div>
				<input type="hidden" name="company_id">		
			</div>
			<input type="hidden" name="type" value="<?=$_GET['type']?>">
		</div>
		<div class="row">
			<div class="col-xs-12">
				<table id="application" class="table table-striped">
					<thead>
						<tr>
							<th>#</th>
							<th>Имя</th>
							<th>Отчество</th>
							<th>Телефон</th>
							<th>АН</th>
							<?if($_GET['type']=="black"){?>
								<th>Комментарий</th>
							<?}?>
							<?if($_GET['type']=="black" ){?>
								<th>показать варианты</th>
							<?}?>
							<?if($_GET['type']=="black" ){?>
								<th>показывать сообщения в форуме</th>
							<?}?>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?$count = count($data);
						for($i=0; $i<$count; $i++){?>
							<tr data-id="<?=$data[$i]["id"];?>">
								<td><?=($i+1);?></td>
								<td><?=$data[$i]["name"];?></td>
								<td><?=$data[$i]["second_name"];?></td>
								<td><?=$data[$i]["phone"];?></td>
								<td><?=$data[$i]["an"];?></td>
								<?if($_GET['type']=="black"){?>
									<td><?=$data[$i]["text"];?></td>
								<?}?>

								<?if($_GET['type']=="black" && empty($_POST['type']) ){?>
									<td align = 'center'><input type='checkbox' <?if($data[$i]["show_var"] == 1) echo' checked ';?> 
										onClick="ShowMessages('<?=$data[$i]["id"];?>','<?=$data[$i]["show_var"];?>','show_var')"></td>
								<?}?>

								<?if($_GET['type']=="black" && empty($_POST['type']) ){?>
									<td align = 'center'><input type='checkbox' <?if($data[$i]["show_forum"] == 1) echo' checked ';?> 
										onClick="ShowMessages('<?=$data[$i]["id"];?>','<?=$data[$i]["show_forum"];?>','show_forum')"></td>
								<?}?>


								<?if($_POST['type']=="search"){?>
									<td><span class="add" onClick="AddList('<?=$data[$i]["id"];?>')">добавить в список</span></td>
								<?}else{?>
									<td><span class="delete" onClick="DeleteList('<?=$data[$i]["id"];?>')">реабилитировать</span></td>
								<?}?>


							</tr>
						<?}?>
					</tbody>
				</table>
			</div>
		</div>
	</div>