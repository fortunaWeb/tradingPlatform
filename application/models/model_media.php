<?php
class Model_Media extends Model
{
	public function push_photo()
	{	
		$file = $_POST['value'];
		$name = $_POST['name'];
		if($_POST["uploaddir"]){
			$uploaddir = $_POST["uploaddir"];
		}else{
			$uploaddir = $_SERVER['DOCUMENT_ROOT'] .'images/'. $_SESSION['people_id'] .'/'. $_SESSION['cur_var'];
		}

        if (!file_exists($uploaddir)) {
            @mkdir($_SERVER['DOCUMENT_ROOT'] .'/images/'. $_SESSION['people_id'] .'/'. $_SESSION['cur_var'], 0777);
        }

		$getMime = explode('.', $name);
		$mime = end($getMime);
		$data = explode(',', $file);
		//$randomName = substr_replace(sha1(microtime(true)), '', 12) .'.'. $mime;
		$randomName = substr_replace(sha1(microtime(true)), '', 12) .'.jpg';
		if(isset($_POST["main_photo"])){
			//$mainName = "main.".$mime;
			$mainFile = $uploaddir ."/main.jpg";
		}
		// Декодируем данные, закодированные алгоритмом MIME base64
		$encodedData = str_replace(' ','+',$data[1]);
		$decodedData = base64_decode($encodedData);
		
		$file = $uploaddir ."/". $randomName;
		// Создаем изображение на сервере

		file_put_contents($file, $decodedData);
		
		if(file_exists($file)) {
			try{
				$thumb = PhpThumbFactory::create($file);
				$thumb->resize(600);
				if($_POST["rotate"]>0){
					$thumb->rotateImageNDegrees(-$_POST["rotate"]);
				}
				$thumb->save($file);
				if(isset($_POST["main_photo"]) && !file_exists($mainFile)){					
					$thumb = PhpThumbFactory::create($file);
					$thumb->resize(200);
					$thumb->save($mainFile);					
				}
			}catch(Exception $ex){echo $ex;}
			unset($thumb);
			// echo "<script>console.log('push')</script>";
			// echo $uploaddir .":".$randomName.":загружен успешно";
			//Helper::Add_watermark($file);
			if(!isset($_POST["uploaddir"])){
				$cur_date = date("Y-m-d H:i");
				$column = "var_id, photo, people_id, date_added";
				$values = "'". $_SESSION['cur_var'] ."', '". $randomName ."', '". $_SESSION['people_id'] ."', '". $cur_date ."'";
				
				DB::Insert("re_photos", $column, $values);		
			}
			
		} else {
			// Показать сообщение об ошибке, если что-то пойдет не так.
			echo "Что-то пошло не так. Убедитесь, что файл не поврежден!";
		}
		//	return $data_res;
		unset($_POST, $file, $name, $uploaddir, $getMime, $mime, $data, $randomName, $encodedData, $decodedData, $cur_date, $column, $values);
		
	}
	
	public function get_photos() 
	{
		if($_POST['id']) {
			$query = "SELECT * FROM `re_photos` where (`var_id` = '". $_POST['id'] ."')";
			$photos_res = mysql_query($query);
			$photos_num = mysql_num_rows($photos_res);
			if ($photos_num == 0) {
				$data = "Фотографий к данному варианту не найдено.";
			} else {
				$data = "<ul id='photo-block'>";
				for($j=0; $j<$photos_num; ++$j) {
					$photo = mysql_fetch_assoc($photos_res);
					//$photo['id'] = "'". $photo['id'] ."'";
					$data .= "<li id='photo-". $j ."'><img id='img-photo' src='images/". $photo['people_id'] ."/". $photo['var_id'] ."/". $photo['photo'] ."'><br /><span class='btndeletePhoto' onclick='deletePhoto({$photo['id']})'>удалить</span></li>";
				}
				$data .= "</ul>";
			}
		} else {
			$data = "Ошибка загрузки фотографий (error 1210).";
		}
		
		return $data;
	}
	
	public function delete_photo()
	{
		if($_POST['id']){
			$query_select = "SELECT * FROM `re_photos` where `id` = '". $_POST['id'] ."'";
			$res_select = mysql_query($query_select);
			$photo = mysql_fetch_assoc($res_select);
			unlink(''. $_SERVER['DOCUMENT_ROOT'] .'/images/'. $photo['people_id'] .'/'. $photo['var_id'] .'/'. $photo['photo'] .'');
			@unlink('/var/www/arendanovosib/images/'. $photo['people_id'] .'/'. $photo['var_id'] .'/'. $photo['photo'] .'');
			
			$query = "DELETE FROM `re_photos` where `id` = '". $_POST['id'] ."'";
			$res = mysql_query($query);
			if($res) {
				$data = "ok";
			} else {
				$data = "no2";
			}
		} else if($_POST["way"]){
			$photo_attr = explode("/", $_POST["way"]);
			$photo = $photo_attr[(count($photo_attr)-1)];
			DB::Delete("re_photos", "photo='".$photo."' AND people_id='".$_SESSION["people_id"]."'");
			unlink($_SERVER['DOCUMENT_ROOT'] .$_POST["way"]);
			$way = str_replace($photo, "", $_POST["way"]);
			Helper::Main_photo_update($way);
		}else{
			$data = "no";
		}
		return $data;
	}
	
	public function rotate(){
		if($_POST["way"] && $_POST["photo"]){
			$name_mime = explode(".", $_POST["photo"]);
			$file = $_SERVER['DOCUMENT_ROOT'].$_POST["way"].$_POST["photo"];
			$new_file = $name_mime[0].".jpg";
			$thumb = PhpThumbFactory::create($file);
			$thumb->rotateImage('CCW');
			unlink($file);
			$thumb->save($_SERVER['DOCUMENT_ROOT'].$_POST["way"].$new_file);
			DB::Update("re_photos", "photo='".$new_file."'", "id='".$_POST['photo_id']."'");
			unset($file, $thumb, $new_file);
			Helper::Main_photo_update($_POST["way"]);
			echo 1;
		}
	}
}
