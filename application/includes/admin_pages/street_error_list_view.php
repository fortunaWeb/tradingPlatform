<script type="text/javaScript">

    function updateStreetAdmin(id){
        var street = $(".new_street[data-name='new_street"+id+"']").val();
        $.post('?task=admin&action=street_change', 'id='+ id+ '&street='+ street , function(update){
            if(update != 'OK'){
                alertify.error("Не удалось");
            }else{
                alertify.success("Изменено");
                $(".var_street[data-id="+id+"]").hide()
            }
        });
    }

</script>
<div class='col-xs-9'>
    <legend>Список косячных улиц</legend>
    <table class="table table-striped list" style = 'font-size: 10px'>
        <thead>
        <tr><th>#</th>

            <th>id</th>
            <th>Дата</th>
            <th>Улица</th>
            <th>УлицаНовая</th>
            <th>Сцылка</th>
        </tr>
        </thead>
        <tbody>
        <?
        $i = 1;
        foreach ($data as $var) {?>
        <tr class="var_street" data-name='street' data-id="<?=$var["id"]?>" style = 'background-color:;'data-list-id="<?=$var["id"]?>">
                <td><?=$i++?></td>
                <td><?=$var['id']?></td>
                <td ><?=$var["created"];?></td>
                <td> <?=$var["street"];?></td>
                <td><input type="text" class = 'new_street' data-name = 'new_street<?=$var["id"]?>' >
                    <input type="submit" value="сменить" onclick='updateStreetAdmin(<?=$var["id"]?>);'>
            </td>
                <td><a target="_blank" href="<?=$var["link"];?>"><?=$var["link"];?> </a> </td>
            </tr>
        <? }?>
        </tbody>
    </table>
</div>