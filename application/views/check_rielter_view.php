<script type="text/javascript">
	$(function(){		
		$(document).on("change", "[name=search_type]", function(){
			var search = $("[name=search_type]:checked").val();
			$("[data-name=search-str]").hide();
			$("div").has("#"+search).show();
		});

		$(document).on("click", function(e){
			if(!$(".street_list").has($(e.target)).length>0 && !$(".street_list").is($(e.target))){
				$(".street_list").slideUp();
			}
		});
	})
</script>
<div class="col-xs-9" id='check_rielter'>
	<legend>Поиск риелтора в базе</legend>	
	<?php
		if($data['error'] == '***'){
	?>
	<br/><br/>
		<div style = 'border: 2px solid red; text-align:center;'>
			<i><b style = 'color:red'>Перед проверкой номера выбирите в списке вариант по которому звонил риэлтор</b></i></div>
		<br/>
	<?php
		}
	?>
    <script type="text/javascript">
        <!--
        /**
         *
         * @returns {boolean|*}
         */
        function check_rielter_form(){
            valid = true;
            if(document.check_rielter.phone.value == ""  && document.check_rielter.company_id.value == ""){
                alert( "Введите номер телефона или название агентства " );
                valid = false;
            }
            return valid;
        }
        //-->
    </script>

    <form method='POST' id='check_rielter'  name='check_rielter' onsubmit="return check_rielter_form();">
		<?if($_SESSION['admin'] == 1){?>
				<label class="signature">Выберите тип поиска</label>
				<div class="radio" style="display:none">
					<label>
						<input type="radio" name="search_type" value="phone" <?=($_POST['search_type']=="phone" || !$_POST)?"checked":''?>>
						телефон
					</label>
				</div>	
			</div>
		<?}?>

		<div class="col-xs-2 deployed" data-name='search-srt' style="<?if($_POST['search_type']=="mail") echo 'display:none'?>">
			<label class="signature">Телефон1</label>
			<input type='tel' class="form-control"  name="phone" id='phone'
                   value="<?=$_POST['phone']?>"
            >
		</div>
		<?if($_SESSION['admin'] == 1){ ?>
			<div class="col-xs-2 deployed" data-name='search-str' style="<?if($_POST['search_type']=="phone" || !$_POST) echo 'display:none'?>">
				<label class="signature">E-Mail</label>
				<input type='text' class="form-control" name="mail" id='mail' value="<?if(isset($_POST['mail'])) echo $_POST["mail"];?>">
			</div>
		<?}?>
		<div class="col-xs-2 deployed">			
			<label class="signature">В каком агентстве</label>
			<input type="text" class="form-control" data-name="an-list" placeholder="все АН">
			<div class="an_list" style="display: none;"></div>
			<input type="hidden" name="company_id">		
		</div>
		<input type='hidden' value='00_00' name = 'var_id'>
		<div class="col-xs-2 deployed">	
			<input type="submit" class="form-control btn btn-success" value='Поиск'>
		</div>
		<br/>
				
	</form>

		<br/>
	<?if ($_SESSION["admin"] == 1){
		?>
	<div class="col-xs-3 deployed right">	
		<a href="?task=admin&action=check_rielter&request=all" class="form-control btn btn-primary"> Все </a>
	</div>		
	<?}

	if ($_POST || $_GET['request'] == "all"){
		$num = count($data)-1; 
		$count_check = count($data['check_list']);
		if ($_POST){
			for($i=0; $i<$num; $i++){
				if(empty($data[$i]['company_name'])) continue;
			?>
				<div class='col-xs-12 info' style = 'width:78%'>
					<div class='col-xs-12 center'>
						АН  «<?echo $data[$i]['company_name'];?>»
					</div>
					
					<div class='col-xs-6'>
						<span style="color: rgb(50, 150, 50);font-size: 17px;"><?echo $data[$i]['name'];?> <?echo $data[$i]['second_name'];?></span><br />
						<?if($data[$i]['parent'] == "0"){
							echo "Директор агентства<br />";
						}?>
						дата регистрации: <?echo $data[$i]['date_reg'];?><br />
						статус: <?echo $data[$i]['status'];?><br />
						 : <?echo $data[$i]['phone'];?>
					<?php
						if($data[$i]['phone_addon'] != "") {
							echo "<br />телефоны для исходящих: " . str_replace('||', ' ', $data[$i]['phone_addon']);
						}
						if($data[$i]['phone_archive'] != "") 
							echo "<br />архивные телефоны: " . str_replace('||', ' ', $data[$i]['phone_archive']);
					?>
					</div>		
					<?if($data[$i]['warning'] == "1"){?>
						<div class='col-xs-6'>
							<a href="/?task=profile&action=caution&type=1&people=<?=$data[$i]['people_id']?>" class="warning" target="_blank" title="данный риелтор был занесен в раздел 'осторожно'">!</a>
						</div>
					<?}
					?>
				</div>
			<?}


			if(empty($data['search_result'])){

				unset($i, $num);		
				$search_str = "телефоном ".$_POST['phone'];
				$num_or_mail = $_POST['phone'];
				$check_date = date("d.m.Y H:i:s");?>
				<div class='col-xs-12 info center' style = 'width:78%'>
					<h3 style='color:red'>ВНИМАНИЕ! Риелтора с <?echo $search_str;?> нет в базе!</h3>
					<div>Поделитесь с нами информацией! <br/>
					Напишите каким ан представлялся, 
					как зовут, по какому 
					варианту звонил (пример: 1к Титова 36 за 1400) во сколько был звонок,
					 или вообще что известно! Эти данные помогут предотвратить появление людей на сайте которые незарегестрированны! 
					<br/>Заранее спасибо!<br/>
					<div class='col-xs-12 deployed'>
							<textarea class='form-control' name='check_rielter_comment' placeholder='пояснение' rows='5' cols='80' ></textarea>
						</div>
						<div class='col-xs-2 deployed'>
							<button type='button'
							 onClick="Check_comment_set('<?=$_SESSION['io']?>', '<?=$check_date?>', '<?=$num_or_mail?>', '<?=$_SESSION['people_id']?>')" class='form-control btn btn-success'>Отправить</button>
						</div>
					</div>
				</div>
		<?	}
		}
		?>
			<div class='col-xs-12' id='check_list' style = 'width: 79%'>
				<hr>
				<h4 class="">Кто ещё искал данный номер:


					<?php
						if($_SESSION['admin']==1){
						$day = 0;
						if(!empty($_GET['day'])){
							$day = $_GET['day'];
						}

						?>
						<table >
							<tbody>
								<tr>
									<td>
										 дней назад :
									</td>
								<?php
									for ($i=0; $i < 11; $i++) { 
										?>
										<td width = '20px' style = 'margin : 10px' align = 'center'>
											<?php
											if($i == 0) echo 'сегодня';
											else echo $i;
											$jsFunc = "window.location = '?task=admin&action=check_rielter&request=all&day={$i}'";
											?> <br/>
										<input type = 'radio' name = 'day' form="days" onClick = "<?=$jsFunc?>"  value = '<?=$i?>' <?php if ($i==$day) echo 'checked'; ?>>
									</td>
										<?
									}
								?>
							</tr>
						</tbody>
					</table>

					<?}?>
					<span style="color:#F00; float:right; margin-right:5px; font-size: 14px;">нет в базе</span>
				<!--<span style="color:#D0B400; float:right; margin-right:5px; font-size: 14px;">уволен</span>-->


				<span style="color:#4CAE4C; float:right; margin-right:5px; font-size: 14px;">работает</span></h4>
				<?php 

		if($count_check > 0){ ?>
				<table class="table table-striped list">
					<thead><tr><th>#</th><th>Кто искал</th><th>АН</th><th>Что искали</th><th>Дата поиска</th>
					<?if($_SESSION['admin']==1){
						?>
						<th>Просмотренный вариант</th><th>Оставленный коментарий</th>
						<?
					}?>
					</tr></thead>
					<tbody>
						<?
						$result_color=[
							0 => "color:#F00",
							1 => "color:#D0B400",
							2 => "color:#4CAE4C",
							3 => "color:#4CAE4C",
							4 => "color:#4CAE4C"
						];

						for($c=0; $c<$count_check; $c++){			
							$companyExists =  $data['check_list'][$c]['company_cnt'];

							$check_date = date("d.m.Y H:i:s", strtotime($data['check_list'][$c]['date_search']));?>
							<tr>
								<td> <?echo $c + 1?></td>
								<td> 
									<?echo $data['check_list'][$c]['name']." ".$data['check_list'][$c]['second_name'];?>
									<br/>
									<a href="tel: <?echo $data['check_list'][$c]['phone']?>"> 
										<?echo $data['check_list'][$c]['phone']?> </a>
								</td>

								<td> «<?=$data['check_list'][$c]['company_name'];?>»</td>

								<td style="<?echo $result_color[$data['check_list'][$c]['search_result'] + $companyExists]?>"> 
									<?php 
										if(!empty($data['check_list'][$c]['search_str'])){
										echo "<span style='".
										  $result_color[$data['check_list'][$c]['search_result'] + $companyExists].
										  "'>".
										  $data['check_list'][$c]['search_str'].
										  "</span>";

										if($_SESSION['admin']==1 && !empty($data['check_list'][$c]['cnt']))
											echo "(".$data['check_list'][$c]['cnt'].")";
											}else{
												echo $data['check_list'][$c]['search_str'];
											}
									?>
								</td>							
								<td> <?=$check_date?></td>
								<td> 

									<?php 
										if($_SESSION['admin']==1){
										?>
										<form id = 'phone_search_<?=$c?>' name = 'phone_search' action = '?task=profile&action=check_rielter' 
												 method = 'post'>
											<input type = 'hidden' name = 'phone' form="phone_search_<?=$c?>" 
											value = '<?=$data['check_list'][$c]['search_str']?>'>
												<input type="submit" form="phone_search_<?=$c?>" 
												value="Поиск телефона" Onclick = 'submit()'>										
										</form>
										<?php
										$var_id = explode('_', $data['check_list'][$c]['variant']); 
										if(!isset($var_id[1]))
											$var_id[1]= 1;
									?>
								</td>
								<td> <?=$data['check_list'][$c]['check_comment']?></td>
								<?php

									}
								?>
							</tr>
						<?
						unset($companyExists);
						}
						unset($c, $count_check);?>
					</tbody>
				</table>
			</div>
		<?}
	}?>
</div>