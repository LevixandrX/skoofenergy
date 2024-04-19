<?php
namespace RT_Easy_Builder;

class Script_Handler extends Builder{

	public function enqueue( $script, $assets = true ){

		$handler = "rt-easy-builder-{$script['handler']}";

		if( isset( $script[ 'absolute' ] ) ){
			$file = $script['file']; 
		}else{

			if( $assets ){
				$file = $this->get_directory_uri( "assets/{$script['file']}" );
			}else{
				$file = $this->get_directory_uri( $script['file'] );
			}
		}

		if( strpos( $script['file'], '.js' ) ){
			
			$dependency = isset( $script[ 'dependency' ] ) ? $script[ 'dependency' ] : array( 'jquery' );
			wp_enqueue_script( $handler, $file, $dependency, RT_EASY_BUILDER_VERSION );

			if( isset( $script['localize'] ) ){
				wp_localize_script(
					$handler,
					$script['localize']['name'],
					$script['localize']['data']
				);
			}
		}else{
			$dependency = isset( $script[ 'dependency' ] ) ? $script[ 'dependency' ] : array();
			wp_enqueue_style( $handler, $file, $dependency, RT_EASY_BUILDER_VERSION  );
			if ( isset( $script[ 'inline' ] ) ) {
				wp_add_inline_style( $handler, wp_strip_all_tags( preg_replace( '#<style[^>]*>(.*)</style>#is', '$1', $script[ 'inline' ] ) ) );
			}
		}
	}

	public function register( $script ){

		$handler = $script[ 'handler' ];
		$file = $this->get_directory_uri( $script['file'] );

		if( strpos( $script['file'], '.js' ) ){
			
			$dependency = isset( $script[ 'dependency' ] ) ? $script[ 'dependency' ] : array( 'jquery' );
			wp_register_script( $handler, $file, $dependency, RT_EASY_BUILDER_VERSION, true );

		}else{

			$dependency = isset( $script[ 'dependency' ] ) ? $script[ 'dependency' ] : array();
			wp_register_style( $handler, $file, $dependency, RT_EASY_BUILDER_VERSION  );
			
		}
	}
}