<script type="text/javascript">
	function NewSample(){
		var divNewSample = $(".new_sample"),
			nameInput = $(divNewSample).parent().find("input")[0],
			name = $(nameInput).val();
			$.post('?task=profile&action=add_sample', 'name=' + name, function(new_sample_id){
				if(new_sample_id > 0){
                    window.location = location;
				}else if(new_sample_id = 'too_much'){
					alertify.error("Слишком много подборок");
				}
			});
	}

	function clearSample(id){
			$.post('?task=profile&action=clear_sample', 'id=' + id, function(isClear){
				if(isClear > 0){
					window.location = location;
				}
			});
	}

	function DeleteSample(id){
		var obj = $(".products-list.samples[data-id="+id+"]")
			$.post('?task=profile&action=delete_sample', 'id=' + id, function(isDel){
				if(isDel > 0){
						window.location = location;
				}
			});
	}

	function OpenSample(recId, classStr, actionType){
		var obj = $(".products-list."+classStr+"[data-id="+recId+"]"),
            url ="?task=profile&action=mysample",
			product = $(obj).find(".product");


		if($(product).length == 0){
			$(obj).find("button").attr("disabled","disabled");
			$.post(url, "sample_id="+recId, function(html){
				$(obj).append($(html).find(".product"));
				$(obj).find('button span>span').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
				$(obj).find("button").removeAttr("disabled");
			});
		}else if($(product).is(":visible")){
			$(product).slideUp();
			$(obj).find('button span>span').removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
		}else{
			$(product).slideDown();
			$(obj).find('button span>span').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
		}/**/
	}

	$(document).on('click', '[data-name=del_sample_var]', function(){
		var varId = $('.product').has($(this)).data('id'),
			sampleId = $('.products-list.samples').has($(this)).data('id'),
			sampleObj = $('.products-list.samples').has($(this)),
			varobj = $('.product').has($(this));
		$.ajax({
			type: "POST",
			url: "?task=profile&action=sample_delete_var",
			data: "var_id="+varId+"&sample_id="+sampleId,
			success: function(isDelete){
				if(isDelete == 1){
					$(varobj).hide();
					alertify.success("Удалён");
				}else{
					alertify.error("Удаление не удалось");		
				}				
			}
		})
	});
</script>

<style>
.ya-share2__container_size_m .ya-share2__item{
	margin: 9px 8px 5px 0;
}
</style>
<div class="col-xs-12">
	<h4>Список Подборок</h4>
	<?php 
	$samples = Helper::Save_sample();
	$search_count = count($samples);
    $samplesBalance = DB::Select('samples_balance', 're_people',"id = {$_SESSION['people_id']}");
	if($search_count < $samplesBalance[0]['samples_balance']){
		?>

		<div class = 'new_sample'  style = 'width: 300px'>
			<lable> Создать новую : </lable>
			<input type = 'text' name  = 'sample_name' id = 'sample_name' placeholder="название" style = 'width: 200px'>
			<input onclick="NewSample()" class="btn btn-danger right" style="margin-right: 5px;margin-top: 0px;padding-top: 0px;" value="Создать" type="button">
		</div>
		<?
	}
        foreach ($samples as $sample) {
	    $link = urlencode("http://www.an-podborka.ru?task=main&action=index&link={$sample['external_link']}");
		?>
		<div class='row products-list samples' data-id='<?=$sample["id"];?>' style='margin-top:5px'>
			<span style='float:left;margin-right:10px'><?=$sample["sample_name"];?></span>
			<span style='float:left'>
				<a href = '<?="http://www.an-podborka.ru?task=main&action=index&link={$sample['external_link']}"?>' target = '_blank'>
					Перейти  к просмотру</a>
				</span>  <br/><?="http://www.an-podborka.ru?task=main&action=index&link={$sample['external_link']}"?>
			<br/>

            <div class="share">
                <ul class="hr">
                    <li>
                        <a class="share" href="https://api.whatsapp.com/send?text=<?=$link?>"
                           rel="nofollow" target="_blank" title="WhatsApp">
                            <img class="media-object" src="images/icon/whatsapp.ico"
                                 style="padding: 2px;display: inline;  width: 32px">
                        </a>
                    </li>
                    <li>
                        <a class="share" href="https://telegram.me/share/?url=<?=$link?>&amp;text=Подборка"
                           rel="nofollow noopener" target="_blank" title="telegram">
                            <img class="media-object" src="images/icon/telegram.ico"
                                 style="padding: 2px;display: inline;  width: 32px">
                        </a>
                    </li>
                    <li>
                        <a href = "viber://forward?text=<?=$link?>&amp;text=Подборка">
                            <img class="media-object" src="images/icon/viber.ico"
                                 style="padding: 2px;display: inline;  width: 32px">
                        </a>
                    </li>
                    <li>
                        <a href = "https://web.skype.com/share?url=<?=$link?>&amp;text=Подборка">
                            <img class="media-object" src="images/icon/skype.ico"
                                 style="padding: 2px;display: inline;  width: 32px">
                        </a>
                    </li>
                    <li>
                        <a href='http://vkontakte.ru/share.php?url=<?=$link?>' target='_blank'>
                            <img src='http://img-fotki.yandex.ru/get/6440/40839264.b/0_92085_e23512a0_XS.gif' border='0' width='32' height='32'
                                 alt=''
                                 title='Поделиться ВКонтакте'>
                        </a>
                    </li>
                </ul>
            </div>

			<span style="float:right"><?=(date("d.m.Y H:i", strtotime($sample["modified"])));?></span>
			<br />
			<button type="button" class="btn btn-default left" style='margin-left:10px;padding: 0px 12px; margin-bottom: 4px;'
				 onclick="OpenSample('<?=$sample["id"]?>', 'samples','<?=$sample['action_type']?>' )">
				<span style="float:right; margin-right:10px;color: #D9534F;">Отобразить:
					<span class="glyphicon glyphicon-chevron-down"></span>
				</span>
			</button>
			<a href="javascript:void(0)" style="float:right;margin-right:10px;color: #D9534F;" onClick="clearSample(<?=$sample["id"];?>)">Очистить</a>
			<a href="javascript:void(0)" style="float:right;margin-right:10px;color: #D9534F;" onClick="DeleteSample(<?=$sample["id"];?>)">Удалить</a>
		</div>
	<?}?>
</div>