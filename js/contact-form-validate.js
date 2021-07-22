$(document).ready(function() {
	$( ".contact-form-button" ).click(function() {
		$(this).attr('style', 'disabled="disabled"');
		$form = $(this).parent();
		$form.find('.help-block-error').empty();
		$serializeform = $form.serializeArray();
		if(!checkContactForm($serializeform, $form)){
			return false;
		}
		$.ajax({
			url: 'backend/contact-form.php', 
			type:     "POST",
			dataType: "json", 
			data: $serializeform, 
			success: function(response) { 
				if(response != ""){
					$.each(response, function(nameinput, errortext){
						$form.children('input[name="' + nameinput + '"]').next('.help-block-error').text(errortext);
					});
				}else{
					$form.empty();
					$form.html('<p style = "color:white;">Спасибо за заказ! Наш оператор свяжется с Вами</p>');
				}
			},
			error: function(response) {
			}
		});
	  $(this).attr('style', '');
	  return false;
	});
});

function checkContactForm($serializeform, $form) {
   $result = true;
   $.each($serializeform, function(){
		if(this.value == ""){
			if(this.name == "name"){
				$form.find('input[name="name"]').next('.help-block-error').text('Введите своё имя');
			}
			if(this.name == "phone"){
				$form.find('input[name="phone"]').next('.help-block-error').text('Введите номер телефона');
			}
			$result = false;
		}
	});
	return $result;
}