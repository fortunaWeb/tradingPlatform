<?php

$url = ($_GET['parent_id'] ? "&parent_id=".$_GET['parent_id']: '') ."&topic_id=".(isset($_GET['topic_id']) ? $_GET['topic_id'] : ($_SESSION["group_topic_id"] == 3 ? 1 : $_SESSION["group_topic_id"]));?>
<script type="text/javaScript">
	$(function(){
		$("[role=menu] li").on("click", function(){
			$(".dropdown-menu[data-name=dropdown-second]").hide();
			$(".dropdown-menu."+$(this).data("name")).show();
			if(!$(this).hasClass("active")){
				$("[role=menu] li").removeClass("active");
				$(this).addClass("active");			
			}		
		});
		
		$(document).on("click", function(e){
			if ($(".dropdown-menu:visible").length !=0){			
				var obj = $(".dropdown-menu").parent();
				if(!obj.is(e.target) && obj.has(e.target).length == 0){
					$(".dropdown-menu").parent().removeClass("open");
					$(".dropdown-menu li").removeClass("active");
					$(".dropdown-menu[data-name=dropdown-second]").hide();					
				}  
			}
		});	
		$(".dropdown-menu[data-name=dropdown-second] a").on('click', function(){
			window.location = $(this).attr("href");
		});
		$(".btn-group.count label").on("click", function(){
			window.location = $(this).data("href");
		})		
	})
</script>
<?php
    $cellWidth = !($_SESSION['mobile']) ? "width:14%" : " width:99%";
?>
<div class="btn-group btn-group-justified count" role="group" aria-label="...">
  <div class="btn-group" role="group" data-toggle="buttons">
    <label class="btn btn-default
            <?=(Helper::FilterVal('action') == "mytype" && Helper::FilterVal('active') == 1 && Helper::FilterVal('copyright') != 1) ? "active" : "" ?>"
            style="<?=$cellWidth?>" data-href="<?="?task=profile&action=mytype".$url."&limit=all&active=1"?>">
		<input type="radio" name="active" value="1"
            <?=(Helper::FilterVal('active') == 1 && Helper::FilterVal('copyright') != 1) ? "checked" : ""?> >Для агентств
            <?=(Helper::FilterVal('active') == 1 && Helper::FilterVal('copyright') != 1)
                ? "<span class='badge'>{$data[0]['count']}</span>"
                :""
            ?>
	</label>
    <label class="btn btn-default <?=Helper::FilterVal('action') == "mytype" && Helper::FilterVal('active')== 0 ? "active" : ""?>"
           style="<?=$cellWidth?>" data-href="<?="?task=profile&action=mytype".$url."&active=0"?>">
		<input type="radio" name="active" value="0"
            <?=(Helper::FilterVal('active')==0 && Helper::FilterVal('action')=="mytype") ? "checked" : ""?>>Архив
            <?=(Helper::FilterVal('active')== 0 && Helper::FilterVal('active') == 0 && Helper::FilterVal('action') == "mytype" )
                ? "<span class='badge'>{$data[0]['count']}</span>"
                : ""
            ?>
	</label>
    <label class="btn btn-default
     <?=(Helper::FilterVal('active') == 1 && Helper::FilterVal('copyright') == 1) ? "active" : "" ?>"
           style="<?=$cellWidth?>" data-href="<?="?task=profile&action=mytype&copyright=1&active=1{$url}"?>">
		<input type="radio" name="active" value="1"
            <?=(Helper::FilterVal('active') == 1 && Helper::FilterVal('copyright') == 1) ? "checked" : ""?>>Скопированные
            <?=(Helper::FilterVal('active') == 1 && Helper::FilterVal('copyright') == 1)
                ? "<span class='badge'>{$data[0]['count']}</span>"
                :""
           ?>
	</label>
    <label class="btn btn-default
        <?=(Helper::FilterVal('action') == 'sample') ? "active" : "" ?>" style="<?=$cellWidth?>" data-href="?task=profile&action=sample">
        <input type="radio" name="active" value="1" <?=(Helper::FilterVal('action') == 'sample') ? "checked" : ""?>>Подборки
        <?=( Helper::FilterVal('action') == 'sample') ? "<span class='badge'>".count(Helper::Save_sample())."</span>" :""?>
    </label>

  </div>
</div>