<?php
	$photo_query = "SELECT * FROM `re_photos` where `var_id` = '".$_SESSION['cur_var'] ."'";
	$p_res = mysql_query($photo_query);
	$p_num = mysql_num_rows($p_res);
if ($p_num <= 15){
//	$path = $_GET['path'];
	$file = $_POST['value'];
	$name = $_POST['name'];
	
	$uploaddir = $_SERVER['DOCUMENT_ROOT'] .'/images/'. $_SESSION['user'] .'/'. $_SESSION['cur_var'];
	
	$getMime = explode('.', $name);
	$mime = end($getMime);
	$data = explode(',', $file);
	$randomName = substr_replace(sha1(microtime(true)), '', 12) .'.'. $mime;

	// Декодируем данные, закодированные алгоритмом MIME base64
	$encodedData = str_replace(' ','+',$data[1]);
	$decodedData = base64_decode($encodedData);

	// Создаем изображение на сервере
	file_put_contents($uploaddir ."/". $randomName, $decodedData);
	if(file_exists($uploaddir ."/". $randomName)) {
	
		echo $uploaddir .":".$randomName.":загружен успешно";
		$cur_date = date("Y-m-d H:i");
		$query = "INSERT INTO `re_photos` (`var_id`, `photo`, `user_id`, `date_added`) VALUES ('". $_SESSION['cur_var'] ."', '". $randomName ."', '". $_SESSION['user'] ."', '". $cur_date ."')";
	} else {
		// Показать сообщение об ошибке, если что-то пойдет не так.
		echo "Что-то пошло не так. Убедитесь, что файл не поврежден!";
	}
	
	
	
	
	
	
	
	
	file_put_contents($uploaddir, $decodedData);
	if(file_exists($uploaddir)) {
		@mkdir($uploaddir, 0777);
		echo $uploaddir .":". $_POST['name'] .":загружен успешно";
	} else {
		// Показать сообщение об ошибке, если что-то пойдет не так.
		echo "Что-то пошло не так. Убедитесь, что файл не поврежден!";
	}
}
/*	if(empty($path)){
       do {
            $randomString = md5(microtime() . rand(0, 9999));
            $uploaddir = "../../images/tmp" . "/".$randomString;
            $path = "images/tmp" . "/".$randomString;
        } while (file_exists($uploaddir));	 
		@mkdir($uploaddir, 0777);
	}else{
	   	$uploaddir = '../../'.$path;
	   	@mkdir($uploaddir, 0777);
	}


	// Получаем расширение файла
	$getMime = explode('.', $name);
	$mime = end($getMime);

	// Выделим данные
	$data = explode(',', $file);
	$randomName = substr_replace(sha1(microtime(true)), '', 12).'.'.$mime;

	// Декодируем данные, закодированные алгоритмом MIME base64
	$encodedData = str_replace(' ','+',$data[1]);
	$decodedData = base64_decode($encodedData);

	// Создаем изображение на сервере
	file_put_contents($uploaddir ."/". $randomName, $decodedData);
	if(file_exists($uploaddir ."/". $randomName)) {
		echo $uploaddir .":".$randomName.":загружен успешно".":".$path;
	} else {
		// Показать сообщение об ошибке, если что-то пойдет не так.
		echo "Что-то пошло не так. Убедитесь, что файл не поврежден!";
	}

*/