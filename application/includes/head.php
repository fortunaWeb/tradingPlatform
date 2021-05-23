<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title><?php echo $this->title;?></title>
<link rel="stylesheet" href="<?php echo URL_ROOT;?>/css/style.css" type="text/css">		
<script src="<?php echo URL_ROOT;?>/js/script.js" type="text/javascript"></script>
<<script src="<?php echo URL_ROOT;?>/js/jquery-1.8.3.min.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo URL_ROOT;?>/js/jquery.maskedinput.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(function() {
        $.mask.definitions['~'] = "[+-]";
        $("#date").mask("99/99/9999",{completed:function(){alert("completed!");}});
        $("#phone").mask("(999) 999-9999");
        $("#phoneExt").mask("(999) 999-9999? x99999");
        $("#iphone").mask("+33 999 999 999");
        $("#tin").mask("99-9999999");
        $("#ssn").mask("999-99-9999");
        $("#product").mask("a*-999-a999", { placeholder: " " });
        $("#eyescript").mask("~9.99 ~9.99 999");
        $("#po").mask("PO: aaa-999-***");
		$("#pct").mask("99%");

        $("input").blur(function() {
            $("#info").html("Unmasked value: " + $(this).mask());
        }).dblclick(function() {
            $(this).unmask();
        });
    });
	
</script>