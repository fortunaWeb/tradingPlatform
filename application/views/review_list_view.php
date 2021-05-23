<script type='text/javascript'>
	$(function(){
		$(".modal#clean-modal-win .modal-title").text("Список жалоб по данному варианту");
		$(".modal#clean-modal-win .modal-footer").remove();
		$(document).on('click', '[data-name=review_list_for_admin]', function(){
			var id = $('.product').has($(this)).data('id');
			$.ajax({
				type:'POST',
				url:'?task=profile&action=review_list_for_admin',
				data:"id="+id,
				success:function(html){
					$(".modal#clean-modal-win .modal-body").text('');
					$(".modal#clean-modal-win .modal-body").append(html);
				}
			})
		})
	})
</script>
<div class='col-xs-12 products-list'>
	<?include "application/includes/product.php";	
	echo Helper::Modal_win_clean();	
	echo Helper::Modal_win_add_to_black_list();
	?>
</div>