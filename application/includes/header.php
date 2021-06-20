<div class="container" style="position: fixed;top: 0;z-index: 99;width: 100%;max-width: 2000px;">
	<div class="row">
		<div class="header center" id="user-menu">
		
			<a class="left" href='?task=main&action=index&copyright=0&parent_id=1&topic_id=2'
               style="margin: -11px -10px -11px -20px;padding: 13px;">На главную</a>
     			<span class="dropdown left" style="display: block;margin-top: 0px;">
				<a href="javascript:void(0)" id="dropdownMenu4" data-toggle="dropdown" style="margin: -11px -10px -11px 10px;padding: 13px;" class="left">Меню<span class="caret"></span></a>
				<ul class="dropdown-menu" aria-labelledby="dropdownMenu4">
					<?php
                     /*if($_SESSION['parent'] == 0){?>
						<li><a href="?task=profile&action=order"><font style = 'color: #884535'>  Отправка данных  об оплате</font></a></li>
                        <li><a href="?task=profile&action=services"><font style = 'color: #884535'> Продление доступа</font></a></li>
						<li><a href="?task=profile&action=user_list">Список сотрудников</a></li>
						<li><a href="?task=profile&action=tariffs">Оферта</a></li>
					<?}/**/?>
                <?php if($_SESSION['login'] == 'admin'){ ?>
                    <li><a href="?task=profile&action=messages">Сообщения от админа</a></li>
                 <?php }?>
					<li><a href="?task=profile&action=contacts">Контакты администратора</a></li>
					<li><a target="_blank" href="https://disk.yandex.ru/d/PFXphoGDoEyAfA">Инструкция по сайту</a></li>
				</ul>
			</span>


			<span class="dropdown right dropdownMenu1" 
					style="display: block;margin-top: 0px;font-size: 18px;">
                <a class="left" href="javascript:void(0)" id="dropdownMenu1" data-toggle="dropdown" style="float:left;    margin: -13px -10px -11px 10px; padding: 12px; color: rgb(205, 24, 24);" aria-expanded="false">Продажа
                    <span class='date-end'>
                        <?=date('d.m.Y', strtotime($topic=='Продажа' ? $_SESSION['sell_date_end'] : $_SESSION['sell_date_end']))?>
                    </span>
				</a>
				<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">

					<li>
						<a href="<?echo "?task=login&action=logout";?>">Выход</a>
					</li>
				</ul>
			</span>
            <?
            $my_obj_topic = isset($_GET['topic_id'])
                ? $_GET['topic_id']
                : ($_SESSION["group_topic_id"] == 3
                    ? 1
                    : $_SESSION["group_topic_id"]);

            if(Helper::isMobileExists($_SESSION['people_id']) ){ ?>
                <a href="?task=profile&action=sample" class="right" style="color:red;margin: -11px -10px -11px 10px;padding: 13px;">Подборки</a>
            <?php } ?>


<!--            <a href="?task=profile&action=services" class="right" style="margin: -11px -10px -11px 10px;padding: 13px;">ЛK</a>-->

            <span class="dropdown right" style="display: block;margin-top: 0px;">
				<a href="javascript:void(0)" id="dropdownMenu2"
                   data-toggle="dropdown" style="margin: -11px -10px -11px 10px;padding: 13px;"
                   class="right">Добавить объект<span class="caret"></span></a>

                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
						<li><a href="?task=profile&action=newvar&topic_id=2&parent_id=1">Квартира</a></li>
						<li><a href="?task=profile&action=newvar&topic_id=2&parent_id=8">ЖП</a></li>
						<li><a href="?task=profile&action=newvar&topic_id=2&parent_id=18">Комната</a></li>
<!--						<li><a href="?task=profile&action=newvar&topic_id=2&parent_id=3">Коттеджи-дома</a></li>-->
<!--						<li><a href="?task=profile&action=newvar&topic_id=2&parent_id=5">Земля</a></li>-->
<!--						<li><a href="?task=profile&action=newvar&topic_id=2&parent_id=6">Гаражи/Парковки</a></li>-->
<!--						<li><a href="?task=profile&action=newvar&topic_id=2&parent_id=7">Коммерческая</a></li>-->
					</ul>
			</span>

            <?
			if(($_SESSION['user']) && ($_SESSION['user'] != 'guest' )) {
				
				if($_SESSION['admin']==1){							
					echo "<a style='float: left; margin: -11px -10px -11px 10px;padding: 13px;' href='?task=admin'>Админка</a>";
				}
			if($_SESSION['parent']==0 && $_SESSION['admin']==0){?>
				<a class="left" href="?task=profile&action=send_message" style="margin: -11px -10px -11px 10px;padding: 13px;">
                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> админу</a>
			<?}
			    $link = $_SESSION['parent']==0 ? "?task=profile&action=services" : "?task=profile&action=services";
            ?>

            <span class="dropdown right" style="display: block;margin-top: 0px;">
				<a href="javascript:void(0)" id="dropdownMenu2"
                   data-toggle="dropdown" style="margin: -11px -10px -11px 10px;padding: 13px;"
                   class="right">Мои объекты<span class="caret"></span></a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
						<li><a href="?task=profile&action=mytype&topic_id=1&limit=all&active=1">Для агентств</a></li>
						<li><a href="?task=profile&action=mytype&topic_id=1&active=0">Архив</a></li>
						<li><a href="?task=profile&action=mytype&copyright=1&active=1&topic_id=1">Скопированные</a></li>
						<li><a href="?task=profile&action=sample">Подборки</a></li>
					</ul>
			</span>
            <?php
            $link = $_SESSION['parent']==0 ? "?task=profile&action=services" : "?task=profile&action=services";
            $my_obj_topic = isset($_GET['topic_id'])
                ? $_GET['topic_id']
                : ($_SESSION["group_topic_id"] == 3
                    ? 1
                    : $_SESSION["group_topic_id"]);
            ?>


				
		</div>		
	</div>
	<?php } ?>
		</div>		
	</div>
</div>