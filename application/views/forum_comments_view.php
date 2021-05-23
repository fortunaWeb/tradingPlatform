<?unset($count);
$count=count($data);
for($i=0;$i<$count;$i++){?>
	<div class="col-xs-12 forum-comment" id="<?=$data[$i]["id"];?>">
		<?if($_SESSION["admin"]==1){?>
			<button type="button" class="close" data-name="text" data-id="<?=$data[$i]["id"];?>" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
		<?}?>
		
		<p align = left style = 'font-size: 9px;'>
			<?php /*<img alt="В чёрный список" title="Добавить в чёрный список и скрыть сообщения" src = "images/icon-abuse-active.png" OnClick= "ShowMessages(<?=$data[$i]["people_id"]?>)" style = " margin-left: 10px; cursor: pointer;margin-top: -2px;">/**/?>
			<b style="color:#1A831E;" >АН:</b> <?=$data[$i]["company_name"];?><span class="right"><b style="color:#1A831E;"></b> <?=$data[$i]["date_f"];?></span>
			<br/>
			<a href="tel:<?=$data[$i]["phone"]?>"><?=$data[$i]["phone"]?></a> <?=$data[$i]["name"]?> 
		</p>
		<p>
			<?=$data[$i]["text"];?>	
		</p>
		<?if($data[$i]["comment_count"]>0){?>
			<span class="right gray-mini-link"  style='color: #D44444' data_name="comment-show-button" onclick="ShowForumComments(<?=$data[$i]["id"];?>)">Показать кометарии: <?=$data[$i]["comment_count"];?><span class="caret"></span></span>
		<?}
		/*?>
		<span class="left gray-mini-link" style='color: #337ab7;' onclick="$(this).next().toggleClass('hidden')">Коментировать<span class="caret"></span></span>
		<form method="POST" id="form-comment<?=$data[$i]["id"];?>" class="hidden" style="margin-top: 40px;" action="/?task=profile&action=forum&topic=<?=$data[$i]['topic_id']?>&new=comment">
			<div class="col-xs-9 deployed">
				<textarea name="text" form="form-comment<?=$data[$i]["id"];?>" class="form-control" placeholder="текст коментария" rows="3" cols="80" required="required"></textarea>
			</div>
			<div class="col-xs-2 deployed">	
				<input type="submit" form="form-comment<?=$data[$i]["id"];?>" class="form-control btn btn-success" value="Добавить">
			</div>
			<input type="hidden" form="form-comment<?=$data[$i]["id"];?>" name="id" value="<?=$data[$i]["id"];?>">
		</form>
		<? /**/?>
	</div>
<?}?>
