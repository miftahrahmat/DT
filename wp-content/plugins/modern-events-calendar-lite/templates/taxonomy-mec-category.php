<?php
/** no direct access **/
defined('MECEXEC') or die();

/**
 * The Template for displaying mec-category taxonomy events
 * 
 * @author Webnus <info@webnus.biz>
 * @package MEC/Templates
 * @version 1.0.0
 */
get_header('mec'); ?>
    
	<?php do_action('mec_before_main_content'); ?>
        
        <section id="<?php echo apply_filters('mec_category_page_html_id', 'main-content'); ?>" class="<?php echo apply_filters('mec_category_page_html_class', 'container'); ?>">
		<?php if(have_posts()): ?>

			<?php do_action('mec_before_events_loop'); ?>
                
                <h1><?php echo single_term_title(''); ?></h1>
				<?php $MEC = MEC::instance(); echo $MEC->category(); ?>

			<?php do_action('mec_after_events_loop'); ?>

		<?php endif; ?>
        </section>

    <?php do_action('mec_after_main_content'); ?>

<?php get_footer('mec');