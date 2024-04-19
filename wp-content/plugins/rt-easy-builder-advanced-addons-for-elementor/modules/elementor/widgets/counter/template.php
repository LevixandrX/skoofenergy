<div class="rt-counter-wrapper">
	<div class="tr-counter-inner">
		<div class="rt-counter-icon">
			<i class="<?php echo esc_attr( $settings[ 'icon' ] ); ?>"></i>
		</div>
		<div class="rt-counter-text">
			<h3 class="rt-counter-number"><span data-duration="<?php echo absint( $settings[ 'duration' ] ); ?>" data-count="<?php echo absint( $settings[ 'number' ] ); ?>">0</span> <?php if( 'yes' == $settings[ 'append_plus' ] ): ?><i class="fa fa-plus"></i><?php endif; ?></h3>
			<h4 class="rt-counter-label"><?php echo esc_html( $settings[ 'label' ] ); ?></h4>
		</div>
	</div>
</div>