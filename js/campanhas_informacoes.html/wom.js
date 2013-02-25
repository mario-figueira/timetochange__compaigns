//var messageDelay = 2000; // How long to display status messages (in
							// milliseconds)

// Init the form once the document is ready
//$(init);

// Initialize the form

function init() {

	// Hide the form initially.
	// Make submitForm() the form's submit handler.
	// Position the form so it sits in the centre of the browser window.
	$('#contactForm').submit(submitForm);
	// When the "Send us an email" link is clicked:
	// 1. Fade the content out
	// 2. Display the form
	// 3. Move focus to the first field
	// 4. Prevent the link being followed
//	$('a[href="#contactForm"]').click(function() {
//		$('#content').fadeTo('slow', .2);
//		$('#contactForm').fadeIn('slow', function() {
//			$('#senderName').focus();
//		})
//
//		return false;
//	});

}

// Submit the form via Ajax

function submitForm() {
//	var contactForm = $(this);

	
//	$('#topo_coluna2').fadeOut();
//	$('#sendingMessage').fadeIn();
//	
//	$.ajax({
//		url : contactForm.attr('action'),
//		type : contactForm.attr('method'),
//		data : contactForm.serialize(),
//		success : submitFinished
//	});
	var contactForm = $(this);
	TINY.box.show({url:'http://10.0.0.116/wom/1/pt/landingPage/persistEmail',post:contactForm.serialize(),width:480,height:250,opacity:20,topsplit:3});
	
	//Prevent the default form submission occurring
	return false;
}

// Handle the Ajax response

function submitFinished(response) {
	response = $.trim(response);
	// $('#sendingMessage').fadeOut();
	$('#topo_coluna2').fadeOut(500);
	if (response == "Success") {
		$('#successMessage').html('<p style=\"color: green;\">Parabéns. O teu registo foi um sucesso. Dentro de alguns dias receberás novidades no teu email. Entretanto recomenda já o nosso site a todos os teus amigos. Podes ganhar pontos adicionais por cada um que se inscreva através da tua recomendação. Mais pontos são mais possibilidades de receberes convites para as campanhas que são do teu interesse. Não percas tempo!<p>');
		$('#successMessage').delay(500).fadeIn(500).delay(messageDelay).fadeOut();
		$('#topo_coluna2').delay(messageDelay + 1500).fadeIn();
	} else {
		$('#successMessage').html('<p style=\"color: red;\">' + response + '</p>');
		$('#successMessage').delay(500).fadeIn(500).delay(messageDelay).fadeOut();
		$('#topo_coluna2').delay(messageDelay + 1500).fadeIn();
	}
}

function ajaxMenuSubmit(target_id) {
	alert(target_id);
	alert(requestUrl);
}
//	$.ajax({
//		url : contactForm.attr('action'),
//		type : contactForm.attr('method'),
//		data : contactForm.serialize(),
//		success : submitFinished
//	});
