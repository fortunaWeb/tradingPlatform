<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
	<head><?PHP  //header("Content-Type: text/html; charset=utf-8");
		date_default_timezone_set('Asia/Yekaterinburg');
		$_SESSION['topic_id'] = !isset($_SESSION['topic_id']) ? 2 : $_SESSION['topic_id'];

		$_SESSION['parent_id'] = !isset($_SESSION['parent_id']) ? 1 : $_SESSION['parent_id'];
		$topic_id = isset($_GET['topic_id']) ? $_GET['topic_id'] : $_SESSION['topic_id'];	
		$parent_id = isset($_GET['parent_id']) ? $_GET['parent_id'] : $_SESSION['parent_id'];	
		$phone_enter = (ereg("Mac OS", $_SERVER['HTTP_USER_AGENT']) || ereg("Android", $_SERVER['HTTP_USER_AGENT']));

		/**
		 *	Обновление времени сессии
		 */
		Helper::Session_date_update();/**/
		list($topic, $parent) =  explode(" ", Translate::Estate_type($topic_id, $parent_id));
		?>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<!-- disable iPhone inital scale -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Trading-Platform</title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
		<link rel="stylesheet" type="text/css" href="css/jquery-ui.min.css" />
		<link rel="stylesheet" href="/css/alertify.core.css">
		<link rel="stylesheet" href="/css/alertify.default.css">
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		<?php
			if(isset($_SESSION['mobile']) &&  $_SESSION['mobile'] == 1)
				echo "<style >  html{ min-width: 100px !important;</style>";
		?>
		
<!-- html5.js for IE less than 9 -->
<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<!-- css3-mediaqueries.js for IE less than 9 -->
<!--[if lt IE 9]>
		<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<![endif]-->
                <script src="js/api.yandex.21.js"></script>
		<script src="js/jquery-2.1.3.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/jquery.maskedinput.js" type="text/javascript"></script>
		<script src="js/jquery-ui.min.js" type="text/javascript"></script>
		<script src="js/bootstrap.js" type="text/javascript"></script>
		<script type="text/javascript" src="/js/alertify.js"></script>
		<script src="js/javascript_new.js" type="text/javascript"></script>
		<script src="js/add_photos.js" type="text/javascript"></script>

<!--    <script src="//api-maps.yandex.ru/2.0-stable/?load=package.standard,package.geoObjects,package.geoQuery,package.route&lang=ru-RU"
                type="text/javascript"></script>
        <script src="https://api-maps.yandex.ru/2.1?apikey=66f45507-6248-4ef1-8634-1c0661e134cf&lang=ru-RU"
        type="text/javascript"></script>
        -->
		<?/*<script src="js/snow.js" type="text/javascript"></script>*/?>
		<?if(isset($_SESSION['admin']) && $_SESSION['admin']==1){?>
			<script src="js/admin_scripts.js" type="text/javascript"></script>
		<?}?>
		<!-- Add fancyBox main JS and CSS files -->
		<script type="text/javascript" src="fancyBox/source/jquery.fancybox.js?v=2.1.5"> </script>
		<link rel="stylesheet" type="text/css" href="fancyBox/source/jquery.fancybox.css?v=2.1.5" media="screen" />
		<!-- Add Thumbnail helper (this is optional) -->
		<link rel="stylesheet" type="text/css" href="fancyBox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
		<script type="text/javascript" src="fancyBox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>

		<script type="text/javascript">
			$(function() {

				if( $("#user-menu").length>0 && $("#ses").val()=="" ){
					window.location='/';
				}
				HeaderToTop();
				$(window).resize(function(){HeaderToTop();});
				$.mask.definitions['~'] = "[+-]";
                $("#phone").bind('paste', function(e) {
                    $("#phone").unmask();
                    $("#phone").val('');
                    var self = this;
                    pasteValue = $(self).val();
                    setTimeout(function(e) {
                        $(self).val(formatPhone($(self).val()));
                     }, 1);
                });

                $("[data-id=time]").mask("99:99");
				$("[data-id=sber_num]").mask("9999")
				$("[data-id=phone]").mask("8 (999) 999-9999");
				$("[data-id=date]").datepicker();
				$("[data-id=date]").datepicker( "option", "dateFormat", "yy-mm-dd");
				$("[data-id=date]").on("keypress", function(e){e.preventDefault()});
				$('.fancybox-thumbs').fancybox({
					helpers : {
						thumbs : {
							width  : 50,
							height : 50
						}
					}
				});
				
				alertify.set({ 
					labels: {
						ok     : "Ok",
						cancel : "Отмена"
					} 
				});
				
				if($("input#alert").length == 1)
				{
					alertify.alert($("input#alert").val());
				}
				
				$('[data-toggle="tooltip"]').tooltip();
				 $('[data-toggle="popover"]').popover();
				
				<?
				if(isset($_GET['access'])){
					 echo " alertify.alert('Ваш доступ продлен до ".Helper::Company_assess_date($_SESSION['company_id'])."');"; 
					unset($_SESSION);
				}

				if(isset($_SESSION['people_id'])){?>
					$.get("/?task=profile&action=session_update");
				<?}?>
				
				$(document).on("keydown", "[name=pricefrom],[name=priceto]", function(e){
					var letters=' ';
					return (letters.indexOf(String.fromCharCode(e.which))==-1);
				})
			});
            function formatPhone(phone)
            {
                const pattern = new RegExp(`(^\\d{${pasteValue.length % 10}})(\\d{3})(\\d{3})(\\d{2})(\\d{2}$)`);
                formattedNumber = phone.replace(pattern, '$1($2)$3-$4-$5');
                if(formattedNumber.charAt(0) == '8'){
                    formattedNumber = formattedNumber.slice(1);
                }
                if(formattedNumber.charAt(0) == '+'){
                    formattedNumber = formattedNumber.slice(1);
                    formattedNumber = formattedNumber.slice(1);
                }
                return '8' + formattedNumber;
            }

			function HeaderToTop(){
				if($(".header").leght > 0){
					$(".container").has(".header").css("margin-top", "-"+$(".header").offset().top);
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
		</script>
		<?	if(isset($_SESSION['group_topic_id']) && isset($_SESSION['user'])) 
				$condition = ($_SESSION['group_topic_id'] == 3 AND $_SESSION['user'] != 'guest');
			$url = "?task=main&action=index";
			if(isset($_GET['task']) && $_GET['task'] == "profile")$url = "?task=profile&action=".$_GET['action'].$active;
			if(isset($_SESSION['start_time'])) {
				if(isset($_SESSION['mobile']) && $_SESSION['mobile']){
					include 'application/includes/header_mobile.php';	
				}else{
					include 'application/includes/header.php';
				}
				
			}else{?>
				<div class="container" style="position: fixed;top: 0;z-index: 99;width: 100%;max-width: 2000px;">
					<span onclick="loginShow()" class="btn btn-default" id="loginShow" style="position: absolute;text-align: center;">Вход</span>
                    <div  class="enter_form" id="enter"
                            style="opacity: 0;  margin-top: 40px; "
                    >
					<form  action="/?task=login&action=enter" method="post" class="left" >
						<span>Авторизация</span>
						<span class="glyphicon glyphicon-remove right" onClick="closeLogin()"
                              id="close" style="cursor:pointer; margin-bottom: 2px;"></span>

						<input type="text" name="login" class="form-control"
                               style="margin-bottom: 2px;"
                               placeholder="Логин" required>
						<input type="password" name="password" class="form-control"
                               style="margin-bottom: 2px;"
                               placeholder="Пароль" required>
						<input type = checkbox class="form-control"   style = "width: 10%;margin-left: 0px;margin-top: 0px;float: left;" name = 'mobile' value = '1'> 
						<label  style = 'margin-left: -15px;'> - моб</label>
						<input type="submit" value="Войти" name="btn" class="btn btn-success right"><br/>

					<label  style = 'margin-left: -15px;' id = 'main-polong'>Продление</label>
					</form>
                    </div>
				</div>
			<?}
		?>	
	</head>	
	<body>
		<?php 
			$styleMobileLeft='';
			if(isset($_SESSION['mobile']) && $_SESSION['mobile'] ==1){
				$styleMobileLeft='left:0px;'	;
			}
		?>
		<span  style = "<?=$styleMobileLeft?>" class="glyphicon glyphicon-circle-arrow-up slide-top hidden" 
				onClick="$('html,body').stop().animate({	scrollTop: $('html').offset().top}, 1000);"></span>
		<?if(isset($_SESSION['people_id'])){
			?>
			<div class="container" style="margin-top: 25px;">	
				<?php 
					if (($_GET['task'] == '') OR ($_GET['task'] == 'main') OR ($_GET['task'] == 'test')) {
						include 'application/includes/search.php';
					}
					echo Helper::Admin_message();
					include 'application/views/'.$content_view; 
					$_SESSION['show_message']=0;
				?>
			</div>
		<?}else if($data[0]=="ex_of_acc"){
			echo "<div class='container col-md-9 col-md-offset-3' style='margin-top: 25px;'>";
				include "application/includes/profile_pages/order_view.php";
				$data = Helper::Services_data();
                include "application/includes/profile_pages/services_view_tinkoff.php";
				unset($data, $_SESSION);
			echo "</div>";
		}else{
			if(count($data)==1 && (!isset($_GET) || $_GET['task']=="login")){
				echo "<input type='hidden' id='alert' value='".$data."'>";
			}
			?>			
			<div class="center">
				<?

				if(!isset($_SESSION['company_id'])){
					$image_num = rand(1, 36);					
					?>
					<img class="job" src="images/fons/<?=$image_num?>.jpg" style="width: 100%;height: 620px;">
				<?unset($image_num);
				}?>
			</div>
		<?}
		?>
		<?
			if(	$_SESSION['login'] == '!!!!!'){?>
			<div class="chat">
				<b class="title" 
				onClick="$('.chatContent').toggleClass('hidden');$('.chatMessages').stop().animate({	scrollTop: $('.chatMessages').offset().top+9999999}, 1);">
				Сниму <span data-name="count"> <?=Get_functions::Get_chat_mess_count();?></span> 
				<span class="glyphicon glyphicon-comment" aria-hidden="true" style="vertical-align: middle; color:#fff">
				</span></b>
				<div class="chatContent hidden">
					<div class="chatMessages">
						<?=Get_functions::Get_chat_mess_list();?>
					</div>
					<?if($_SESSION["nickname"]!=""){?>
						<form id="chatNewMess">
							<textarea form="chatNewMess" name="text" id="messText" col='5' 
								placeholder="здесь пишут только то что нужно вашим клиентам" maxlength="100"></textarea>
							<button form="chatNewMess" type="submit">
								<span class="glyphicon glyphicon-share" aria-hidden="true"></span></button>
						</form>
					<?}else{?>
						<form id="nickCreate">
							<input form="nickCreate" type="text" name="nickname" 
							placeholder="введите ник для чата" data-toggle="tooltip" 
							data-placement="left" title="Ник вводится 1 раз и записывается в ваши данные! Будте внимательны при выборе!" />
							<button form="nickCreate" type="submit"  >
								<span class="glyphicon glyphicon-share" aria-hidden="true"></span></button>
						</form>
					<?}?>
				</div>
			</div>
		<?}
Helper::checkIpLogin();
?>

		<div class="row footer" id="footer">

		</div>
		<input type="hidden" id="ses" value="<?=isset($_SESSION['people_id'])?$_SESSION['people_id']:''?>">
		<!-- Yandex.Metrika counter 
		<script type="text/javascript"> (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter33419443 = new Ya.Metrika({ id:33419443, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true, ut:"noindex" }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="https://mc.yandex.ru/watch/33419443?ut=noindex" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
		<!-- /Yandex.Metrika counter -->
	</body>
</html>