<div class="container" style="position: fixed;top: 0;z-index: 99;width: 100%;max-width: 2000px;">
	<div class="row">
		<div class="header center" id="user-menu">

			<span class=" left" style="display: block;margin-top: 0px;">
				<a class="left" href="/?task=main&action=index&parent_id=1&topic_id=2"
				style="margin: -11px -10px -11px -20px;padding: 13px;">Главная</a>
			</span>

			<span class="dropdown left" style="display: block;margin-top: 0px;">
				<a href="javascript:void(0)" id="dropdownMenu4" data-toggle="dropdown" 
						style="margin: -11px -10px -11px 10px;padding: 13px;" class="left">Меню<span class="caret"></span></a>

				<ul class="dropdown-menu" aria-labelledby="dropdownMenu4">

					<li><a href="?task=profile&action=forum_rent&topic=12" style="text-decoration:underline; color:#8b00ff;" >КУПЛЮ</a></li>
					<li><a style = 'color:#5cb85c;text-decoration:underline;' href="?task=profile&action=send_message">Админу написать</a></li>
					<li><a style = 'color:#5cb85c;;text-decoration:underline; 'href="?task=profile&action=check_rielter" >Кто звонит?</a></li>
                <?php
					if($_SESSION['mobile']){ ?>
						<li><a style = 'color:red;text-decoration:underline; '  href="?task=profile&action=sample">Подборки</a></li>
					<?php } ?>
                    <li><a href="?buysell&action=parse_buysell">Частники2</a></li>
				</ul>
			</span>
			
			<span class=" left" style="display: block;margin-top: 0px;">
				<a href="?task=profile&action=sample" style="color:red;text-decoration:underline;margin: -11px -20px -11px 10px;padding: 13px;" class="right">Подб</a>
			</span>

			<span class="dropdown left"
					style="display: block;margin-top: 0px;font-size: 18px;">
				<a class="left" href="javascript:void(0)" id="dropdownMenu1" data-toggle="dropdown" style="float:left;    margin: -13px -10px -11px 10px; padding: 12px; color: rgb(205, 24, 24);" aria-expanded="false">
                    Продажа
				<span class='date-end'>
					<?=date('d.m.Y', strtotime($topic=='Продажа' ? $_SESSION['sell_date_end'] : $_SESSION['sell_date_end']))?>
				</span>
				</a>
				<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">

					<li>
						<a href="<?echo "?task=buysell&action=parse_buysell&topic_id=2&parent_id=1";?>">Продажа</a>
					</li>
					<li>
						<a href="?task=profile&action=services">ЛК</a>
					</li>
					<li>
						<a href="?task=login&action=logout">Выход</a>
					</li>
				</ul>
			</span>
		</div>		
	</div>
		</div>		
	</div>
</div>