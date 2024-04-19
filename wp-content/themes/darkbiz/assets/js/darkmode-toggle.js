(function( $ ){
	function darkModeToggle() {
		$(document).on('click', '.darkbiz-switch-wrapper', function (e) {
			e.preventDefault();
			var checkBox = $(this).find('.darkbiz-switch input');
			checkBox.prop('checked', !checkBox.prop('checked'));
			$('body').toggleClass('darkbiz-dark-mode');

			if ($('body').hasClass('darkbiz-dark-mode')) {
				createCookie('darkbizDarkMode', true, 60);
			} else {
				createCookie('darkbizDarkMode', false, 1);
			}
		});
	}

	function createCookie(name, value, minutes) {
		if (minutes) {
			var date = new Date();
			date.setTime(date.getTime() + minutes * 60 * 1000);
			var expires = "; expires=" + date.toGMTString();
		} else {
			var expires = "";
		}

		document.cookie = name + "=" + value + expires + "; path=/";
	}

	$(document).ready(function () {
		darkModeToggle();
	});

})(jQuery);