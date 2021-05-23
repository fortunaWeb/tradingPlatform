
<?php
print_r($_SESSION);


if ($_SESSION['user'])
	{
?>
<noscript>
<div style = 'text-align:center'>	
	<span>У Вас отключён JavaScript...</span>
	<br/>ВКЛЮЧИТЕ для корректной работы
</div>
</noscript>
<form  enctype="multipart/form-data"  action="/?task=profile&action=savevar_old" method="post">

<?php 
//if($mid == '513'){echo "smart_add.php";}else {echo "smart.php";}
?>



<table border="0" align="center" style="background:#eff5f8; border: 1px solid #e0e0e0; padding: 3px; width: 30%;">
	<tr>
		<td align = 'center' >
		<a href='#' style = 'font-size: 22px;fon-weight:bold;color : red' id = 'demize'	
		Onclick = "
			document.getElementById('demize').style.color ='red';
			document.getElementById('rent').style.color ='grey';

			document.getElementById('3').style.background ='#F2D7E7';
			document.getElementById('action').value ='demise';
			document.getElementById('rnt_nide').style.display ='inline';
			
			document.getElementById('flr').style.display ='inline';	
			document.getElementById('floor').style.display ='inline';	
			document.getElementById('demise').style.display ='inline';	

			document.getElementById('smotr_zaezd').style.display ='inline';	
			document.getElementById('hot').style.display ='inline';	
			document.getElementById('commiss').style.display ='inline';	
			document.getElementById('predopl').style.display ='inline';	

			document.getElementById('right_').style.display ='none';
			document.getElementById('left_').style.display ='none';
			document.getElementById('metro_').style.display ='none';

			document.getElementById('22').style.display ='inline';	
			document.getElementById('dop_v_stoim').style.display ='inline';	
			document.getElementById('komiss').innerHTML = ' Комиссия не менее : ';
			document.getElementById('tip_sdelki_txt').style.display ='';	
			document.getElementById('AN_comm').style.display ='';	
			document.getElementById('str').required = true;	
			document.getElementById('pokaz').style.display ='';	
			

		

			document.getElementById('ner').style.display ='inline';
			document.getElementById('depo').style.display ='inline';
			"
		>Сдам</a>
		
		</td>
		<td align = 'center'>
		<a id = 'rent' style = 'font-size: 22px;fon-weight:bold; color:grey' href = '#'
		Onclick = "
		
		document.getElementById('demize').style.color ='grey';
		document.getElementById('rent').style.color ='red';
		document.getElementById('3').style.color ='grey';
		document.getElementById('3').style.background ='';
		document.getElementById('action').value ='rent';
		document.getElementById('rnt_nide').style.display ='none';
		
		document.getElementById('flr').style.display ='none';
		document.getElementById('floor').style.display ='none';
		document.getElementById('demise').style.display ='none';

		document.getElementById('smotr_zaezd').style.display ='none';
		document.getElementById('hot').style.display ='none';
		/*document.getElementById('commiss').style.display ='none';	*/
		document.getElementById('predopl').style.display ='none';	
		document.getElementById('ner').style.display ='none';
		document.getElementById('metr').style.display = 'none';				
		document.getElementById('square').style.display = 'none';				
		document.getElementById('comnat').style.display = 'none';		

		document.getElementById('metro_').style.display ='block';

		document.getElementById('right_').style.display ='block';
		document.getElementById('left_').style.display ='block';

		document.getElementById('ner').style.display ='none';
		document.getElementById('22').style.display ='none';
		document.getElementById('dop_v_stoim').style.display ='none';	
		document.getElementById('komiss').innerHTML = ' По услугам готовы оплатить : ';
		document.getElementById('tip_sdelki_txt').style.display ='none';	
		document.getElementById('AN_comm').style.display ='none';	
		document.getElementById('pokaz').style.display ='none';	
		document.getElementById('str').required = false;	
		document.getElementById('houses').style.display = 'none';
		document.getElementById('depo').style.display ='none';
		"
		>Сниму</a>
		<input type="hidden" name="action" value="demise" id = 'action' />
		</td>
	</tr>
</table>
<table border="0" align="center" style="background:#eff5f8; border: 1px solid #e0e0e0; padding: 3px; width: 99%;">
	<tr>
		<td style = 'width:5%' colspan = '2'><br>
		</td>
	</tr>
	<tr>
		<td colspan = '2'>
		
					<select name='object' 
						OnChange = "
						document.getElementById('houses').style.display = 'none';
							if(document.getElementById('action').value != 'rent'){
								if(this.value =='4' || this.value =='5'|| this.value =='15'|| this.value =='16')
									 {
											document.getElementById('metr').style.display = 'block'; 
											document.getElementById('comnat').style.display = 'block';
											document.getElementById('comnat_h').style.display = 'block';
											document.getElementById('square').style.display = 'none';
									}
										else
									{ 
										document.getElementById('metr').style.display = 'none'; 	
										document.getElementById('comnat').style.display = 'none';
										document.getElementById('comnat_h').style.display = 'none';
										document.getElementById('square').style.display = 'block';
									}

								if(this.value =='6'||this.value =='16'||this.value =='19')
										{	
										document.getElementById('metr').style.display = 'block';
										document.getElementById('comnat').style.display = 'none';
										document.getElementById('comnat_h').style.display = 'none';
										document.getElementById('square').style.display = 'none';
										} 
								if(this.value =='20'||this.value =='13'){	
										document.getElementById('metr').style.display = 'none';
										document.getElementById('comnat').style.display = 'none';
										document.getElementById('comnat_h').style.display = 'none';
										document.getElementById('square').style.display = 'none';
										}									
								if(this.value =='2'||this.value =='3'||this.value =='17'||this.value =='18'){	
										document.getElementById('comnat_h').style.display = 'block';
										document.getElementById('comnat').style.display = 'none';
										document.getElementById('square').style.display = 'block';
										
										document.getElementById('houses').style.display = 'block';
										}
								if(this.value!='0')this.style.background = '';
									document.getElementById('obj_f').value = this.value;
						}else{
							 
									document.getElementById('metr').style.display = 'none'; 
									document.getElementById('comnat').style.display = 'none';
									document.getElementById('comnat_h').style.display = 'none';
									document.getElementById('square').style.display = 'none';
									document.getElementById('ner').style.display = 'none';
																	
									if(this.value!='0')this.style.background = '';
									document.getElementById('obj_f').value = this.value;
								
						}
						if(this.value =='4' || this.value =='5'|| this.value =='15'|| this.value =='16'|| this.value =='19'|| this.value =='6'){
									var objSel = document.getElementById('price_comm'); 
									objSel.options[0].disabled = true;
									objSel.options[1].disabled = true;
									objSel.options[2].disabled = true;
									objSel.options[3].disabled = true;
									objSel.options[4].selected=true;

								}else{
								var objSel = document.getElementById('price_comm'); 
									objSel.options[0].disabled = false;
									objSel.options[1].disabled = false;
									objSel.options[2].disabled = false;
									objSel.options[3].disabled = false;
						}
						"

					id='2'   style = ' background: #F2D7E7; color:grey' >
						<option value='0' selected><font color="red">- Объект -</font></option>
						<option value='15' <?php if ($object == '15') echo " selected"; ?> >койко-место</option>
						<option value='4' <?php if ($object == '4') echo " selected"; ?> >комнату</option>
						<option value='19' <?php if ($object == '19') echo " selected"; ?> >две комнаты</option>
						<option value='5' <?php if ($object == '5') echo " selected"; ?> >коммуналку</option>
						<option value='16' <?php if ($object == '16') echo " selected"; ?> >две коммуналки</option>
						<option value='6' <?php if ($object == '6') echo " selected"; ?> >общежитие</option>
						<option value='7' <?php if ($object == '7') echo " selected"; ?> >малосемейку</option>
						<option value='8' <?php if ($object == '8') echo " selected"; ?> >1-комнатную</option>
						<option value='9' <?php if ($object == '9') echo " selected"; ?> >2-комнатную</option>
						<option value='10' <?php if ($object == '10') echo " selected"; ?> >3-комнатную</option>
						<option value='11' <?php if ($object == '11') echo " selected"; ?> >4-комнатную</option>
						<option value='12' <?php if ($object == '12') echo " selected"; ?> >5-комнатную</option>
						<option value='2' <?php if ($object == '2') echo " selected"; ?> >ч\дом</option>
						<option value='17' <?php if ($object == '17') echo " selected"; ?> >1/2 ч.дома</option>
						<option value='3' <?php if ($object == '3') echo " selected"; ?> >коттедж</option>
						<option value='18' <?php if ($object == '18') echo " selected"; ?> >1/2 коттеджа</option>
						<option value='20' <?php if ($object == '20') echo " selected"; ?> >дача</option>
						<option value='13' <?php if ($object == '13') echo " selected"; ?> >офис</option>
						
					</select>
					<input type = 'hidden' value = '' id = 'obj_f'>
				&nbsp;&nbsp;		
					<select name='conti' OnChange = '	if(this.value!="0")this.style.background = "";' id='3'  style = '  color:grey;background: #F2D7E7;'>
						<option value='0'>-планировка-</option>
						<option value='1' <?php if ($conti == '1') echo " selected"; ?> >смежная </option>
						<option value='2' <?php if ($conti == '2') echo " selected"; ?>>изолированная</option>
						<option value='3' <?php if ($conti == '3') echo " selected"; ?>>смежно-изолированная</option>		
						<option value='4' <?php if ($conti == '4') echo " selected"; ?>>студия</option>						
						<option value='6' <?php if ($conti == '6') echo " selected"; ?>>улучшенной планировки</option>						
							
					</select>
					&nbsp;&nbsp;					
					<select name='area'  id='4'  OnChange = '	if(this.value!="0")this.style.background = "";
					document.getElementById("area_f").value = this.value;
					
					
					'  style = ' color:grey; background: #F2D7E7;'>
						<option value='0' >- Район -</option>
						<option value='2' <?php if ($area == '2') echo " selected"; ?> >Жел/дор</option>
						<option value='3' <?php if ($area == '3') echo " selected"; ?>>Заельцовский</option>
						<option value='4'<?php if ($area == '4') echo " selected"; ?>>Центральный</option>
						<option value='5'<?php if ($area == '5') echo " selected"; ?>>Октябрьский</option>
						<option value='6'<?php if ($area == '6') echo " selected"; ?>>Дзержинский</option>
						<option value='7'<?php if ($area == '7') echo " selected"; ?>>Калининский</option>
						<option value='8'<?php if ($area == '8') echo " selected"; ?>>Ленинский</option>
						<option value='9'<?php if ($area == '9') echo " selected"; ?>>Кировский</option>
						<option value='10'<?php if ($area == '10') echo " selected"; ?>>Первомайский</option>
						<option value='11'<?php if ($area == '11') echo " selected"; ?>>Советский</option>
						
						<?php /*<option value='16'<?php if ($area == '16') echo " selected"; ?>>По метро</option>
*/?>
						<option value='18' id = 'right_'  style = 'display:none' <?php if ($area == '18') echo " selected"; ?>>Правый берег</option>
						<option value='17' id = 'left_'  style = 'display:none' <?php if ($area == '17') echo " selected"; ?>>Левый берег</option>
						
						<option value='12'<?php if ($area == '12') echo " selected"; ?>>ВАСХНИЛ</option>
						<option value='13'<?php if ($area == '13') echo " selected"; ?>>г. Бердск</option>
						<option value='14'<?php if ($area == '14') echo " selected"; ?>>г. Обь</option>
						<option value='15'<?php if ($area == '15') echo " selected"; ?>>НСО</option>
						<option value='20'<?php if ($area == '20') echo " selected"; ?>>пос.Элитный</option>
						<option value='21'<?php if ($area == '21') echo " selected"; ?>>Кудряши</option>
						<option value='22'<?php if ($area == '22') echo " selected"; ?>>Криводановка</option>
						<option value='23'<?php if ($area == '23') echo " selected"; ?>>ОбьГЭС</option>
						<option value='24'<?php if ($area == '24') echo " selected"; ?>>Кольцово</option>
						<option value='25'<?php if ($area == '25') echo " selected"; ?>>Толмачево</option>
						<option value='26'<?php if ($area == '26') echo " selected"; ?>>пос.Мочище</option>
						<option value='27'<?php if ($area == '27') echo " selected"; ?>>ст.Мочище</option>
						<option value='28'<?php if ($area == '28') echo " selected"; ?>>Пашино</option>
						<option value='29'<?php if ($area == '29') echo " selected"; ?>>Раздольное</option>
						</select>
					<input type = 'hidden' value = '' id = 'area_f'>
						&nbsp;&nbsp;
			<div id = 'rnt_nide' style = 'display: inline-block;'>

			<span>
				<font style = "color :grey; font-size:13px;">УЛ.</font>
				<input type="text" id="str" name="street" style="background: #F2D7E7;" required value="<?php if($data_res['street']) {echo $data_res['street']; } ?>" 
					
					 autocomplete="off"/> <div class="street_list" style="display: none"> </div>
					 <span style="background: white; padding: 3px; border: 1px solid grey;" id="str_button" placeholder="Поиск">Поиск</span>
				
					<span id="indicator" style="height:11px; display:none;">
					</span>
					<div id="street_choices" class="autocomplete" style="height:auto; display:none; height: auto; margin-left: 2%;" >
					</div>
						<?php  // echo $_SERVER['HTTP_USER_AGENT']; ?>
						

						<input  style = '  color:grey;background: #F2D7E7;' id = 'hs' type="text" onClick = 'this.value = "";' 
						OnChange = "if(this.value!=''){ this.style.background = '';document.getElementById('hs').style.background = '';} "
						name="house" size = '8' value =" № дома " /> 
						<font color=grey id = 'ili'>ИЛИ </font>
						<input  style = ' color:grey; background: #F2D7E7;' id = 'stat' type="text" name="station" size = '15' 
						OnChange = "if(this.value!=''){ this.style.background = '';document.getElementById('stat').style.background = '';} "
						onClick = 'this.value = "";' value ="остановка" />
						
			</div>
							
				</td>
				</tr>
				<tr width="100% !important">
					<td><br>
						 <h1_red>если метро дальше чем 700 метров выбирайте параметр "до метро большее 700 метров"</h1>
					<div id = 'metro_' style = 'display:none'>
							<input    type = 'checkbox' name = 'metro_'    value = '1' >
							В пешей досягаемостит от метро
					</div>
					</td>
				</tr>
				<tr id = 'demise'>
					<td colspan = 2 style = ' color:grey;'>
					<div  style = 'display : inline'>
					
					
					<select name='metro' id = '28' style = 'color:grey;background: #F2D7E7;' 
						OnChange = 'if(this.value!="1"){this.style.background = "";}else{this.style.background = "#F2D7E7"}'>
						<option value='1' selected >- Станция метро -</option>
						<option value='0'  style = 'font-weight:bold'><b> - До метро больше 700 метров - </b></option>
						<option value='Пл.Маркса'>Плoщадь Маркса</option>
						<option value='Студенческая'>Студенческая</option>
						<option value='Речной вокзал'>Речной вокзал</option>
						<option value='Октябрьская'>Октябрьская</option>
						<option value='Пл.Ленина'>Площадь Ленина</option>
						<option value='Кр.Пр/Сибирская'>Красный проспект/Сибирская</option>
						<option value='Гагаринская'>Гагаринская</option>
						<option value='Заельцовская'>Заельцовская</option>
						<option value='Пл.Г-Михайловского'>Площадь Гарина-Михайловского</option>
						<option value='Маршала Покрышкина'>Маршала Покрышкина</option>
						<option value='Березовая роща'>Березовая роща</option>
						<option value='Золотая Нива'>Золотая Нива</option>
						
					
					</select>
						&nbsp;&nbsp;
						<select name="flr" id = 'flr'  style = "color :grey; background: #F2D7E7;"  OnChange = 'if(this.value!=""){this.style.background = "";}'>
										<option value="">Этаж</option>
										<option value="ср">Средний</option>
											<?php
											
											for($i=1; $i<=30; $i++)
												{
												$flr = $i;
												echo "<option value='{$flr}'";
													
													echo " >{$i}</option>";
												}
											?>					
									</select>
										
									&nbsp;&nbsp;
						<select name="floor"  id = 'floor' style = "color :grey; background: #F2D7E7;" OnChange = 'if(this.value!=""){this.style.background = "";}' >
										<option value="">Этажность</option>
											<?php
											for($i=1; $i<=30; $i++)
												{
												$floor = $i;
												echo "<option value='{$floor}'";
													
													echo " >{$i}</option>";
												}
											?>					
							</select>
												
										
			
				
				
				
					&nbsp;&nbsp;</div>
			 <select name='period' id = '22'   style = ' background: #F2D7E7;color:grey;' OnChange = '
				if(this.value!="0")this.style.background = "";' >
						<option value='0' selected>- Период сдачи -</option>
						<option value='14' >Длительно</option>
						<option value='15' >На продаже</option>
						<option value='13' >Лето</option>
						<option value='1' >1 мес.</option>
						<option value='2' >2 мес.</option>
						<option value='3' >3 мес.</option>
						<option value='4' >4 мес.</option>
						<option value='5' >5 мес.</option>
						<option value='6' >6 мес.</option>
						<option value='7' >7 мес.</option>
						<option value='8' >8 мес.</option>
						<option value='9' >9 мес.</option>
						<option value='10' >10 мес.</option>
						<option value='11' >11 мес.</option>
						<option value='12' >12 мес.</option>
						
					</select> 
					</td>
			</tr>
			
			<tr>
				<td><br>
				</td>
			</tr>
	</table>
	<table border="0" align="center" style="background:#eff5f8; border: 0px solid #e0e0e0; padding: 3px; width: 99%;">
			<tr>
				<td colspan = '1' style = 'width: 45%'>
				
		<font style ='font-size: 13px;color:grey;'>
			<input type='checkbox' class='phones' name='tel' value='1' <?php if ($tel =='1'){ echo "checked";} ?> />	ТЕЛ
			<input type='checkbox' class='phones' name='meb' value='1'  <?php if ($meb=='1'){ echo "checked";} ?> />	МЕБ
			<input type='checkbox' class='phones' name='hol' value='1'  <?php if ($hol=='1'){ echo "checked";} ?> />	ХОЛ
			<input type='checkbox' class='phones' name='tv' value='1'  <?php if ($tv=='1'){ echo "checked";} ?> />	TV
			<input type='checkbox' class='phones' name='stir' value='1'  <?php if ($stir=='1'){ echo "checked";} ?>/>	СТИР
		<div id = 'ner' style = 'display : inline;'>
		<br>
		<input type='checkbox' class='phones' name='ner' value='1'   <?php if ($ner=='1'){ echo "checked";} ?>/> БЕРУТ НЕРУССКИХ	
		<input type='checkbox' class='phones' name='stud' value='1'   <?php if ($stud=='1'){ echo "checked";} ?>/> БЕРУТ СТУДЕНТОВ	
			</font>	
			</td>
			<td>
			
				<div id = 'metr' style ='font-size: 13px;color:grey;display:none;' 
						
						>
						<?php $metr =  $_REQUEST['metr']; ?>
						<input onClick = 'this.value = "";'
						type = 'text' value = '<?php if($metr!=''){echo $metr;}else{echo "метраж";} ?>' style = ' background: #F2D7E7;color:grey' 
						name = 'metr' id= '9' size = '6' OnChange = 'if(this.value!=""){this.style.background = "";}'> 
					
						 КОГО БЕРУТ
					<font style ='font-size: 16px;color:grey;'>
							<input id = '10' type = 'checkbox'  name = 'who1' value='-всех-' <?php if ($who== '-всех-')echo " checked";?>>-всех-
							<input id = '11' type = 'checkbox' name = 'who2' value='1ж' <?php if ($who== '1ж')echo " checked";?>>1ж
							<input id = '12' type = 'checkbox' name = 'who3' value='1м' <?php if ($who== '1м')echo " checked";?>>1м
							<input id = '13' type = 'checkbox' name = 'who4' value='2ж' <?php if ($who== '2ж')echo " checked";?>>2ж
							<input id = '14'  type = 'checkbox' name = 'who5'  value='2м' <?php if ($who== '2м')echo " checked";?>>2м
							<input id = '15'  type = 'checkbox' name = 'who6' value='сп' <?php if ($who== 'сп')echo " checked";?>>сп
							<input id = '16'  type = 'checkbox' name = 'who7' value='сп+р' <?php if ($who== 'сп+р')echo " checked";?>>сп+р
							<input id = '27'  type = 'checkbox' name = 'who8' value='ж+р' <?php if ($who== 'ж+р')echo " checked";?>>ж+р
					</font>
			</div>	
			
			<div id = 'square' style ='font-size: 13px;color:grey;display:none;'>
						ПЛ: 
						 ОБЩ <input  
						 OnChange = "
								if(this.value!=''){ 
									this.style.background = '';
									document.getElementById('s_o').style.background = '';
								}
							"
						 style = ' color:grey; background: #F2D7E7;' type="text" name="s_o" size = '3'  id='s_o' />
					 	 ЖИЛ <input  style = ' color:grey; background: #F2D7E7;' type="text" name="s_j" size = '3' OnChange = 'if(this.value!=""){this.style.background = "";}' />
						 КУХ <input  style = ' color:grey; background: #F2D7E7;' type="text" name="s_k" size = '3' OnChange = 'if(this.value!=""){this.style.background = "";}' />
					
			</div>
			
			
			</td>
			</tr>
			<tr >
			<td colspan = '2'>
			
			<table>
				<tr>
					<td>
				<div id = 'comnat_h' style ='font-size: 13px;color:grey;display:none; width:100%;'>
					ЧИСЛО КОМНАТ В КВАРТИРЕ 
						<select name='comn' id = 'comn' style = 'font-size: 13px;color:grey;background: #F2D7E7;color:grey' OnChange = 'if(this.value!=""){this.style.background = "";}'>
								<option value='' selected>-++-</option>
								<option value='1' >1</option>
								<option value='2'>2</option>
								<option value='3'>3</option>
								<option value='4'>4</option>
								<option value='5'>5</option>
								<option value='6'>6</option>
						</select>
				</div>
					</td>
					<td style = 'width:150px;'></td>
					<td >
				<div id = 'comnat' style ='font-size: 13px;color:grey;display:none; width:100%;' >
						КТО ПРОЖИВАЕТ В КВАРТИРЕ :
				<input type = 'text' name="who_p" id="who_p" style  = 'background: #F2D7E7;width:200px;' value = '' OnChange = 'if(this.value!=""){this.style.background = "";}' >
				</div>
					</td>

				</tr>		
					
			</table>
			
			</td>
			
		</tr>
		<tr >
			<td><div  id = 'houses' style = 'display:none;'>
				<table style = 'width: 90%'>
					<tr>
						<td>
							<select name='otopl' id = 'otopl' style = 'font-size: 13px;color:grey;background: #F2D7E7;color:grey' OnChange = 'if(this.value!=""){this.style.background = "";}'>
								<option value=''>-=Отопление=-</option>
								<option value='gaz'>Газовое</option>
								<option value='pech'>Печное</option>
								<option value='centr'>Центральное</option>
							</select>
						<td>
							<select name = 'water'  id = 'water' style = 'font-size: 13px;color:grey;background: #F2D7E7;color:grey' OnChange = 'if(this.value!=""){this.style.background = "";}'>
								<option value = ''>-=Вода=-</option>
								<option value = 'dom'>В доме</option>
								<option value = 'kolonka'>В колонке</option>
							</select>
						<td>
							<select name = 'sliv' id = 'sliv'  style = 'font-size: 13px;color:grey;background: #F2D7E7;color:grey' OnChange = 'if(this.value!=""){this.style.background = "";}'>
								<option value = ''>-=Слив=-</option>
								<option value = 'yama'>Яма</option>
								<option value = 'centr'>Центральная</option>
							</select>
					<tr>
						<td>
							<select name = 'toilet' id = 'toilet' style = 'font-size: 13px;color:grey;background: #F2D7E7;color:grey' OnChange = 'if(this.value!=""){this.style.background = "";}'>
								<option value = ''>-=Туалет=-</option>
								<option value = 'dom'>В доме</option>
								<option value = 'out'>На улице</option>
							</select>
						<td>
							<select name = 'mashina' id = 'mashina' style = 'font-size: 13px;color:grey;background: #F2D7E7;color:grey' OnChange = 'if(this.value!=""){this.style.background = "";}'>
								<option value = ''>-=Место под машину=-</option>
								<option value = 'in'>В ограде</option>
								<option value = 'out'>Возле ограды</option>
								<option value = 'no'>Отсутствует</option>
							</select>
						<td>
							<select name = 'washing' id = 'washing' style = 'font-size: 13px;color:grey;background: #F2D7E7;color:grey' OnChange = 'if(this.value!=""){this.style.background = "";}'>
								<option value = ''>-=Мыться=-</option>
								<option value = 'banya'>Баня</option>
								<option value = 'dush'>Душ</option>
								<option value = 'no'>Негде</option>
							</select>	
					<tr>
						<td colspan = 3><div id = 'half_house' style = 'display:none' valign = middle>
							Во второй половине живут соседи : 
                  <textarea  name="neigh" id = 'neigh' cols="50" rows="2"></textarea>
                  	</div>
                  </table>

			</div>
		</tr>
			<tr >
		
		<td valign="top" align="left" colspan = '2' >
		<br>
			<font color="grey" style ='font-size: 13px;'>CТОИМОСТЬ, ВКЛЮЧАЯ КОММУНАЛЬНЫЕ УСЛУГИ:  </font>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input type="text"  OnKeyUp = "if(this.value!='') this.style.background = '';"
									  name="price" id="5" 
			style = ' background: #F2D7E7;' value ="<?php if(isset($price)){echo $price;} ?>" size = '7' required onchange='validatePrice()' />
			<select name='dlit'  id='111'    style = 'color:grey;' >
						
						<option value='1' <?php if ($dlit == '1') echo " selected"; ?> >мес</option>
						<option value='2' <?php if ($dlit == '2') echo " selected"; ?> >сут</option>
						
			</select>
			<div id = 'predopl' style = 'display:inline'>
	<font color="grey" style ='font-size: 13px;'>		ПРЕДОПЛАТА 3A:  </font>
			 <select name='predopl' id = '29'   style = ' background: #F2D7E7;color:grey;' OnChange = '
				if(this.value!="0")this.style.background = "";' >
						<option value='1'  selected>1 мес.</option>
						
						<option value='2' >2 мес.</option>
						<option value='3' >3 мес.</option>
						<option value='4' >4 мес.</option>
						<option value='5' >5 мес.</option>
						<option value='6' >6 мес.</option>
						<option value='7' >7 мес.</option>
						<option value='8' >8 мес.</option>
						<option value='9' >9 мес.</option>
						<option value='10' >10 мес.</option>
						<option value='11' >11 мес.</option>
						<option value='12' >12 мес.</option>
						
			</select> 
			</div>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<div id = 'depo' style = 'display:inline;'>
		     <font style ='font-size: 13px;color:grey;'>ТОРГ </font>
			 <input type='checkbox' id = 'torg' name='torg' value='1' <?php if ($torg=='1'){ echo "checked";} ?> />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			 
			 <input  style = 'font-size: 13px;color:grey;'type="text"  name="deposit" value ="Депозит" size = '7' onClick = 'this.value = "";' />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</div>
		
		<div id = 'dop_v_stoim'>
			<br>
			<span style ='font-size: 13px;color :grey'>  за ВОДУ и СВЕТ : </span>
			<select id='svet' name = 'svet'>
			
			<option value = 'sy' selected>платить дополнительно</option>
			<option value = '' >оплата включена в цену</option>
			<option value = 'vyo' >дополнительно только за воду</option>
			<option value = 'syo' >дополнительно только за свет</option>
			</select>
			
			<!--
			свет по счетчику:<select id='svet' name = 'svet'>
			<option value = '' selected >-=С=-</option>
			<option value = 'sy'>Включено</option>
			<option value = 'sn'>Не включено</option>
			</select>
			вода по счетчику:<select id='voda' name = 'voda'>
			<option value = '' selected >-=В=-</option>
			<option value = 'vy'>Включено</option>
			<option value = 'vn'>Не включено</option>
			</select>
			
			телефон:<select id='telefon' name = 'telefon'>
			<option value = '' selected >-=Т=-</option>
			<option value = 'ty'>Включено</option>
			<option value = 'tn'>Не включено</option>
			</select>
			интернет:<select id='inet' name = 'inet'>
			<option value = '' selected >-=И=-</option>
			<option value = 'iy'>Включено</option>
			<option value = 'in'>Не включено</option>
			</select>
			-->
		</div>
		<br>
	<tr>
	<td colspan = 2>	

		<div id = 'commiss'>
				<span id = 'komiss'>	Комиссия не менее : </span><select style = ' background: #F2D7E7;color:grey;' id = 'price_comm' name='comm' style = 'font-size: 13px;color:grey;'  >
						<option value='50' <?php if ($comm == '50') echo " selected"; ?>>50%</option>
						<option value='55' <?php if ($comm == '55') echo " selected"; ?>>55%</option>
						<option value='60' <?php if ($comm == '60') echo " selected"; ?>>60%</option>
						<option value='65' <?php if ($comm == '65') echo " selected"; ?>>65%</option>
						<option value='70' <?php if ($comm == '70') echo " selected"; ?>>70%</option>
						<option value='75' <?php if ($comm == '75') echo " selected"; ?>>75%</option>
						<option value='80' <?php if ($comm == '80') echo " selected"; ?>>80%</option>
						<option value='85' <?php if ($comm == '85') echo " selected"; ?>>85%</option>
						<option value='90' <?php if ($comm == '90') echo " selected"; ?>>90%</option>
						<option value='95' <?php if ($comm == '95') echo " selected"; ?>>95%</option>
						<option value='100' <?php if ($comm == '100') echo " selected"; ?>>100%</option>
						
					</select>	
				<span id= 'tip_sdelki_txt'>	Тип сделки : </span>
				<select style = ' background: #F2D7E7;color:grey;' id = 'AN_comm' name='AN_comm' style = 'font-size: 13px;color:grey;' 
					OnChange = "if(this.value == 3){
								document.getElementById('premium_ch').disabled = true;
								document.getElementById('premium_ch').checked = false;
							}
								if(this.value == 2)document.getElementById('premium_ch').disabled = false;
								" >
						<option value='2' >50 на 50</option>
						<option value='2' disabled >На троих</option>
				</select>	 - "На троих"	запрещено!
				</DIV>
				</td>
		<tr>
			<td colspan = 2>
			<div id = 'pokaz'>
				<input type = radio name = who_show value = 1 OnClick = "document.getElementById('my_show').disabled = false;" checked>
				 - Mогу показать один за :
				<select style = 'color:grey;' id = 'my_show' name='my_show' style = 'font-size: 13px;color:grey;'  >
						<option value='0' > - = 0 рублей = -</option>
						<option value='500' > - = 500p = - </option>
						<option value='1000' > - = 1000p = - </option>
				</select>
				<br>
				<input type = radio name = who_show  value = 0 OnClick = "document.getElementById('my_show').disabled = true;document.getElementById('my_show').value = 0">
				 - Показ осуществляется только в присутствии второго риэлтора
			</div>
	</tr>
	</table>
<table border="0" align="center" style="background:#eff5f8; border: 0px solid #e0e0e0; padding: 3px; width: 99%;">
				<tr>
					<td><br>
					</td>
				</tr>
	
			<tr>
				<td colspan = '2' >
			
				
				<div  id = 'rent_text3' >
	<table border = '0'style="background:#eff5f8; border: 0px solid #e0e0e0; padding: 3px; width: 99%;">
				<tr>
					<td  >
					
					<div id='hot' style = "border: 0px solid red;margin-left:0px; height:35px;" >
							<table >
						<tr>
							<td  colspan = '2' >
							<font style = "color :grey; font-size:13px;">
							<input id = '21'
							OnChange = "
									if(this.checked){
										document.getElementById('smotr_zaezd').style.display ='none'
									}else
									{
										document.getElementById('smotr_zaezd').style.display ='block'
									}
									"
							type = "checkbox" value  = "1"   name = "publ"> ПОСМОТР, ОФОРМЛЕНИЕ И ЗАЕЗД СЕГОДНЯ</font> 
						</td>
						</tr>
						</table>
						</div>
						
					</td>
					<td colspan = 3  >
					<div id ='smotr_zaezd'   style = "border: 0px solid red;margin-left:10px; height:35px;">
					<table >
						<tr>
							<td  colspan = '2' >
						<font style = "color :grey; font-size:13px;">
								СМОТРЕТЬ И ОФОРМЛЯТЬ С :	</font>
									<select name="smotr_day" id = '17' style = "color :grey; background: #F2D7E7;"  OnChange = 'if(this.value!=""){this.style.background = "";}'>
										<option value="">Число</option>
											<?php
											for($i=1; $i<=31; $i++)
												{
												$day_num=$i;
												if ($i<=9)
													{
													$day_num="0{$i}";
													}
													echo "<option value='{$day_num}'>{$i}</option>";
												}
											?>					
										</select>
										<select id = '18' name="smotr_month" style = "color :grey;background: #F2D7E7;"  OnChange = 'if(this.value!=""){this.style.background = "";}'>
											<option value="">Месяц</option><option value="01">Январь</option><option value="02">Февраль</option><option value="03">Март</option><option value="04">Апрель</option><option value="05">Май</option><option value="06">Июнь</option><option value="07">Июль</option><option value="08">Август</option><option value="09">Сентябрь</option><option value="10">Октябрь</option><option value="11">Ноябрь</option><option value="12">Декабрь</option>
									</select>
								</td>
								<td style = "color :grey;font-size:13px;">
									ДАТА ЗАЕЗДА:
										<select name="zaezd_day" id = '19' style = "color :grey;background: #F2D7E7;"  OnChange = 'if(this.value!=""){this.style.background = "";}'>
												<option value="">Число</option>
												<?php
												for($i=1; $i<=31; $i++)
													{
													$day_num=$i;
													if ($i<=9)
														{
														$day_num="0{$i}";
														}
														echo "<option value='{$day_num}'>{$i}</option>";
													}
												?>					
										</select>
									<select name="zaezd_month" id = '20' style = "color :grey;background: #F2D7E7; "  OnChange = 'if(this.value!=""){this.style.background = "";}'>
										<option value="">Месяц</option><option value="01">Январь</option><option value="02">Февраль</option><option value="03">Март</option><option value="04">Апрель</option><option value="05">Май</option><option value="06">Июнь</option><option value="07">Июль</option><option value="08">Август</option><option value="09">Сентябрь</option><option value="10">Октябрь</option><option value="11">Ноябрь</option><option value="12">Декабрь</option>
									</select>
									
								</td>
								<tr>
							</table>
							</div>
						</td>		
					</tr>
				
			
				</table>
					<div>
				</td>
			
			</tr>			
		
	
	<tr>
		<td width = '1'>
			
		
		</td>
		<td>
			<table style="background:#eff5f8; border: 1px solid #e0e0e0; padding: 3px; width: 99%;">
				<tr>
				<td>
						
						<font style = "color :grey; font-size:13px;">
								ОПИСАНИЕ:	ЗАПРЕЩЕНО ПИСАТЬ НОМЕРА ТЕЛЕФОНОВ, АДРЕСА САЙТОВ, ПОЧТЫ И Т.Д. - ШТРАФ 200 РУБЛЕЙ.<br>
								ТАКЖЕ НЕЛЬЗЯ ПИСАТЬ СУММЫ,КОТОРЫЕ ВЫ ЖЕЛАЕТЕ ПОЛУЧИТЬ СО СДЕЛКИ. ЭТОТ ПАРАМЕТР УКАЗЫВАЙТЕ В КОМИССИИ
							</font>
					<br/>
						<textarea name="new_text_area" cols="70" rows="3" ></textarea>
								<input type = 'hidden' value = '0' id = 'clear_txt'><br/>
				</td>
				<td>
						<font style = "color :grey; font-size:13px;">
							СКРЫТОЕ ПРИМЕЧАЕНИЕ (ВИДНО ТОЛЬКО ВАМ В "ЛИЧНОМ КАБИНЕТЕ").<br>
					<textarea name="new_text_prim" cols="40" rows="3"></textarea>
				</td>
				
				</tr>
		</table>
				
			
		</td>
	</tr>
	</table>
	<!--
	<table  align = center style="background:#eff5f8; border: 0px solid #e0e0e0; padding: 3px; width: 99%;">
	<tr>
		<td valign="top" colspan = '1' align="left" >Звонить с 
			<select name = 'since' id='since'>
				<?php 
					echo "<option value = '' selected >звонить с</option>";
					for ($i=6; $i < 24; $i++) { 
						if($i <10 )$x = '0'.$i; else $x = $i;
						echo "<option value = '{$x}'>$x:00</option>";
					}
				?>
			</select>
			До 
			<select name = 'before' id='before'>
				<?php 
					echo "<option value = '' selected ;>звонить до</option>";
					for ($i=6; $i <= 23; $i++) { 
						if($i <10 )$x = '0'.$i; else $x = $i;
						echo "<option value = '{$x}'>$x:00</option>";
					}
				?>
			</select>
</table>
-->
<table>
	<tr>

	<td valign="top" colspan = '1' align="left" >		
			<td>
					<table align ='left' border ='0' style = 'wigth :100%'>
						<?php					
						if (trim($_SESSION['phone']) != "")
							{
						?>		
							<tr>
								<td align="left"  	valign="top"><font color="red"><strong>* </strong></font>
							
						<?php
							$phones = explode(" * ", $_SESSION['phone']);
							$size_phones = count($phones);
							for ($i=0; $i < $size_phones; $i++)
								{
								echo "<input type='checkbox'   class='phones'  OnChange = 'Check_state(2);'  name='phone2mess[".$i."]' id = 'phone".$i."' value='". $phones[$i] ."'  /><font style ='font-size: 14px;'>". $phones[$i] .'</font>';
								}
							?>
							</td>
							</tr>
						<?php	}
						?>
								
							<?php
						if (trim($_SESSION['names']) != "")
							{
						?>		
						<tr>
							<td align="left" valign="top">
								<font color="white"><strong>* </strong></font>
									<?php
										$names2choose = explode("*", $_SESSION['names']);
										$size_names = count($names2choose);
										for ($i=0; $i < $size_names; $i++)
											{
											echo "<input type='checkbox' OnChange = 'Check_state(2);'  class='names' name='name2mess[".$i."]' id = 'name".$i."' value='". $names2choose[$i] ."' /><font style ='font-size: 14px;'>". $names2choose[$i] .'</font>';
											}
									?>
							</td>
							</tr>
							
						<?php	}
						?>
					</table>
			</td>
		</tr>
		</table>
	</td>
		
		
	</tr>
	<?php /* if ($_SESSION['mid']=='51'||$_SESSION['mid']=='386'||$_SESSION['fio']=='9211'||$_SESSION['fio']=='099911'){ */ ?>
	
	<?php /*} */ ?>
	<tr>
		<td>
	<td align="center">
		<div id = 'photos'></div>
			<p align = center style = 'margin: 5px'>Необходимо выбрать статус сообщения. <br>
			В связи с отчисткой базы от "хлама", необходимо отметить статус данного варианта</p>
<div style = 'display:block; border:1px solid red; padding:5px; margin:10px'>
<br>
<table>
	<tr>
		<td style = 'height: 21px'  align = center>
			<div id = 'premium' style= 'display:none;' >
				<?php 
					if($premium <= 5){ 
						$prem = 5-$premium;
					?>
						<input type = "checkbox"  id = premium_ch value  = "1" name = "premium">
						<span style = 'color:green'>ПРЕМИУМ(<?php echo $prem;?></span></b>)
					<?php } ?>
			</div>
	<tr>
		<td>

	<input OnChange = "if(this.checked){ document.getElementById('premium').style.display = 'block';}
					else{ document.getElementById('premium').style.display = 'none';}"
	id="exkl" type="radio" value="3" name="exkl" <?php if($exkl) echo ' disabled'; ?> >VIP<br>
	Гарантия 100% что его нет в разделе «от хозяев», на сайтах:  «нгс»,  «авито»!<br>
	<span style = 'font-size:12px;color:red'>( VIP не обозначает, что это эксклюзив. VIP значит, что данного варианта нет на перечисленных выше сайтах. 
		Будьте внимательны и честны при выборе данного статуса. Если выяснится, что заявленная информация не соответствует действительности,
		   вам будут не доступны все статусы при отправке сообщений,  кроме «без гарантий»! 
		   Возобновить все статусы будет возможно за 1000 рублей.
		  Сообщения «vip» могут быть премиум и отображаются на самом верху всех сообщений! 
		  Если не уверены, в том что хозяева не ведут свою игру, лучше отметьте статус «50на50»!)
	</span>
	<br><br>
	
	<tr>
		<td>
<input OnChange = "if(this.checked){ document.getElementById('premium').style.display = 'block';}
				else{ document.getElementById('premium').style.display = 'none';}"
id="exkl" type="radio" value="2" name="exkl" <?php if($exkl==1) echo ' disabled'; ?>>  50 на 50 <br>
	Гарантирую что на момент публикации на Фортуне данного варианта нет на сайтах  «нгс» и «авито»  и тем более в  разделе « от хозяев»! 
	Но не уверен, что по истечении какого то времяни хозяева или их близкие, не поставив меня в известность, откажутся  дополнительно 
	опубликовать его самостоятельно на авито и нгс! 
<span style = 'font-size:12px;color:red'>(Обращаем ваше внимание!  Если выяснится что данный вариант есть  
	на нгс или  авито или в разделе от хозяев  и, ко всему прочему, опубликован раньше чем отправили,  или в дальнейшем 
	продлили его, то вам будут не доступны все статусы при отправке сообщений,  кроме «без гарантий»!
	Возобновить все статусы будет возможно за 1000 рублей.
	 Если сомневаетесь,	лучше отметьте статус «без гарантий»!)</span>
<br><br>
	<tr>
		<td>
<input OnChange = "if(this.checked){ document.getElementById('premium').style.display = 'none';}"
id="exkl" type="radio" value="1" name="exkl" checked> «без гарантий»<br>
Ничего гарантировать не могу и не собираюсь! Вам надо вот вы и проверяйте, есть такое сообщение на «нгс» или «авито» или в разделе «от хозяев», мне это не надо!
<span style = 'font-size:12px;color:red'>(С данным статусом сообщение вообще не обязательно как то проверять и чего то гарантировать, отправил и забыл! Единственный минус - это то что сообщения под данным статусом не может быть «премиум» и расположено в общем списке после сообщений «VIP» и «50на50»!.</span>
<br>
</table>

	</div>
<div id = 'photo_old' style = 'display: inline;padding: 0px;'>
<table  style = 'width: 75%; margin: 10px'>
	<tr>
		<td colspan = 2>
			<p style = 'color:black; font-size:16px;text-align:center'>ДОБАВЛЕНИЕ ФОТОГРАФИЙ</p>
			<p style = ' text-align:center;color:red'>Здесь можно загрузить всего 5 фото, каждая размером не более 2 Мб, 
														все фотографии тяжелее 2мегабайт не будут загружены. Если у вас много фотографий,
														 можете их добавить  при редактировании в "загрузке №2".</p>
	<tr>
		<td>			<input type="file" name="gals_photo2" size="1"  style = 'width: 250px;'  id = 'file_2' 
						OnChange = "if(this.value != ''){document.getElementById('link_file_2').style.display = 'inline'; }
									else{document.getElementById('link_file_2').style.display = 'none';}" value = ''>
					<br><a href = '#f_del' style='display:none; color:red;' id = 'link_file_2' 
						Onclick = "document.getElementById('file_2').value = ''; 
									this.style.display = 'none';"> удалить фотографию</a>
		<td>
				<input type="file" name="gals_photo3" size="1"  style = 'width: 250px;'  id = 'file_3' 
						OnChange = "if(this.value != ''){document.getElementById('link_file_3').style.display = 'inline'; }
									else{document.getElementById('link_file_3').style.display = 'none';}" value = ''>
					<br><a href = '#f_del' style='display:none; color:red;' id = 'link_file_3' 
						Onclick = "document.getElementById('file_3').value = ''; 
									this.style.display = 'none';"> удалить фотографию</a>
	<tr>
		<td>
				<input type="file" name="gals_photo4" size="1"  style = 'width: 250px;'  id = 'file_4' 
						OnChange = "if(this.value != ''){document.getElementById('link_file_4').style.display = 'inline'; }
									else{document.getElementById('link_file_4').style.display = 'none';}" value = ''>
					<br><a href = '#f_del' style='display:none; color:red;' id = 'link_file_4' 
						Onclick = "document.getElementById('file_4').value = ''; 
									this.style.display = 'none';"> удалить фотографию</a>
		<td>
				<input type="file" name="gals_photo5" size="1"  style = 'width: 250px;'  id = 'file_5' 
						OnChange = "if(this.value != ''){document.getElementById('link_file_5').style.display = 'inline'; }
									else{document.getElementById('link_file_5').style.display = 'none';}" value = ''>
					<br><a href = '#f_del' style='display:none; color:red;' id = 'link_file_5' 
						Onclick = "document.getElementById('file_5').value = ''; 
									this.style.display = 'none';"> удалить фотографию</a>	
	<tr>	
		<td>
				<input type="file" name="gals_photo6" size="1"  style = 'width: 250px;'  id = 'file_6' 
						OnChange = "if(this.value != ''){document.getElementById('link_file_6').style.display = 'inline'; }
									else{document.getElementById('link_file_6').style.display = 'none';}" value = ''>
					<br><a href = '#f_del' style='display:none; color:red' id = 'link_file_6' 
						Onclick = "document.getElementById('file_6').value = ''; 
									this.style.display = 'none';"> удалить фотографию</a>
</table>
<div style = 'width: 530px; margin-left:auto;margin-right:auto; display: none; border: 2px solid red'>		
	<p style = 'text-align: center;'>

	<?php 	if($my_list!='') { ?>
			<input type="checkbox" name="butt" value="1" id = 'butt' /> <span  style = 'margin-right:50px'>	
						<font style = "color :grey; font-size:13px;">ОТПРАВИТЬ ТОЛЬКО СВОЕЙ ГРУППЕ
						<?php } ?>
					</span>
						

						<a href = '/mail/user_list.php' Target = '_blank' style = "font-size:13px;"> НАСТРОЙКА СВОЕЙ ГРУППЫ</a>
							</font>
	</p>
</div>
<div align="center" valign = 'top' style = "

 background: none repeat scroll 0 0  #E3FAC9;
    border: 1px solid blue;
    color:red;
    left: 0;
    margin-top: 5px;
    min-width: 900px;
    padding: 10px;
    
">
Ресурс www.fortunasib.ru является закрытой обменной базой, которая содержит коммерческую информацию от агентств недвижимости.
 Категорически запрещено и не приемлемо перепечатывать, копировать информацию, фото или элементы сайта.
  В случае нарушения данного требования, нарушителю будет заблокирован доступ и выставлен штраф в размере 5000 рублей,
   при повторном нарушении безоговорочно удаляется с ресурса. Администрация
<br>
</div>
<p style = 'text-align: center'>
		
							<input type = 'submit'  onclick=" window.open('http://fortunasib.ru/mail/user_list.php','_blank'); return false" value = 'Настройка своей группы'>
							
							<input type="hidden" name="new_text_smart_ok" value="ok" />

				
								<input  style = 'background:green;margin-left: 30px' type="submit"  id = 'btn' value="Отправить своей группе"
									OnClick = '
									if(validateEmpty("s_o","2","3","4","5","6","7","8","28")){
										document.getElementById("butt").checked = true;
										return true;
										}else{return false;};
										'/>
				
								<input  style = 'background:green;margin-left: 30px' type="submit"  id = 'btn' value="Отправить всем"
									OnClick = '
									if(validateEmpty("s_o","2","3","4","5","6","7","8","28")){
										return true;
										}else{return false;}; 
										
										'/></p>
								
			
		</div>	
		</form>
		</div>
		
</table>
<br><br><br>

<?php
	}
?> 
<script>
$("#str").on("keypress", function(){
		$.ajax({
			type: 'POST',
			url: '?task=profile&action=search_street', 
			data: 'street=' + $(this).val(), 
			success: function(html) { 
				$(".street_list #str_list").remove();
				$(".street_list").append(html);
				$(".street_list").slideDown();
			}
		});
	});
</script>