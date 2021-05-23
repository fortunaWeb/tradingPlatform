<script type='text/javascript'>
	$(function(){
		$(".modal#clean-modal-win .modal-title").text("Список жалоб по данному варианту");
		$(".modal#clean-modal-win .modal-footer").remove();
		$(".modal#clean-modal-win .modal-dialog").width(700);
	})
</script>
<div class='col-xs-9'>
	<legend>Жалобы на сообщения</legend>
	<?
	include "application/includes/product_review.php";
	echo Helper::Modal_win_clean();
	echo Helper::Modal_win_add_to_black_list();
	?>
</div>