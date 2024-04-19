(function( $ ){
    class RtCounter extends elementorModules.frontend.handlers.Base {

        getDefaultElements() {
            return {
                $wrapper: this.$element.find( '.rt-counter-number span' )
            };
        }

        bindEvents() {
        	var $this = this.elements.$wrapper,
    	      countTo = $this.attr( 'data-count' ),
    	      duration = $this.attr( 'data-duration' );
              
        	$({ countNum: $this.text()}).animate({ countNum: countTo }, {
    	    	duration: duration * 1000,
    	    	easing:'linear',
        	    step: function() {
        	    	$this.text( Math.floor( this.countNum ) );
        	    },
        	    complete: function() {
        	    	$this.text( this.countNum );
        	    }
    	  	});
        }
    }

    $( window ).on( 'elementor/frontend/init', function(){
        
        var addHandler = function( $element ){
            elementorFrontend.elementsHandler.addHandler( RtCounter, { $element  } );
        };

        elementorFrontend.hooks.addAction( 'frontend/element_ready/rt-counter.default', addHandler );
    } );
})( jQuery );