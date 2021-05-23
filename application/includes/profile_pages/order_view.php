<?/*if($_SESSION["admin"]!=1){?>
	<div class="col-xs-9">
		<legend>Данные для оплаты доступа</legend>
		<div class="col-xs-12 deployed">
			<p>Страница временно не доступна. Ведутся работы.</p>
		</div>
	</div>
<?exit;}*/

?>
<script type="text/javascript">
	$(function(){
		if($("form#order_send").attr("action") == ""){
			$("form#order_send .form-control").attr("disabled", "");
		}

		//отображение доп. полей взависимости от типа платежа
		$(document).on("change", "[name=order_type]", function(){
			var dataId = $(this).val(),
				anotherId = {"tinkoff":"qiwi", "qiwi":"tinkoff", "sber":"sber"};
			if(dataId != ""){
				ShowFields(anotherId[dataId], "[name=wallet_num]", 0);
				ShowFields(anotherId[dataId], "select", 0);
				ShowFields(anotherId[dataId], "textarea", 0);
				ShowFields(dataId, "select", 1);
			}else{
				ShowFields("sber", ":visible", 0);
				ShowFields("tinkoff", ":visible", 0);
				ShowFields("qiwi", ":visible", 0);
			}
			$("textarea").removeAttr("disabled");
		});
		$(document).on("change", "[name=order_place]", function(){
			var val = $(this).val();
			if(val == "wallet"){

				ShowFields("sber", "[data-name=wallet_num]", 2);
				ShowFields("tinkoff", "[data-name=wallet_num]", 0);
				ShowFields("qiwi", "[name=wallet_num]", 1);
			//	$("div[data-id=qiwi]").has("textarea").show();

			}else if(val == "terminal" || val == "euroset"){

				ShowFields("sber", "[data-name=wallet_num]", 0);
				ShowFields("tinkoff", "[data-name=wallet_num]", 0);
				ShowFields("qiwi", "[name=wallet_num]", 0);
			//	$("div[data-id=qiwi]").has("textarea").show();

			}else if(val == "mobil" || val == "lk" || val == "bankomat" || val == "tinkoff_card" || val == "enother_card"){
//				ShowFields("qiwi", "[name=wallet_num]", 0);
//				ShowFields("tinkoff", "[data-name=wallet_num]", 1);
//				$("div[data-id=qiwi]").has("textarea").hide();
			}else{
				ShowFields("sber", "[data-name=wallet_num]", 0);
				ShowFields("tinkoff", "[data-name=wallet_num]", 0);
				ShowFields("qiwi", "[name=wallet_num]", 0);
//				$("div[data-id=qiwi]").has("textarea").hide();
			}
		})
		$("#order_send").submit(function(e){
			if(parseInt($("[data-id=price]").val().replace(" ", "")) > 5000){
				 e.preventDefault();
				 alertify.error("Максимальная сумма к оплате 5 000р");
				 $("[data-id=price]").focus();
			}else if($("[name=order_place]:required").val()==""){
				 e.preventDefault();
				 alertify.error("Отметьте все обязательные поля!");
				 $("[name=order_place]:required").focus();
			}else if($("[data-id=tinkoff_num]:visible").length > 0){
				if($("[data-id=tinkoff_num]").val().match(/\d{4}/) == null){
					e.preventDefault();
					alertify.error("Укажите последнии цыфры карты");
					$("[data-id=tinkoff_num]").focus();
				}
			}
		})
	})

function ShowFields(type, objStr, show){
	if(show == 0){
		$("div[data-id="+type+"]").has(objStr).hide();
		$("div[data-id="+type+"] "+objStr).removeAttr("required").attr("disabled", "");
	}else{
		$("div[data-id="+type+"]").has(objStr).show();
		$("div[data-id="+type+"] "+objStr).attr("required", "").removeAttr("disabled");
	}
}
</script>
<?$form_visible =  intval($data[0]['order_access']) == 1 || intval($_SESSION['order_access']) == 1;?>
<div class="col-xs-9">

    <legend>Отправка данных об оплате <?if($_GET["task"]=="login") echo "АН «".$data[1]."»";?></legend>
		<!--<p>Оплата производится на карту сбербанка номер: <span style="color: #33B100;font-weight: bolder;">4276 8440 1970 6084</span> которая привязана к номеру телефона 89139179516 или на киви кошелек: <span style="color: #33B100;font-weight: bolder;">9139179516</span></p>
		<p/>С 17 декабря временно оплата принемается только на киви кошелек его номер<span style="color: #33B100;font-weight: bolder;"> 89139179516</span>.<br/>
		При оплате учитывайте что необходимо учитывать комиссию за отправку и обналичивание.<br/>
		За отправку бывает что комиссию и не берут а за обналичивание с любой суммы 20р списывается при внесении данных об оплате.<br/>
		Скоро появятся альтернативные способы оплаты.</p>
		<p/>Для тех кому всё сложно, звоните, помогу решить вопрос альтернативным, подходящиям для вас способом -->
    <p style='color:#884535;'>
        Запрещено при совершении оплаты на карту Тинькофф или киви кошелек оставлять любые комментарии! Все платежи с комментариями зачислятся не будут!
       </p>
		<?if($_GET["task"]=="login"){
			echo "<p style='color: rgb(216, 42, 42);'>Ваш доступ деактивирован, т.к. закончилась абонентская плата. Рекомендуемый минимальный платеж по аренде: ".($data['duty'] + $data['subscription'] - $data['balance'] + 50)."р.. Все оплаченные излишки остаются на вашем балансе и могут быть использованы в любое время.<br /><br />После отправки данных об оплате, Вам потребуется заново ввести логин и пароль, чтобы выбрать и активировать нужные Вам услуги, которые будут доступны в пределах вашего баланса. После активации услуг опять заходите под логином и паролем, пользуетесь ресурсом. Те кому требуется дополнительные премиумы, могут их активировать из ЛК раздел 'Продление доступа, изменение услуг'.</p>";
		}?>
		<?if(!$form_visible){?>
			<div class="col-xs-12 deployed">
				<p style="color:red">Форма оплаты будет доступна после проверки администратором предыдущего платежа.</p>
		<?}?>

    <div class="col-xs-8" style="margin-top:15px">
		<form id="order_send" method="POST" action="<?if($form_visible) echo "?task=profile&action=order_send";?>">
			<div class="col-xs-2 deployed">
				<label class="signature">Дата платежа</label>
				<input type="text" class="form-control" data-id="date" name="pay_date" required>
			</div>
			<div class="col-xs-2 deployed">
				<label class="signature">Время платежа</label>
				<input type="text" class="form-control" data-id="time" name="pay_time" required>
			</div>
			<div class="col-xs-2 deployed">
				<label class="signature">Сумма</label>
				<input type="type" class="form-control" data-id="price" name="sum" required>
			</div>
			<div class="col-xs-12 deployed">
				<hr style="margin-bottom: 5px;margin-top: 0;">
			</div>
			<div class="col-xs-2 deployed">
				<label class="signature">Способ оплаты</label>
				<select class="form-control" name="order_type" required>
					<option value="">выберите</option>
					<option value="sber">На карту Сбер</option>
					<option value="tinkoff">На карту Tinkoff</option>
					<option value="qiwi">На Qiwi-кошелёк</option>
				</select>
			</div>
			<div class="col-xs-2 deployed" data-id="qiwi">
				<label class="signature">Через что</label>
				<select class="form-control" name="order_place">
					<option value="">выберите</option>
					<option value="wallet">со своего кошелька</option>
					<option value="terminal">через терминал QIWI</option>
					<option value="euroset">в евросети</option>
				</select>
			</div>	
			<div class="col-xs-2 deployed" data-id="tinkoff">
				<label class="signature">Через что</label>
				<select class="form-control" name="order_place">
					<option value="">выберите</option>
                    <option value="tinkoff_card">с карты Тинькоффт</option>
                    <option value="sber_card">с карты Сбер</option>
                    <option value="another_bank">С карты другого банка</option>
                    <option value="euroset">В салоне связи MTC, Cвязной, Eвросеть</option>
				</select>
			</div>
			<div class="col-xs-2 deployed" data-id="qiwi">
				<label class="signature">Номер кошелька</label>
				<input type="text" data-id="phone" class="form-control" name="wallet_num">
			</div>

			<div class="col-xs-4 deployed">
				<label class="signature">Коментарий для админа</label>
				<textarea rows="3" name="comment_order" class="form-control" placeholder="коментарий для админа"></textarea>
			</div>
			<div class="col-xs-12 deployed">
				<div class="checkbox" style="margin-bottom: auto; display: inline-block;">
					<label>
						<input name="access" type="checkbox" required>
						подтверждаю, что данные не вымышлены, и введены правильно. В случае отправки не существующего платежа, логин будет заблокирован до момента оплаты штрафа 500р
					</label>
				</div>
			</div>
	<?if ($form_visible){?>
			<div class="col-xs-2 deployed right">
				<input type="submit" class="form-control btn btn-success" value="Отправить">
			</div>	
			<input type="hidden" name="company_id" value="<?echo $_SESSION['company_id'];?>">
			<input type="hidden" name="active" value="1">
	<?}unset($form_visible);?>
		</form>
    </div>
	<?if($_GET["task"]=="profile"){?>
        <?php if($_SESSION['admin']==1){ ?>
		<div class="col-xs-12 deployed">
			<legend>Список платежей</legend>	
		</div>

            <table id="application" class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Дата <br />записи</th>
                        <th>Дата <br />платежа</th>
                        <th>Тип <br />платежа</th>
<!--                         <th>Номер карты/<br />кошелька</th>-->
                        <th>Место <br />платежа</th>
                        <th>Сумма</th>
<!--                        <th>Коментарий <br />в платеже</th>-->
                        <th>Пояснение</th></tr>
                </thead>
                <tbody>
                    <?	$count = count($data);
                        if($data[0]['id']!=""){
                            for($i=0; $i<$count; $i++){?>
                                <tr>
                                    <td><?echo $i+1;?></td>
                                    <td style="width: 100px;"><?echo date("d.m.Y H:i:s", strtotime($data[$i]['date_order']));?></td>
                                    <td style="width: 100px;"><?echo date("d.m.Y H:i:s", strtotime($data[$i]['pay_date']));?></td>
<!--                                    <td>--><?//echo Translate::Order_type_place($data[$i]['order_type']);?><!--</td>-->
                                    <td><?echo $data[$i]['wallet_num'];?></td>
                                    <td><?php
                                                echo Translate::Order_type_place($data[$i]['order_place']);
                                            if(!empty($data[$i]['wallet_num'])){ echo $data[$i]['wallet_num']; }
                                        ?>
                                    </td>
                                    <td><?echo $data[$i]["sum"];?></td>
<!--                                    <td>--><?//echo $data[$i]['comment_pay'];?><!--</td>-->
                                    <td><?echo $data[$i]['comment_order'];?></td>
                                </tr>
                            <?}
                        }
                    ?>
                </tbody>
            </table>
        <?php } ?>
	<?}?>
            </div>
</div>