<script type="text/javascript">
	$(function(){
		$(document).on("click", ".btn-group label", function(){
			var url = window.location.search.match(/\?.+=callboard/)[0];
			window.location=url+"&callboard_topic="+$(this).data("target");
		});
		
		$(document).on("click", "[data-name=photoapp]", function(){
			var fileList = $(this).data("files"),
				fileListArr = fileList.split(";"),
				count = fileListArr.length-1,
				dir = $(this).data("dir"),
				id = $(".callboard").has($(this)).data("id");
			for(var i=0; i<count; i++){
				$(this).after("<a class='fancybox-thumbs pull-left hidden' href='"+dir+fileListArr[i]+"' data-fancybox-group='"+id+"'><img src='"+dir+fileListArr[i]+"'></a>");
			}
			$(this).next().click();
		});
		
		$("form#callboard_add").submit(function(e){
			e.preventDefault();
			var t = 0;
			var message = "Отправить объявление раздел '"+$("label.active").text()+"'",
				post = decodeURIComponent($("form#callboard_add").serialize()),
				postUrl = "?task=media&action=push_photo",
				uploaddir = "",
				backUrl = window.location;
			if(dataArray.length>0){
				var container = $("form").parent();
				$("div.load").show().height(container.height() + 200).css({"background-color":"rgba(0, 0, 0, .6)"});
				loading(1);
				post+="&photo=1";
				t=5000;
			}else{
				post+="&photo=0";
			}
			alertify.confirm(message, function(result){
				if(result){
					$("[type=submit]").attr("disabled", "disabled");
					$.ajax({
						type:"post",
						url:$("form#callboard_add").attr("action"),
						data:post,
						success:function(html){
							uploaddir = html.match(/\/.+\d/)[0];
							$("form#callboard_add").after("<div class='col-xs-12 info callboard'><div class='col-xs-10'><p><span>Объявление: </span>"+$('form#callboard_add [name=text]').val()+"</p></div><div class='col-xs-2'><span>Ваше новое объявление</span></div></div>");
							$("[name=text]").val("");
							addPhoto(postUrl, uploaddir, backUrl);
						}
						// complete:function(){
							// $("#dropped-files div").remove();
							// setTimeout(function(){
								// window.location.reload();
							// }, t);
						// }
					})
				}else{
					window.location.reload();
				}
			})
		})
	})
</script>
<div class='col-xs-9'>
	<legend>
		<a href="?task=profile&action=forum">Форум</a>
		<a href="?task=profile&action=caution&type=1" style="padding: 0 100px;">Список предупреждений</a>
		<span style="text-decoration: underline;">Доска объявлений</span>
	</legend>
	<form id="callboard_add" method="POST" action="?task=chat&action=send_call" enctype="multipart/form-data">
		<div class="btn-group" data-toggle="buttons" style="width:100%;">
			<label class="btn btn-default <?if($_GET["callboard_topic"] == 'work') echo 'active';?>" style="width:20%;" data-target="work">
				<input type="radio" autocomplete="off" checked> Работа
			</label>
			<label class="btn btn-default <?if($_GET["callboard_topic"] == 'services') echo 'active';?>" style="width:20%;" data-target="services">
				<input type="radio" autocomplete="off"> Услуги
			</label>
			<label class="btn btn-default <?if($_GET["callboard_topic"] == 'sell') echo 'active';?>" style="width:20%;" data-target="sell">
				<input type="radio" autocomplete="off"> Продам
			</label>
			<label class="btn btn-default <?if($_GET["callboard_topic"] == 'buy') echo 'active';?>" style="width:20%;" data-target="buy">
				<input type="radio" autocomplete="off"> Куплю
			</label>
			<label class="btn btn-default <?if($_GET["callboard_topic"] == 'registration') echo 'active';?>" style="width:20%;" data-target="registration">
				<input type="radio" autocomplete="off"> Прописка
			</label>
		</div>
		<div class="col-xs-12 deployed">	
			<textarea name="text" class="form-control" placeholder="содержание объявления" rows="5" cols="80" required="required"></textarea>
		</div>
		<div class="col-xs-12">
			<!--<legend>Фотографии</legend>	-->
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
		<?//unlink($_SERVER['DOCUMENT_ROOT'] .'/images/1/90231/c9eaf3ec0afc.jpg');?>
		<div class="col-xs-2 deployed">	
			<input type="submit" class="form-control btn btn-success" value="Отправить">
		</div>
		<input type="hidden" name="callboard_topic" value="<?echo $_GET["callboard_topic"];?>">
		<input type="hidden" data-name="photo-count" value="0">
	</form>
	<?$count = count($data);
	for($i=0; $i<$count; $i++){?>
		<div class="col-xs-12 info callboard" data-id="<?echo $data[$i]["id"];?>">
			<div class="col-xs-10">
				<p><span>Объявление: </span>
				<?echo $data[$i]["text"];?></p>
				<p>
					<span>тел.: </span><?echo $data[$i]["phone"];?>
					<span> имя: </span><?echo $data[$i]["name"];?>
					<span> АН.: </span><?echo $data[$i]["company_name"];?>
				</p>
			</div>
			<div class="col-xs-2 right">
				<p class="right"><?echo $data[$i]["date"];?></p>
				<?if($data[$i]["photo"]==1){
					$dir = 'images/'.$data[$i]["people_id"]."/callboard/".$data[$i]["id"]."/";
					$dh = opendir($dir);
					$file_str = "";
					$file_list = "";
					while ($file = readdir($dh)){
						if($file != "." && $file!=".."){
							if($fale_str==""){
								$file_str = $dir.$file;
							}
							$file_list.=$file.";";
						}
					}?>
					<?if($file_str!=""){?>
						<p>
							<a href="javascript:void(0)" data-files="<?echo $file_list;?>" data-dir="<?echo $dir;?>" data-name="photoapp">		
								<img src="/images/photoapp.png">
							</a>
							<a class="fancybox-thumbs pull-left hidden" href="<?echo $file_str;?>" data-fancybox-group="msg<?echo $i;?>">		
								<img src="<?echo $file_str;?>">
							</a>
						</p>
					<?}?>
				<?}; unset($dir, $dr, $file_str, $file, $file_list);
				if($_SESSION['admin']==1 || $_SESSION['people_id'] == $data[$i]['people_id']){?>
					<p><span class="delete right" onclick="Delete('callboard', <?=$data[$i]["id"];?>)">удалить</span></p>
				<?}?>
			</div>
		</div>
	<?}?>	
</div>
<div class='load'>
	<div class="progress"  style="margin: 25%;">
		<p style="position: absolute;margin-top: -35px;font-size: 20px;color: #fff;">Загрузка</p>
		<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
	</div>
</div>