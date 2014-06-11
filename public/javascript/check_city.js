$(document).ready(function() {
	var availableTags;
	$('#reg_em').keyup(function() {
			$.post('emails', {email:email}, function(data) {
				availableTags = data;
			});
		
	});

	 $( "#location" ).autocomplete({
		source: availableTags
	 });
});
