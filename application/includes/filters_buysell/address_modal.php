<?php

?>
<div class="col-xs-1 deployed" style = 'margin-right: <?=$_SESSION['mobile']==1?"auto;'":"auto;"?>'>
    <input type="button"  id = 'subdist'  value="Районы">
    <div class="address_modal" style = '
    min-width:665px;z-index:99; position: absolute;padding: 3px 7px;border: 1px solid #ccc;
    border-radius: 4px;background-color: #fff; display: none;box-sizing: content-box;-webkit-box-sizing: content-box;
    height:480px; overflow-y:auto '>
            <div   class="col-xs-2 deployed"   style = 'background-color: #F7E5B1'>
                    <input type="checkbox" onchange='mainDistCheck(1)'  id = 'main_dist1'  name = 'main_dst1' value="Адлерский" >
                    Адлерский
                <div id = 'main_subdist1'>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist1')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist1" value="1" <?=(Helper::FilterVal('subdist1'))?'checked="checked"':''?>>Адлер Центр
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist2')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist2" value="2" <?=(Helper::FilterVal('subdist2'))?'checked="checked"':''?>>Блиново
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist3')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist3" value="3" <?=(Helper::FilterVal('subdist3'))?'checked="checked"':''?>>Голубые дали
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist4')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist4" value="4" <?=(Helper::FilterVal('subdist4'))?'checked="checked"':''?>>Зорька
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist5')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist5" value="5" <?=(Helper::FilterVal('subdist5'))?'checked="checked"':''?>>Красная Поляна
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist6')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist6" value="6" <?=(Helper::FilterVal('subdist6'))?'checked="checked"':''?>>Кудепста
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist7')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist7" value="7" <?=(Helper::FilterVal('subdist7'))?'checked="checked"':''?>>Курортный городок
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist8')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist8" value="8" <?=(Helper::FilterVal('subdist8'))?'checked="checked"':''?>>Мирный
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist9')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist9" value="9" <?=(Helper::FilterVal('subdist9'))?'checked="checked"':''?>>Нижнеимеретинская Бухта
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist10')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist10" value="10" <?=(Helper::FilterVal('subdist10'))?'checked="checked"':''?>>село Бестужевское
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist11')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist11" value="11" <?=(Helper::FilterVal('subdist11'))?'checked="checked"':''?>>село Верхневеселое
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist12')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist12" value="12" <?=(Helper::FilterVal('subdist12'))?'checked="checked"':''?>>село Веселое
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist13')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist13" value="13" <?=(Helper::FilterVal('subdist13'))?'checked="checked"':''?>>село Галицыно
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist14')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist14" value="14" <?=(Helper::FilterVal('subdist14'))?'checked="checked"':''?>>село Каштаны
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist15')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist15" value="15" <?=(Helper::FilterVal('subdist15'))?'checked="checked"':''?>>село Молдовка
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist16')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist16" value="16" <?=(Helper::FilterVal('subdist16'))?'checked="checked"':''?>>село Нижняя Шиловка
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist17')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist17" value="17" <?=(Helper::FilterVal('subdist17'))?'checked="checked"':''?>>село Орел-Изумруд
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist18')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist18" value="18" <?=(Helper::FilterVal('subdist18'))?'checked="checked"':''?>>село Черешня
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist19')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist19" value="19" <?=(Helper::FilterVal('subdist19'))?'checked="checked"':''?>>село Эсто-Садок
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist20')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist20" value="20" <?=(Helper::FilterVal('subdist20'))?'checked="checked"':''?>>Сельсовет
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist21')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist21" value="21" <?=(Helper::FilterVal('subdist21'))?'checked="checked"':''?>>совхоз Россия
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist22')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist22" value="22" <?=(Helper::FilterVal('subdist22'))?'checked="checked"':''?>>совхоз Южные культуры
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist23')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist23" value="23" <?=(Helper::FilterVal('subdist23'))?'checked="checked"':''?>>Хоста
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist24')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist24" value="24" <?=(Helper::FilterVal('subdist24'))?'checked="checked"':''?>>Чайсовхоз
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist25')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist25" value="25" <?=(Helper::FilterVal('subdist25'))?'checked="checked"':''?>>Черемушки
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist26')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist26" value="26" <?=(Helper::FilterVal('subdist26'))?'checked="checked"':''?>>Чкаловский
                    </label>

                </div>
            </div>
            <div class="col-xs-2 deployed"  style = 'background-color: #C6E486'>
                    <input type="checkbox"     onChange='mainDistCheck(2)' id = 'main_dist2' name = 'main_dst2' value="Лазаревский" >
                    Лазаревский
                <div id = 'main_subdist2'>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist62')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist62" value="62" <?=(Helper::FilterVal('subdist62'))?'checked="checked"':''?>>Аше
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist63')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist63" value="63" <?=(Helper::FilterVal('subdist63'))?'checked="checked"':''?>>Вардане
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist64')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist64" value="64" <?=(Helper::FilterVal('subdist64'))?'checked="checked"':''?>>Вишневка
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist65')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist65" value="65" <?=(Helper::FilterVal('subdist65'))?'checked="checked"':''?>>Волконка
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist66')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist66" value="66" <?=(Helper::FilterVal('subdist66'))?'checked="checked"':''?>>Головинка
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist67')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist67" value="67" <?=(Helper::FilterVal('subdist67'))?'checked="checked"':''?>>Голубая дача
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist68')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist68" value="68" <?=(Helper::FilterVal('subdist68'))?'checked="checked"':''?>>Дагомыс
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist69')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist69" value="69" <?=(Helper::FilterVal('subdist69'))?'checked="checked"':''?>>Культурное Уч-Дере
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist70')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist70" value="70" <?=(Helper::FilterVal('subdist70'))?'checked="checked"':''?>>Кучук-Дере
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist71')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist71" value="71" <?=(Helper::FilterVal('subdist71'))?'checked="checked"':''?>>Лазаревское
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist72')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist72" value="72" <?=(Helper::FilterVal('subdist72'))?'checked="checked"':''?>>Лоо
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist73')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist73" value="73" <?=(Helper::FilterVal('subdist73'))?'checked="checked"':''?>>Магри
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist74')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist74" value="74" <?=(Helper::FilterVal('subdist74'))?'checked="checked"':''?>>Макопсе
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist75')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist75" value="75" <?=(Helper::FilterVal('subdist75'))?'checked="checked"':''?>>Нижняя Беранда
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist76')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist76" value="76" <?=(Helper::FilterVal('subdist76'))?'checked="checked"':''?>>Нижняя Хобза
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist77')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist77" value="77" <?=(Helper::FilterVal('subdist77'))?'checked="checked"':''?>>поселок Атарбеково
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist78')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist78" value="78" <?=(Helper::FilterVal('subdist78'))?'checked="checked"':''?>>поселок Шаумяновка
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist79')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist79" value="79" <?=(Helper::FilterVal('subdist79'))?'checked="checked"':''?>>село Беранда
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist80')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist80" value="80" <?=(Helper::FilterVal('subdist80'))?'checked="checked"':''?>>село Верхнее Уч-Дере
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist81')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist81" value="81" <?=(Helper::FilterVal('subdist81'))?'checked="checked"':''?>>село Глубокая Щель
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist82')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist82" value="82" <?=(Helper::FilterVal('subdist82'))?'checked="checked"':''?>>село Горное Лоо
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist83')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist83" value="83" <?=(Helper::FilterVal('subdist83'))?'checked="checked"':''?>>село Детляжка
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist84')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist84" value="84" <?=(Helper::FilterVal('subdist84'))?'checked="checked"':''?>>село Зубова Щель
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist85')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist85" value="85" <?=(Helper::FilterVal('subdist85'))?'checked="checked"':''?>>село Катковая Щель
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist86')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist86" value="86" <?=(Helper::FilterVal('subdist86'))?'checked="checked"':''?>>село Нижнее Уч-Дере
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist87')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist87" value="87" <?=(Helper::FilterVal('subdist87'))?'checked="checked"':''?>>Совет-Квадже
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist88')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist88" value="88" <?=(Helper::FilterVal('subdist88'))?'checked="checked"':''?>>Солоники
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist89')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist89" value="89" <?=(Helper::FilterVal('subdist89'))?'checked="checked"':''?>>Тихоновка
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist90')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist90" value="90" <?=(Helper::FilterVal('subdist90'))?'checked="checked"':''?>>Чемитоквадже
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist91')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist91" value="91" <?=(Helper::FilterVal('subdist91'))?'checked="checked"':''?>>Шхафит
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist92')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist92" value="92" <?=(Helper::FilterVal('subdist92'))?'checked="checked"':''?>>Якорная Щель
                    </label>
                </div>
            </div>
            <div   class="col-xs-2 deployed"   style = 'background-color: #8B5085'>
                <input type="checkbox"     onChange='mainDistCheck(3)' id = 'main_dist3' name = 'main_dst3' value="Хостинский" >
                Хостинский
                <div id = 'main_subdist3'>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist38')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist38" value="38" <?=(Helper::FilterVal('subdist38'))?'checked="checked"':''?>>Бытха
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist39')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist39" value="39" <?=(Helper::FilterVal('subdist39'))?'checked="checked"':''?>>Верхняя Мацеста
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist40')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist40" value="40" <?=(Helper::FilterVal('subdist40'))?'checked="checked"':''?>>Вишневая
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist41')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist41" value="41" <?=(Helper::FilterVal('subdist41'))?'checked="checked"':''?>>Кудепста
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist42')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist42" value="42" <?=(Helper::FilterVal('subdist42'))?'checked="checked"':''?>>Малый Ахун
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist43')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist43" value="43" <?=(Helper::FilterVal('subdist43'))?'checked="checked"':''?>>Малый Ручей
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist44')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist44" value="44" <?=(Helper::FilterVal('subdist44'))?'checked="checked"':''?>>Новая Мацеста
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist45')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist45" value="45" <?=(Helper::FilterVal('subdist45'))?'checked="checked"':''?>>Приморье
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist46')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist46" value="46" <?=(Helper::FilterVal('subdist46'))?'checked="checked"':''?>>Светлана
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist47')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist47" value="47" <?=(Helper::FilterVal('subdist47'))?'checked="checked"':''?>>село Богушевка
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist48')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist48" value="48" <?=(Helper::FilterVal('subdist48'))?'checked="checked"':''?>>село Верхний Юрт
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist49')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist49" value="49" <?=(Helper::FilterVal('subdist49'))?'checked="checked"':''?>>село Верховское
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist50')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist50" value="50" <?=(Helper::FilterVal('subdist50'))?'checked="checked"':''?>>село Измайловка
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist51')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist51" value="51" <?=(Helper::FilterVal('subdist51'))?'checked="checked"':''?>>село Краевско-Армянское
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist52')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist52" value="52" <?=(Helper::FilterVal('subdist52'))?'checked="checked"':''?>>село Краевско-Греческое
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist53')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist53" value="53" <?=(Helper::FilterVal('subdist53'))?'checked="checked"':''?>>село Пластунка
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist54')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist54" value="54" <?=(Helper::FilterVal('subdist54'))?'checked="checked"':''?>>село Прогресс
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist55')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist55" value="55" <?=(Helper::FilterVal('subdist55'))?'checked="checked"':''?>>село Раздольное
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist56')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist56" value="56" <?=(Helper::FilterVal('subdist56'))?'checked="checked"':''?>>село Русская Мамайка
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist57')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist57" value="57" <?=(Helper::FilterVal('subdist57'))?'checked="checked"':''?>>Соболевка
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist58')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist58" value="58" <?=(Helper::FilterVal('subdist58'))?'checked="checked"':''?>>совхоз Приморский
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist59')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist59" value="59" <?=(Helper::FilterVal('subdist59'))?'checked="checked"':''?>>Старая Мацеста
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist60')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist60" value="60" <?=(Helper::FilterVal('subdist60'))?'checked="checked"':''?>>Хоста
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist61')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist61" value="61" <?=(Helper::FilterVal('subdist61'))?'checked="checked"':''?>>Яна Фабрициуса
                    </label>

                </div>
            </div>
            <div   class="col-xs-2 deployed"   style = 'background-color: #71B7AE'>
                <input type="checkbox"     onChange='mainDistCheck(4)' id = 'main_dist4' name = 'main_dst4' value="Центральный" >
                Центральный
                <div id = 'main_subdist4'>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist27')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist27" value="27" <?=(Helper::FilterVal('subdist27'))?'checked="checked"':''?>>Ареда
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist28')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist28" value="28" <?=(Helper::FilterVal('subdist28'))?'checked="checked"':''?>>Больничный городок
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist29')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist29" value="29" <?=(Helper::FilterVal('subdist29'))?'checked="checked"':''?>>Вишневая
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist30')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist30" value="30" <?=(Helper::FilterVal('subdist30'))?'checked="checked"':''?>>Донская
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist31')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist31" value="31" <?=(Helper::FilterVal('subdist31'))?'checked="checked"':''?>>Завокзальный
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist32')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist32" value="32" <?=(Helper::FilterVal('subdist32'))?'checked="checked"':''?>>Заречный
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist33')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist33" value="33" <?=(Helper::FilterVal('subdist33'))?'checked="checked"':''?>>КСМ
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist34')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist34" value="34" <?=(Helper::FilterVal('subdist34'))?'checked="checked"':''?>>Макаренко
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist35')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist35" value="35" <?=(Helper::FilterVal('subdist35'))?'checked="checked"':''?>>Мамайка
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist36')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist36" value="36" <?=(Helper::FilterVal('subdist36'))?'checked="checked"':''?>>Новый Сочи
                    </label><br/>
                    <label class="checkbox-inline <?=Helper::FilterVal('subdist37')? 'active':''?>" style = 'margin-left: 10px;'>
                        <input type="checkbox"  name="subdist37" value="37" <?=(Helper::FilterVal('subdist37'))?'checked="checked"':''?>>Центр
                    </label>
                </div>
            </div>

        <div class="btn-group medium " style="margin-left: 1%;">
            <label id = 'subdist_complete' class="btn btn-primary" style = 'border-radius: 4px;margin-right: 10px;'>
                Готово
            </label>
            <label   id = 'subdist_clear' class="btn  btn-danger" style = 'border-radius: 4px;margin-right: 10px;'>
                Сброс
            </label>
        </div>
  </div>

</div>
