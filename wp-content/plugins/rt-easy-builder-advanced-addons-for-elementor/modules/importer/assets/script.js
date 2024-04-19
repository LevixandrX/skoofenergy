(function( $ ){
	$(document).ready(function(){
		$( document ).on( 'click', '.activate-plugins', function( e ){

			e.preventDefault();
			var data = {
				'action': 'activate_plugins',
				'security': RTEASYBUILDER.nonce
			};

			var $this = $(this);
			$this.addClass( 'loading' );
			$.post( RTEASYBUILDER.ajaxurl, data, function(response) {
				window.location.reload();
			});
		});

		$( document ).on( 'click', '.show-details', function(e){
			e.preventDefault();
			$(this).closest( '.ocdi__gl-item-footer' ).toggleClass( 'show-requirements' );
		});
	});
})(jQuery)