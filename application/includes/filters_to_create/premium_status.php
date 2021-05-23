<?php
$prem_count = Get_functions::Get_premium_balance();
$without_vip = DB::Select("without_vip", "re_company", "id={$_SESSION['company_id']}")[0]['without_vip'];?>
<div style="display:block; border:1px solid red; padding:5px; margin:10px">
	<br>
	<table>
		<tbody>
				<tr>
					<td style="height: 21px" >
							<img title="статус-премиум" style="vertical-align: initial;float: left;    margin: 3px 3px;" src="images/icon/zv.gif" width="28px">

                        <?php
                        if($prem_count>0 || $data_res['premium'] == 1)
                        {
                        ?>
							<input type="checkbox" id="premium" value="1" name="premium" <?php if($data_res['premium'] == 1) echo "checked"; ?>>
              <?php } ?>
							<span > - «Премиум (<?=$prem_count;?>)»</span>
							<br/>Параметр «ПРЕМИУМ» дает возможность позиционировать свои объекты в общем списке выше,
                                так как сначало выводятся все варианты с параметром премиум за 4 дня, а потом обычные варианты!
                                Получается если вариант с премиум не продлевать 4 дня то он всеравно будет выше в общем списке чем вариант простой только что продленный!
                                Приобрести премиум можно любое количество на любое количество дней, в ЛК в разделе «продление доступа»!
					</td>
				</tr>

			<?

			echo "<tr><td style='height: 21px' ></td></tr>";

			if($without_vip == 0){
				?>
				<tr>
					<td>
						<img title="статус-VIP" style="vertical-align: initial;float: left;    margin: 3px 3px;" src="images/icon/vip.jpg" width="28px">
						<input id="exkl" type="checkbox" value="3" name="status" <?php if($data_res['status'] == 3) echo "checked"; ?>> - «Гарантия что объекта нет в интернете на прямую от собственника»<br>
						 Гарантирую что в момент публикации и в момент последнего продления данного объекта нет на просторах интернета на прямую от собственника.
						  В случае если это не так согласен что у моего агентства данный статус будет отключен.
						  Повторная активация под большим вопросом и в случаи принятия положительного решения данная опция активируется платно!
						<br><br>
					</td>
				</tr>
				<?
			}
				?>	
				<tr>
					<td colspan = '2'>
						<div style = 'margin:auto; text-align : center;<?php 
							if(!Helper::checkProlongExists($_SESSION['user']))
								echo ' display: none; ';
							?>' >
							<input  type = 'radio' name = 'prolong_garant' value = '1'
							 <?php 
							 	if($data_res['prolong_garant']!=0 && $data_res['prolongExists'])
							 			echo' checked ';

							 ?>>
							 	На момент последнего обновления вариант актуален
							<br/>

							<input type = 'radio' name = 'prolong_garant' value = '0'
							 <?php 
							 	if($data_res['prolong_garant']==0 || !$data_res['prolongExists'])
							 			echo'checked';

							 ?> >
							 	Не гарантирую актуальность варианта, выясняю это в момент обращения
						</div>
					</td>
				</tr>
		</tbody>
	</table>
</div>