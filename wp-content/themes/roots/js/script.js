/* Author:  */

// Check if browser supports HTML5 input placeholder
function supports_input_placeholder() {
	var i = document.createElement('input');
	return 'placeholder' in i;
}

// Change input text on focus
if (!supports_input_placeholder()) {
	$(':text').focus(function(){
		var self = $(this);
		if (self.val() == self.attr('placeholder')) self.val('');
	}).blur(function(){
		var self = $(this), value = $.trim(self.val());
		if(val == '') self.val(self.attr('placeholder'));
	});
} else {
	$(':text').focus(function(){
		$(this).css('color', '#000');
	});
}






