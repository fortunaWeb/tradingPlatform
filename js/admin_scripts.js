$(function(){
	//отметка платежа как просмотренного
	$(document).on("click", "td[data-name=an]", function(){
		var id = $("tr[data-name=order]").has($(this)).data("order-id");
		$.ajax({
			type:"POST",
			url:"?task=admin&action=order_check",
			data: "id="+id,
			success:function(){
				$("tr[data-order-id="+id+"]").find("td").last().empty().append("<span class='dropdown'><a href='javascript:void(0)' id='orderMenu' data-toggle='dropdown'>Меню<span class='caret'></span></a><ul class='dropdown-menu' aria-labelledby='orderMenu' style='margin-left: -115px;'><li><a href='javascript:void(0)' onclick=\"ToArchive('order', "+id+")\">В архив</a></li><li><a href='javascript:void(0)' onclick=\"Delete('order', "+id+")\">Удалить</a></li></ul></span>");
			}
		})
	})
	//ответ на сообщение
	$(document).on('click', ".modal#messages-modal-win .btn-primary", function(){
		var modal = $(".modal").has($(this)),
			content = $(modal).find('textarea').val(),
			people_id_to = $(modal).find('.question').data("id");
		if(people_id_to==undefined)people_id_to=$("[data-id='question']").val();
		if(people_id_to != undefined && content!=""){
			$.ajax({
				type:"POST",
				url:"?task=admin&action=message_reply",
				data: "content="+ content + "&people_id_to="+people_id_to,
				success:function(html){
					$(".modal#messages-modal-win .messages_list").prepend("<div class='item info'  style='text-align: right;'><div class='reply'>ответ отправлен</div>"+content+"</div>");
					$(modal).find('textarea').val("");
				}
			})
		}
	})
	
})

//список жалоб данного сообщения
function ReviewListForAdmin(id){
	$(".modal#clean-modal-win .modal-body").empty();
	$.ajax({		
		type:'POST',
		url:'?task=admin&action=review_list_for_admin',
		data:"id="+id,
		success:function(html){
			$(".modal#clean-modal-win .modal-body").append(html);
		}
	})
};

//отметить жалобу как провереную
function CheckedReview(id, cheaked){
	if(cheaked == 0){
		//if(confirm('Подтвердите проверку.')){
			send();
		//}
	}else{
		send();
	}
	function send(){
		$.ajax({
			type:"POST",
			url:"?task=admin&action=checked_review",
			data: "var_id="+id,
			success:function(){
				$('.product[data-id='+id+']').slideUp('fast');
				alertify.success("Сообщение проверено!");
			}
		})
	}
}	

//удаление жалобы
function DeleteReview(id){
	if(confirm('Удалить жалобу?')){
		$.ajax({
			type:"POST",
			url:"?task=admin&action=delete_review",
			data: "id="+id,
			success:function(){
				$('.comment[data-id='+id+']').slideUp('fast');
				alertify.success("Жалоба удалена.");
			}
		})
	}
}

//список сообщений от кого 'from' к кому 'to'
function Messages(from, to, fio){
	$.ajax({
		type:"POST",
		url:"?task=admin&action=messages_list",
		data: "from="+from+"&to="+to+"&fio="+fio,
		success: function(html){
			if(QueryString("action")=="review_list"){
				var mes = $(".product").has("[data-people-id="+from+"]").find("[data-target=#messages-modal-win]").data("text");
				$(".modal-body textarea").val(mes);
			}
			$(".modal#messages-modal-win .messages_list div").remove();
			$(".modal#messages-modal-win .messages_list").append(html);
			if($(".modal#messages-modal-win").find(".question").length==0){
				$(".modal#messages-modal-win").append("<input type='hidden' data-id='question' value='"+from+"'>");
			}
			$($("[onclick='Messages("+from+", "+to+", \""+fio+"\")'] td")).each(function(){
				if($(this).text()=="Новое!"){
					$(this).text("");
					var num = $("[href='?task=admin&action=messages'] li").text().match(/\d/)[0];
					$("[href='?task=admin&action=messages'] li").text("Сообщения от пользователей ("+(num-1)+")");
				}
			})
		}
	})
}

//открытие статистики
function EnterStatistics(login, fio){
	$(".modal-dialog").css("max-width", "90%");
	$("#clean-modal-win .modal-body").text('');
	$("#clean-modal-win .modal-title").text("Статистика посещения. "+fio);
	$("#clean-modal-win .btn-primary").remove();
	$("#clean-modal-win .btn-default").text("Закрыть");
	if(login!="" && login>0){
		console.log(login);
		$.ajax({
			url:"?task=admin&action=enter_statistics",
			type:"POST",
			data:"login="+login,
			success:function(html){
				$("#clean-modal-win .modal-body").append($(html).find("table"));
			}
		})
	}
}

//открытие списка покупак
function ServicesListShow(company_id){
	if(QueryString("task")=="admin" && company_id!=undefined){
		var obj = $(".tariff[data-id="+company_id+"] [data-name=services-list]");
		if($(obj).has("table#application").length == 0){
			$.post("?task=admin&action=services_list_show", "id="+company_id, function(html){
				$(obj).prepend($(html).find("table#application")).removeClass("hidden");
				$("table#application").removeClass("hidden");
			})
		}else{
			var table = $(obj).find("table#application");
			if($(table).is(":visible")){
				$("[data-name=services-list]").has($(table)).slideUp();
			}else{
				$("[data-name=services-list]").has($(table)).slideDown();
			}
		}
	}
}

//открытие списка оплат
function OrderListShow(company_id){
	if(QueryString("task")=="admin" && company_id!=undefined){
		var obj = $(".tariff[data-id="+company_id+"] [data-name=order-list]");
		if($(obj).has("table#orders").length == 0){
			$.post("?task=admin&action=order_list_show", "id="+company_id, function(html){
				$(obj).prepend($(html).find("table#orders")).removeClass("hidden");
			})
		}else{
			var table = $(obj).find("table#orders");
			if($(table).is(":visible")){
				$("[data-name=order-list]").has($(table)).slideUp();
			}else{
				$("[data-name=order-list]").has($(table)).slideDown();
			}
		}
	}
}
function orderHide(order)
{
    $("[data-list-id="+order+"]").hide();
}

//универсальный метод для архивации
function ToArchive(name, id)
{
	var adr,request;
	if(name=='order' || name == 'payment_tinkoff'){
		adr="?task=admin&action=order_to_archive";
        request = "id="+id+"&name="+name;
	}else if(name=='message'){
		adr="?task=admin&action=message_to_archive";
		request="id="+id;
	}
    orderHide(id);
	$.post(adr, request, function(){});
}

function RemoveTinkoffPayment(name, id){
    adr="?task=admin&action=delete_order";
    request = "id="+id+"&name="+name;
    orderHide(id);
    $.post(adr, request, function(){});
}

//универсальный метод для удаления
function Delete(name, id){
	var adr,request;
	if(name=='order' || name=='payment'|| name=='payment_tinkoff'){
		adr="?task=admin&action=delete_order";
		request = "id="+id+"&name="+name;
	}else if(name=='message'){
		adr="?task=admin&action=delete_message";
		request="id="+id;
	}else if(name=='session'){
		adr="?task=admin&action=delete_statistic";
		request="user="+id;
	}else if(name=="callboard"){
		adr="?task=admin&action=delete_callboard";
		request="id="+id;
	}else if(name=="parse" || name=="pay_parse"){
		adr="?task=admin&action=delete_parse";
		request="id="+id+"&name="+name;
	}else if(name=="tasks"){
		adr="?task=tasks&action=delete";
		request="id="+id;
	}
	$.post(adr, request, function(){});
}

//добавление или снятие с довереных
function ForOpenSite(obj){
	var val = $(obj).is(":checked"),
		id = $(".employee").has(obj).data("id");
	$.post("?task=admin&action=trusted", "id="+id+"&trusted="+val, function(){
		alertify.success("Выполнено");
	})
}

//удаление фотографий с варианта
function DeletePhotos(id){
	if(confirm("Удалить фотографии данного варианта?")){
		$.post("?task=admin&action=delete_photos", "id="+id, function(){
			window.location.reload();
		})
	}
}

//удаление всей информации о риелторе
function DeleteEmploye(userId, all){
	var message;
	if(all==1){
		message = "Вы уверены, что хотите удалить всю информацию о данном риелтере безвозвратно?";
	}else if(all==0){
		message = "Передать все варианты риелтера директору АН и удалить всю остальную информацию о данном риелторе?";
	}
	if(confirm(message)){
		$.post("?task=admin&action=delete_employe", "user_id="+userId+"&all="+all, function(){
			$("[data-id="+userId+"]").slideUp();
		})
	}
}

//блокировка всех сотрудников АН
function BlockAn(anIp, block){
	if(anIp>0){
		if(confirm("Заблокировать всех сотрудников АН?")){
			$.post("?task=admin&action=block_an", "an_ip="+anIp+"&block="+block, function(){
				window.location.reload();
			})
		}
	}
}

//удаление всей информации о АН
function DeleteAn(anId){
	if(anId>0){
		if(confirm("Вы уверены, что хотите удалить абсолютно всю информацию об АН?")){
			$.post("?task=admin&action=delete_an", "an_id="+anId, function(){
				$("#"+anId).next().slideUp();
				$("#"+anId).slideUp();
			})
		}
	}
}

//перевеод сотрудника в директоры
function ChangeStatus(userId){
	if(userId>0){
		var name = $("[data-id="+userId+"] [name=pe-name]").val() + " " + $("[data-id="+userId+"] [name=pe-second_name]").val();
		if(confirm("После подтвержния "+ name +" станет директором АН. Изменить статус сотрудника?")){
			$.post("?task=admin&action=change_status", "user_id="+userId, function(){
				window.location.reload();
			})
		}
	}
}

	
function remove_ip(id){
		$("div.row[data-id=" + id + "]").remove();
		$.ajax({
			type: 'POST',
			url: '?task=profile&action=del_ip',
			data: 'id=' + id, 
			success: function(ipId){
				alertify.success("Удалено!");
			}
		});	

}