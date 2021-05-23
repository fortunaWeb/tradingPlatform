<script type="text/javascript">
	$(function(){
		$("[data-id=statistic]").on("click", function(){
			var login = $(this).data("login");
			$.post(location, "login="+login, function(html){
				CloseResult();
				$("#result").append($(html).find('thead').parent()).show();
				$("#main_table").parent().hide();
			})
		});
		
		$("form").submit(function(e){
			e.preventDefault();
			var data = decodeURIComponent($("form").serialize());
			$.post(location, data, function(html){
				CloseResult();
				$("#result").append($(html).find('thead').parent()).show();
				$("#main_table").parent().hide();
			})
		})
	});
	
	function CloseResult(){
		$("#result table").remove();
		$("#result").hide();
		$("#main_table").parent().show();
	}
</script>

<style>
	tbody>tr{
		cursor:pointer;
	}
		tbody>tr:hover{
			background-color:#ccc !important;
		}
		tbody>tr:nth-child(2n){
			background-color: rgba(204, 204, 204, 0.3);
		}
	#result{
		display:none;
		width: 90%;
		position: absolute;
		background-color: #fff;
		height: 500px;
		padding: 20px;
		margin: -20px;
		border: 1px solid #ccc;
		overflow: scroll;
		border-radius: 10px;
	}
		#result span{
			margin-top: -40px;
			position: fixed;
			left: 88%;
			background-color: #fff;
			padding: 7px;
			border: 1px solid #ccc;
			border-radius: 5px;
			cursor: pointer;
		}
			#result span:hover{
				background-color: #F4F4F4;
			}
</style>
<form action="#" method="POST" style="padding: 15px 0 50px;">
	<input type="text" name="street" placeholder="улица">
	<input type="text" name="house" placeholder="номер дома">
	<input type="submit" value="Поиск">
</form>
<div id="result">
	<span onClick="CloseResult()">Закрыть</span>
</div>
<table width="90%" border="1" align="center" cellpadding="4" cellspacing="0">
	<?if(!isset($_POST["login"]) && !isset($_POST["street"])){?>
			<thead id="main_table">
				<tr>
					<th>#</th>
					<th>Логин</th>
					<th>Ip</th>
					<th>Просмотров за неделю</th>
				</tr>
			</thead>
			<tbody>
				<?
				$count = count($data);
				for($i=0; $i<$count; $i++){?>
					<tr data-login="<?=$data[$i]["login"];?>" data-id="statistic">
						<td><?$i+1;?></td>
						<td><?=$data[$i]["login"];?></td>
						<td><?=$data[$i]["ip"];?></td>
						<td><?=$data[$i]["count"];?></td>
					</tr>
				<?}?>
			</tbody>
		<?}else{?>
			<thead>
				<tr>
					<th>Логин</th>
					<th>Ip</th>
					<th>Улица просмотренного варианта</th>
					<th>Номер дома просмотренного варианта</th>
					<th>Дата</th>
					<th>lnk</th>
				</tr>
			</thead>
			<tbody>
			<?
			if(isset($_POST["login"])){	
				$res = DB::Select("p.login, p.ip, DATE_FORMAT(p.date, '%H:%i:%s %d.%m.%Y') as date, v.street, v.house, v.id as var_id, v.parent_id as var_parent_id",
                    "re_photo_statistic as p, re_var as v",
                    "p.var_id = v.id AND p.login='{$_POST['login']}' ORDER BY p.date DESC");
			}else if(isset($_POST["street"])){
				$house = $_POST["house"] != "" ? "AND v.house='".$_POST["house"]."'" : "";
				$res = DB::Select("p.login, p.ip, DATE_FORMAT(p.date, '%H:%i:%s %d.%m.%Y') as date, v.street, v.house, v.id as var_id, v.parent_id as var_parent_id", 
						"re_photo_statistic as p, re_var as v", "p.var_id = v.id AND v.street like '%{$_POST["street"]}%' {$house} ORDER BY p.date DESC");
			}
			$count = count($res);
			for($v=0; $v<$count; $v++){

				?>
				<tr>
					<td><?=$res[$v]["login"];?></td>
					<td><?=$res[$v]["ip"];?></td>
					<td><?=$res[$v]["street"];?></td>
					<td><?=$res[$v]["house"];?></td>
					<td><?=$res[$v]["date"];?></td>
					<td><a target="_blank" href="?task=main&id=<?=$res[$v]["var_id"]?>&hours=96+hour&parent_id=<?=$res[$v]["var_parent_id"]?>"><?=$res[$v]["var_id"]?></a></td>
				</tr>
			<?}?>
			</tbody>
		<?}?>
</table>
