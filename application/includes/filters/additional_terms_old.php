<div class="col-xs-4 deployed">
	<div class="btn-group medium multi-active" id="furniture">
		<button type="button" name="torg" class="btn btn-default <?php if($data_res['torg'] == 1 || $_POST['torg'] == 1) echo "active"; ?>">
			Торг
		</button>
		<button type="button" name="chist_prod" class="btn btn-default <?php if($data_res['chist_prod'] == 1 || $_POST['chist_prod'] == 1) echo "active"; ?>">
			Чистая продажа	
		</button>
		<button type="button" name="obmen" class="btn btn-default <?php if($data_res['obmen'] == 1 || $_POST['obmen'] == 1) echo "active"; ?>">
			Обмен
		</button>
		<button type="button" name="ipoteka" class="btn btn-default <?php if($data_res['ipoteka'] == 1 || $_POST['ipoteka'] == 1) echo "active"; ?>">
			Ипотека
		</button>										
	</div> 
</div> 