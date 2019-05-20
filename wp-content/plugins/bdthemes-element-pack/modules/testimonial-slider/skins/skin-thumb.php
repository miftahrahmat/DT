<?php
namespace ElementPack\Modules\TestimonialSlider\Skins;


use Elementor\Skin_Base as Elementor_Skin_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Thumb extends Elementor_Skin_Base {
	public function get_id() {
		return 'bdt-thumb';
	}

	public function get_title() {
		return __( 'Thumb', 'bdthemes-element-pack' );
	}

	public function render_image( $image_id, $bdt_counter ) {

		$testimonial_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $image_id ), 'medium' );		

		if ( ! $testimonial_thumb ) {
			$testimonial_thumb = BDTEP_ASSETS_URL.'images/member.svg';
		} else {
			$testimonial_thumb = $testimonial_thumb[0];
		}

		?>
		<li class="bdt-slider-thumbnav" bdt-slider-item="<?php echo esc_attr($bdt_counter); ?>">
			<div class="bdt-slider-thumbnav-inner bdt-position-relative">
				<a href="#">
					<img src="<?php echo esc_url( $testimonial_thumb ); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" />
				</a>
			</div>
		</li>
		<?php
	}

	public function render_thumbnavs($settings) {

		?>
		<div class="bdt-thumbnav-wrapper bdt-flex bdt-flex-<?php echo esc_attr($settings['alignment']); ?>">
    		<ul class="bdt-thumbnav">

				<?php		
				$bdt_counter = 0;

				$this->parent->query_posts();

				$wp_query = $this->parent->get_query();
				      
				while ( $wp_query->have_posts() ) : $wp_query->the_post();

					$this->render_image( get_the_ID(), $bdt_counter );
					
					$bdt_counter++;

				endwhile;
				
				wp_reset_postdata();

				?>
    		</ul>
		</div>
		
		<?php
	}

	public function render_footer($settings) {

		?>
			</ul>
				<?php $this->render_thumbnavs($settings); ?>
		</div>
	</div>
	<?php
	}

	public function render() {
		$settings = $this->parent->get_settings_for_display();
		$id       = $this->parent->get_id();

    	$rating_align = ($settings['thumb']) ? '' : ' bdt-flex-' . esc_attr($settings['alignment']);

		$this->parent->query_posts();

		$wp_query = $this->parent->get_query();

		if ( ! $wp_query->found_posts ) {
			return;
		}
			$this->parent->render_header('thumb', $id, $settings);
		?>
			<?php while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

		  		<li class="bdt-slider-item">
			  		<div class="bdt-slider-item-inner bdt-box-shadow-small bdt-padding">

	                	<div class="bdt-testimonial-text bdt-text-<?php echo esc_attr($settings['alignment']); ?> bdt-padding-remove-vertical"><?php echo wp_kses_post(\element_pack_helper::custom_excerpt($settings['text_limit'])); ?></div>
	                	
	                		<div class="bdt-flex bdt-flex-<?php echo esc_attr($settings['alignment']); ?> bdt-flex-middle">

		                    <?php if (('yes' == $settings['title']) or ('yes' == $settings['company_name']) or ('yes' == $settings['rating'])) : ?>
							    <div class="bdt-testimonial-meta">
			                        <?php if ('yes' == $settings['title']) : ?>
			                        	<?php $separator = (( 'yes' == $settings['title'] ) and ( 'yes' == $settings['company_name'] )) ? ', ' : ''?>
			                            <div class="bdt-testimonial-title"><?php echo esc_attr(get_the_title()) . esc_attr( $separator ); ?></div>
			                        <?php endif ?>

			                        <?php if ( 'yes' == $settings['company_name']) : ?>
			                            <span class="bdt-testimonial-address"><?php echo get_post_meta(get_the_ID(), 'bdthemes_tm_company_name', true); ?></span>
			                        <?php endif ?>
			                        
			                        <?php if ('yes' == $settings['rating']) : ?>
			                            <ul class="bdt-rating bdt-rating-<?php echo get_post_meta(get_the_ID(), 'bdthemes_tm_rating', true); ?> bdt-grid bdt-grid-collapse<?php echo esc_attr($rating_align); ?>">
						                    <li class="bdt-rating-item"><span><i class="fa fa-star" aria-hidden="true"></i></span></li>
											<li class="bdt-rating-item"><span><i class="fa fa-star" aria-hidden="true"></i></span></li>
											<li class="bdt-rating-item"><span><i class="fa fa-star" aria-hidden="true"></i></span></li>
											<li class="bdt-rating-item"><span><i class="fa fa-star" aria-hidden="true"></i></span></li>
											<li class="bdt-rating-item"><span><i class="fa fa-star" aria-hidden="true"></i></span></li>
						                </ul>
			                        <?php endif ?>

			                    </div>
			                <?php endif ?>

		                </div>
	                </div>
                </li>
		  
			<?php endwhile;	wp_reset_postdata();
			
		$this->render_footer($settings);
	}
}

