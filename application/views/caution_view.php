<?
	if($_GET["type"]==1){
		$type = "риелтора";
	}else if($_GET["type"]==2){
		$type = "хозяина";
	}else if($_GET["type"]==3){
		$type = "клиента";
	}
	$disabled = $_GET["type"]==1 ? "readonly" : "";
?>
<script type="text/javascript">
	var phone="";
	$(function(){
		$(".btn-group label").on("click", function(){
			window.location = "/?task=profile&action=caution&type="+$(this).data("type");
		});
		$("[type=submit]").on("click", function(){
			if($(this).data("metod")=="get"){
				//$("form input, form textarea").each(function(){
					$("input").removeAttr("required");
					$("textarea").removeAttr("required");
				//})
			}
		});
		if(QueryString("type")==1){
			$("[name=phone]").on("keyup", function(){
				if($(this).val().match(/\d\W\(\d{3}\)\W\d{3}-\d{4}/) != null){
					if(phone!=$(this).val()){
						phone = $(this).val();
						$.post("?task=profile&action=find_on_phone", "phone="+phone+"&type=for_caution", function(html){
							if(html.length > 5){
								var people = html.split(";");
								$("[name=name]").val(people[0]);
								$("[name=second_name]").val(people[1]);
								$("[name=an]").val(people[2]);
								$("[name=comment]").removeAttr("readonly");
							}else{
								RemoveForm();
							}
						})
					}
				}else{
					RemoveForm();
				}
			});
		}
		var an = decodeURIComponent(window.location.search).match(/an=(.+)/);
		if(an!=null){
			var anName = an[1],
				count = $("tr").length;
			for(var i=0; i<count; i++){
				if($($($("tr")[i]).find("td")[4]).text()==anName){
					$($("tr")[0]).after($("tr")[i]);
					$($("tr")[1]).addClass("hasReview");
					$($("tr")[1]).after($("tr")[i+1]);
					$($("tr")[2]).addClass("hasReview");
				}
			}
			$('html,body').stop().animate({	scrollTop: $($("tr")[1]).offset().top-100}, 1000);
		}
	});
	
	function DeleteCaution(id){
		var message = "Вы уверены, что хотите удалить предупреждение на недобросовестного <?=$type;?>?";
		alertify.confirm(message, function(result){
			if(result){
				$.post("?task=profile&action=delete_caution", "id="+id, function(){
					$("tr[data-id="+id+"]").slideUp();
				});
			}
		})
	}
	
	function RemoveForm(){
		$("[name=name]").val("");
		$("[name=second_name]").val("");
		$("[name=an]").val("");
		$("[name=comment]").attr("readonly", "readonly");
	}
</script>
<div class="col-xs-9">
	<legend>
		<a href="?task=profile&action=forum">Форум</a>
		<span style="text-decoration: underline;padding: 0 100px;">Список предупреждений</span>
		<a href="?task=profile&action=callboard&callboard_topic=sell">Доска объявлений</a>
	</legend>
	<div class="btn-group" data-toggle="buttons" style="width:100%;">
		<label class="btn btn-default <?if($_GET["type"]==1) echo 'active';?>" style="width:33%;" data-type="1">
			<input type="radio" autocomplete="off" checked="checked"> Риелторы
		</label>
		<label class="btn btn-default <?if($_GET["type"]==2) echo 'active';?>" style="width:33%;" data-type="2">
			<input type="radio" autocomplete="off"> Хозяева
		</label>
		<label class="btn btn-default <?if($_GET["type"]==3) echo 'active';?>" style="width:33%;" data-type="3">
			<input type="radio" autocomplete="off"> Клиенты
		</label>
	</div>
	<div class="row">
		<form method="POST" id="caution" action="#" style="margin-top: 15px;">
			<div class="col-xs-2 deployed">
				<label class="signature">Телефон <?=$type;?></label>
				<input type="text" class="form-control" placeholder="телефон" name="phone" data-id="phone" value="<?if(isset($_POST["search"])) echo $_POST["phone"];?>" required>
			</div>
			<div class="col-xs-2 deployed">
				<label class="signature">Имя <?=$type;?></label>
				<input type="text" class="form-control" placeholder="имя" name="name" value="<?if(isset($_POST["search"])) echo $_POST["name"];?>" <?=$disabled?>>
			</div>
			<div class="col-xs-2 deployed">
				<label class="signature">Отчество <?=$type;?></label>
				<input type="text" class="form-control" placeholder="отчество" name="second_name" value="<?if(isset($_POST["search"])) echo $_POST["second_name"];?>" <?=$disabled?>>
			</div>
			<?if($_GET["type"]==1){?>
				<div class="col-xs-4 deployed">
					<label class="signature">АН риэлтора</label>
					<input type="text" class="form-control" placeholder="ан" name="an" value="<?if(isset($_POST["search"])) echo $_POST["an"];?>" required <?=$disabled?>>
				</div>
			<?}else if($_GET["type"]==2){?>
				<div class="col-xs-3 deployed">
					<label class="signature">Улица</label>
					<input type="text" id="str" name="street" class="form-control" placeholder="улица" autocomplete="off" required
					value="<?if(isset($_POST["search"])) echo $_POST["street"];?>" <?=$disabled?>>
					<div class="street_list" style="display: none;"></div>
				</div>
				<div class="col-xs-2 deployed">
					<label class="signature">Номер дома</label>
					<input type="text" class="form-control" placeholder="номер дома" name="house" value="<?if(isset($_POST["search"])) echo $_POST["house"];?>" required <?=$disabled?>>
				</div>
			<?}?>
			<div class="col-xs-12 deployed">	
				<textarea name="comment" class="form-control" placeholder="коментарий" rows="5" cols="80" required="required" <?=$disabled?>><?if(isset($_POST["search"])) echo $_POST["comment"];?></textarea>
			</div>
			<input type="hidden" name="type" value="<?=$_GET['type']?>">
		</form>
		<div class="col-xs-2 deployed right">	
			<input type="submit" form="caution" data-metod="get" class="form-control btn btn-success" name="search" value="Поиск">
		</div>
		<div class="col-xs-4 deployed right">	
			<input type="submit" form="caution" data-metod="post" class="form-control btn btn-success" value="Добавить предупреждение">
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<table id="application" class="table table-striped caution-table">
				<thead>
					<tr>
						<th>#</th>
						<th>Имя</th>
						<th>Отчество</th>
						<th>Телефон</th>
						<?if($_GET["type"]==1){?>
							<th>АН</th>
						<?}else if($_GET["type"]==2){?>
							<th>Улица</th>
							<th>Номер дома</th>
						<?}?>
						<th>Дата</th>
						<?if($_SESSION['admin']==1){?>
							<th></th>
						<?}?>
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
							<?if($_GET["type"]==1){?>
								<td><?=$data[$i]["an"];?></td>
							<?}else if($_GET["type"]==2){?>
								<td><?=$data[$i]["street"];?></td>
								<td><?=$data[$i]["house"];?></td>
							<?}?>
							<td><?=$data[$i]["date_time"];?></td>
							<?if($_SESSION['admin']==1){?>
								<td><span class="delete" onClick="DeleteCaution('<?=$data[$i]["id"];?>')">удалить</span></td>
							<?}?>
						</tr>
						<tr data-id="<?=$data[$i]["id"];?>">
							<td>Коментарий:</td>
							<td colspan="10"><?=$data[$i]["comment"];?>
								<span style="float: right;color: #d9534f;">Автор: <?=Get_functions::Get_io_by_people_id($data[$i]['owner_people_id'])?> АН: <?=Get_functions::Get_company_name_by_people_id($data[$i]['owner_people_id'])?></span>
							</td>
						</tr>
					<?}?>
				</tbody>
			</table>
		</div>
	</div>
</div>