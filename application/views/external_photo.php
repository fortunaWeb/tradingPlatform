<?php

if (!empty($data)){
	foreach ($data as $key => $photo) {
		$path = $photo['people_id']."/".$photo['var_id'];
		echo  "<img src = 'http://fortunasib.ru/images/{$path}/{$photo['photo']}'><br/><br/>";
	}
}