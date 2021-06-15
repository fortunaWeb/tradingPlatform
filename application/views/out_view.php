<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head><?php 

		date_default_timezone_set('Asia/Yekaterinburg');
		$topic_id = isset($_GET['topic_id']) ? $_GET['topic_id'] : 1;	
		$parent_id = isset($_GET['parent_id']) ? $_GET['parent_id'] : 1;	
		$phone_enter = (ereg("Mac OS", $_SERVER['HTTP_USER_AGENT']) || ereg("Android", $_SERVER['HTTP_USER_AGENT']));

		list($topic, $parent) =  explode(" ", Translate::Estate_type($topic_id, $parent_id));
		?>	
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<!-- disable iPhone inital scale -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Trading-Platform</title>
		<link rel="stylesheet" href="/css/alertify.core.css">
		<link rel="stylesheet" href="/css/alertify.default.css">
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		
		<script src="js/jquery-2.1.3.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/jquery.maskedinput.js" type="text/javascript"></script>
		<script src="js/jquery-ui.min.js" type="text/javascript"></script>
		<script src="js/bootstrap.js" type="text/javascript"></script>	
		<script src="//api-maps.yandex.ru/2.0-stable/?load=package.standard,package.geoObjects,package.geoQuery,package.route&lang=ru-RU" type="text/javascript"></script>
		<script src="http://maps.api.2gis.ru/2.0/loader.js?pkg=full"></script>
		<script type="text/javascript" src="/js/alertify.js"></script>
		<script src="js/javascript_new.js" type="text/javascript"></script>
		<script src="js/add_photos.js" type="text/javascript"></script>	
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
				if($("#ses").val()=="" && $("#user-menu").length>0){
					window.location='/';
				}
				HeaderToTop();
				$(window).resize(function(){HeaderToTop();});
				$.mask.definitions['~'] = "[+-]";
				$("#phone").mask("8 (999) 999-9999");
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
				
				<?if(isset($_SESSION['people_id'])){?>
					$.get("/?task=profile&action=session_update");
				<?}?>
				$(document).on("keydown", "[name=pricefrom],[name=priceto]", function(e){
					var letters=' ';
					return (letters.indexOf(String.fromCharCode(e.which))==-1);
				})
			});
			
			function HeaderToTop(){
				if($(".header").leght > 0){
					$(".container").has(".header").css("margin-top", "-"+$(".header").offset().top);
				}
			}
		</script>
		<?		
			$url = "?task=main&action=out";
		?>
	<body>
		<span class="glyphicon glyphicon-circle-arrow-up slide-top hidden" onClick="$('html,body').stop().animate({	scrollTop: $('html').offset().top}, 1000);"></span>
		<?if(isset($_SESSION['people_id'])){?>
			<div class="container" style="margin-top: 25px;">	
				<?php 
					if (($_GET['task'] == '') OR ($_GET['task'] == 'main') OR ($_GET['task'] == 'test')) {
						include 'application/includes/out_search.php';
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
			}else{
				//echo "<input type='hidden' id='alert' value='Внимание! Мы сделали обновление текущего сайта! Старая версия прекратила работу! Данные для входа (логин и пароль), а также краткая инструкция отправлены на электронную почту всем директорам ан! Все вопросы по телефону: 89139179516 или на почту 89139179516@mail.ru'>";
			}?>			
			<div class="center">
				<?if(!isset($_SESSION['company_id'])){
					$image_num = rand(1, 36);?>
					<img class="job" src="images/fons/<?=$image_num?>.jpg" style="width: 100%;height: 620px;">
				<?unset($image_num);
				}?>
			</div>
		<?}?>
		<?
		/*
		if($_SESSION['user']>0 && $_SESSION['block_chat']==0 && 1==0){
			?>
			<div class="chat">
				<b class="title" onClick="$('.chatContent').toggleClass('hidden');$('.chatMessages').stop().animate({	scrollTop: $('.chatMessages').offset().top+9999999}, 1);">Чат  <span data-name="count"><?=Get_functions::Get_chat_mess_count();?></span> <span class="glyphicon glyphicon-comment" aria-hidden="true" style="vertical-align: middle;"></span></b>
				<div class="chatContent hidden">
					<div class="chatMessages">
						<?=Get_functions::Get_chat_mess_list();?>
					</div>
					<?if($_SESSION["nickname"]!=""){?>
						<form id="chatNewMess">
							<textarea form="chatNewMess" name="text" id="messText" col='5' placeholder="текст сообщения" maxlength="100"></textarea>
							<button form="chatNewMess" type="submit"><span class="glyphicon glyphicon-share" aria-hidden="true"></span></button>
						</form>
					<?}else{?>
						<form id="nickCreate">
							<input form="nickCreate" type="text" name="nickname" placeholder="введите ник для чата" data-toggle="tooltip" data-placement="left" title="Ник вводится 1 раз и записывается в ваши данные! Будте внимательны при выборе!" />
							<button form="nickCreate" type="submit"><span class="glyphicon glyphicon-share" aria-hidden="true"></span></button>
						</form>
					<?}?>
				</div>
			</div>
		<?
			} 
			*/
		?>
		<div class="row footer" id="footer">

		</div>
		<input type="hidden" id="ses" value="<?=isset($_SESSION['people_id'])?$_SESSION['people_id']:''?>">
		<!-- Yandex.Metrika counter --><script type="text/javascript"> (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter33419443 = new Ya.Metrika({ id:33419443, clickmap:true, trackLinks:true, accurateTrackBounce:true, webvisor:true, ut:"noindex" }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks");</script><noscript><div><img src="https://mc.yandex.ru/watch/33419443?ut=noindex" style="position:absolute; left:-9999px;" alt="" /></div></noscript><!-- /Yandex.Metrika counter -->
	</body>
</html>