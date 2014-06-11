$(document).ready(function() {
	var mail_valid = 0;
	var password_valid = 0;
	var normalInput_valid = 0;
	// Call on page load
	$(updateTotalItems);
	//verific la incarcarea paginii daca campurile is completate
	function updateTotalItems() {
		//verific daca sunt campuri libere
		
		
		var pswd = $('input[type=password]').val();
		if (typeof(pswd) != 'undefined' && pswd != null) {
			empty_fields();
			password_valid = check_password(pswd);
		
			var email = $('input[id=reg_em]').val();
			mail_valid = e_valid(email);
			register_avaible();
		}
	}

	$('form input').keyup(function() {
		//verific daca sunt campuri libere
		if ($(this).attr('id') != 'reg_em') {
			empty_fields();
			register_avaible();
		}
	});
	
	function empty_fields() {
		var empty = false;
		
		$('form input').keyup(function() {

			if ($(this).val() == '') {
				empty = true;
				
			}
		});
		
		if ( empty == false) {
			normalInput_valid = 1;	
		}
		else {
			normalInput_valid = 0;	
		}

	}
	
	function register_avaible() {
		
		if (normalInput_valid == 1 && password_valid == 1 && mail_valid == 1) {
			$('#register_btn').removeAttr('disabled');
		} else {
			$('#register_btn').attr('disabled', 'disabled'); 
		}
	}
	
	//cand se completeaza campul password verific daca respecta cerintele
	$('input[type=password]').keyup(function() {
		var pswd = $(this).val();
		password_valid = check_password(pswd);
		register_avaible();
	}).focus(function() {
		$('#pswd_info').show();
	}).blur(function() {
		$('#pswd_info').hide();
	});
	
	function check_password(pswd) {
		var password_complete = 1;
		//validate count
		if ( pswd.length < 8 ) {
			$('#length').removeClass('valid').addClass('invalid');
			password_complete = 0;
			} else {
			$('#length').removeClass('invalid').addClass('valid');
		}
		//validate letter
		if ( pswd.match(/[A-z]/) ) {
			$('#letter').removeClass('invalid').addClass('valid');
		} else {
			$('#letter').removeClass('valid').addClass('invalid');
			password_complete = 0;
		}

		//validate capital letter
		if ( pswd.match(/[A-Z]/) ) {
			$('#capital').removeClass('invalid').addClass('valid');
			
		} else {
			$('#capital').removeClass('valid').addClass('invalid');
			password_complete = 0;
		}

		//validate number
		if ( pswd.match(/\d/) ) {
			$('#number').removeClass('invalid').addClass('valid');
		} else {
			$('#number').removeClass('valid').addClass('invalid');
			password_complete = 0;
		}
		
		return password_complete;
	}
	
	$('#reg_em').keyup(function() {
		var email = $(this).val();
		e_valid(email);
		
	});
	
	
	function e_valid(email) {
		
		var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
		var emailus_complete = 0;
		if (pattern.test(email)) {
			$.post('emails', {email:email}, function(data) {
				if ( data > 0 ) {
					$('#resp').text( "Mai exista un utilizator cu emailul acesta" );
					set_mail(0);
				}
				else
				if ( data == 0) {
					$('#resp').text( "Email valid" );
					set_mail(1);
				}
			});
		}
		else {
			$('#resp').text( "Email invalid." );
			 set_mail(0);
		}		
	}
	
	function set_mail(val) {
		mail_valid = val;
		register_avaible();
	}
	
	
});
