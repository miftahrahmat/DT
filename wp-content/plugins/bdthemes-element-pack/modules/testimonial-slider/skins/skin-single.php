<?php
namespace ElementPack\Modules\TestimonialSlider\Skins;


use Elementor\Skin_Base as Elementor_Skin_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Skin_Single extends Elementor_Skin_Base {
	public function get_id() {
		return 'bdt-single';
	}

	public function get_title() {
		return __( 'Single', 'bdthemes-element-pack' );
	}

	public function render_image( $image_id ) {

		$testimonial_thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $image_id ), 'medium' );		

		if ( ! $testimonial_thumb ) {
			$testimonial_thumb = BDTEP_ASSETS_URL.'images/member.svg';
		} else {
			$testimonial_thumb = $testimonial_thumb[0];
		}

		?>
		<div>
    		<div class="bdt-testimonial-thumb">
				<img src="<?php echo esc_url( $testimonial_thumb ); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" />
			</div>
		</div>
		<?php
	}

	public function render() {
		$settings = $this->parent->get_settings_for_display();
		$id       = $this->parent->get_id();

    	$rating_align = ($settings['thumb']) ? '' : ' bdt-flex-center';


    	$this->parent->query_posts();

		$wp_query = $this->parent->get_query();

		if ( ! $wp_query->found_posts ) {
			return;
		}

			$this->parent->render_header('single', $id, $settings);

			while ( $wp_query->have_posts() ) : $wp_query->the_post(); ?>

		  		<li class="bdt-slider-item">
	             
	            	<div class="bdt-grid bdt-flex-middle" bdt-grid>
		            	<div class="bdt-testimonial-image-part bdt-width-auto@m">
		            		<?php $this->render_image( get_the_ID() ); ?>
		        		</div>

	                	<div class="bdt-testimonial-desc-part bdt-width-expand@m">
		                	<div class="bdt-testimonial-text bdt-text-left">
		                		<?php echo wp_kses_post(\element_pack_helper::custom_excerpt($settings['text_limit'])); ?>
		            		</div>
		                	
		            		<div>

			                    <?php if ( $settings['title']  or $settings['company_name'] or $settings['rating']) : ?>
								    <div class="bdt-testimonial-meta">
				                        <?php if ($settings['title']) : ?>
				                            <div class="bdt-testimonial-title"><?php echo esc_attr(get_the_title()); ?></div>
				                        <?php endif ?>

				                        <?php if ( $settings['company_name']) : ?>
				                        	<?php $separator = (( $settings['title'] ) and ( $settings['company_name'] )) ? ', ' : ''?>
				                            <span class="bdt-testimonial-address"><?php echo esc_attr( $separator ).get_post_meta(get_the_ID(), 'bdthemes_tm_company_name', true); ?></span>
				                        <?php endif ?>
				                        
				                        <?php if ($settings['rating']) : ?>
				                            <ul class="bdt-rating bdt-rating-<?php echo get_post_meta(get_the_ID(), 'bdthemes_tm_rating', true); ?> bdt-grid bdt-grid-collapse">
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
	                </div>
	            </li>
		  
			<?php endwhile;	wp_reset_postdata();
			
		$this->parent->render_footer($settings);
	}
}

