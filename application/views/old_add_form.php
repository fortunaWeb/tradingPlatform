
<?php

/*
(`type_id`, `topic_id`, `city_id`, `metro_id`, `street`, `district`, `price`, `text`, `active`, `floor`, `floor_count`, `square_all`, `square_live`, `square_kitchen`, `bathroom`, `is_telephone`, `furniture`, `number`, `metro`)
*/

mysql_set_charset( 'utf8' );
$query = "SELECT * FROM `re_city`";
	$q_res = mysql_query($query);
	$q_num = mysql_num_rows($q_res);
		

	echo "<h2>Создание варианта</h2>";

?>





<form action="?task=profile&action=savevar" method="POST"/>
<div>
Я хочу
<label for="rent" id="label-rent" onClick="setCheck('rent')" style="background: orange">Сдать</label>
<label for="sell" id="label-sell" onClick="setCheck('sell')">Продать</label>
<input type="radio" name="topic_id" value="1" id="rent" class="invisible-input" checked="checked" required >
<input type="radio" name="topic_id" value="2" id="sell" class="invisible-input" required >
</div>

<br /><br /><br /><br /><br /><br /><br /><br />

<label>Город:</label>
<select type="text" name="city_id" id="city">
	<?php 
		for($j=0; $j<$q_num; ++$j) {
			$q_city = mysql_fetch_array($q_res);
			echo "<option value='". $q_city['city_id'] ."' >". $q_city['name'] ."</option>";
		}
	?>
</select>
<br />


<?php

	$query2 = "SELECT * FROM `re_street";
		$q_res2 = mysql_query($query2);
		$q_num2 = mysql_num_rows($q_res2);
		
		

		$data_dis = array();
		for($i=0; $i<$q_num2; ++$i) {
			$q_street = mysql_fetch_array($q_res2);
			$data_dis[$i] = array('district_id'=>$q_street['district_id'], 'district'=>$q_street['district'], 'street_id'=>$q_street['street_id'], 'name'=>$q_street['name']);
			
		}
	?>
	
		


<label>Улица</label>
				<input type="text" id="str" name="street" style="background: #F2D7E7;" required value="" 
					
					 autocomplete="off"/> 
					 <span style="background: white; padding: 3px; border: 1px solid grey;" id="str_button" placeholder="Поиск">Поиск</span>
				
					<span id="indicator" style="height:11px; display:none;">
					</span>
					<div id="street_choices" class="autocomplete" style="height:auto; display:none; height: auto; margin-left: 2%;" >
					</div>
							
<label>Район</label>
				<input type="text" id="dis" name="district" />
		
<label>№ Дома</label>
				<input type="text" id="dom" name="number" />
				
<label>Тип объекта</label>
				<select name="type_id" id="type_id">
				<?php
					if ($_GET['topic_id'] == '2') {
						$parent_id = "((`parent_id` = '". $_GET['topic_id'] ."') OR (`parent_id` = '3'))";
					} else {
						$parent_id = "(`parent_id` = '". $_GET['topic_id'] ."')";
					}
					$query3 = "SELECT * FROM `re_topic` where ". $parent_id ."";
					$q_res3 = mysql_query($query3);
					$q_num3 = mysql_num_rows($q_res3);
				
						for($j=0; $j<$q_num3; ++$j) {
							$q_type = mysql_fetch_array($q_res3);
								if ($q_type['parent_id'] == 3) {
									echo "<option value='". $q_type['id'] ."' >Новостройка: ". $q_type['name'] ."</option>";
								} else {
									echo "<option value='". $q_type['id'] ."' >". $q_type['name'] ."</option>";
								}
						}
				?>
</select>

<label>Метро</label>
				<input type="text" name="metro" id="metro" />

<label>Описание</label>
				<textarea id="text" name="text" cols="50" rows="10"> </textarea>	

<label>Цена</label>
				<input type="text" name="price" id="price" />
	
<label>Этаж / Этажность</label>
<input type="text" name="floor" id="floor" /> / <input type="text" name="floor_count" id="floor_count" />

<label>Площадь общая/жилая/кухня </label>
<input type="text" name="square_all" id="square_all" /> / <input type="text" name="square_live" id="square_live" /> / <input type="text" name="square_kitchen" id="square_kitchen" />

<label>Тип Ванной</label>
<select type="text" name="bathroom" id="bathroom">
	<option value="совмещенная">совмещенная</option>
	<option value="радельная">раздельная</option>
</select>
<label>Телефон / Мебель</label>
Телефон: <input type="checkbox" name="is_telephone" id="is_telephone" /> 
Мебель: <input type="checkbox" name="furniture" id="furniture" /> 

<script type="text/javascript">
	
						
							var ua = navigator.userAgent.toLowerCase();
							var isAndroid = ua.indexOf("android") > -1; //&& ua.indexOf("mobile");
							if(isAndroid) {
								document.getElementById('str').setAttribute('onchange', 'send()')
							//	document.getElementById('str_button').style.display = 'block';
							} else {
								document.getElementById('str').setAttribute('onkeyup', 'send()')
								document.getElementById('str_button').style.display = 'none';
							}						
													
																			
						  function send() {
							var var1 = document.getElementById('str').value
						//	document.getElementById('street_choices').innerHTML = document.getElementById('str').value
							document.getElementById('street_choices').innerHTML = '';
							
							jQuery.ajax({
								type: 'POST',
							    url: '?task=profile&action=search_street', 
							    data: 'street=' + var1, 
							    success: function(html) { 
											
											document.getElementById('street_choices').innerHTML = html;
											document.getElementById('street_choices').style.display = 'block';
									
										
								}
							})
							
							
						
						}
						
						function setStreet(j) {
						
							document.getElementById('str').value = document.getElementById('s'+j).innerHTML
							document.getElementById('street_choices').style.display = 'none';
							document.getElementById('dis').value = document.getElementById('d'+j).innerHTML
						}
						
						
</script>
<input type="hidden" name="user_id" value="<?php echo $_SESSION['user']; ?>" />
<input type="hidden" name="topic_id" value="<?php echo $_GET['topic_id']; ?>" />
<input type="submit" name="submit" id="submit" value="Создать"/>

</form>
