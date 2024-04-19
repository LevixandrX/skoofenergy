(function( $ ){
    class RtFeaturedSlider extends elementorModules.frontend.handlers.Base {

        getDefaultElements() {
            return {
                $wrapper: this.$element.find( '.rt-featured-slider' )
            };
        }

        bindEvents() {
            var args = this.elements.$wrapper.data( 'settings' );
            setTimeout(()=>{
                this.elements.$wrapper.slick({
                    prevArrow: '<button type="button" class="slick-prev"><i class="fa fa-angle-left"></i></button>',
                    nextArrow: '<button type="button" class="slick-next"><i class="fa fa-angle-right"></i></button>',
                    dots: args.dots == 'yes' ? true: false,
                    arrows: args.show_arrows == 'yes' ? true : false,
                    speed: 300,
                    infinite: args.infinite == 'yes' ? true: false,
                    slidesToShow: args.slides_to_show > 2 ? 2 : args.slides_to_show,
                    autoplaySpeed: 2000,       
                    fade: false,         
                    responsive: [
                        {
                          breakpoint: 768,
                          settings: {
                            slidesToShow: 1
                          }
                        },
                    ]
                });

                this.elements.$wrapper.slick('setPosition');
            });
        }
    }

    $( window ).on( 'elementor/frontend/init', () => {
        
        const addHandler = ( $element ) => {
            elementorFrontend.elementsHandler.addHandler( RtFeaturedSlider, { $element  } );
        };

        elementorFrontend.hooks.addAction( 'frontend/element_ready/rt-featured-slider.default', addHandler );
    } );
})( jQuery );