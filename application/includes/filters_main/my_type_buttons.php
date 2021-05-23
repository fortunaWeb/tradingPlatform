<?$url = "&parent_id=".($_GET['parent_id'] ? $_GET['parent_id'] : 1)."&topic_id=".(isset($_GET['topic_id']) ? $_GET['topic_id'] : ($_SESSION["group_topic_id"] == 3 ? 1 : $_SESSION["group_topic_id"]));?>
<script type="text/javaScript">
	$(function(){
		//показ подменю создания вариантов
		$("[role=menu] li").on("click", function(){
			$(".dropdown-menu[data-name=dropdown-second]").hide();
			$(".dropdown-menu."+$(this).data("name")).show();
			if(!$(this).hasClass("active")){
				$("[role=menu] li").removeClass("active");
				$(this).addClass("active");			
			}		
		});
		
		//скрытие меню добавления варианта
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
	$mobile =  $_SESSION['mobile'];
	if(!$mobile){
		$cellWidth = "width:14%";	
	}else{
		$cellWidth = " width:99%";	
	}
	
?>
<div class="btn-group btn-group-justified count" role="group" aria-label="...">
  <div class="btn-group" role="group" data-toggle="buttons">
    <label class="btn btn-default <?php if(!isset($_GET['active']) && $_GET['action'] == "mytype" || $_GET['active'] == 1) echo "active"; ?>" style="<?=$cellWidth?>" data-href="<?echo "?task=profile&action=mytype".$url."&limit=all&active=1";?>">
		<input type="radio" name="active" value="1" <?php if(!isset($_GET['active']) || $_GET['active'] == 1) echo "checked"; ?>>Для агентств <?if($_GET['active']==1)echo "<span class='badge'>{$data[0]['count']}</span>";/*<span class="badge"><?echo Get_functions::Get_var_count(null,$_GET['topic_id'],$_GET['parent_id'],1);?></span>*/?>
	</label>

    <label class="btn btn-default <?php if(isset($_GET['active']) && $_GET['active'] == 0) echo "active"; ?>" style="<?=$cellWidth?>" data-href="<?echo "?task=profile&action=mytype".$url."&active=0";?>">
		<input type="radio" name="active" value="0" <?php if(isset($_GET['active']) && $_GET['active'] == 0) echo "checked"; ?>>Архив<?if($_GET['active']==0 && $_GET['action']=='mytype')echo "<span class='badge'>{$data[0]['count']}</span>";/*<span class="badge"><?echo Get_functions::Get_var_count(null,$_GET['topic_id'],$_GET['parent_id'],0);?></span>*/?>
	</label>

    <label class="btn btn-default <?php if($_GET['action'] == "copyright") echo "active"; ?>" style="<?=$cellWidth?>" data-href="<?echo "?task=profile&action=mytype&copyright=1&active=1".$url;?>">
		<input type="radio" name="copyright" value="1" <?php if($_GET['action'] == "favorites") echo "checked"; ?>>Скопированные
	</label>

	<label class="btn btn-default <?php if($_GET['action'] == "recipients") echo "active"; ?>" style="width: 14%;" data-href="?task=profile&action=recipients">
		<input type="radio" name="recipients" value="1" <?php if($_GET['action'] == "recipients") echo "checked"; ?>>Подборки</span>
	</label>

  </div>
</div>