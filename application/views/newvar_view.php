<!--<script src="http://maps.api.2gis.ru/2.0/loader.js?pkg=full"></script>
<script src="js/2gis.js" type="text/javascript"></script>-->
<script src="js/yandex_new.js" type="text/javascript"></script>
<script>
var address = "",
	coords = "",
	metro_coords = "",
	metro_name = "",
	furn_list="",
	distanceToMetro = 0,
	postUrl = "?task=profile&action=edit_group",
	confirmStr = "Обновить информацию о своей группе?",
	alreadyClick = false;
	
$(function (){
	HideField($("[name=topic_id]:checked"));
	// $(document).on("keyup", "[name=house]", function(){
		// var val = $(this).val();
		// $(this).val(val.match(/\d+\/\d+|\d+/)[0]);		
	// });
	
	if($("[name=type_id]").val() == 53 || $("[name=type_id]").val() == 54){
		$("[name=ap_layout]").removeAttr('required').parent().hide();
		$("[name=room_count]").removeAttr('required').parent().hide();
		$("[name=owner]").removeAttr('required').parent().hide();
	}
	
	if($("#sq_live").length > 0)MinusRemove($("#sq_live"));
	if($("#sq_all").length > 0)MinusRemove($("#sq_all"));
	if($("#sq_k").length > 0)MinusRemove($("#sq_k"));
	if($("#sq_land").length > 0)MinusRemove($("#sq_land"));
	
	/*скрытие типа объекта при выборе коммуналки*/
	$("[name=type_id], [name=ap_layout]").on("change", function(){
		if($(this).val()==50 || $(this).val()==52 || $(this).val()==53  || $(this).val()==54){
			$("[name=ap_layout]").removeAttr('required').parent().hide();
			$("[name=room_count]").attr('required', 'required').parent().show();
			if($(this).val()==53 || $(this).val()==54){
				$("[name=room_count]").removeAttr('required').parent().hide();
				$("[name=owner]").removeAttr('required').parent().hide();
			}
		}else if($(this).val()!='в общежитии'){
			$("[name=ap_layout]").parent().show();
			$("[name=room_count]").attr('required', 'required').parent().show();
			$("[name=owner]").attr('required', 'required').parent().show();
		}else{
			$("[name=room_count]").removeAttr('required').parent().hide();
		}		
	})

	if($("[name=ap_layout]").val()=='в общежитии'){
		$("[name=room_count]").removeAttr('required').parent().hide();
	}
	$(":required,[name=residents]").each(function(){
		if($(this).val()==""){
			if($(this).attr("name") == "residents"){
				$(this).next().css("border-color", "red");
			}
			$(this).css("border-color", "red");
		}else{
			if($(this).attr("name") == "residents"){
				$(this).next().css("border-color", "#5cb85c");
			}
			$(this).css("border-color", "#5cb85c");
		}
	})
	$(":required,[name=residents]").on("change", function(){
		if($(this).val()!=""){
			if($(this).attr("name") == "residents"){
				$(this).next().css("border-color", "#5cb85c");
			}
			$(this).css("border-color", "#5cb85c");
		}else{
			if($(this).attr("name") == "residents"){
				$(this).next().css("border-color", "red");
			}
			$(this).css("border-color", "red");
		}
	})
	
	if($("[data-name=coords]").val()!=""){
		coords=$("[data-name=coords]").val();
		metro_coords=$("[data-name=metro_coords]").val();
		metro_name=$("[data-name=metro_name]").val();
		distanceToMetro=$("[data-name=distance_to_metro]").val();
	}
	
	$("[name=ap_race_date]").on("change", function(){
		var dateStr = $("[name=ap_view_date]").val().split("-"),
			dateStart = new Date(dateStr[0], dateStr[1], dateStr[2]),
			dateStr = $(this).val().split("-"),
			dateEnd = new Date(dateStr[0], dateStr[1], dateStr[2]);
		if(dateEnd < dateStart){
			$(this).val($("[name=ap_view_date]").val());
		}
		
	});
	$("#add_form [type=submit]").on("click", function(){		
		try{
		setTimeout(function(){
			if(!$("#residents").hasClass("focus")){
				$("body").animate({scrollTop:$(":focus").offset()['top'] - 200}, '500', 'swing');
			}
		}, 100);	
		}catch(error){}
	});
	//обновление дат пикеров(без этого даты не видны)
	$("[data-id=date]").each(function(){
		$(this).val($(this).attr("value"));
		if($(this).val()!=""){
			$(this).css("border-color", "#5cb85c");
		}
	});	

	view_price();	

	$("[name=house]").on("change", function(){
		var live_point = $("[name=live_point]").val();
		var street = $("[name=street]").val();
		var house = $("[name=house]").val();
		if(live_point != "", street != "", house!=""){
			address = live_point + ", " + street + " д." + house;	
			try{	
				getCoord(address);
			}catch(err){}
		}
	});

	//checkTemplate();
	$("#add_form").submit(function(e){
		e.preventDefault();
		if(alreadyClick){
			return false;
		}
		alreadyClick = true;
		$.post("?task=var&action=street_check", "street="+$("#str").val(), function(html){
			if(parseInt(html) == 0 && parseInt($('[name=topic_id]:checked').val())<3){
				$("#str").focus();
				alert("Такой улицы не существует! Проверьте правильность написания!");
				alreadyClick = false;
				return false;
			}else{
                if($("#val_copyright").val() == ''){
                    alert("Проверьте  назначение варианта");
                    alreadyClick = false;
                    return false;
                }
                // if($("#val_lodg").val() == 0 || $("#val_bal").val() == 0){
                //     alert("Проверьте балконы и лоджии");
                //     alreadyClick = false;
                //     return false;
                // }
                // if($("#sq_live").length > 0)MinusRemove($("#sq_live"));
                // if($("#sq_all").length > 0)MinusRemove($("#sq_all"));
                // if($("#sq_k").length > 0)MinusRemove($("#sq_k"));
                // if($("#sq_land").length > 0)MinusRemove($("#sq_land"));
				var house = $("[name=house]"),
                    copyright = $("#val_copyright").val(),
					topic_id = $("[name=topic_id]:checked").val();
				if($(house).prop("required") && $(house).val().match(/[1-9]\d*\/[1-9]\d*\W*|[1-9]\d*\W*/) == null){
					$(house).val("");
					$("[name=house]").focus();
					alreadyClick = false;
					return false;
				}else if((QueryString("parent_id") == 1 || QueryString("parent_id") == 2 || QueryString("parent_id") == 18) && (topic_id==1 || topic_id==2)){
					$(house).val($(house).val().match(/[1-9]\d*\/[1-9]\d*\W*|[1-9]\d*\W*/)[0]);
					$(house).val($(house).val().replace('.','/'));
				}
				if($("[name=residents]").val() == ""){
					$("body").animate({scrollTop:200}, '500', 'swing');
					$("[name=residents]").next().addClass("focus");
					$(".residents_list").slideDown();
					alreadyClick = false;
					return false;
				}
				var post = add_form();
				var id = "";
				window.location = "#add_form";
				if(dataArray.length>0){
					var container = $("form").parent();
					$("div.load").show().height(container.height() + 200).css({"background-color":"rgba(0, 0, 0, .6)"});
					loading(1);
				}
				$(".progress").addClass("pr").removeClass("progress");
				$("#add_form").append("<div class='progress' style='width: 103%;height: 100%; position: fixed;z-index: 9999;top: 0;margin-left: -10px;background-color: rgba(0, 0, 0, 0.5);text-align: center;'><p style='margin-top: 250px;font-size: 20px;color: #fff;'>Загрузка</p></div>");
				loading(1);
				jQuery.ajax({
					type: 'POST',
					url: '?task=profile&action=add_photo', 
					data: post, 
					success:function(html) {				
						//html;
					},
					complete: function() { 	
						$(".progress").remove();
						$(".pr").addClass("progress").removeClass("pr");
						addPhotoToServer(id,copyright);
					}				
				});		
			}
		});
		
	});
	
	$("[data-id=furn_list] [type=checkbox]").on("change", function(){
		furn_list = "";
		$("[data-id=furn_list] [type=checkbox]").each(function(){
			if($(this).is(":checked")){
				furn_list+="&"+$(this).data("name")+"=1";
			}else{
				furn_list+="&"+$(this).data("name")+"=0";
			}
		})
	});
	
	//срытие лишних полей
	$(document).on("change", "[name=topic_id]", function(){
		var obj = $(this);
		HideField(obj);
	});
	
	$(document).on("click", "[data-name=rotate]", function(){
		if($("#drop-files").has($(this)).length > 0){
			var obj = $(this).parent().find(".image");
			RotateUpdate(obj);
		}else{
			var obj = $(this).parent().find(".image"),
					src = $(obj).data("way"),
					arr = src.split('/'),
					photo = arr[arr.length-1],
					way = src.replace(photo, ""),
					photoId=$(obj).data("photo_id");
			$.ajax({
				type:"POST",
				url:"?task=media&action=rotate",
				data: "photo="+photo+"&way="+way+"&photo_id="+photoId,
				complete: function(){
					RotateUpdate(obj);					
				}
			});
		}
	});
});

function HideField(obj){
	if($(obj).val()=="3"){
		if($(obj).is(":checked")){
			//$("[name=text]").attr("required", "");
			//$("[name=hidden_text]").attr("required", "");
			$(".deployed").each(function(){
				if($(this).has("[name=topic_id], [name=rent_type], [name=live_point], [type=button], [type=submit]").length == 0){
					$(this).addClass("hidden");
					if($(this).find("[required]").length>0){
						$(this).find("[required]").attr("disabled", "");
						$(this).find("[required]").removeAttr("required");
					}
				}
			});

			$("[name=text]").attr("required", "");
			$(".price_rent").parent().addClass("hidden");
			$(".object_desc").parent().parent().addClass("hidden");
			$("[name=premium]").removeAttr("checked");
			$("[name=status]").last().click();
			$("#dropped-files").children().remove();
			$("[type=file]").val("");
			$("[name=residents]").prev().text("Состав жильцов");
			$("[name=residents]").val("2");
			$("[name=deliv_period]").prev().text("Период аренды");
		}
	}else{
		if($(obj).is(":checked")){
			$("[name=text]").removeAttr("required");
			$("[name=hidden_text]").removeAttr("required");
			$(".deployed").each(function(){
				if($(this).has("[name=topic_id], [name=rent_type], [name=live_point],  [type=button], [type=submit]").length == 0){
					$(this).removeClass("hidden");
					if($(this).find("[disabled]").length>0){
                        $(this).find("[disabled]").attr("required", "");
						$("[name=text]").removeAttr("required");
						$(this).find("[disabled]").removeAttr("disabled");
					}
				}
			});
			$("[name=residents]").val();
			$(".price_rent").parent().removeClass("hidden");
			$(".object_desc").parent().parent().removeClass("hidden");

			$("[name=residents]").prev().text("Кого берут");
			$("[name=deliv_period]").prev().text("Период сдачи");
		}	
	}
}

function add_form(){
	var serializeForm = decodeURIComponent($("form#add_form").serialize());
		
	if (serializeForm.match("topic_id") == null){
		$(".btn.active [name=topic_id]").click();
		serializeForm = decodeURIComponent($("form#add_form").serialize());
	}
	$("[type=checkbox]").each(function(){
		var name = $(this).attr("name");
		if(name!=undefined){
			if(serializeForm.indexOf(name) == -1){
				serializeForm += "&"+name+"=0";
			}
		}
	})
	
	var post = serializeForm
				+ furn_list
				+ "&coords=" + coords
				+ "&metro_coords=" + metro_coords
				+ "&metro_name=" + metro_name
				+ "&distance_to_metro=" + distanceToMetro
				+ (!$("[name=premium]").is(":checked") ? "&premium=0" : "");		
	if(window.location.search.match(/&id=([0-9]+)/)!=null){
		post+="&id=" + window.location.search.match(/&id=([0-9]+)/)[1];
	}
	if(dataArray.length > 0){
		post+="&photo=1";
	}
	return post;
}

function RotateUpdate(obj){
	var grd = 0;
	try{
		var str = $(obj).attr("class").match(/\d+/);
		if(str != null){
			grd = parseInt(str);
		}
	}catch(err){}
	$(obj).removeClass("g"+grd);
	if(grd>270) grd = 0;
	if(grd == 90 || grd == 270){
		$(obj).addClass("g"+(grd+90));
	}else{
		$(obj).addClass("g"+(grd+90));
	}
}

function MinusRemove(obj){
	$(obj).val($(obj).val().replace("-", ""));
}



function check_number(obj) {
  obj = (obj) ? obj : window.obj
  var charCode = (obj.which) ? obj.which : obj.keyCode

  if (charCode < 32 || (charCode > 47 && charCode < 58) || (charCode > 1071 && charCode < 1080)  || charCode == 47) {
    return true;
  }
   status = "В данное поле можно вводить только цифры"
    return false;
}

</script>	
<?php
    $topic = "Продажа";
    $data_res = $data;
?>
<form id="add_form" method="POST" enctype="multipart/form-data" action="?task=profile&action=add_photo" >
<div class="info">
	<div class="row">
		<div class="col-xs-12">
			<?$title = $_GET['action']=="edit"? "Редактирование варианта" : "Добавление нового варианта";?>
			<legend><?=$title?> (<?=$topic." - ".$parent?>)
			<?if($_GET['action']!="newvar"){?>
				<span style="float: right;font-size: 14px;color: #C50202;">дата следующего прозвона: <input type="text" data-id="date" class="form-control" name="col_date" style="width:110px; display:inline-block" placeholder="дата прозвона" value="<?php if (isset($data_res['col_date'])) echo $data_res['col_date']; ?>"></span>
			<?}?>
			</legend>
            <?php
                include "application/includes/filters_to_create/copyright.php";
                if($parent_id ==1 || $parent_id == 18) {
                    include "application/includes/filters_to_create/parent_ch.php";
                }
            ?>

		</div>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<legend>Местоположение</legend>
		</div>
		<?
		include "application/includes/filters_to_create/location.php";
		?>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<legend class = 'object_desc'>Описание Объекта</legend>
		</div>
		<?
		if($parent == "Квартиры"){
			include "application/includes/filters_to_create/rooms_count.php";
			include "application/includes/filters_to_create/area.php";
			include "application/includes/filters_to_create/planning.php";
			include "application/includes/filters_to_create/estate_type.php";
			include "application/includes/filters_to_create/wc_type.php";
			include "application/includes/filters_to_create/bal_lodg.php";
//			include "application/includes/filters_to_create/park.php";
			include "application/includes/filters_to_create/floor.php";
			include "application/includes/filters_to_create/wall_type.php";
			/*форма собственности и мебель*/
			include "application/includes/filters_to_create/own_type.php";
		}else if($parent == "Комната"){
			include "application/includes/filters_to_create/estate_type.php";
			include "application/includes/filters_to_create/room_type.php";
			include "application/includes/filters_to_create/planning.php";
			include "application/includes/filters_to_create/area.php";
			include "application/includes/filters_to_create/rooms_count.php";
			include "application/includes/filters_to_create/wc_type.php";
			include "application/includes/filters_to_create/bal_lodg.php";
//			include "application/includes/filters_to_create/park.php";
			include "application/includes/filters_to_create/floor.php";
			include "application/includes/filters_to_create/wall_type.php";
			include "application/includes/filters_to_create/own_type.php";
		}else if($parent == "Дома"){
			include "application/includes/filters_to_create/estate_type.php";
			include "application/includes/filters_to_create/area.php";
			include "application/includes/filters_to_create/wc_type.php";
			include "application/includes/filters_to_create/heating.php";
			include "application/includes/filters_to_create/wash.php";
			include "application/includes/filters_to_create/water.php";
			include "application/includes/filters_to_create/sewage.php";
//			include "application/includes/filters_to_create/park.php";
			include "application/includes/filters_to_create/floor.php";
			include "application/includes/filters_to_create/wall_type.php";
			include "application/includes/filters_to_create/rooms_count.php";
//            include "application/includes/filters_to_create/sleeping_area.php";
			include "application/includes/filters_to_create/own_type.php";
		}else if($parent == "Дачи"){
			include "application/includes/filters_to_create/estate_type.php";
			include "application/includes/filters_to_create/area.php";
//			include "application/includes/filters_to_create/park.php";
			include "application/includes/filters_to_create/own_type.php";
		}else if($parent == "Гаражи"){
			include "application/includes/filters_to_create/estate_type.php";
			include "application/includes/filters_to_create/area.php";
			include "application/includes/filters_to_create/heating.php";
			include "application/includes/filters_to_create/own_type.php";
		}else if($parent == "Коммерческая"){
			include "application/includes/filters_to_create/estate_type.php";
			include "application/includes/filters_to_create/area.php";
		}else if($parent == "Земля"){
			include "application/includes/filters_to_create/estate_type.php";
			include "application/includes/filters_to_create/area.php";
		}else if($parent == "Новостройки"){
			include "application/includes/filters_to_create/rooms_count.php";
			include "application/includes/filters_to_create/area.php";
			include "application/includes/filters_to_create/planning.php";
			include "application/includes/filters_to_create/estate_type.php";
			include "application/includes/filters_to_create/wc_type.php";
			include "application/includes/filters_to_create/bal_lodg.php";
            include "application/includes/filters_to_create/sleeping_area.php";
//			include "application/includes/filters_to_create/park.php";
			include "application/includes/filters_to_create/floor.php";
			include "application/includes/filters_to_create/wall_type.php";
			/*Застройщик*/
			include "application/includes/filters_to_create/developer.php";
			/*сдача*/
			include "application/includes/filters/delivery.php";
		}
		if($parent != 'Земля' && $parent != ' Коммерческая'){
            include "application/includes/filters_to_create/construct_y.php";
        }
		?>

	</div>
	<div class="row" >
		<div class="col-xs-6" >
			<legend class = 'price_rent'>Цена и условия</legend>
			<p style = "color:red;"><i>
                    Значение в поле"<b>цена</b>" состоит из суммы стоимости объекта и услуг агентства.<br/>
                    Пишем полное число со всеми нулями.
            </i></p>
			<?php
				include "application/includes/filters_to_create/price.php";
				include "application/includes/filters_to_create/additional_terms.php";
			?>
		</div>
		<?=$_SESSION['mobile']?"</div><div class='row'>":""?>
		<div class="col-xs-6">
			<legend>Комментарии</legend>
			<?
				/*коментарий/код ворианта*/
				include "application/includes/filters_to_create/var_comment_code.php";
			?>
		</div>
	</div>
	<?if($topic == "Аренда"){ ?>
		<div class="row deployed">
			<div class="col-xs-12">
				<?php
				include "application/includes/filters_to_create/premium_status.php";
				include "application/includes/filters_to_create/last_call_date.php";
				?>
			</div>
		</div>
	<?
	}

	if($data_res['photo_close']!=1){
		?>
	<div class="row deployed">
		<div class="col-xs-12">
			<legend>Фотографии
				<span style="font-size: 12px;float: right;margin-top: 8px;color: #D20000;">(Все фото с водяными знаками будут удалены!!! Фото весом более 4 мегобайт на сайт не загрузятся. Для загрузки их предворительно нужно сжать.)</span>
			</legend>
			<?

			$photos = DB::Select("`id`,`photo`", "`re_photos`", "`var_id` = ".$_GET['id']);
			if (isset($photos[0]['photo'])){
				echo "<span>Имеющиеся фотографии</span><br />";
				for($i=0; $i<count($photos); $i++){
					$way = "images/".$_SESSION['people_id']."/".$_GET['id']."/".$photos[$i]['photo'];

					if(file_exists($way))
						echo "<div style='display: inline-block;'>
						<div class='image' data-photo_id='".$photos[$i]['id']."' data-way='{$way}' 
						style='background-image:url({$way});background-size:cover; text-align: center; display: inline-block;margin: 5px 5px 5px 0;'>

						</div>
							<span class='glyphicon glyphicon-remove right' style='{$styleMobileLeft} margin-left: -25px;background-color: #fff;
									 border-radius: 15px; padding: 5px;cursor: pointer; color: #d9534f;' onClick='DeletePhotoByWay(\"{$way}\")'>
							</span><span class='glyphicon glyphicon-repeat left' aria-hidden='true' style='background-color:#fff; border-radius: 15px; padding: 5px;cursor: pointer;color: #449d44; margin-right:-20px;' data-name='rotate'>
							</span></div>";				
					
					unset($way);
				}
			}?>
			<input type="file" id="uploadbtn" name="files[]" multiple style="margin-bottom: 10px;">
			<div id="drop-files" class="center" ondragover="return false">	
				<p>Перетащите изображение сюда</p>
				<div class="col-xs-12">		
					<!-- Область предпросмотра -->
					<div id="uploaded-holder" class="left" style="display:none; min-width:400px;margin: 10px 0 10px 0;"> 
						<div id="dropped-files">						
						</div>
					</div>			
				</div>		
			</div>
		</div>
	</div>
	<?}?>
	<div class="row">
		<div class="col-xs-12">
			<?if(!isset($_GET['active']) && $_GET['action']=="edit"){?>
				<div class="col-xs-2 deployed">
					<input type="submit" class="btn btn-warning right" onclick="$('[name=active]').val(0)" name="submit" value="Сохранить в архив" />
				</div>
				<input type="hidden" name="active" value="1">
			<?}?>
			<div class="col-xs-2 deployed">
				<input type="button" class="btn btn-danger right" onClick="window.history.back();" value="Отмена" />
			</div>
			<?if($topic == "Аренда" && (!isset($_GET['active']) || $_GET['active']==1)){?>
				<div class="col-xs-3 deployed" style="max-width: 220px !important;">
					<input type="button" class="btn btn-default right" data-toggle="modal" data-target="#modal-win-group" value="Настройка своей группы" />
				</div>
				<div class="col-xs-3 deployed" style="max-width: 220px !important;">
					<input  type="submit" class="btn btn-primary right" onClick="$('[name=group]').val('1');" value="Отправить своей группе" />
				</div>
				<div class="col-xs-2 deployed">
					<input type="submit" id='sendAll'
                           onClick="$('[name=group]').val('0');"
                           class="btn btn-success right" name="submit" value="Отправить всем" />
				</div>
			<?}else if(isset($_GET['active']) && $_GET['active']==0){?>
				<div class="col-xs-2 deployed">
					<input type="submit" class="btn btn-success right" name="submit" value="Сохранить" />
				</div>
			<?}else{?>
				<div class="col-xs-2 deployed">
					<input type="submit" class="btn btn-success right" name="submit" value="Отправить" />
				</div>
			<?}?>
		</div>
	</div>
</div>
<input type="hidden" data-name="photo-count" value="<?echo $p_num;?>">
<input type="hidden" name="parent_id" value="<?=$parent_id?>">
<input type="hidden" name="group" value="<?if($data_res['group']){echo $data_res['group'];}else{echo "0";}?>">
<input type="hidden" data-name="coords" value="<?if($data_res['coords']) echo $data_res['coords'];?>">
<input type="hidden" data-name="metro_coords" value="<?if($data_res['metro_coords']) echo $data_res['metro_coords'];?>">
<input type="hidden" data-name="metro_name" value="<?if($data_res['metro_name']) echo $data_res['metro_name'];?>">
<?if(isset($_GET['active'])){?>
	<input type="hidden" name="active" value="<?=$_GET['active'];?>">
<?}?>
<input type="hidden" data-name="distance_to_metro" value="<?if($data_res['distance_to_metro']) echo $data_res['distance_to_metro'];?>">
<div class='load'>
	<div class="progress"  style="margin: 25%;">
		<p style="position: absolute;margin-top: -35px;font-size: 20px;color: #fff;">Загрузка</p>
		<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
	</div>
</div>
</form>
<? echo Helper::Modal_win_group_setting();?>

