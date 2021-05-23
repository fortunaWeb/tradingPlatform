<?
if($_SESSION['cur_var']){ 
	echo $_SESSION['cur_var'];
	//$_SESSION['cur_var'] = "";
	$photo_query = "SELECT * FROM `re_photos` where `var_id` = '".$_SESSION['cur_var'] ."'";
	$p_res = mysql_query($photo_query);
	$p_num = mysql_num_rows($p_res);	
?>
<div class="row">	
	<!--<center><a href="gallery.php" class="nav">Перейти в галерею</a></center>-->
	<!-- Область для перетаскивания -->		
	<div id="drop-files" class="center" ondragover="return false">			
		<!--<p>Перетащите изображение сюда</p>
		<img src="/images/b_plus.png" alt="Добавить фотографии" class="img-rounded">-->
		<div class="row">
			<div class="col-xs-12">		
				<form id="frm" class="left">
					<input type="file" id="uploadbtn" multiple />
				</form>	
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">		
				<!-- Область предпросмотра -->
				<div id="uploaded-holder" class="info left" style="display:none; min-width:400px"> 
					<div id="dropped-files">						
					</div>
				</div>
				<!-- Кнопки загрузить и удалить, а также количество файлов -->
				<div id="upload-button">
					<div class="col-xs-12" style="margin-top:5px; margin-bottom:5px">
						<span>0 Файлов</span><br />						
						<button class="upload btn btn-success right" data-id="<? echo $_SESSION['cur_var'];?>">Далее</button>
						<!--<button class="delete btn btn-danger left">Удалить все фотографии</button>	-->					
					</div>					
					<div class="col-xs-12" style="margin-top:15px;">
					<!-- Прогресс бар загрузки -->
						<div id="loading" style="display:none">
							<div id="loading-bar">
								<div class="loading-color"></div>
								<div class="progress">
									<div class="loading-color progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
									</div>
								</div>
							</div>
							<div id="loading-content"></div>
						</div>
					</div>	
				</div>  
				<!-- Список загруженных файлов 
				<div id="file-name-holder">
					<ul id="uploaded-files">
						<h3>Загруженные файлы</h3>
					</ul>
				</div>-->
			</div>
		</div>
	</div>	
</div>    
<input type="hidden" data-name="photo-count" value="<?echo $p_num;?>">
<?
	$_SESSION['photo_count'] = $p_num;
}
?>