<?php
$data = "application/includes/txt/orders.txt"; 
$company_data_payment = Helper::Services_data();
$form_visible =  intval($data[0]['order_access']) == 1 || intval($_SESSION['order_access']) == 1;

if($_SESSION['admin']==1){?>
    <script src="tmce4/tinymce.min.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
        tinymce.PluginManager.load('moxiecut', "/tmce4/plugins/moxiecut/plugin.min.js");
        tinymce.init({
            language: 'ru',
            selector: '#order_txt',
            plugins: [
                'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
                'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
                'save table contextmenu directionality emoticons template paste textcolor moxiecut'
            ],
            toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons',
            height: 300,
        });
    </script>
<?}?>

<div class="col-xs-9">
    <div class="col-xs-12" style="margin-top:15px">
        <?if($_SESSION['admin']==1){?>
            <?php if(isset($_POST['content']) && $_GET['edit']==1){
                $fp = fopen($data, "wa"); // Открываем файл в режиме записи
                fwrite($fp, $_POST['content']); // Запись в файл
                fclose($fp); //Закрытие файла
            }?>
            <div data-id="text" class="hidden">
                <form method="post" action="?task=profile&action=order_txt&edit=1">
                    <textarea id="order_txt" name="content"><?readfile($data)?></textarea>
                    <div class="col-xs-12" style="text-align: right;margin-top:15px">
                        <a href="?task=profile&action=order_txt" class="btn btn-default">Отмена</a>
                        <button type="submit" class="btn btn-success">Отправить</button>
                    </div>
                </form>
            </div>
        <?}?>
        <div data-id="text">
            <?readfile($data);?>
            <?if($_SESSION['admin']==1){?>
                <div class="col-xs-12" style="text-align: right;margin-top:15px">
                    <button type="button" class="btn btn-primary" onClick="$('[data-id=text]').toggleClass('hidden')">Редактировать</button>
                </div>
            <?}?>
        </div>
    </div>
   </div>