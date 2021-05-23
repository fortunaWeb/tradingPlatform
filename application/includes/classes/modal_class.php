<?php

class Modal
{
    static function Modal_win_send_payment(){
        $modal =
            "<div class='modal fade' id='send-payment-modal-win' tabindex='-1' role='dialog' aria-hidden='true'>
		  <div class='modal-dialog' style='width: 90%; max-width:700px'>
			<div class='modal-content'>
			  <div class='modal-header'>
				<button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
				<h4 class='modal-title'></h4>
			</div>
			   <style>.tinkoffPayRow{display:block;margin:1%;width:160px;}</style>

			<legend>Пополнение баланса</legend>
			<form name='TinkoffPayForm' onsubmit='pay(this); return false;'>
			   <input class='tinkoffPayRow' type='hidden' name='terminalkey' value='TinkoffBankTest'>
				<input class='tinkoffPayRow' type='hidden' name='frame' value='true'>
				<input class='tinkoffPayRow' type='hidden' name='language' value='ru'>
				<input class='tinkoffPayRow' type='text' placeholder='Сумма заказа' name='amount' required>
			   <input class='tinkoffPayRow' type='text' placeholder='Номер заказа' name='order'>
				<input class='tinkoffPayRow' type='text' placeholder='Описание заказа' name='description'>
			   <input class='tinkoffPayRow' type='text' placeholder='ФИО плательщика' name='name'>
				<input class='tinkoffPayRow' type='text' placeholder='E-mail' name='email'>
				<input class='tinkoffPayRow' type='text' placeholder='Контактный телефон' name='phone'>
				<div class='checkbox'>
						<label>
							<input type='checkbox' id='anonymous' name='anonymous' value='1'>
							Знаком с офертой и согласен с правилами
						</label>
					</div>
				<input class='tinkoffPayRow' type='submit' value='Оплатить'>
			</form>
				  

			</div>
		  </div>
		</div>";
        return $modal;
    }


}