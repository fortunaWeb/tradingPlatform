
function MenuButtonResize(){
	var width = $(".secondary_menu").width(),
		liCount = $(".secondary_menu .nav li").length
	$(".secondary_menu .nav li").css("width", width/liCount -1);
}

function showFotosMobile(var_id)
{
	var productDiv = $("div[data-name='mobile-fotos-"+var_id+"']");
	if($(productDiv).html() == ''){			
		$.ajax({		
			type:'POST',
			url:'?task=var&action=list_photos_mobile',
			data:"var_id="+var_id,
			success:function(html){
				$(productDiv).empty().append(html);

                document.getElementById('eyemsg'+var_id).style.display = 'block';
			}
		});
	}else{
		$(productDiv).empty();
	}
}

function CollectSample(varId, sampleId)
{

    jQuery.ajax({
        type: 'POST',
        url: '?task=profile&action=collect_sample',
        data: 'varId=' + varId + '&sampleId=' + sampleId,
        success: function(html) {
          //console.log(html);
        }
    })
}


function showFotosPayParseMobile(var_id, ngs)
{
	var productDiv = $("div[data-name='mobile-fotos-"+var_id+"']");
	if($(productDiv).html() == ''){			
		$.ajax({
			type:'POST',
			url:'?task=var&action=list_photos_pay_parse_mobile',
			data:"var_id="+var_id+"&ngs="+ngs,
			success:function(html){
				$(productDiv).empty().append(html); 
			}
		});
	}else{
		$(productDiv).empty();
	}
}


function createElement(name, attrs, style, text, parent_id) {
    var parent = document.getElementById(parent_id);
    var e = document.createElement(name);
    if (attrs) {
        for (key in attrs) {
            if (key == 'class') {
                e.className = attrs[key];
            } else if (key == 'id') {
                e.id = attrs[key];
            } else {
                e.setAttribute(key, attrs[key]);
            }
        }
    }
    if (style) {
        for (key in style) {
            e.style[key] = style[key];
        }
    }
    if (text) {
        e.appendChild(document.createTextNode(text));
    }
    parent.appendChild(e);
    
}

	function searchClearPoligon()
	{
        $("input#post_poligon_points").val('');
	}

	function changePagePost(page)
	{
        $("input#page_post_id").val(page);
        $("form#main_search").submit();
    }

    function changePage(page) {
	var url = window.location.search;
	if(url.match(/task=main/)!=null){
		if(url.match(/(.*page=)(\d)/)!=null){
			window.location = url.match(/(.*page=)(\d)/)[1]+page;
		 }else{
			window.location = url+"&page="+page;
		 }
	}else if(url.match(/task=buysell/)!=null){
		if(url.match(/(.*page=)(\d)/)!=null){
			window.location = url.match(/(.*page=)(\d)/)[1]+page;
		 }else{
			window.location = url+"&page="+page;
		 }
	}else if(url==""){
		url += $(".nav.nav-tabs li.active a").attr("href");
		window.location = url+"&page="+page;
	}
}

function sendLimit(){
var limit = document.getElementById('limit').value
                try {
                  history.pushState(null, null, '?&limit=' + limit);
                  return;
                } catch(e) {}
                location.hash = '#&limit=' + limit;
}




readyList = [];

function bindReady(handler){

	var called = false

	function ready() { // (1)
		if (called) return
		called = true
		handler()
	}

	if ( document.addEventListener ) { // (2)
		document.addEventListener( "DOMContentLoaded", function(){
			ready()
		}, false )
	} else if ( document.attachEvent ) {  // (3)

		// (3.1)
		if ( document.documentElement.doScroll && window == window.top ) {
			function tryScroll(){
				if (called) return
				if (!document.body) return
				try {
					document.documentElement.doScroll("left")
					ready()
				} catch(e) {
					setTimeout(tryScroll, 0)
				}
			}
			tryScroll()
		}

		// (3.2)
		document.attachEvent("onreadystatechange", function(){

			if ( document.readyState === "complete" ) {
				ready()
			}
		})
	}

	// (4)
    if (window.addEventListener)
        window.addEventListener('load', ready, false)
    else if (window.attachEvent)
        window.attachEvent('onload', ready)
    /*  else  // (4.1)
        window.onload=ready
	*/
}


function onReady(handler) {

	if (!readyList.length) {
		bindReady(function() {
			for(var i=0; i<readyList.length; i++) {
				readyList[i]()
			}
		})
	}

	readyList.push(handler)
}

  function checkTab(id) {
	var obj = document.getElementById(id)
	obj.className = 'active-search'
  }
  
  	function checkForm(val){
			if (val == 2) {
				document.getElementById('novo').style.display = 'block'
				document.getElementById('topic_id').value = val
				
			} else {
				document.getElementById('novo').style.display = 'none'
				document.getElementById('topic_id').value = val
			}
			checkTemplate()
		// console.log(val)
	}
	
	function checkTemplate(){
		var topic = $("button[name=topic_id].active").data("value");
		var parent = document.getElementById('parent_id').value
		$("#topic_id").val(topic);
		if (topic != 1) {
			topic = 2;
		}
		
		//console.log(temp) 
		if (parent && parent!='0') {
			parent = (parent == '2' && topic =='1') ? "1" : parent;
			var url = "?task=profile&action=newvar&topic_id="+topic+"&type_id="+ parent;
			jQuery.ajax({
				type: 'POST',
				url: '?task=profile&action=get_template', 
				data: 'type_id=' + parent + '&topic_id=' + topic,
				complete: function(){
					if (window.location.search != url)
					{
						window.location = url;
					}
				}
			});
		}
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

function sendSearch() {
	var val = $('#str').val();
	if(val.length > 1)
	{		
		$.post("?task=main&action=search_street", "street="+val, function(html){
			$(".street_list #str_list").remove();
			$(".street_list").append(html);
			$(".street_list").slideDown();
		})
	}
}

function sendParseSearch(parentId) {
	var val = $('#str').val();
	if(val.length > 1)
	{		
		$.post("?task=main&action=street_in_parse", "street="+val+'&parentId='+parentId, function(html){
			$(".street_list #str_list").remove();
			$(".street_list").append(html);
			$(".street_list").slideDown();
		})
	}
}

function sendParseSearchBuysell(parent_id) {
	var val = $('#str').val();
	if(val.length > 1)
	{		
		$.post(
			"?task=buysell&action=street_in_parse_buysell", 
			"street="+val+"&parent_id="+parent_id,
			function(html){
				$(".street_list #str_list").remove();
				$(".street_list").append(html);
				$(".street_list").slideDown();
		})
	}
}

function sendParseBuysellSearch() {
	var val = $('#str').val();
	if(val.length > 1)
	{		
		$.post("?task=buysell&action=street_in_parse", "street="+val, function(html){
			$(".street_list #str_list").remove();
			$(".street_list").append(html);
			$(".street_list").slideDown();
		})
	}
}

//вывод улиц имеющихся в базу вариантов
function GetStreetList(){
	var val = $('#str').val(),
		action = QueryString("action");
	if(val.length > 1)
	{
		$.post("?task=main&action=street_in_parse", "street="+val+"&action="+action, function(html){
			$(".street_list #str_list").remove();
			$(".street_list").append(html);
			$(".street_list").slideDown();
		})
	}
}


function addDStreet(j) {

    var street = $("li#str"+j).text();
    for(var i=0; i<5; i++)
    {
        var  str_input = $("input#street-"+i);
        if ($(str_input).val() == "")
        {
            $(str_input).val(street);
            $("span#span-"+i).text(street).css("display", "block");
            // $(".street_list").slideUp();
            return false;
        }else if($(str_input).val() == street)
        {
            // $(".street_list").slideUp();
            return false;
        }
    }

}
function addStreet(j) {

	var street = $("li#str"+j).text();
	for(var i=0; i<5; i++)
	{
		var  str_input = $("input#street-"+i);		
		if ($(str_input).val() == "")
		{
			$(str_input).val(street);
			$("span#span-"+i).text(street).css("display", "block");
			$(".street_list").slideUp();
			return false;
		}else if($(str_input).val() == street)	
		{
			$(".street_list").slideUp();
			return false;
		}
	}
}

function setStreet(j, street) {
	$("#str").val(street);
	$(".street_list").slideUp();
	$(".live_point_list").empty();
	$("#str").css("border-color", "#5cb85c");
	//$("ul#str_list").remove();
}

function setCity(j, city) {
	$("#live_point").val(city);
	$(".live_point_list").slideUp();
	$(".live_point_list").empty();
	$("#live_point").css("border-color", "#5cb85c");

	if(city != "Сочи"){
		$(".deployed").has("#dis").hide();
	 $("[name=dis]").val("");
	}else{
		$(".deployed").has("#dis").show();
	}
	$("ul#str_list").remove();
}

function removeStreet(cur_num) {
	
	$("span#span-"+cur_num).text("").hide();
	$("input#street-"+cur_num).val("");
	inputStrUpdate();	
}
  
  
function showSelect(id) {
	var obj = document.getElementById(id)
		if (obj.style.display == 'block') {
			obj.style.display = 'none'
		} else {
			obj.style.display = 'block'
		}
}
	
function inputStrUpdate(){
	var j = 0;
	var inputId = "";
	for(var i=0; i<5; i++)
	{
		var  str_input = $("input#street-"+i);
		if ($(str_input).val() != "")
		{
			j++;				
		}		
	}
	if(j>0){
		$("input#str").val("Выбрано [" + j + "]");
	}else{
		$("input#str").val("");
	}
	
}

function checkSearch(temp) {
	
	/*
	if(temp) {
		jQuery.ajax({
								type: 'POST',
							    url: '?task=main&action=get_search_template', 
							    data: 'template=' + temp, 
							    success: function(html) { 
											
			document.getElementById('template').innerHTML = html;
			var ua = navigator.userAgent.toLowerCase();
			var isAndroid = ua.indexOf("android") > -1; //&& ua.indexOf("mobile");
				if(isAndroid) {
					document.getElementById('str').setAttribute('onchange', 'sendSearch()')
				//	document.getElementById('str_button').style.display = 'block';
				} else {
					document.getElementById('str').setAttribute('onkeyup', 'sendSearch()')
					document.getElementById('str_button').style.display = 'none';
				}	
			}
		})
	}
	*/
}



function countType(e, type) {
	alert(type);
}

function countAttrType(e,type) {
	var length = $("."+type+"_list input:checkbox:checked").length;
	$("input[name="+type+"]").val("");
	if(e != "all"){
		$(e).parent().toggleClass("active");
	}else{
		if(length == 5){
			$("."+type+"_list input:checkbox").click();
		}else{
			$("."+type+"_list input:checkbox").each(function(){
				if(!$(this).prop("checked")){
					$(this).parent().click();
				}
			})
		}
		length = $("."+type+"_list input:checkbox:checked").length;
	}
	if(length > 0){
		$("input[name="+type+"]").val("Выбрано [" + length + "]");	
	}else{
		$("input[name="+type+"]").val("");	
	}
}

/**/


function countValueList(list,e) {
    var length = $("."+list+"_list input:checkbox:checked").length;

    $("input[name="+list+"]").val("");
    if(e != "all"){
        $(e).parent().toggleClass("active");
    }else{
        if(length == 10){
            $("."+list+"_list input:checkbox").click();
        }else{
            $("."+list+"_list input:checkbox").each(function(){
                if(!$(this).prop("checked")){
                    $(this).parent().click();
                }
            })
        }
        length = $("."+list+"_list input:checkbox:checked").length;
    }
    if(length > 0){
        $("input[name="+list+"]").val("Выбрано [" + length + "]");
    }else{
        $("input[name="+list+"]").val("");
    }
}


function mainDistCheck(dist) {
    // $("#main_subdist"+dist+" input:checkbox").click();
    if ($('input#main_dist'+dist).is(':checked')) {
        $("#main_subdist"+dist+" input:checkbox").prop('checked', true);
    }else{
        $("#main_subdist" + dist + " input:checkbox").prop('checked', false);
    }
}
function countDis(e) {
	var length = $(".district_list input:checkbox:checked").length;
	$("input[name=dis]").val("");
	if(e != "all"){
		$(e).parent().toggleClass("active");
	}else{
		if(length == 10){
			$(".district_list input:checkbox").click();
		}else{
			$(".district_list input:checkbox").each(function(){
				if(!$(this).prop("checked")){
					$(this).parent().click();
				}
			})
		}
		length = $(".district_list input:checkbox:checked").length;
	}
	if(length > 0){
		$("input[name=dis]").val("Выбрано [" + length + "]");
	}else{
		$("input[name=dis]").val("");
	}
}


function countOrigins(e) {
    var length = $(".origin_list input:checkbox:checked").length;
    $("input[name=origin]").val("");
    if(e != "all"){
        $(e).parent().toggleClass("active");
    }else{
        if(length == 10){
            $(".origin_list input:checkbox").click();
        }else{
            $(".origin_list input:checkbox").each(function(){
                if(!$(this).prop("checked")){
                    $(this).parent().click();
                }
            })
        }
        length = $(".origin_list input:checkbox:checked").length;
    }
    if(length > 0){
        $("input[name=origin]").val("Выбрано [" + length + "]");
    }else{
        $("input[name=origin]").val("");
    }
}



function closeParent(id) {
	var obj = document.getElementById(id)
	obj.style.display = 'none';
}

function countType(type) {
	var presButton = $("button#"+type);
	if(!$(presButton).hasClass("active")){	
		$("input[data-id="+$(presButton).attr("id")+"]").val($(presButton).data("value"));	
		$("input#type_id").val(parseInt($("input#type_id").val())+1);
	}else{
		$("input[data-id="+$(presButton).attr("id")+"]").val("");
		$("input#type_id").val(parseInt($("input#type_id").val())-1);
	}
	
}

function  openDescription(id){
	var productDescription = $(".product#"+id+" .product-description"),
		//buttonSpan = $(productDescription).find("span.glyphicon");
		spanForOpen = $(productDescription).find(".description");
	
	if ($(spanForOpen).css("height") == "55px")
	{
		$(spanForOpen).css("height", $(spanForOpen).find("div").css("height"));
		$($(productDescription).find(".shading")).hide();
		// $(spanForOpen).css("height", $(spanForOpen).find("div").height());
		// $(buttonSpan).removeClass("glyphicon-chevron-down");
		// $(buttonSpan).addClass("glyphicon-chevron-up");
	}else{
		$(spanForOpen).css("height", "55px");
		$($(productDescription).find(".shading")).show();
		// $(buttonSpan).removeClass("glyphicon-chevron-up");
		// $(buttonSpan).addClass("glyphicon-chevron-down");
	}
};

//добавление нового номера
function add_phone(id, userList){
		var button = $(".phone button[data-user="+id+"]"),
			phoneInput = $(button).parent().find("input"),
			phone = $(phoneInput).val();
		if(phone.match(/\d+\s\(\d+\)\s\d+-\d+/) != null){
			if(confirm("Добавить номер "+phone+" ?")){
				$.ajax({
					type: 'POST',
					url: '?task=profile&action=add_phone',
					data: 'phone=' + phone + "&user="+id, 
					success: function(html){
						if(userList){
							$(button).parent().parent().before(
								"<div class='col-xs-2 deployed'><label class='signature'>Основной</label><input type='text' onFocus='$(this).mask(\"8 (999) 999-9999\")' name='pe-phone_addon"+($(".employee[data-id=1] .row.phone").children().length-1)+"' class='form-control' placeholder='Телефоны для созвонов' value='"+phone+"' required disabled></div>"
							);
						}else{
							$("div.phoneAddon").append("<div class='input-group interval xl phone'><span class='input-group-addon success'>Активен</span><input type='text' class='form-control' value='"+phone+"' disabled><button onClick='delete_phone()' id='delete_phone' class='form-control btn btn-danger right disabled'>удалить</button></div>");
							$(phoneInput).val("");
						}
						$(".phone[data-id=new] [data-id=phone]").val("");
					},			
				});	
			}	
		}else{
			$(phoneInput).focus();
		}
}

//добавление
function add_email_work(id, userList){
		var button = $("input#email_work_"+id+".form-control"),
			emailInput = $(button).parent().find("input"),
			email = $(emailInput).val();	
			if(confirm("Рабочий e-mail "+email+" ?")){		
				$.ajax({
					type: 'POST',
					url: '?task=profile&action=add_email_work',
					data: 'email=' + email + "&user="+id, 

				});	
			}	
}

function add_email_pass(id, userList){
		var button = $("input#email_pass_"+id+".form-control"),
			passInput = $(button).parent().find("input"),
			pass = $(passInput).val();	
			if(confirm("Рабочий  пароль email "+pass+" ?")){		
				$.ajax({
					type: 'POST',
					url: '?task=profile&action=add_email_pass',
					data: 'pass=' + pass + "&user="+id, 

				});	
			}	
}


function add_external_login(id, userList){
	var button = $("input#external_login_"+id+".form-control"),
		loginInput = $(button).parent().find("input"),
		login = $(loginInput).val();	
	if(confirm("Логин для внешнего сайта "+login+" ?")){		
		$.ajax({
			type: 'POST',
			url: '?task=profile&action=add_external_login',
			data: 'login=' + login + "&user="+id, 

		});	
	}	
}

function add_external_pass(id, userList){
	var button = $("input#external_pass_"+id+".form-control"),
		passInput = $(button).parent().find("input"),
		pass = $(passInput).val();	
	if(confirm("Пароль внешнего сайта "+pass+" ?")){		
		$.ajax({
			type: 'POST',
			url: '?task=profile&action=add_external_pass',
			data: 'pass=' + pass + "&user="+id, 

		});	
	}	
}


function SampleAddVar(action_type, sample_id, var_id, type)
{
	var UlSamples = $("ul[data_sample='"+var_id+"']"),
			sample = $(UlSamples).parent().find("a[data-id='"+sample_id+"']"),
			sampleName = $(sample).text();
	console.log('!'+sample+'!');
		$.post('?task=profile&action=sample_add_var', 
			'var_id=' + var_id + '&sample_id=' + sample_id + '&type='+type + '&action_type='+action_type,
			function(isAdd){
			if(isAdd == 2){
				alertify.error("Вариант такой уже есть в подборке этой");		
			}else if(isAdd == 3){
				alertify.error("Подборка " + sampleName +" уже заполнена");		
			}else if(isAdd == 1){
				alertify.success("Добавлен");
			}
		});
}

//добавление нового ip-адреса
function add_ip(id, rentOrSell){
	var button = $(".ip button[data-user="+id+"]"),
		ipInput = $(button).parent().find("input")[1],
		browserInput = $(button).parent().find("input")[2],
		mobInput = $(button).parent().find("input")[0],
		ip = $(ipInput).val(),
		mob = '0',
		mobChecked = '',
		browser = $(browserInput).val();
		
		if($(mobInput).prop('checked')){mobChecked = ' checked ';mob = '1';}

		if(ip.match(/[\d+\.]+/) != null){
			alertify.confirm("Добавить новый ip-адрес "+ip+" ?", function(result){
				if(result){		
					$.ajax({
						type: 'POST',
						url: '?task=profile&action=add_ip',
						data: 'ip=' + ip + "&user="+id + "&rentOrSell="+rentOrSell + "&browser=" + browser + "&mob=" + mob, 
						success: function(ipId){
							$(button).parent().parent().before(
							"<div class='col-xs-1 deployed'> " +
									"<label class='signature'>мобила</label>" + 
									"<input type='checkbox' name='ad-rent_mob-" + id + "' " + 
										"class='form-control' style = 'width: 50px' placeholder='mob' " + 
											"value='" + mob + "' required='' value = '1' disabled='' " + mobChecked + " >" +
								"</div> " +
							"<div class='row fio' id = " + id + "><div class='col-xs-2 deployed'>" + 
							"<label class='signature'>IP</label>" + 
									"<input type='text' name='ad-"+rentOrSell+"_ip-"+ipId+"' class='form-control' placeholder='ip' " + 
											"value='"+ip+"' required='' disabled=''>" + 
								 "</div> " + 
								"<div class='col-xs-2 deployed'  style = '    margin-top: 58px;margin-left: -190px;'> " +
									"<label class='signature'>Браузер</label>" + 
									"<input type='text' name='ad-rent_browser-" + id + "' " + 
										"class='form-control' style = 'width: 640px' placeholder='browser' " + 
											"value='" + browser + "' required='' disabled=''>" +
								"</div>" + 
							"</div>");

							$(browserInput).val("");
							$(ipInput).val("");
						}
					})
				}
			})
		}else{
			$(ipInput).focus();
		}
}


/**/
// function add_phone_to_div(){
	// $(".phones").append("<div class='col-xs-2 deployed'><input type='text' id='phone' class='form-control' name='' value='' placeholder='доп. телефон'></div>");	
// }

//удаление номера телефона (запрос от агенства)
function delete_phone(id){
	var div = $("div.phone[data-id="+id+"]");
	var phone = $(div).find("input").val();
	var user = $(div).find("button").data("user");
	if(confirm("Отправить запрос на удаление номера "+phone+" ?")){		
		$.ajax({
			type: 'POST',
			url: '?task=profile&action=delete_phone',
			data: 'phone=' + phone + "&user="+user, 
			success: function(){
				$(div).find("span").text("Неактивен").removeClass("success").addClass("danger").addClass("disabled");
				$(div).find("button").addClass("disabled").attr("onclick", "");
			},			
		});	
	}	
}

//добавление допалнительных ip для АН
function ip_add(id){
	var addressDiv = $("#address div#"+id);	
	var index = $(addressDiv).find(".info").length;
	var type = id == "1" ? "rent"+index : "sell"+index;
	$("input[data-id="+id+"]").val(index);
	$(addressDiv).append("<div class='info' style='margin-top:10px'><div class='interval' style=''><input type='text' id='ip' class='form-control' style='max-width:150px' name='ip_"+type+"' placeholder='ip' value=''><div class='checkbox' style='margin-left:20px'><label><input type='checkbox' name='active_"+type+"'> Активный</label></div></div><button type='button' class='close' onclick='removeRow("+id+", "+index+")'><span>×</span></button><div class='input-group interval xxl' style='margin: 10px 0px;'><input type='text' id='str' class='form-control' name='street_"+type+"' style='min-width: 230px; max-width: 260px;' onkeypress='sendSearch()' placeholder='улица' value=''><input type='text' class='form-control' name='house_"+type+"' placeholder='дом' style='min-width: 60px; max-width: 60px;' value=''><input type='text' class='form-control' name='office_"+type+"' placeholder='офис' style='min-width: 60px; max-width: 60px;' value=''></div><textarea type='text' class='form-control' name='comment_"+type+"' placeholder='дополнение'></textarea></div>");
}

//выбор кого берут
function residentAdd(id){
	if (id == "all"){
		/*если все отмеченые то выберается множитель data-id=x*11, чтобы изменить data-id для дальнейших запросов*/
		id = $(".inside").length == $(".residents_list span").length-2 ? 12 : 1;		
		for(i=id; i<=id*10; i=i+id){
			residentAdd(i);
		}
		return false;
	}
	var residents = "";	
	var span = $("span[data-id="+id+"]");
	if(!$(span).hasClass("inside")){		
		$(span).attr({"data-id":""+(id*12)+"", "onClick":"residentAdd("+(id*12)+")"}).addClass("inside");		
	}else{
		var newId = id/12;
		$(span).attr({"data-id":newId, "onClick":"residentAdd("+newId+")"}).removeClass("inside");				
	}
	var insideCount = $(".inside").length,
		residentCountText = $(".inside").length == 0 ? "выберите" : "Выбрано ["+insideCount+ "]",
		spanText = insideCount == 10 ? "Всех" : "Всех";
	if($(".inside").length == 0 && QueryString('task')=='profile'){
		$("[name=residents]").next().css("border-color", "red");
	}else{
		$("[name=residents]").next().css("border-color", "#5cb85c");
	}
	$("span[data-id=all]").text(spanText);
	$("#residents .placeholderSpan").text(residentCountText);
	$(".inside").each(function(){
		residents += $(this).text()+ "||";
	})
	$("input[name=residents]").val(residents);	
}

//отображение условий показа
function view_price(){
	var view_price = $(".input-group#view_price");
	if(!$(view_price).find("[type=checkbox]").prop("checked"))
	{
		$($(view_price).find("span")[1]).css({'background-color':'rgba(215, 215, 215, 0.1)',  'color':'#9B9B9B'});
		$(view_price).find("select").css({'color':'#9B9B9B'});
		$("[name=ap_view_price] option:selected").prop("selected", false);
	}else{
		$($(view_price).find("span")[1]).css({'background-color': 'rgba(234, 251, 236, 1)',  'color':'#555'});
		$(view_price).find("select").css({'color':'#555'}).prop("disabled", "");	
	}
}

//удаление div'a или строки, где находется объект
function removeRow(id, index){
	try{
		$("#address div#"+id+" .info")[index].remove();		
		var ip_count = $("input[data-id="+id+"]").val();
		$("input[data-id="+id+"]").val(ip_count - 1);
	}catch(err){
		removeRow(id, index - 1)
	}
};

//показ кнопок при отметки варианта в своих сообщениях
function showButtons(odj){
	if($(odj).prop("checked")){
		$("[data-id=control-buttons] button").show();
		$("[data-id=control-buttons] span").show();
	}else if ($(".product :checked").length == 0){
		$("[data-id=control-buttons] button").hide();
		$("[data-id=control-buttons] span").hide();
		$("[data-id=checkAll]").prop("checked", false);
	}
}


$(document).ready(function() {

	$(document).on("mouseover", ".chat .mess a", function(){
		if($(this).attr("title")==""){
			var user_id = $(this).data("user-id");
			var obj = $(this);
			$.post("?task=chat&action=chat_user_info", "user_id="+user_id, function(html){
				$(".chat [data-user-id="+user_id+"]").attr("title", html);
			})
		}
		$(this).tooltip('show');
	})
		
	setInterval(function(){
		if($(".chatContent").is(":visible") && !$("#chatNewMess textarea").is(":focus")){
			UpdateChatCountMess();
		}
	}, 5000);
	

	$("label#main-polong").on("click", function(){
		var login = $("input[name=login]").val();
		var password = $("input[name=password]").val();
		loading(1);
		if(login != '' && password != ''){
			jQuery.ajax({
				type: 'POST',
				url: '?task=login&action=check_update',
				data: "login="+login+"&password="+password,
				success: function(html){
					if(html=='OK'){
					alertify.confirm("Продлить варианты ?", function(result){
						if (result) {
							jQuery.ajax({
								type: 'POST',
								url: "?task=login&action=var_update", 	
								data: 'update='+'1',									
								success: function(html_update) {				
									if(html_update == 'UPDATE') {
										alertifysuccess("Варианты продлены");
									}else{
										alertify.alert("ОШИБКА ' "+ html_update+" '");
									}
								}
							});	
						}
					});
					}else{
						if(html != ''){
							alertify.alert(html);
						}
					}
				}
			});	
		}
	});

	$("#nickCreate").submit(function(e){
		e.preventDefault();
		var nick = $("#nickCreate input").val();
		NewChatNick(nick, null);
	});
	
	$(document).on("submit", "#chatNewMess", function(e){
		e.preventDefault();
		var text = $('#chatNewMess textarea').val();
		if(text!=""){
			ChatNewMessSend(text);
		}
	});
	
	$(document).on('keydown', '#chatNewMess textarea', function( e ) {
		if( e.keyCode == 13 ) {
			e.preventDefault();
			$('#chatNewMess [type=submit]').click();	
		}
	});
	
	$(document).on("click", "[data-name=fav_star]", function(){
		if($(this).attr("onClick") == undefined){
			var product = $(".product").has($(this));
			if($(this).find("img").attr("src").indexOf("favorites_all") < 0){
				addToFavorites($(product).data("user").toString(), $(product).data("id"));
			}else{
				removeFromFavorites($(product).data("user").toString(), $(product).data("id"));
			}
		}
	})
	
	//добавить варианты на открытый сайта
	$("[data-id=for_open_site]").on("click", function(){
		if($(this).is(":checked")){
			$.post("?task=profile&action=for_open_site", "val=1", function(){
				alertify.success("Готово!");
			})
		}else{
			$.post("?task=profile&action=for_open_site", "val=2", function(){
				alertify.success("Готово!");
			})
		}
	})


	
	//удаление отзыва хозяеном или админом в частниках
	$(document).on('click', '[data-name=review_parse]', function(){
		var obj = $(this).parent(),
			id = $(obj).attr('id'),
			name = "review_parse";
		if(QueryString("action")=="pay_parse"){
			name="review_pay_parse";
		}
		if(QueryString("action")=="mytype" && (QueryString("active")=="0" || QueryString("active")=="1")){
			name = "review";
		}
		$.post("?task=profile&action=delete", "id="+id+"&name="+name+"&people_id="+$(obj).data("people-id"), function(){
			$("div.comment").has($(obj)).remove();
			//window.location.reload();
		})
	})
	
	//закрытие сообщения от админа
	$(document).on("click", ".admin-mes .close", function(){
		var messId = $(this).data('id');

		$.post("?task=chat&action=read_mes&mess="+messId);
	})

	//закрытие сообщения от админа
	$(document).on("click", ".showFotosPayParse", function(){
		var messId = $(this).data('id'),
			ngs = $(this).data('name');
			isNgs = 0;
		if(ngs == 'ngs'){
			isNgs = 1;
		}
		showFotosPayParseMobile(messId, isNgs);
	})

	//Показать Фотки
	$(document).on("click", ".showFotos", function(){
		var messId = $(this).data('id');
		showFotosMobile(messId);
	})

	//закрытие сообщения от админа
	$(document).on("click", ".rent-mess .close", function(){
		var messId = $(this).data('id');
		$.post("?task=chat&action=read_mes_rent&mess="+messId);
	})

	//закрытие сообщения от админа
	$(document).on("click", ".rent-mess-ansver .close", function(){
		var messId = $(this).data('id');
		$.post("?task=chat&action=read_mes_rent&mess="+messId);
	})


	//вывод риелтеров в поиске для исключения из своей группы
	if((QueryString("action")=="edit" || QueryString("action")=="newvar" || QueryString("action")=="group_setting") && QueryString("task")=="profile"){
		var id="";
		$(".an_list").on("click", function(){
			if(id!=$("[name=company_id]").val()){
				id=$("[name=company_id]").val();
				if(id!=""){
					$.ajax({
						type:"POST",
						url:"?task=profile&action=find_rielter",
						data:"id="+id,
						success:function(html){
							if(html != "﻿"){
								$("table[data-id=seacrh-rielter] tbody").empty().append(html);
							}else{
								alertify.alert("Риелтер с данным номером не обнаружен");
							}
						}
					})
				}
			}
		})
	}
	
	
	/*открытие нового окна*/
	$(document).on("click", "[data-id=new-window]", function(e){
		e.preventDefault();
		window.open($(this).attr("href"), '_blank');
	})
	

	$(document).on("keyup", "#str, #live_point", function(){
		if(QueryString("task")=="profile" || QueryString("task")=="admin"){
			var url, 
				data, 
				container;
			if($(this).attr("id")=="str"){
				url = '?task=profile&action=search_street';
				data = 'street=' + $(this).val();
				if(QueryString('action') == "newvar" || QueryString('action') == "edit" || QueryString("task")=="admin"){
					container = $(".street_list");
				}else{
					container = $(".street_list #str_list");
				}
			}else{
				url = '?task=profile&action=search_city';
				data = 'name=' + $(this).val();
				container = $(".live_point_list");
			}
			$.post(url, data, function(html){
				$(container).empty();
				$(container).append(html);
				$(container).slideDown();
			});
		}
	});
	
	$(".product").click(function(){
		var shading = $(this).find(".shading");
		if($(this).css("background-color") == "rgb(245, 204, 107)"){
			$(shading).css({'-webkit-box-shadow':'', 'box-shadow':''});
			$(this).css("background-color", "");
		}else{
			$(shading).css({'-webkit-box-shadow':'inset 0px -8px 10px -2px rgb(245, 204, 107)', 'box-shadow':'inset 0px -8px 10px -2px rgb(245, 204, 107)'});
			$(this).css("background-color", "rgb(245, 204, 107)");
		}

	});

	//смена владельца варианта
	$(document).on("click", ".change-owner-list>div", function(){
		var obj = $(this),
			message = "Вы уверены, чтобы новым владельцем варианта был "+$(obj).text()+"?",
			varId = $(".product").has(obj).data('id'),
			userId = $(obj).data("id");
		alertify.confirm(message, function(result){
			if(result){
				$.post("?task=var&action=change_owner", "user_id="+userId+"&var_id="+varId, function(){
					alertify.success("Владелец варианта успешно изменен.");
					//$(".product[data-id="+varId +"]").slideUp();
					window.location.reload();
					$(".product[data-id="+varId+"] [data-name=io]").html($(obj).html());
				});
			}else{
				$(this).parent().slideUp();
			}
		});		
	});
	
	//растягивание кропок меню
	MenuButtonResize();
	$(window).resize(function(){
		MenuButtonResize();
	});

	//проверка варианта в частниках
	$(document).on("click", "[data-name=check-var]", function(){
		var id = $(".product").has($(this)).data("id"),
			table = $(this).data('id');
		$(".form-inline").append("<div class='progress' style='width: 103%;height: 100%; position: fixed;z-index: 9999;top: 0;margin-left: -10px;background-color: rgba(0, 0, 0, 0.5);text-align: center;'><p style='margin-top: 250px;font-size: 20px;color: #fff;'>Загрузка</p></div>");
		loading(1);
		$.get("?task=main&action=check_var", "var_id="+id+"&table="+table, function(html){

			$(".modal-body").css({"overflow":"scroll", 'max-height': '450px'});
			$("#clean-modal-win .modal-title").empty().append("Похожие варианты от частников");
			$("#clean-modal-win .modal-dialog").css("max-width", "");
			$("#clean-modal-win .btn-default").text("Закрыть");
			$("#clean-modal-win .btn-primary").remove();

			if($(html).find(".products-list .product").length > 0){

				$("#clean-modal-win .modal-body").empty().append($(html).find(".products-list .product"));
				$("#clean-modal-win .modal-body .product a").removeAttr("data-target").removeAttr("onclick").removeAttr("target").removeAttr("data-toggle");				
			}else if(table == "parse"){				
				$("#clean-modal-win .modal-body").empty().append("Похожих вариантов от частников нет.");
			}else if(table == "pay_parse"){
				$("#clean-modal-win .modal-body").empty().append("Похожих вариантов от 'частников 2' нет или доступ к данным частникам закончился.");
			}else if(table == "archive"){
				$("#clean-modal-win .modal-body").empty().append("Похожих вариантов  в архиве нет.");
			}
			$(".progress").remove();
		})
	});

	
	//скрытие списка
	$(document).on("click", function(e){
		if(!$(".street_list").parent().has($(e.target)).length>0 && !$(".street_list").is($(e.target))){
			$(".street_list").slideUp();
		}
		if(!$(".live_point_list").parent().has($(e.target)).length>0 && !$(".live_point_list").is($(e.target))){
			$(".live_point_list").slideUp();
		}
		if(!$(".change-owner-list").parent().has($(e.target)).length>0 && !$(".change-owner-list").parent().is($(e.target))){
			$(".change-owner-list").slideUp();
		}
	});
	
	//отображение стрелки прокрутки вверх
	$(window).on("scroll", function() {
		if ($(window).scrollTop() > 1000) $('.slide-top').removeClass('hidden');
		else $('.slide-top').addClass('hidden');
    });
	
	//поиск названия АН (по аналогии с улицами)
	$("[data-name=an-list]").on("keyup", function(){
		if($(this).val().length>0){
			$.ajax({
				type: 'POST',
				url: '?task=profile&action=search_an', 
				data: 'an=' + $(this).val(), 
				success: function(html) { 
					$(".an_list").text("");
					$(".an_list").append(html);
					$(".an_list").slideDown();
				}
			});
		}else{
			$("[name=company_id]").val("");
			$(".an_list").slideUp();
		}
	});	
		
	//отображение сотруднико выбранного агенства
	$(document).on("change", "form#child_profile select[name=company_id]", function(){
		var id = $(this).val(),
			row = $(".row").has($(this));
		/*далее идет изменение страницы для использования метода 'ShowEmployees' (чтобы не переделывать метод)*/
		$(row).find(".col-xs-12").remove();
		$(row).append("<div class='col-xs-12'><table class='table table-striped list'><tbody><tr id='"+id+"'><td style='display:none'></td></tr></tbody><table></div>");
		ShowEmployees(id);
	})
	
	//открытие списка отзывов по данному варианту
	if(QueryString("task")!="admin"){
		$(document).on("click", "[data-id=review]", function(){
			var varId = $('.product').has($(this)).data('id'),
				search_user_id = $("[name=search_user_id]:checked").val();
			if(search_user_id == "ngs" || QueryString('action')=="favorites_parse"){
				search_user_id = "pay_parse";
			}else if($(this).data("name")=="pay_parse"){
				search_user_id = "pay_parse";
			}else{
				search_user_id = "site";
			}
			var delBtn ="";
			if(QueryString("action")=="mytype" && (QueryString("active")=="0" || QueryString("active")=="1")){
				delBtn = "&delBtn=1";
			}
			$("#clean-modal-win .btn-primary").remove();
			$("#clean-modal-win .btn-default").text("Закрыть");
			$("#clean-modal-win .modal-title").text("Список отзывов по данному варианту");
			$("#clean-modal-win .modal-body").empty();
			$.ajax({
				type:'POST',
				url:'?task=var&action=review_list_for_rielter',
				data: "id="+varId+"&search_user_id="+(search_user_id)+delBtn,
				success:function(html){
					$('#clean-modal-win .modal-body').prepend(html);
				}
			})
		})
	}
	
	//модальное окно добавления в черный список
	$(document).on("click", "[data-name=add-to-black-list], [data-name=black-agent]", function(){
		var varId = $('.product').has($(this)).data('id'),
			people_id = $(".product[data-id="+varId+"] [data-name=people]").data('people-id');
		if($(this).data('name') == 'add-to-black-list'){
			$("#add-to-black-list-modal-win .btn-primary").attr("onClick", "AddToBlackList("+varId+")");
			$("#add-to-black-list-modal-win .modal-title").text('Добавление риелтера в черный список');
			$("#add-to-black-list-modal-win .modal-footer").show();
			$("#add-to-black-list-modal-win textarea").parent().show();
		}else{
			$("#add-to-black-list-modal-win .modal-title").text('Список заметок');
			$("#add-to-black-list-modal-win .modal-footer").hide();
			$("#add-to-black-list-modal-win textarea").parent().hide();
		}
		$.ajax({
			type:'POST',
			url:'?task=var&action=black_list_comments',
			data: "people_id="+people_id,
			success:function(html){
				$('#add-to-black-list-modal-win .modal-body').find(".comment, legend").remove();
				$('#add-to-black-list-modal-win .modal-body').prepend(html);				
			}
		})
	});		

	//модальное окно для написния отзыва
	$(document).on('click', '[data-name=send-review]', function(){
		var varId = $('.product').has($(this)).data('id');
		$("#send-review-modal-win .btn-primary").attr("onClick", "SendReview("+varId+")");
	});

    $(document).on('click', '[data-name=parse_var_clone]', function()
    {
        var varId = $('.product').has($(this)).data('id');
        $.post(
            "?task=buysell&action=parse_var_clone",
            "var_id="+varId,
            function(html){
                if( html=='oK'){
                    alertify.success("Вариант успешно клонирован.");
                }else{
                    alertify.error("Ошибка клонирования.");
                }
            });
    });


    $(document).on('click', '[data-name=var_clone]', function()
    {
        var varId = $('.product').has($(this)).data('id');
        $.post(
            "?task=buysell&action=var_clone",
            "var_id="+varId,
            function(html){
                if( html=='oK'){
                    alertify.success("Вариант успешно клонирован.");
                }else{
                    alertify.error("Ошибка клонирования.");
                }
            });
    });

	//для отправки варианта в подборку
	$(document).on('click', '[data-name=send-sample]', function(){

		var varId = $('.product').has($(this)).data('id'),
			sampleId = $(this).data('id'),
			type = $(this).data('type'),
            action_type = $(this).data('action_type'),
			text = $('.product').has($(this)).find(".comment").text();
		$("form#send-sample textarea").val(text);

		$("#send-sample-modal-win .btn-primary").attr("onClick", 
				"SendSample("+varId+","+sampleId+",'"+type+"', '"+action_type +"',1)");
		$("#send-sample-modal-win .btn-primary-emply").attr("onClick",
				"SendSample("+varId+","+sampleId+",'"+type+"', '"+action_type+"',0)");
	});

	//отображение информации об АН(заполнение модального окна)
	$(document).on('click', '[data-name=an-info]', function(){
		$("#clean-modal-win .modal-title").text("Информации о агентстве недвижимости");
		$("#clean-modal-win .btn-primary").remove();
		$("#clean-modal-win .btn-default").text("Закрыть");
		$("#clean-modal-win .modal-dialog").css("max-width", "700px");
		var varId = $('.product').has($(this)).data('id');
		$.ajax({
			type: "POST",
			url: "?task=profile&action=an_info",
			data: "var_id="+varId,
			success: function(html){
				$("#clean-modal-win .modal-body").html(html);
			}
		})
	});

	//отметка всех вариантов в своих сообщениях
	$("input[data-id=checkAll]").on("change", function(){ 
		var checkedCount = $(".product :checkbox:checked").length;
		var productCount = $(".product").length;
		var buttonsControl = $("div.col-xs-12").has($(this)).find("button");
		if (checkedCount != productCount && $(this).prop("checked")){
			$(".product [type=checkbox]").prop("checked", true);
			$(buttonsControl).show();
		}else if (!$(this).prop("checked")){
			$(".product [type=checkbox]").prop("checked", false);
			$(buttonsControl).hide();
		}
	});

    //выбор района при создании варианта
    $(".district_list_to_add span").on("click", function(){
    	var district = $(this).text();
        $("#dis").val(district );
        console.log(district);
        $(".district_list_to_add").slideUp();
        $("[name=dis]").css("border-color", "#5cb85c");
        $.ajax({
            type: "POST",
            url: "?task=buysell&action=get_subdistr",
            data: "district="+district ,
            success: function(html){
                $("#subdistrict_list_to_add").html(html);
                $("#sub_dis").val('');
            }
        })
    });

    $(document).mouseup(function(e){
		if ($(".district_list_to_add").css("display") != "none"){			
			var obj = $(".district_list_to_add");
			if(!obj.is(e.target) && obj.has(e.target).length == 0){
				$(".district_list_to_add").slideUp();
			}  
		}
	});	

	// Смена количества вариантов на странице
	$("select#limit").on("change", function(){
		var limit = $(this).val();		
		jQuery.ajax({
			type: 'POST',
			url: '?task=main&action=save_limit', 
			data: 'limit=' + limit, 
			success: function(){
				$("#msg-box .msg").hide();
				$("#msg-box").append("<img src='/images/ajax-loader.gif' id='ajax-loader'/>");
			},
			complete: function() { 
				window.location.reload();
			}
		});	
	});
	
	//отображение формы ввода адреса
	$("#group_topic_id").on("change", function(){			
		var divIdForOpen = $(this).find("option:selected").val();
		if(divIdForOpen != "3" && divIdForOpen == "1"){
			$("#address #1").slideDown();
			if($("#address #2").css("display") == "block"){
				$("#address #2").slideUp();
			}
		}else if(divIdForOpen != "3" && divIdForOpen == "2"){
			$("#address #2").slideDown();
			if($("#address #1").css("display") == "block"){
				$("#address #1").slideUp();
			}
		}else if(divIdForOpen==""){
			$("#address #1").slideUp();
			$("#address #2").slideUp();
		}else{
			$("#address div").slideDown();
		}
	});
	
	//множественный выбор элементов
	$(document).on("click", ".btn-group.multi-active button", function(){
		$(this).toggleClass("active");
	});
	
	//две кнопки по методу тумблера(нажата всегда только одна)
	$(document).on("click", ".btn-group.toggle button", function(){
		var parent = $(this).parent();	
		if(!$(this).hasClass("active"))
		{
			$(parent).find("button.active").removeClass("active");
			$(this).addClass("active");				
		}
	});	
	
	//показ описания объекта или раскрытие поисковика
	$("#advanced-search-toggle").on("click", function(){			
		if ($("#advanced-search").css("display")=="none")
		{
			$("#advanced-search").slideDown();
		}
		else{
			$("#advanced-search").slideUp();
		}
	});
	
	$(window).resize(function(){
		loginShow();
	});

    //показ выбора районов
    $(document).on("click", "input[id=subdist]", function(){
        if($("div.address_modal").css("display") == "none"){
            $("div.address_modal").slideDown();
        }else{
            $("div.address_modal").slideUp();
        }
    });
    $(document).on("click", "label[id=subdist_complete]", function(){
        if($("div.address_modal").css("display") == "none"){
            $("div.address_modal").slideDown();
        }else{
            $("div.address_modal").slideUp();
        }
    });
    $(document).on("click", "label[id=subdist_clear]", function(){

        for(dist=1; dist<5; dist++){
            $('input#main_dist'+dist).prop('checked', false);
            $("#main_subdist" + dist + " input:checkbox").prop('checked', false);
        }

    });


    //
    // //показ выбора районов
    // $(document).on("click", "a[id=subdist]", function(){
    //     if($("div.subdist_modal").css("display") == "none"){
    //         $("div.subdist_modal").slideDown();
    //     }else{
    //         $("div.subdist_modal").slideUp();
    //     }
    // });


    //показ выбора районов
    $(document).on("click", "input[name=dis]", function(){
        if($("div.district_list").css("display") == "none"){
            $("div.district_list").slideDown();
        }else{
            $("div.district_list").slideUp();
        }
    });

    //показ выбора сточников
    $(document).on("click", "input[name=origin]", function(){
        if($("div.origin_list").css("display") == "none"){
            $("div.origin_list").slideDown();
        }else{
            $("div.origin_list").slideUp();
        }
    });

    //показ выбора планировки
	$(document).on("click", "input[name=planning]", function(){
		if($("div.planning_list").css("display") == "none"){
			$("div.planning_list").slideDown();
		}else{
			$("div.planning_list").slideUp();
		}
	});

//показ выбора Типа квартиры
	$(document).on("click", "input[name=house_type]", function(){
		if($("div.house_type_list").css("display") == "none"){
			$("div.house_type_list").slideDown();
		}else{
			$("div.house_type_list").slideUp();
		}
	});

	//показ выбора Гаражей
	$(document).on("click", "input[name=garage]", function(){
		if($("div.garage_list").css("display") == "none"){
			$("div.garage_list").slideDown();
		}else{
			$("div.garage_list").slideUp();
		}
	});
	//показ выбора Воды
	$(document).on("click", "input[name=water]", function(){
		if($("div.water_list").css("display") == "none"){
			$("div.water_list").slideDown();
		}else{
			$("div.water_list").slideUp();
		}
	});
	//показ выбора Отопления
	$(document).on("click", "input[name=heating]", function(){
		if($("div.heating_list").css("display") == "none"){
			$("div.heating_list").slideDown();
		}else{
			$("div.heating_list").slideUp();
		}
	});

	//показ выбора  Машинка
	$(document).on("click", "input[name=wash]", function(){
		if($("div.wash_list").css("display") == "none"){
			$("div.wash_list").slideDown();
		}else{
			$("div.wash_list").slideUp();
		}
	});

	//показ выбора Туалета
	$(document).on("click", "input[name=wc]", function(){
		if($("div.wc_list").css("display") == "none"){
			$("div.wc_list").slideDown();
		}else{
			$("div.wc_list").slideUp();
		}
	});


	//скрытие "кого берут"/скрыть меню варианта
	$(document).mouseup(function(e){
		if ($(".residents_list").css("display") != "none"){			
			var obj = $(".residents_list").parent();
			if(!obj.is(e.target) && obj.has(e.target).length == 0){
				$(".residents_list").slideUp();
				$("#residents").removeClass("focus");
			}	
		}
		if(!$(".product-menu").is(e.target) && $(".product-menu").has(e.target).length == 0){
			$(".product-menu").slideUp('fast');
		}		
	});		
	//показ "кого берут"
	$(document).on("click", "#residents", function(){
		if($("div.residents_list").css("display") == "none"){
			$("div.residents_list").slideDown();
		}else{
			$("div.residents_list").slideUp();
		}
	});	
	//отметка возможных жильцов при редактировании варианта
	var residentsStr = $("[name=residents]").val();
	$(".residents_list span").each(function(){ 
		if(residentsStr.indexOf($(this).text())>=0) 
		{
			$(this).click();
		}
	});
	//показ премиумов в редактировании
	if($("[name=status]:checked").val()==3 || $("[name=status]:checked").val()==2)
	{
		$("#premium").show();
	}
    //скрытие выбора районов
    $(document).on("click", "button#closeDistrictList", function(){
        $(this).parent().slideUp();
    });
    $(document).mouseup(function(e){
        if ($(".district_list").css("display") != "none"){
            var obj = $(".district_list");
            if(!obj.is(e.target) && obj.has(e.target).length == 0){
                $(".district_list").slideUp();
            }
        }
    });

    //скрытие выбора планировки
    $(document).on("click", "button#closePlaningList", function(){
        $(this).parent().slideUp();
    });
    $(document).mouseup(function(e){
        if ($(".planning_list").css("display") != "none"){
            var obj = $(".planning_list");
            if(!obj.is(e.target) && obj.has(e.target).length == 0){
                $(".planning_list").slideUp();
            }
        }
    });

    /*догружает фотографии данного объекта*/
	$(document).on("click",".fancybox-thumbs img", function (e){
		var obj = $(this).parent(),
			link = $(obj).parent().find("a").first(),
			varId = $(obj).data("fancybox-group");
			dataFGroup = $(obj).data("fancybox-group");
		if($(link).length == 1 && $(link).attr("href").match(/main.jpg||zenit1.png/) != null){
			$(".products-list").append("<div class='progress' style='width: 50%;height: 100%; position: fixed;z-index: 9999;top: 0;margin-left: -10px;background-color: rgba(0, 0, 0, 0.5);text-align: center;'><p style='margin-top: 250px;font-size: 20px;color: #fff;'>Загрузка</p></div>");
			loading(1);
			jQuery.ajax({
				type: 'POST',
				url: '?task=var&action=photo_list',
				data: "varId="+$(obj).data("fancybox-group")+"&url="+$(obj).attr("href")+"&type="+$(obj).data("type"),
				success: function(html){
					if(html=='over'){
						alertify.alert("Сегодня вы больше не можете просматривать фотографии");
						$(".progress").remove();
					}else{
						if(document.getElementById('eye'+varId)){
                            document.getElementById('eye'+varId).style.display = 'block';
						}
                        dataFGroup = $(obj).data("fancybox-group");
						var images = html.split(',');
						$.fancybox(
							images,
						{
							helpers : {
								thumbs : {
									width  : 50,
									height : 50
								}
							}
						});
						$(".progress").remove();
					}

				}
			});	
			e.preventDefault();
			e.stopPropagation();
		}
	})

		
	$("#search .street_list").on("click", function(){
		inputStrUpdate();
	});
	
	$("#search input#str").on("click", function(){
		if($(this).val().slice(0,-4) == "Выбрано")
		{
			$(this).val("");
			$("ul#str_list").remove();
			$("div.street_list").css("display", "block");
		}
	});	
});


function checkPass() {
	if ($("#pass").val().length<6){
		$("#pass").parent().addClass("has-error");
		$("#pass").focus();
		return false;
	}
}

function closeResponse() {
	location.href='?task=profile&action=change_profile';
}
function confirmResponse(confirm) {
	if (confirm == 'yes') {
			location.href='?task=profile&action=delete_profile&user_id=' + document.getElementById('checkResponse_user_id').value;
		} else {
			document.getElementById('checkResponse').style.display = 'none';
		}
}
function user_to_archive(user_id) {
	var row = $("tr#"+user_id);
	var user_name = $('tr#'+user_id+' th[data-id=login]').text().replace(/\s+/, "");
	if (confirm("Перенести пользователя '"+user_name+"' в архив?")) {
		jQuery.ajax({
			type: 'GET',
			url: "?task=profile&action=profile_to_archive&user_id="+user_id, 			
			complete: function() {				
				$(row).slideUp();
			}
		});	
	}
}

function delete_user(user_id) {
	var row = $("form[data-id="+user_id+"]");
	var user_name = $('form[data-id='+user_id+'] [name=us-login]').val().replace(/\s+/, "");
	alertify.confirm("Уволить пользователя '"+user_name+"'?", function(result){
		if (result) {
			jQuery.ajax({
				type: 'GET',
				url: "?task=profile&action=delete_profile&user_id="+user_id, 			
				complete: function() {				
					$(row).slideUp();
				}
			});	
		}
	})	
}

function DeleteVar(id, checkedReview){
	if(id == "checked"){
		id = "";
		$(".product :checked").each(function(){
			id += $(this).data("id")+",";
		})
	}
	if (confirm("Подтвердите удаление.")) {
		jQuery.ajax({
			type: 'POST',
			url: '?task=profile&action=deletevar', 
			data: 'var_ids=' + id, 
			success: function() {
				var ids_array = id.toString().split(','),
					count = ids_array.length == 1 ? 2 : ids_array.length;
				for(i=0; i<count - 1; i++){
					var productDiv = $(".product[data-id="+ids_array[i]+"]");
					$(productDiv).children().remove();
					$(productDiv).append("<h3 class='center' style='color: rgb(242, 14, 14);'>удалено</h3>");
					if(checkedReview == 1){CheckedReview(id, 1);}
				}
			}
		});		
	}
}

function addToFavorites(user_id, var_id)
{
	var data = 'var_id=' + var_id,
		count = parseInt($("#favorites-count").text().match(/\d/));
	if(user_id=="ngs" || user_id=="avito"){
		data+='&ngs=1';
	}else if(user_id=="pay_parse"){
		data+='&pay_parse=1';
	}
	jQuery.ajax({
		type: 'POST',
		url: '?task=profile&action=add_favorites', 
		data: data, 
		success: function(html) {
			alertify.success("Вариант добавлен в избранное");
			if($(".product-menu").is(":visible")){
				$(".product-menu").slideUp('fast');
			}
			$("[data-id="+var_id+"] [data-name=fav_star] img").attr('src', 'images/icon/favorites_all.png');
			$("[onclick='addToFavorites(\""+user_id+"\", "+var_id+")'] div").text('в избраном');
			$("[onclick='addToFavorites(\""+user_id+"\", "+var_id+")']").attr('onClick', "removeFromFavorites(\""+user_id+"\", "+var_id+")");
			$("#favorites-count").empty();
			$("#favorites-count").text(" избр:" + (count+1));
		}
	});
}

function removeFromFavorites(user_id, var_id){
	//if(confirm("Убрать вариант из числа избранных?")){
    //}
		var favoritStr = $(".product[data-id="+var_id+"] input[data-name=favorit]").val(),
			data = 'var_id=' + var_id + "&favorit_str="+ favoritStr,
			count = parseInt($("#favorites-count").text().match(/\d/));
		if(user_id=="ngs" || user_id=="avito"){
			data+='&ngs=1';
		}else if(user_id=="pay_parse"){
			data+='&pay_parse=1';
		}
		jQuery.ajax({
			type: 'POST',
			url: '?task=profile&action=remove_from_favorites',
			data: data,
			success: function(html) {
				alertify.success("Вариант удален из списка избранных");
				if($(".product-menu").is(":visible")){
					$(".product-menu").slideUp('fast');
				}
				$("[data-id="+var_id+"] [data-name=fav_star] img").attr('src', 'images/icon/favorites.png');
				//$(".product[data-id="+var_id+"] input[data-name=favorit]").remove();
				$("[onclick='removeFromFavorites(\""+user_id+"\", "+var_id+")'] div").text('в избраное');
				$("[onclick='removeFromFavorites(\""+user_id+"\", "+var_id+")']").attr('onClick', "addToFavorites(\""+user_id+"\", "+var_id+")");
				$("#favorites-count").empty();
				$("#favorites-count").text(" избр:" + (count-1));
				if($("label.active .badge").length == 1){
					$("label.active .badge").text(count-1);
				}
				if(QueryString("task")=="profile"){
					$("[data-id="+var_id+"]").slideUp();
				}
			}
		});
}

function VarExtend(id, txt)
{

	var dateLastEditArr,
		dateLastEdit,
		dateArr,
		timeArr,
		date = new Date();
	if (id == "checked"){
		id = "";
		$(".product :checked").each(function(){
			id += $(this).data("id")+",";
		});
	}

	if(id != ""){

        jQuery.ajax({
            type: 'POST',
            url: '?task=profile&action=var_extend',
            data: 'var_ids=' + id,
            success: function() {
                window.location.reload();
            }
        });
        // alertify.confirm(txt, function(result){
		// 	if (result) {
		// 	}
		// })
	}else{
		alertify.alert("Нет вариантов для обновления! Обновлять варианты можно 1 раз в час.");
		$(".products-list :checkbox").prop("checked", false);
		$(".extend").hide();
	}
}



function VarExtendOne(id, prolong)
{
	var dateLastEditArr,
		dateLastEdit,
		dateArr,
		timeArr,
		date = new Date();
	if (id == "checked"){
		id = "";
		$(".product :checked").each(function(){
			id += $(this).data("id")+",";
		});
	}
	if(id != ""){
		jQuery.ajax({
			type: 'POST',
			url: '?task=profile&action=var_extend_one', 
			data: 'var_id=' + id + "&prolong=" + prolong,
			success: function() {
				window.location.reload();
			}
		});	
	}
}


function showModalWin(id) {
    var darkLayer = document.createElement('div'); // слой затемнения
    darkLayer.id = 'shadow'; // id чтобы подхватить стиль
    document.body.appendChild(darkLayer); // включаем затемнение
    var modalWin = document.getElementById('popupProlong'+id); // находим наше "окно"
    modalWin.style.display = 'block'; // "включаем" его
    darkLayer.onclick = function () {  // при клике на слой затемнения все исчезнет
        darkLayer.parentNode.removeChild(darkLayer); // удаляем затемнение
        modalWin.style.display = 'none'; // делаем окно невидимым
        return false;
    };
}


function VarArchive(id, action, checkVar){
	var varRow = $(".product[data-id="+id+"]"),
		buttons = $(".btn-group.count .badge"); //кнопки колличества вариантов
	if(action == "add"){		 
		var	confirmStr = "Добавить вариант в архив?",			
			successMes = "Перенесен в архив",
			i = 1,
			d = 0,
			data = "id="+id+"&active=0";
			//i - индекс кнопки увеличения колличества вариантов
			//d - индекс кнопки уменшения колличества вариантов
	}else{		
		var	confirmStr = "Вынести вариант из архива?",			
			successMes = "Востановлен из архива",
			i = 0,
			d = 1,
			data = "id="+id+"&active=1";	
	}
	//if (confirm(confirmStr)) {
		var newCount = {0: parseInt($($(buttons)[i]).text()) + 1, 
						1: parseInt($($(buttons)[d]).text()) - 1};
		jQuery.ajax({
			type: 'POST',
			url: "?task=profile&action=archive", 
			data: data,
			success: function(html) {
				$(varRow).children().remove();
				$(varRow).append("<h3 class='center' style='color: rgb(242, 14, 14);'>"+successMes+"</h3>");
				$($(buttons)[i]).text(newCount[0]);
				$($(buttons)[d]).text(newCount[1]);
				if(checkVar == 1){ CheckedReview(id, 1); }
			}
		});
	//}
}

function searchAn(){
	var searchAnStr = $('input[data-id=searchAn]').val().toLowerCase();
	if(searchAnStr!=""){
		$("tbody tr").each(function(){			
			var row = $(this);
			var i = 0;
			$(row).find("th").each(function(){					
				if($(this).text().toLowerCase().indexOf(searchAnStr)  != "-1"){
					i++;
				}				
			});
			if(i<1){
				$(row).slideUp();
			}
		});
	}else{
		$("tr").show();
	}
}	
function openModalWin(index){		
	jQuery.ajax({
		type: 'POST',
		url: location, 
		data: 'index=' + index, 
		success: function(html) {
			$(".modal").remove();
			var modal = $(html).find(".modal");
			$("table").parent().append($(modal));
			$("button[data-toggle=modal]").click();
		}
	});	
}

function formSubmit(id){
	$("[data-id=seacrh-rielter]").empty();
	var data = "",
		hide_black_group = "";
	if(confirm(confirmStr)){
		$(".progress").remove();
		$(".container").append("<div class='progress' style='width: 103%;height: 100%; position: fixed;z-index: 9999;top: 0;margin-left: -10px;background-color: rgba(0, 0, 0, 0.5);text-align: center;'><p style='margin-top: 250px;font-size: 20px;color: #fff;'>Загрузка</p></div>");
		loading(1);
		if(id == "group_setting"){
			$("form#"+id+" [type=checkbox]").each(function(){

				if($(this).attr('name') == "hide_black_group"){
					if($(this).prop("checked")){
						hide_black_group = "&hide_black_group=1";
					}
				}

				if(!$(this).prop("checked")){
					if($(this).val() != 1){
						data += $(this).val()+"||";
					}
				}
			});
			data = "black_group="+data+hide_black_group;
		}else{
			data = decodeURIComponent($("form").serialize());
		}
		jQuery.ajax({
			type: 'POST',
			url: postUrl, 
			data: data,
			success: function(html){
				if(html == "﻿1"){
					alertify.success("Данные были изменены.");
					if($("#modal-win-group").length > 0){
						 $(".modal-body tr").has(":checkbox:checked").remove();
					}
				}else{
					alertify.error(html);
				}					
			},
			complete: function(){				
				$(".modal button[data-dismiss=modal]").click();
				if(id!="group_setting" || QueryString("action")=="group_setting"){
					window.location.reload();
				}
				$(".progress").remove();
			}
		});	
	}		
}

function ShowEmployees(id){	
	if(!$("tr#"+id).hasClass("open")){
		jQuery.ajax({
			type: 'POST',
			url: '?task=profile&action=employee_list', 
			data: 'company_id=' + id,
			success: function(html){
				var num = $("tr#"+id).children().length
				$("tr#"+id+"").addClass("open");
				$("tr#"+id+"").after("<tr><td colspan='"+num+"'>"+ $(html).find("#employeeList").html() + "</td></tr>");
			},
			complete: function(){
				$("[data-id=phone]").mask("8 (999) 999-9999");
			}
		});	
	}else if($("#"+id).next().css("display") == 'none'){
		$("#"+id).next().slideDown();
	}else{
		$("#"+id).next().slideUp();
	}
	$('.fancybox').fancybox();
}


function ShowEmployee(id){	
	var obj = $('.employee[data-id='+id+']');
	if($(obj).children(":visible").length == 4){
		$(obj).children().each(function(){
			if(!$(this).is(".confirm")){
				$(this).slideDown();
			}
		})		
	}else{
		$(obj).children().each(function(){
			if(!$(this).hasClass("fio") && !$(this).hasClass("phone")){
				$(this).slideUp();
			}
		})
	}
}

function subdistrClick(subdistrict)
{
	$("#sub_dis").val(subdistrict);
	$(".subdistrict_list_to_add").slideUp();
	$("[name=sub_dis]").css("border-color", "#5cb85c");
}

function EditEmployee(id){
	$("form.employee[data-id="+id+"] input").removeAttr("disabled");
	$("form.employee[data-id="+id+"] textarea").removeAttr("disabled");	
	$("form.employee[data-id="+id+"] span.edit").attr("onclick", "Update('us-"+id+"-employee')").text("Сохранить");
}

function EditDescr(id){
	$("input#fd_name_"+id+"").removeAttr("disabled");
	$("textarea#fd_description_"+id+"").removeAttr("disabled");
	$("span#edit_"+id+"").attr("onclick", "UpdateDescr('"+id+"')").text("Сохранить");
}

function AddDescr(){
	jQuery.ajax({
		type: 'POST',
		url: '?task=admin&action=functional_description', 
		data: 'new=1&fd_name=' + $("input#fd_name_new_descr").val() + '&fd_description=' +  $("textarea#fd_description_new_descr").val(),
		complete: function(){
			alertify.success("Данные были Добавлены.");
			window.location.reload();
			
		}
	});
}
function UpdateDescr(id){
	jQuery.ajax({
		type: 'POST',
		url: '?task=admin&action=functional_description', 
		data: 'update=1&id='+id+'&fd_name=' + $("input#fd_name_"+id+"").val() + '&fd_description=' +  $("textarea#fd_description_"+id+"").val(),
		complete: function(){
			alertify.success("Данные были изменены.");
			window.location.reload();
		}
	});
}
function ActivateDescr(id,show){
	showHide = 1;
	if(show == 'show'){
		$("span#active_"+id+"").attr("onclick", "ActivateDescr('"+id+"', 'show')").text("Показать");
	}
	if(show == 'hide'){
		$("span#active_"+id+"").attr("onclick", "ActivateDescr('"+id+"', 'hide')").text("Скрыть");
		showHide = 0;
	}
	jQuery.ajax({
		type: 'POST',
		url: '?task=admin&action=functional_description', 
		data: 'active=1&id='+id+'&actual='+showHide,
		complete: function(){
			alertify.success("Данные были изменены.");
			window.location.reload();
		}
	});
}



function Update(id){
	//if(confirm(confirmStr)){
		var table = id.split('-')[0],
			formId = id.split('-')[1],
			formClass = id.split('-')[2],			
			data = decodeURIComponent($("form."+formClass+"[data-id="+formId+"]").serialize());
		if(table == 'co'){
			data += "&company_id="+formId;
		}else if(table == 'us'){
			data += "&user_id="+formId;
		}
		$("form[data-id="+formId+"] :checkbox").each(function(){
			if($(this).attr('name') != ""){
				if($(this).is(":checked")){
					data += "&"+$(this).attr('name')+"=1";
				}else{
					data += "&"+$(this).attr('name')+"=0";
				}
			}
		});
		jQuery.ajax({
			type: 'POST',
			url: postUrl, 
			data: data,
			success: function(html){
				if(html == "1"){
					alertify.success("Данные были изменены.");
					if(QueryString("action") == "find_employee"){
						$($("#"+formId).find("td")[3]).text($("[data-id="+formId+"] [name=ac-sell_date_end]").val());
						$($("#"+formId).find("td")[4]).text($("[data-id="+formId+"] [name=ac-sell_date_end]").val());
					}
				}else{
					alertify.error(html);
				}					
			}			
		});
	//}
}

//отправка отзыва
function SendReview(id){	
	if($("form#send-review textarea").val() != ""){
		var review = $(".product[data-id="+id+"] span[data-id=review]").length,
			table;
		if(QueryString("action") == "pay_parse" ||QueryString("action") == "favorites_pay_parse"){
			table = "pay_parse";
		}else if(QueryString("action") == "parse" || QueryString("action") == "favorites_parse"){
            table = "pay_parse";
		}else{
			table = "site";
		}

		$.ajax({
			type: "POST",
			url: "?task=profile&action=send_review",
			data: "table="+table+"&review="+review+"&var_id="+id+"&"+decodeURIComponent($('form#send-review').serialize()),
			success: function(html){
				alertify.success("Отзыв отправлен");
				if(!$("#anonymous").is(":checked") && $(".product[data-id="+id+"] [data-id=review]").length == 0){
					$(".product[data-id="+id+"] div").last().append(" | <a href='javascript:void(0)' style='color:#E81010'" +
						" data-id='review' target='_blank' data-name='"+ table+ "' data-toggle='modal' " +
						"data-target='#clean-modal-win'>Комментарии</a>")
				}
				$(".modal-header button.close").click();
			},		
			error: function(){
				alertify.error("Произошла ошибка отправки, попробуйте позже");
			},
		})
	}else{
		alertify.error("Отзыв не может быть пустым!");
	}
}

//отправка варианта в подборку
function SendSample(varId, sampleId, type, action_type, empty){
	text = '';
	if(empty ==1 ){
        var text =  $("textarea[name=sample_text]").val();
	}
    var clientPrice =  $("input[name=sample_client_price]").val();
	$.ajax({
		type: "POST",
		url: "?task=profile&action=sample_add_var",
		data: 'var_id=' + varId + '&sample_id=' + sampleId + '&type='+type+'&action_type='+action_type+'&client_price='+clientPrice+'&text='+text,
		success: function(isAdd){
			if(isAdd == 2){
				alertify.error("Вариант такой уже есть в подборке этой");		
			}else if(isAdd == 3){
				alertify.error("Подборка  уже заполнена");		
			}else if(isAdd == 1){
				alertify.success("Добавлен");
			}
			$("form#send-sample textarea").val('');
			$(".modal-header button.close").click();
		},		
		error: function(){
			alertify.error("Произошла ошибка отправки, попробуйте позже");
		},
	});
}


//добавление в черный список
function AddToBlackList(id){
	var black_agent = $(".product[data-id="+id+"] span[data-name=black-agent]").length,	
		people_id = $(".product[data-id="+id+"] [data-name=people]").data('people-id');
	if($("form#add-to-black-list textarea").val() != ""){
		if(confirm("Добавить риелтера в черный список?")){
			$.ajax({
				type: "POST",
				url: "?task=var&action=add_to_black_list",
				data: "people_id="+people_id+"&black_agent="+black_agent+"&"+decodeURIComponent($('form#add-to-black-list').serialize()),
				success: function(html){
					alertify.success("Риелтер добавлен в черный список");
					$(".modal-header button.close").click();
					if(black_agent == 0){
						$(".product[data-id="+id+"] [data-name=people]").append("<span data-name='black-agent' style='cursor:pointer; color:red; display:inline-block; font-size: 13px; ' target='_blank' data-toggle='modal' data-target='#add-to-black-list-modal-win'>Агент в черном списке</span>");
					}
				},		
				error: function(){
					alertify.error("Произошла ошибка отправки, попробуйте позже");
				},
			})
		}
	}else{
		alertify.error("Укажите причину очернения репутации риелтера!");
	}
}

//удаление заметки в черном списке
function DeleteBlackListComment(id, target){
	var text;
	if(target == "comment"){
		text = "Удалить заметку?";
	}else{
		text = "Удалить все заметки по агенту и убрать его из черного списка?";
	}
	alertify.confirm(text, function(result){
		if(result){
			$.post("?task=var&action=delete_black_list_comment", "id="+id+"&target="+target, function(){
				if(target=="comment"){
					$(".modal-body .comment[data-id="+id+"]").slideUp();
				}else if(target=="people"){
					$(".modal-header .close").click();
					$("[data-people-id="+id+"] [data-name=black-agent]").remove();
				}				
			})
		}
	})
}

//отправка пояснения к ненайденному риелтеру в базе
function Check_comment_set(io, date, searchStr, peopleId, company_name){
	var text = $("textarea[name=check_rielter_comment]").val();
	if(text!=""){
		$.ajax({
			type:'POST',
			url:'?task=profile&action=check_comment_set',
			data:"comment="+text+"&search_str="+searchStr+"&people_id="+peopleId,
			success:function(html){
				if(html = 1){
					if($("div#check_list").length == 0){
						$("div#check_rielter").append("<div class='col-xs-12' id='check_list'><hr><h4 class='center'>Также данный запрос выполняли</h4><table class='table table-striped list'><thead><tr><th>#</th><th>ФИО</th><th>Дата поиска</th><th>Оставленный коментарий</th></tr></thead><tbody><tr><td>1</td><td>"+io+"</td><td>"+date+"</td><td>"+text+"</td></tr></tbody></table></div>");
					}else{
						var number = parseInt($($("div#check_list tbody tr").last().find("td")[0]).text()) + 1;
						$("div#check_list tbody").append("<tr><td>"+number+"</td><td>"+io+"</td><td></td><td>"+searchStr+"</td><td>"+date+"</td><td></td></tr>");
					}
					$("div.info").slideUp();
					alertify.success('Коментарий добавлен');
				}else{
					aletify.error("Ошибка добавления коментария, обратитесь к администратору сайта.")
				}
			},
		})
	}
}

//поиск риелтера для исключения из доверенной группы
var lastTel;
function SearchRieleter(tel){
	if(tel.match(/\d\s\(\d+\)\s\d+-\d{4}/)!=null && tel != lastTel){
		lastTel = tel;
		$.ajax({
			type:"POST",
			url:"?task=profile&action=find_rielter",
			data:"tel="+lastTel,
			success:function(html){
				if(html != "﻿"){
					$("table[data-id=seacrh-rielter] tbody").empty().append(html);
				}else{
					alertify.alert("Риелтер с данным номером не обнаружен");
				}
			}
		})
	}	
}

//отправка подборки на Email
/*function SendFavoritesToEmail(){
	var obj = $("[data-name=email_for_favor]"),
		email = $(obj).val(),
		pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
	if(email.match(pattern) != null){
		if($(".product").length > 0){
			var message = "Сейчас избранное будет очищено! И в течении 10 минут ваша подборка прийдет клиенту на почтовый адрес: "+email+". Количество отправляемых вариантов на одну и туже почту в месяц не может превышать 20 штук. Будьте  внимательны!";
			alertify.confirm(message, function(result){
				if(result){
					$.post("?task=var&action=send_favorites_to_email", "email="+email, function(html){
						if(html==1){
							$(".product").remove();
							$("#favorites-count").text(0);
							$(obj).val("");
							$("[name=favorites]").next(".badge").text(0);
							alertify.success("Подборка отправлена.");
						}else{
							alertify.error("Отправление более 20 вариантов на 1 почту запрещено!");
						}
					});
				}
			});
		}else{
			alertify.error("Нет вариантов для отправки.");
		}
	}else{
		alertify.error("Адрес почты не вырен!");
	}
}*/

function Open_send_email_form(obj){
	$(obj).next().toggleClass('hidden'); 
	if(!$(obj).next().hasClass('hidden')){
		var product = $('.product').has($(obj)),
			title = $($(product).find('td').last().find('span')[2]).text(),
			comment = $($(product).find('span[data-name=comment]')).text(),
			floor = $($(product).find('font[data-name=floor]')).text(),
			sq = $($(product).find('font[data-name=sq]')).text(),
			price = $($(product).find('span[data-name=price]')).text();
			deposit = $($(product).find('span[data-name=deposit]')).text();
			view_race = $($(product).find('span[data-name=view-race]')).text();
		$(obj).next().find("textarea").empty().append(title+" цена: "+price+" "+ deposit +" этаж:"+floor+" площади:"+sq+". " + view_race +".  "+comment);
	}
}

function No_email_work(){
	alertify.error(" Не корректен или отсутствует рабочий e-mail.");
}

function SendVarToEmail(obj, id){
	var input = $(".send-email-form").has($(obj)).find("[data-name=email_for_favor]"),
		comment = $(".send-email-form").has($(obj)).find("[data-name=comment]"),
		email = input.val(),
		pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;

	if(email.match(pattern) != null){
		if($(".product").length > 0){
			
//			var message = "В течении 10 минут данный вариант прийдет клиенту на почтовый адрес: "+email+". Количество отправляемых вариантов на одну и туже почту в месяц не может превышать 50 штук. Будьте  внимательны!";
			var message = "В течении 5 минут данный вариант прийдет клиенту на почтовый адрес: "+email+". Количество отправляемых вариантов на одну и туже почту в месяц не может превышать 50 штук. Будьте  внимательны!";
			
			alertify.confirm(message, function(result){
				if(result){
					$.post("?task=var&action=send_var_to_email", "email="+email+"&id="+id+"&comment="+comment.val(), function(html){
						if(html==1){
							$(input).val("");
							$(".send-email-form").has($(obj)).toggleClass('hidden');
							alertify.success("Вариант отправлен.");
						}else if(html==2){
							alertify.error("Проблемы при отправке почты, обратитесь к Администратору");
						}else if(html==3){
							alertify.error("Отсутствует рабочая почта. Попробуйте повторить вход на сайт");
						}else if(html==4){
							alertify.error("Отправлено более 50-ти вариантов на почту "+email+" . ");
						}
					});
				}
			});
		}else{
			alertify.error("Нет вариантов для отправки.");
		}
	}else{
		alertify.error("Адрес почты получателя не верен!");
	}
}

//вывод списка сотрудников АН для смены владельца варианта
function EmployeeList (varId, companyName, userId){
	var obj = $(".product[data-id="+varId+"] [data-name=people]");
	if($(obj).find(".change-owner-list").length == 0){
		$.post("?task=var&action=employee_list", "company_name="+companyName+"&user_id="+userId, function(html){
			$(obj).append(html);
			$(obj).find(".change-owner-list").slideDown();
		});
	}else{
		$(obj).find(".change-owner-list").slideDown();
	}
}

function CloseOwnerList(obj){
	setTimeout(function(){
		$(".change-owner-list").has($(obj)).slideUp();		
	}, 100);
}

/*открытие меню варианта*/
function OpenProductMenu(id){
	var menu = $(".product[data-id="+id+"]").find(".product-menu");
	if($(menu).is(':visible')){
		$(menu).slideUp('fast');
	}else{
		$(menu).slideDown('fast');
	}
}
/*получение GET-параметров*/
function QueryString(str){
	try{
		var matchStr = new RegExp("("+str+"=)(\\w+)"),
			result = window.location.search.match(matchStr)[2];
	}catch(error){}
	return result;
}

/*скрытие контактов*/
function HideContacts(obj){
	if(!$(obj).hasClass('active')){
		$.post("?task=var&action=contacts_hide", function(){
			$("[data-name=contacts]").hide();
			$("[data-name=contacts-hide]").show();
		})
	}else{
		$.post("?task=var&action=contacts_show", function(){
			$("[data-name=contacts-hide]").hide();
			$("[data-name=contacts]").show();
		})
		
	}
}	

function fullPriceClick(obj)
{
    if (!$('input#full_price').is(':checked')) {
        $("input#full_price  input:checkbox").prop('checked', true);
    }else{
        $("input#full_price  input:checkbox").prop('checked', false);
	}
}


/*скачка фото со старой фортуны*/
function PhotoSearch(tid, id){
	if(tid!=''){
		$(".products-list").append("<div class='progress' style='width: 103%;height: 100%; position: fixed;z-index: 9999;top: 0;margin-left: -10px;background-color: rgba(0, 0, 0, 0.5);text-align: center;'><p style='margin-top: 250px;font-size: 20px;color: #fff;'>Загрузка</p></div>");
		loading(1);
		$.post("photo_search.php", "tid="+tid, function(html){
			$('.progress').remove();
			if(html==""){
				alertify.alert("У данного варианта нет фотографий или они уже перенесены. В противном случае свяжитесь с администратором сайта.");
			}else if(html.match(/Warning/)!=null){
				alertify.alert("У данного варианта на старой фортуне нет фотографий.");
			}else{
				window.location.reload();
			}
		})
	}
}

//универсальный метод для обновление
function UpdateUser(name, id){
	var adr,request;
	if(name=='access_var'){
		$(".container").last().append("<div class='progress' style='width: 103%;height: 100%; position: fixed;z-index: 9999;top: 0;margin-left: -10px;background-color: rgba(0, 0, 0, 0.5);text-align: center;'><p style='margin-top: 250px;font-size: 20px;color: #fff;'>Загрузка</p></div>");
		loading(1);
		var val = $("[data-id="+id+"] [name="+name+"]").prop('checked') ? 1 : 0;
		adr="?task=profile&action=update";
		request = "id="+id+"&name=user&col="+name+"&value="+val;
	}else if( name == 'rent_view'){
		$(".container").last().append("<div class='progress' style='width: 103%;height: 100%; position: fixed;z-index: 9999;top: 0;margin-left: -10px;background-color: rgba(0, 0, 0, 0.5);text-align: center;'><p style='margin-top: 250px;font-size: 20px;color: #fff;'>Загрузка</p></div>");
		loading(1);
		var val = $("[data-id="+id+"] [name="+name+"]").prop('checked') ? 1 : 0;
		adr="?task=profile&action=updateById";
		request = "id="+id+"&name=people&col="+name+"&value="+val;
	}

	$.post(adr, request, function(){
		$(".progress").remove();
		alertify.success("Готово!");
	});
}


//добавление в белый список с главнос страницы
function AddListFromMain(id){
	$.post("?task=profile&action=lists", "id="+id+"&type=add&list_type=white", function(){
		window.location.reload();
	})
}

//добавление в белый список с главнос страницы
function ShowVar(id,show_var){
	$.post("?task=profile&action=lists", "id="+id+"&show="+show_var, function(){
		alertify.confirm("змен");
	})
}

//удаление подборки
function DeleteRecipients(){
	alertify.confirm("Вы уверены, что хотите удалить подборки старше 30 дней?", function(r){
		if(r){
			$.post("?task=var&action=delete_recipients", function(){
				window.location.reload();
			});
		}
	})
}

//открытие новой страницы
function NewPage(page){
	var querySrt = decodeURIComponent(window.location.href);
	if(querySrt.indexOf("?") == '-1'){
		querySrt = querySrt+"?page="+page;
	}else if(querySrt.indexOf("page") == '-1'){
		querySrt = querySrt+"&page="+page;
	}else{
		querySrt = decodeURIComponent(window.location.href).replace(/page=\d+/, "page="+page);
	}	
	Limit($("#limit").val(), querySrt);
}

function SaveSearch(){
	// var searchStr = decodeURIComponent($("#main_search").serialize());
	// searchStr = searchStr.replace(/^.+topic_id/, 'topic_id').replace(/&order=.+/, '');
	$("#main_search").attr("action", "?task=profile&action=recipients").attr("method", "post").submit();
}

//колличество вариантов на странице
function Limit(limit, querySrt){
	if(limit==0)limit=50;
	if(querySrt.indexOf("limit") == '-1'){
		var location = querySrt+"&limit="+limit;
		window.location = location;
		$(".products-list").load(location+" .products-list");
	}else{
		var location = decodeURIComponent(querySrt).replace(/limit=\d+/, "limit="+limit);
		window.location = location;
		$(".products-list").load(location+" .products-list");
	}
}

function ChatNewMessSend(text){
	if(text!=""){
		$.post("?task=chat&action=new_chat_mess", "text="+text, function(){
			//UpdateChat();
			$("#chatNewMess textarea").text("").val("").blur();
		})
	}
}

function UpdateChat(){
	$(".chatContent").load("/?task=chat&action=chat .chatMessages,#chatNewMess");
	setTimeout(function(){
		$('.chatMessages').stop().animate({	scrollTop: $('.chatMessages').offset().top+9999999}, 1);			
	}, 400);
}

var chatCountMess = 0;
function UpdateChatCountMess(){
	chatCountMess = $(".chat [data-name=count]").text();
	$.post("?task=chat&action=chat_mess_count", function(html){
		if(parseInt(chatCountMess)!=parseInt(html)){
			$(".chat [data-name=count]").text(html);
			UpdateChat();
		}
	})
}

function NewChatNick(nick, user_id){
	if(nick.length > 0){
		$.post("?task=chat&action=nick_create", "nick="+nick+"&user_id="+user_id, function(){
			$(".chat").load("/ .chat");
		})
	}
}

// Удаление сессии
function deleteSession(people_id){	
	$.ajax({
		type: 'POST',
		url: '?task=profile&action=delete_session',
		data: 'people_id=' + people_id, 
		success: function(html){
			if(html == "FALSE"){
				alertify.error("Пустой запрос");
			}else if(html == "NO_SESSION"){
				alertify.error("Логин не в работе");
			}else if( html = "UNLINK OK"){
				alertify.success("Сессия удалена!");
			}
		}
	});
}

//универсальный метод для удаления
function Delete(name, id){
	var adr,request;
	if(name=="callboard"){
		adr="?task=profile&action=delete_callboard";
		request="id="+id;
	}
	$.post(adr, request, function(){
		window.location.reload();
	})
}

//обновление поисковика
function SearchUpdate(){
	setTimeout(function(){$('[type=submit]').click()}, 100);
}

function loading(i){
	setTimeout(function(){
		if(i<=3){
			var text = $(".progress p").text();
			$(".progress p").text(text+".");
			i++;
		}else{
			$(".progress p").text("Загрузка");
			i = 1;
		}
		loading(i);
	}, 500);
}

function loginShow() {
    var enterButt = document.getElementById('enter');
    if (typeof(enterButt) != 'undefined' && enterButt != null)
    {
        var visible = enterButt.style.opacity;
        needShow = 1;
        if (visible == 1 ){
            needShow = 0;
        }
        enterButt.style.opacity = needShow;
    }
}

function updateAddress(id){
    var address = $(".new_address[data-name='new_address"+id+"']").val();
    $.post('?task=admin&action=address_change', 'id='+ id+ '&address='+ address , function(newAddress){

        if(newAddress != ''){
            alertify.success("Изменено");
            $(".var_address[data-id="+id+"]").hide();
            $(".address_to_change[data-id="+id+"]")[0].style.color = 'orange';
            $(".address_to_change[data-id="+id+"]")[0].innerHTML = newAddress;
        }else{
            alertify.error("Не удалось");
        }
    });
}


function closeLogin() {
	$("div#enter").slideUp();
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








