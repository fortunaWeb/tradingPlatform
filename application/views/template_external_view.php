<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head><?PHP  //header("Content-Type: text/html; charset=utf-8");
		date_default_timezone_set('Asia/Yekaterinburg');


		list($topic, $parent) =  explode(" ", Translate::Estate_type($topic_id, $parent_id));?>	
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<!-- disable iPhone inital scale -->
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Fortunasib</title>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
		<link rel="stylesheet" type="text/css" href="css/jquery-ui.min.css" />
		<link rel="stylesheet" href="/css/alertify.core.css">
		<link rel="stylesheet" href="/css/alertify.default.css">
		<link rel="stylesheet" type="text/css" href="css/style.css" />
		
		
<!-- html5.js for IE less than 9 -->
<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<!-- css3-mediaqueries.js for IE less than 9 -->
<!--[if lt IE 9]>
		<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<![endif]-->
		
		<script src="js/jquery-2.1.3.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/jquery.maskedinput.js" type="text/javascript"></script>
		<script src="js/jquery-ui.min.js" type="text/javascript"></script>
		<script src="js/bootstrap.js" type="text/javascript"></script>	

		<script src="//api-maps.yandex.ru/2.0-stable/?load=package.standard,package.geoObjects,package.geoQuery,package.route&lang=ru-RU" type="text/javascript"></script>
		
			<script src="http://maps.api.2gis.ru/2.0/loader.js?pkg=full"></script>
	
		<!--<script src="js/jquery.maskMoney.min.js" type="text/javascript"></script>-->
		<script type="text/javascript" src="/js/alertify.js"></script>
		<script src="js/javascript_new.js" type="text/javascript"></script>
		<script src="js/add_photos.js" type="text/javascript"></script>	

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
					// setInterval(function(){
						// $.get("/?task=profile&action=session_update");
					// }, 59000);
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

	</head>	
	<body>
		<span class="glyphicon glyphicon-circle-arrow-up slide-top hidden" onClick="$('html,body').stop().animate({	scrollTop: $('html').offset().top}, 1000);"></span>
			<div class="container" style="margin-top: 25px;">	
				<?php 
					//include 'application/includes/external_search.php';
					include 'application/views/'.$content_view; 
				?>
			</div>
		<div class="row footer" id="footer">

		</div>
	</body>
</html>