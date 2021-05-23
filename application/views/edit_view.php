<?php 
$data_res = $data;
//print_r($data['parent_id']);
//print_r($_SESSION);

?>


<form id="add_form" method="POST" action="?task=profile&action=saveedit" >

<div class="row">
	
	<div class="control-group checklabel topic_id">
		<div class="header-3">
			Я хочу
		</div>
<?php if($_SESSION['group_topic_id'] != 1) { ?>		
		<input class="invisible" id="sell" value="2" <?php if ($_GET['topic_id'] == 2) {echo 'checked="checked"';} ?>  type="radio" name="topic_id" onclick="checkForm('2')" /> 
		<label id="label" for="sell">Продать</label>
<?php } ?>		
<?php if($_SESSION['group_topic_id'] != 2) { ?>
		<input class="invisible" id="rent" value="1" <?php if ($_GET['topic_id'] == 1) {echo 'checked="checked"';} ?> type="radio" name="topic_id"  onclick="checkForm('1')" /> 
		<label id="label" for="rent">Сдать</label>
<?php } ?>
		<input id="topic_id" value="<?php echo $_GET['topic_id']; ?>" type="hidden" name="topic_id" /> 
		<input id="id" value="<?php echo $_GET['id']; ?>" type="hidden" name="id" />
		<label class="control-label">Тип объекта</label>
		
			<select class="controls-select" name="parent_id" id="parent_id" required onchange="checkTemplate()">
				
				<option <?php if ($data['parent_id'] == 1) {echo 'checked="checked" selected';} ?> value="1" >Вторичка</option>
				<option <?php if ($data['parent_id'] == 2) {echo 'checked="checked" selected';} ?> id="novo" value="2">Новостройка</option>
				<option <?php if ($data['parent_id'] == 3) {echo 'checked="checked" selected';} ?> value="3">Коттедж-дом</option>
				<option <?php if ($data['parent_id'] == 4) {echo 'checked="checked" selected';} ?> value="4">Дача</option>
				<option <?php if ($data['parent_id'] == 5) {echo 'checked="checked" selected';} ?> value="5">Земля</option>
				<option <?php if ($data['parent_id'] == 6) {echo 'checked="checked" selected';} ?> value="6">Гараж/Парковка</option>
				<option <?php if ($data['parent_id'] == 7) {echo 'checked="checked" selected';} ?> value="7">Коммерческую</option>
			<!--	<option value="foreign">Зарубежную</option> -->
			</select>
		
	</div>
	<!--
<script>
checkForm('<?php echo $data['topic_id']; ?>')
</script>

-->

<div id="template">

<?php
if ($data['topic_id'] == 2) {
			if ($data['parent_id'] == 1) {
				include_once 'application/type_templates/sell/type_1_view.php';
			} else if ($data['parent_id'] == 2) {
				include_once 'application/type_templates/sell/type_2_view.php';
			} else if ($data['parent_id'] == 3) {
				include_once 'application/type_templates/sell/type_3_view.php';
			} else if ($data['parent_id'] == 4) {
				include_once 'application/type_templates/sell/type_4_view.php';
			} else if ($data['parent_id'] == 5) {
				include_once 'application/type_templates/sell/type_5_view.php';
			} else if ($data['parent_id'] == 6) {
				include_once 'application/type_templates/sell/type_6_view.php';
			} else if ($data['parent_id'] == 7) {
				include_once 'application/type_templates/sell/type_7_view.php';
			} 
			
		} else {
			if ($data['parent_id'] == 1) {
				include_once 'application/type_templates/rent/type_1_view.php';
			} else if ($data['parent_id'] == 2) {
				include_once 'application/type_templates/rent/type_2_view.php';
			} else if ($data['parent_id'] == 3) {
				include_once 'application/type_templates/rent/type_3_view.php';
			} else if ($data['parent_id'] == 4) {
				include_once 'application/type_templates/rent/type_4_view.php';
			} else if ($data['parent_id'] == 5) {
				include_once 'application/type_templates/rent/type_5_view.php';
			} else if ($data['parent_id'] == 6) {
				include_once 'application/type_templates/rent/type_6_view.php';
			} else if ($data['parent_id'] == 7) {
				include_once 'application/type_templates/rent/type_7_view.php';
			} 
		}
?>

</div>
<!--
<fieldset>
	<legend>Местоположение</legend>

</fieldset>

<fieldset>
	<legend>Описание объекта</legend>

</fieldset>

<fieldset>
	<legend>Комментарии</legend>

</fieldset>


	
<fieldset>
	<legend>Цена и условия</legend>

</fieldset>

<fieldset>
	<legend>Контактные данные</legend>

</fieldset>
 -->
 
 
</div>
<input type="submit" name="submit" value="Сохранить" />
</form>

<fieldset>
	<legend>Фотографии</legend>
	<div id="photos">
		
	</div>
<div class="content">
	<!--<center><a href="gallery.php" class="nav">Перейти в галерею</a></center>-->
	<!-- Область для перетаскивания -->
	<div id="drop-files" ondragover="return false">
		<p>Перетащите изображение сюда</p>
        <form id="frm">
        	<input type="file" id="uploadbtn" multiple />
        </form>
	</div>
    <!-- Область предпросмотра -->
	<div id="uploaded-holder"> 
		<div id="dropped-files">
        	<!-- Кнопки загрузить и удалить, а также количество файлов -->
        	<div id="upload-button">
            	<center>
                	<span>0 Файлов</span>
					<a href="#" class="upload">Загрузить</a>
					<a href="#" class="delete">Удалить</a>
                    <!-- Прогресс бар загрузки -->
                	<div id="loading">
						<div id="loading-bar">
							<div class="loading-color"></div>
						</div>
						<div id="loading-content"></div>
					</div>
                </center>
			</div>  
        </div>
	</div>
	<!-- Список загруженных файлов -->
	<div id="file-name-holder">
		<ul id="uploaded-files">
			<h3>Загруженные файлы</h3>
		</ul>
	</div>
    
</div>
</fieldset>
<script>
		var ua = navigator.userAgent.toLowerCase();
		var isAndroid = ua.indexOf("android") > -1; //&& ua.indexOf("mobile");
		if(isAndroid) {
			document.getElementById('str').setAttribute('onchange', 'send()')
		//	document.getElementById('str_button').style.display = 'block';
		} else {
			document.getElementById('str').setAttribute('onkeyup', 'send()')
			document.getElementById('str_button').style.display = 'none';
		}
</script>
<div>
<fieldset>
	<legend>Контактная информация</legend>
	ФИО: <?php echo $_SESSION['fio']; ?> <br />
	Телефон <?php echo $_SESSION['phone']; ?> <br />
	АН или группа: <?php echo $_SESSION['company_id']; ?> <br />
	Email: <?php echo $_SESSION['email']; ?>
</fieldset>
</div>