<?php header('Content-Type: text/html; charset=windows-1251');?>
<!doctype html>
<html>
<head>
  <link rel="stylesheet" type="text/css" media="all" href="css/style.css">
  <link rel="stylesheet" type="text/css" media="all" href="fancybox/jquery.fancybox.css">
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
  <script type="text/javascript" src="fancybox/jquery.fancybox.js"></script>
  <script src="js/countdown.js" type="text/javascript"></script>
</head>
<?php 
$lang = 2;
echo date('Y/m/d H:i:s',time());
?>
<body>
<div id="wrapper">
	<p><a class="modalbox" href="#inline"> &#9993; Подписаться</a></p>
</div>

<!-- hidden inline form -->


<script type="text/javascript">
        var html_pop = '<div id="inline"><p>&#9760; &#9760; &#9760; &#9760; &#9760; &#9760; &#9760; &#9760;</p><p>&#9734; Подпишитесь и будет чудо</p><p>бла - бла -бла</p><div id="CDT"></div>	<form id="contact" name="contact" action="#" method="post">		<label for="email">Ваш E-mail</label><input type="email" id="email" name="email" class="txt">		<button id="send"><?php echo ($lang == 2) ? "Пiдписатися" : "Подписаться";?></button>	</form></div>';
        $('#wrapper').after(html_pop);
	function validateEmail(email) { 
		var reg = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return reg.test(email);
	}

	$(document).ready(function() {
		$(".modalbox").fancybox();
		$("#contact").submit(function() { return false; });

		var url_location = location.href;
                var lang = (url_location.indexOf("http://") + 1) ? 0 : 1;
		$(document).on("click","#send", function(){
			var emailval  = $("#email").val();
			var mailvalid = validateEmail(emailval);
			
			if(mailvalid == false) {
				$("#email").addClass("error");
			}
			else if(mailvalid == true){
				$("#email").removeClass("error");
			}
			
			if(mailvalid == true) {
				// сначала мы скрываем кнопку отправки
                                (lang) ? $("#send").replaceWith("<em>отправка...</em>")
                                       : $("#send").replaceWith("<em>вiдправка...</em>");
				
				$.ajax({
					type: 'POST',
					url: './sendmessage.php',
					data: $("#contact").serialize(),
					success: function(data) {
						if(data == "true") {
							$("#contact").fadeOut("slow", function(){
                                                            (lang) ? $(this).before("<p><strong>Спасибо за подписку</strong></p>")
                                                                   : $(this).before("<p><strong>Дякуемо за подписку</strong></p>");
								setTimeout("$.fancybox.close()", 2500);
							});
						}
					}
				});
			}
		});
	});
</script>

</body>
</html>