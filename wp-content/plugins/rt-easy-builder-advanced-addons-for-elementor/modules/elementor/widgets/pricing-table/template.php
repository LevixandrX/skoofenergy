<div class="rt-pricing-table-wrapper">
	<div class="rt-pricing-table-inner">
		<div class="rt-pricing-table-header">			
			<i class="<?php echo esc_attr( $settings[ 'icon' ] ); ?>"></i>
			<h3 class="rt-pricing-table-name"><?php echo esc_html( $settings[ 'name' ] ); ?></h3>
			<div class="rt-pricing-table-price">
				<h3><sup><?php echo esc_html( $settings[ 'currency' ] ); ?></sup><?php echo esc_html( $settings[ 'amount' ] ); ?><sub>/<?php echo esc_html( $settings[ 'period' ] ); ?></sub></h3>
			</div>	
		</div>

		<div class="rt-pricing-table-features">
			<ul>
				<?php foreach( $settings[ 'features' ] as $key => $item ): ?>
					<li><?php echo esc_html( $item[ 'label' ] ); ?></li>
				<?php endforeach; ?>
			</ul>
		</div>

		<div class="rt-pricing-table-footer">
			<?php 
				$base->render_anchor_tag( $settings['button_link'], array(
					'text'  => $settings[ 'button_text' ],
					'class' => array( 'rt-pricing-table-btn' ),
					'name'  => 'pricing-table-button'
				)); 
			?>
		</div>
	</div>
</div>