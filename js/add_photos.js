// Массив для всех изображений
var dataArray = [];
	
$(function (){
	// В dataTransfer помещаются изображения которые перетащили в область div
	jQuery.event.props.push('dataTransfer');
	
	// Максимальное количество загружаемых изображений за одни раз
	var maxFiles = 15 - $("input[data-name=photo-count]").val();
	
	// Оповещение по умолчанию
	var errMessage = 0;
	
	// Кнопка выбора файлов
	var defaultUploadBtn = $('#uploadbtn');
	
	// Область информер о загруженных изображениях - скрыта
	$('#uploaded-files').hide();
	
	// Метод при падении файла в зону загрузки
	$('#drop-files').on('drop', function(e) {	
		// Передаем в files все полученные изображения
		var files = e.dataTransfer.files;
		// Проверяем на максимальное количество файлов
		if (files.length <= maxFiles) {
			// Передаем массив с файлами в функцию загрузки на предпросмотр
			loadInView(files);
		} else {
			alert('Вы не можете загружать больше '+maxFiles+' изображений!'); 
			files.length = 0; return;
		}
	});
	
	// При нажатии на кнопку выбора файлов
	defaultUploadBtn.on('change', function() {
   		// Заполняем массив выбранными изображениями
   		var files = $(this)[0].files;
   		// Проверяем на максимальное количество файлов
		if (files.length <= maxFiles) {
			// Передаем массив с файлами в функцию загрузки на предпросмотр
			loadInView(files);
			// Очищаем инпут файл путем сброса формы
            $('#frm').each(function(){
	        	    this.reset();
			});
		} else {
			alert('Вы не можете загружать больше '+maxFiles+' изображений!'); 
			files.length = 0;
		}
	});

	// Функция загрузки изображений на предросмотр
	function loadInView(files) {
		// Показываем обасть предпросмотра
		$('#uploaded-holder').show();
		
		// Для каждого файла
		$.each(files, function(index, file) {
						
			// Несколько оповещений при попытке загрузить не изображение
			if (!files[index].type.match('image.*')) {
				
				if(errMessage == 0) {
					$('#drop-files p').html('Эй! только изображения!');
					++errMessage
				}
				else if(errMessage == 1) {
					$('#drop-files p').html('Стоп! Загружаются только изображения!');
					++errMessage
				}
				else if(errMessage == 2) {
					$('#drop-files p').html("Не умеешь читать? Только изображения!");
					++errMessage
				}
				else if(errMessage == 3) {
					$('#drop-files p').html("Хорошо! Продолжай в том же духе");
					errMessage = 0;
				}
				return false;
			}
			
			// Проверяем количество загружаемых элементов
			if((dataArray.length+files.length) <= maxFiles) {
				// показываем область с кнопками
				$('#upload-button').css({'display' : 'block'});
			} 
			else { alert('Вы не можете загружать больше '+maxFiles+' изображений!'); return; }
			
			// Создаем новый экземпляра FileReader
			var fileReader = new FileReader();
				// Инициируем функцию FileReader
				fileReader.onload = (function(file) {
					return function(e) {
						// Помещаем URI изображения в массив
						dataArray.push({name : file.name, value : this.result});
						addImage((dataArray.length-1));
					}; 						
				})(files[index]);
			// Производим чтение картинки по URI
			fileReader.readAsDataURL(file);
		});
		return false;
	}
		
	// Процедура добавления эскизов на страницу
	function addImage(ind) {
		// Если индекс отрицательный значит выводим весь массив изображений
		if (ind < 0 ) { 
		start = 0; end = dataArray.length; 
		} else {
		// иначе только определенное изображение 
		start = ind; end = ind+1; } 
		// Оповещения о загруженных файлах
		if(dataArray.length == 0) {
			// // Если пустой массив скрываем кнопки и всю область
			// $('#upload-button').hide();
			// $('#uploaded-holder').hide();
			$('#upload-button span').html("0 файлов");
		} else if (dataArray.length == 1) {
			$('#upload-button span').html("Был выбран 1 файл");
		} else {
			$('#upload-button span').html(dataArray.length+" файлов были выбраны");
		}
		// Цикл для каждого элемента массива
		for (i = start; i < end; i++) {
			// размещаем загруженные изображения
			if($('#dropped-files > .image').length <= maxFiles) { 
				//$('#dropped-files').prepend('<div data-name="' + dataArray[i].name + '" id="img-'+i+'" class="image col-xs-2 center" style="background: url('+dataArray[i].value+'); background-size: cover;"> <a href="#dropped-files" id="drop-'+i+'" class="drop-button"><span class="glyphicon glyphicon-remove right"></span></a></div>'); 
				$('#dropped-files').prepend('<div data-name="' + dataArray[i].name + '" id="img-'+i+'" style="display: inline-block; float:left;"><div class="image" style="background-image:url('+dataArray[i].value+');background-size:cover; text-align: center; display: inline-block;margin: 5px 5px 5px 0;"></div><span class="glyphicon glyphicon-remove right" style="margin-left: -25px;background-color: #fff; border-radius: 15px; padding: 5px;cursor: pointer; color: #d9534f;" id="drop-'+i+'"></span><span class="glyphicon glyphicon-repeat left" aria-hidden="true" style="background-color:#fff; border-radius: 15px; padding: 5px;cursor: pointer;color: #449d44; margin-right:-20px;" data-name="rotate"></span></div>');
			}
		}
		return false;
	}
	
	// Функция удаления всех изображений
	function restartFiles() {
	
		// Установим бар загрузки в значение по умолчанию
		$('#loading-bar .loading-color').css({'width' : '0%'});
		$('#loading').css({'display' : 'none'});
		$('#loading-content').html(' ');
		
		// Удаляем все изображения на странице и скрываем кнопки
		//$('#upload-button').hide();
		$('#dropped-files > .image').remove();
		$('#uploaded-holder').hide();
	
		// Очищаем массив
		dataArray.length = 0;
		
		return false;
	}
	
	// Удаление только выбранного изображения 
	$("#dropped-files").on("click","span[id^='drop']", function() {
		// получаем название id
 		var elid = $(this).attr('id');
		// создаем массив для разделенных строк
		var temp = new Array();
		// делим строку id на 2 части
		temp = elid.split('-');
		// получаем значение после тире тоесть индекс изображения в массиве
		dataArray.splice(temp[1],1);
		// Удаляем старые эскизы
		$("#dropped-files > div").remove();
		// Обновляем эскизи в соответсвии с обновленным массивом
		addImage(-1);
	});
	
	// Удалить все изображения кнопка 
	$('#dropped-files #upload-button .delete').click(restartFiles);
	
	// Простые стили для области перетаскивания
	$('#drop-files').on('dragover', function (e) {
		$(this).css({'border': '4px dashed rgba(60, 118, 61, 0.7)'});
		return false;
	});
	
	$('#drop-files').on("dragleave", function(e){	
		$(this).attr("style", "");
	});	
	
	$('#drop-files').on('drop', function() {	
		$(this).attr("style", "");
		return false;
	});
});

//загрузка изображений к объявлению
function addPhoto(postUrl, uploaddir, backUrl){
	if(dataArray.length == 0){
		if(backUrl != ""){
			window.location = backUrl;
		}else{return false;}
	};
	
	$("#loading").show();	
	var totalPercent = 100 / dataArray.length,
		x = 0;
	$('#loading-content').html('Загружен '+dataArray[0].name);	
	$.each(dataArray, function(index, file) {
		dataArray[index]["uploaddir"] = uploaddir;
		$.post(postUrl, dataArray[index], function() {
			x++;
			$('.progress-bar').css({'width' : totalPercent*(x)+'%'});
			if(totalPercent*(x) == 100) {				
				if(backUrl != ""){
					$(".load").hide();
					window.location = backUrl;
				}else{$(".load").hide(); return false;}
				setTimeout(restartFiles, 1000);
			}
		});
	});
}

// Загрузка изображений на сервер
function addPhotoToServer(id,copyright)
{
	var topic_id = $("[name=topic_id]:checked").val();
	//если фото нет, переходит на страницу результата
	if(dataArray.length == 0){
        if(copyright == 0) {
            window.location = "?task=profile&action=mytype&active=1&parent_id=all&topic_id=" + topic_id;
        }else{
            window.location = "?task=profile&action=mytype&copyright=1&active=1&parent_id=all&topic_id=" + topic_id;
        }
	};
	
	// Показываем прогресс бар
	$("#loading").show();
	// переменные для работы прогресс бара
	var totalPercent = 100 / dataArray.length;
	var x = 0;
	
	$('#loading-content').html('Загружен '+dataArray[0].name);
	// Для каждого файла
	var path = $('#photo-folder').val();
	$.each(dataArray, function(index, file) {
		// загружаем страницу и передаем значения, используя HTTP POST запрос 
		if(index == 0){
			dataArray[index]["main_photo"] = 1;
		}
		var obj = $("#img-"+index+" .image"),
			grd = 0;
		try{
			var str = $(obj).attr("class").match(/\d+/);
			if(str != null){
				grd = parseInt(str);
			}
		}catch(err){}
		dataArray[index]["rotate"] = grd;
		$.post('?task=media&action=push_photo', dataArray[index], function(data) {
	//	$.post('/application/includes/upload.php', dataArray[index], function(data) {
		//функция запроса имен файлов// 
	//	console.log(dataArray[index].name);
	//	console.log(dataArray[index].value);

		//функция запроса имен файлов// 
			var fileName = dataArray[index].name;
			++x;
			// Изменение бара загрузки
			$('.progress-bar').css({'width' : totalPercent*(x)+'%'});
			// Если загрузка закончилась
			if(totalPercent*(x) == 100) {
				// Загрузка завершена
				//$('#loading-content').html('Загрузка завершена!');

				if(copyright == 0) {
                    window.location = "?task=profile&action=mytype&active=1&parent_id=all&topic_id=" + topic_id;
                }else{
                    window.location = "?task=profile&action=mytype&copyright=1&active=1&parent_id=all&topic_id=" + topic_id;
				}
				
				// Вызываем функцию удаления всех изображений после задержки 1 секунда
				setTimeout(restartFiles, 1000);
			// если еще продолжается загрузка	
			} else if(totalPercent*(x) < 100) {
				// Какой файл загружается
				//$('#loading-content').html('Загружается '+fileName);
			}
			
			// Формируем в виде списка все загруженные изображения
			// data формируется в upload.php
			var dataSplit = data.split(':');
			if(dataSplit[2] == 'загружен успешно') {
				$('#photo-folder').val(dataSplit[3]); 
				$('#uploaded-files').append('<li><a href="images/'+dataSplit[0]+"/"+dataSplit[1]+'">'+fileName+'</a> загружен успешно</li>');
			} else {
				$('#uploaded-files').append('<li><a href="images/'+data+'. Имя файла: '+dataArray[index].name+'</li>');
			}
			ajaxPhoto();
			
		});
	});
	// Показываем список загруженных файлов
	$('#uploaded-files').show();
	return false;
};

var $ = jQuery.noConflict();
function ajaxPhoto() {
	var id = document.getElementById('id').value
	jQuery.ajax({
		type: 'POST',
		url: '?task=media&action=get_photos', 
		data: 'id=' + id, 
		success: function(html) { 
			document.getElementById('photos').innerHTML = html;
		}
	})
}
function deletePhoto(id) {
	
	jQuery.ajax({
		type: 'POST',
		url: '?task=media&action=delete_photo', 
		data: 'id=' + id, 
		success: function(html) { 
			if(html == "ok"){
				ajaxPhoto()
			} else {
				alert("Ошибка удаления (error 1302)."+ html);
			}
		}
	});
};

function DeletePhotoByWay(way){
	alertify.confirm("Удалить фотографию?", function(result){
		if(result){
			$.post("?task=media&action=delete_photo", "way="+way, function(html){
				$("[data-way='"+way+"']").parent().remove();
				alertify.success("Фото удалено.");
			})
		}
	})
}