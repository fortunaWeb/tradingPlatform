<script type="text/javascript">
	function ShowForumComments(id){
		var comments = $("#"+id+" .forum-comment");
		if($(comments).length == 0){
			$.post("?task=profile&action=forum_comments", "id="+id, function(html){
				$("#"+id).append($(html).find(".forum-comment"));
			})
		}else if($(comments).is(":visible")){
			$(comments).slideUp();
		}else{
			$(comments).slideDown();
		}
	}
	$(function(){
		$(document).on("click", ".close", function(e){
			e.preventDefault();
			var message = "Подтвердите удаление!";
				id = $(this).data("id"),
				name = $(this).data("name");
				people_id = $(this).data("people_id");
			alertify.confirm(message, function(result){
				if(result){
					$.post("?task=profile&action=delete_from_forum", "name="+name+"&id="+id+"&people_id="+people_id  , function(){
						$("#"+id).remove();
						alertify.success("Удаление прошло успешно.");
					});
				}
			});
		});
	})
	function ShowMessages(id){		
		alertify.confirm("Скрыть все сообщения в форуме от этого риэлтора?", function(result){
			if(result){
				$.post("?task=profile&action=lists", "id="+id+"&type=add&list_type=black&mess_view=show_forum&show=1", function(){
					window.location.reload();
				}); 
			}
		});
	}

</script>
<div class='col-xs-9' style = 'width: 99%; margin:0 auto;'>
	<?
if($_GET['action'] != 'forum_rent'){ ?>
	<legend>
		<span style="text-decoration: underline;">Форум</span>
		<?
			 if(isset($_GET['topic'])){

			?>
			<a href="?task=profile&action=forum" style="font-size: 14px;"> перейти к списку тем</a>
		<?}else{?>
			<a href="?task=profile&action=caution&type=1" style="padding: 0 100px;">Список предупреждений</a>
			<a href="?task=profile&action=callboard&callboard_topic=sell">Доска объявлений</a>
		<?}?>
	</legend>
	<?
}
	if(isset($data[0]["title"])){
		?>
		<center>
		<form method="POST" id="form-text" action="<?=$_SERVER["REQUEST_URI"];?>&new=text">
			<div class="col-xs-9 deployed" style = 'width:100%;float: initial;'>
				<textarea name="text" form="form-text" class="form-control" placeholder="Здесь нужно писать что нужно вашему клиенту" 
						rows="5" cols="80" required="required" 
						style = 'width:<?=$_SESSION["mobile"]?'99':'50'?>%' 
						></textarea>
			</div>
			<div class="col-xs-9 deployed" style = 'float: initial;'>	
					<input type="submit" form="form-text" class="form-control btn btn-success" value="Добавить"  style = 'width:<?=$_SESSION["mobile"]?'30':'20'?>%' >
			</div>	
		</form>
		<div class="col-xs-9" style = 'float:inherit;width:<?=$_SESSION["mobile"]?'99':'60'?>%'>

			<?
			$count = count($data);
			for($i=0; $i<$count; $i++){

/*
				$now = new DateTime();
				$dateCreate = new DateTime($data[$i]['date_f']);
				$interval = $now->diff($dateCreate);
				if($interval->format('%H') > 21){
					continue;
				}
*/
				if($data[$i]["text"]!=""){?>
					<div class="forum-topic" id="<?=$data[$i]["id"];?>">
						<?if($_SESSION["admin"]==1 || $data[$i]['people_id'] ==  $_SESSION['people_id'] ){?>
							<button type="button" class="close" data-name="text" data-id="<?=$data[$i]["id"];?>" data-people_id = "<?=$data[$i]['people_id']?>" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">×</span>
								</button>
						<?}?>
						<p align = left style = 'font-size: 9px;'>
							<?php /*<img alt="В чёрный список" title="Добавить в чёрный список и скрыть сообщения" src = "images/icon-abuse-active.png" OnClick= "ShowMessages(<?=$data[$i]["people_id"]?>)" style = " margin-left: 10px; cursor: pointer;margin-top: -2px;">/**/?>
							<b style="color:#1A831E;" >АН:</b> <?=$data[$i]["company_name"];?><span class="right"><b style="color:#1A831E;"></b> 
									<?=$data[$i]["date_f"];?></span>
							<br/>
							<a href="tel:<?=$data[$i]["phone"]?>"><?=$data[$i]["phone"]?></a> <?=$data[$i]["name"]?> 
						</p>
						<p>
							<?=$data[$i]["text"];?>	
						</p>
						<?if($data[$i]["comment_count"]>0){?>
							<span class="right gray-mini-link"  style='color: #D44444' data_name="comment-show-button" onclick="ShowForumComments(<?=$data[$i]["id"];?>)">Есть предложение: <?=$data[$i]["comment_count"];?><span class="caret"></span></span>
						<?}?>
						<span class="left gray-mini-link" style='color: #337ab7;' onclick="$(this).next().toggleClass('hidden')">Предложить<span class="caret"></span></span>
						<form method="POST" id="form-comment<?=$data[$i]["id"];?>" class="hidden" style="margin-top: 40px;" action="<?=$_SERVER["REQUEST_URI"];?>&new=comment">
							<div class="col-xs-9 deployed">
								<textarea name="text" form="form-comment<?=$data[$i]["id"];?>" class="form-control" placeholder="текст коментария" rows="3" cols="80" required="required"></textarea>
							</div>
							<div class="col-xs-2 deployed">	
								<input type="submit" form="form-comment<?=$data[$i]["id"];?>" class="form-control btn btn-success" value="Добавить">
							</div>
							<input type="hidden" form="form-comment<?=$data[$i]["id"];?>" name="id" value="<?=$data[$i]["id"];?>">
						</form>
					</div>
				<?}
			}?>
		</div>

		</center>

	<?}?>
</div>