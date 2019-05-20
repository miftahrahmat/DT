<?php
namespace ElementPack\Modules\PostGrid\Skins;

use Elementor\Skin_Base as Elementor_Skin_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Reverse extends Elementor_Skin_Base {

	public function get_id() {
		return 'bdt-reverse';
	}

	public function get_title() {
		return __( 'Reverse', 'bdthemes-element-pack' );
	}

	public function render_comments() {

		if ( ! $this->parent->get_settings('show_comments') ) {
			return;
		}
		
		echo 
			'<span class="bdt-post-grid-comments"><i class="fa fa-comments-o" aria-hidden="true"></i> '.get_comments_number().'</span>';
	}

	public function render_category() {

		if ( ! $this->parent->get_settings( 'show_category' ) ) { return; }
		?>
		<div class="bdt-post-grid-category bdt-position-z-index bdt-position-small bdt-position-top-right">
			<?php echo get_the_category_list(' '); ?>
		</div>
		<?php
	}

	public function render_post_grid_layout_plane( $post_id, $image_size, $excerpt_length ) {
		$settings = $this->parent->get_settings();

		?>
		<div class="bdt-post-grid-item bdt-transition-toggle bdt-position-relative">								
			<?php $this->parent->render_image(get_post_thumbnail_id( $post_id ), $image_size ); ?>

	  		
	  		<div class="bdt-post-grid-desc bdt-padding">
				<?php $this->parent->render_title(); ?>

				<?php $this->parent->render_excerpt($excerpt_length); ?>
				<?php $this->parent->render_readmore(); ?>
				
				<?php if ($settings['show_author'] or $settings['show_date'] or $settings['show_comments']) : ?>
					<div class="bdt-post-grid-meta bdt-subnav bdt-flex-middle bdt-margin-small-top bdt-padding-remove-horizontal">
						<?php $this->parent->render_author(); ?>
						<?php $this->parent->render_date(); ?>
						<?php $this->render_comments(); ?>
					</div>
				<?php endif; ?>
			</div>

			<?php $this->render_category(); ?>
		</div>
		<?php
	}

	public function render_post_grid_layout_reverse( $post_id, $image_size, $excerpt_length ) {
		$settings = $this->parent->get_settings();

		?>
		<div class="bdt-post-grid-item bdt-transition-toggle bdt-position-relative">								

	  		
	  		<div class="bdt-post-grid-desc bdt-padding">
				<?php $this->parent->render_title(); ?>

				<?php $this->parent->render_excerpt($excerpt_length); ?>
				<?php $this->parent->render_readmore(); ?>
				
				<?php if ($settings['show_author'] or $settings['show_date'] or $settings['show_comments']) : ?>
					<div class="bdt-post-grid-meta bdt-subnav bdt-flex-middle bdt-margin-small-top bdt-padding-remove-horizontal">
						<?php $this->parent->render_author(); ?>
						<?php $this->parent->render_date(); ?>
						<?php $this->render_comments(); ?>
					</div>
				<?php endif; ?>
			</div>
			<div class="bdt-position-relative">
			<?php $this->parent->render_image(get_post_thumbnail_id( $post_id ), $image_size ); ?>
			<?php $this->render_category(); ?>
			</div>

		</div>
		<?php
	}

	public function render() {
		
		$settings = $this->parent->get_settings();
		$id       = $this->parent->get_id();

		$this->parent->query_posts( $settings['reverse_item_limit']['size'] );
		$wp_query = $this->parent->get_query();

		if ( ! $wp_query->found_posts ) {
			return;
		}

		$this->parent->add_render_attribute( 'grid-height', 'class', ['bdt-grid', 'bdt-grid-collapse'] );
		$this->parent->add_render_attribute( 'grid-height', 'bdt-grid', '' );

		?> 
		<div id="bdt-post-grid-<?php echo esc_attr($id); ?>" class="bdt-post-grid bdt-post-grid-skin-reverse">
	  		<div <?php echo $this->parent->get_render_attribute_string( 'grid-height' ); ?>>

				<?php $bdt_count = 0;
			
				while ($wp_query->have_posts()) :
					$wp_query->the_post();

					if($bdt_count == 3) {
		  				$bdt_count = 0;
		  			}
						
		  			$bdt_count++;

		  			if ( $bdt_count % 2 != 0) {
						$bdt_grid_raw   = ' bdt-width-1-' . esc_attr($settings['columns']) . '@m bdt-width-1-' . esc_attr($settings['columns_tablet']) . '@s bdt-width-1-' . esc_attr($settings['columns_mobile']) ;
						$bdt_post_class = ' bdt-plane';

						?>
						<div class="<?php echo esc_attr($bdt_grid_raw . $bdt_post_class); ?>">
							<?php $this->render_post_grid_layout_plane( get_the_ID(), $settings['thumbnail_size'], $settings['excerpt_length']); ?>
						</div>
						<?php
		  			} else {
						$bdt_grid_raw   = ' bdt-width-1-' . esc_attr($settings['columns']) . '@m bdt-width-1-' . esc_attr($settings['columns_tablet']) . '@s bdt-width-1-' . esc_attr($settings['columns_mobile']) ;
						$bdt_post_class = ' bdt-reverse';

						?>
						<div class="<?php echo esc_attr($bdt_grid_raw . $bdt_post_class); ?>">
							<?php $this->render_post_grid_layout_reverse( get_the_ID(), $settings['thumbnail_size'], $settings['excerpt_length']); ?>
						</div>
						<?php
		  			}

		  			?>	  			
		  			
				<?php endwhile; ?>
			</div>
		</div>	
 		<?php

 		if ($settings['show_pagination']) {
 			element_pack_post_pagination($wp_query);
 		}
		wp_reset_postdata();
	}
}

