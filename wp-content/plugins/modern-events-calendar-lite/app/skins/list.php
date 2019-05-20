<?php
/** no direct access **/
defined('MECEXEC') or die();

/**
 * Webnus MEC list class.
 * @author Webnus <info@webnus.biz>
 */
class MEC_skin_list extends MEC_skins
{
    /**
     * @var string
     */
    public $skin = 'list';

    public $date_format_classic_1;
    public $date_format_minimal_1;
    public $date_format_minimal_2;
    public $date_format_minimal_3;
    public $date_format_modern_1;
    public $date_format_modern_2;
    public $date_format_modern_3;
    public $date_format_standard_1;
    public $date_format_acc_1;
    public $date_format_acc_2;
    public $display_price;

    /**
     * Constructor method
     * @author Webnus <info@webnus.biz>
     */
    public function __construct()
    {
        parent::__construct();

        // MEC Render
        $this->render = $this->getRender();
    }
    
    /**
     * Registers skin actions into WordPress
     * @author Webnus <info@webnus.biz>
     */
    public function actions()
    {
        $this->factory->action('wp_ajax_mec_list_load_more', array($this, 'load_more'));
        $this->factory->action('wp_ajax_nopriv_mec_list_load_more', array($this, 'load_more'));
    }
    
    /**
     * Initialize the skin
     * @author Webnus <info@webnus.biz>
     * @param array $atts
     */
    public function initialize($atts)
    {
        $this->atts = $atts;
        
        // Skin Options
        $this->skin_options = (isset($this->atts['sk-options']) and isset($this->atts['sk-options'][$this->skin])) ? $this->atts['sk-options'][$this->skin] : array();
        
        // Date Formats
        $this->date_format_classic_1 = (isset($this->skin_options['classic_date_format1']) and trim($this->skin_options['classic_date_format1'])) ? $this->skin_options['classic_date_format1'] : 'M d Y';
        
        $this->date_format_minimal_1 = (isset($this->skin_options['minimal_date_format1']) and trim($this->skin_options['minimal_date_format1'])) ? $this->skin_options['minimal_date_format1'] : 'd';
        $this->date_format_minimal_2 = (isset($this->skin_options['minimal_date_format2']) and trim($this->skin_options['minimal_date_format2'])) ? $this->skin_options['minimal_date_format2'] : 'M';
        $this->date_format_minimal_3 = (isset($this->skin_options['minimal_date_format3']) and trim($this->skin_options['minimal_date_format3'])) ? $this->skin_options['minimal_date_format3'] : 'l';
        
        $this->date_format_modern_1 = (isset($this->skin_options['modern_date_format1']) and trim($this->skin_options['modern_date_format1'])) ? $this->skin_options['modern_date_format1'] : 'd';
        $this->date_format_modern_2 = (isset($this->skin_options['modern_date_format2']) and trim($this->skin_options['modern_date_format2'])) ? $this->skin_options['modern_date_format2'] : 'F';
        $this->date_format_modern_3 = (isset($this->skin_options['modern_date_format3']) and trim($this->skin_options['modern_date_format3'])) ? $this->skin_options['modern_date_format3'] : 'l';
        
        $this->date_format_standard_1 = (isset($this->skin_options['standard_date_format1']) and trim($this->skin_options['standard_date_format1'])) ? $this->skin_options['standard_date_format1'] : 'd M';   

        $this->date_format_acc_1 = (isset($this->skin_options['accordion_date_format1']) and trim($this->skin_options['accordion_date_format1'])) ? $this->skin_options['accordion_date_format1'] : 'd';
        $this->date_format_acc_2 = (isset($this->skin_options['accordion_date_format2']) and trim($this->skin_options['accordion_date_format2'])) ? $this->skin_options['accordion_date_format2'] : 'F';
        
        // Search Form Options
        $this->sf_options = (isset($this->atts['sf-options']) and isset($this->atts['sf-options'][$this->skin])) ? $this->atts['sf-options'][$this->skin] : array();
        
        // Search Form Status
        $this->sf_status = isset($this->atts['sf_status']) ? $this->atts['sf_status'] : true;
        
        // Generate an ID for the sking
        $this->id = isset($this->atts['id']) ? $this->atts['id'] : mt_rand(100, 999);
        
        // Set the ID
        if(!isset($this->atts['id'])) $this->atts['id'] = $this->id;
        
        // Show "Load More" button or not
        $this->load_more_button = isset($this->skin_options['load_more_button']) ? $this->skin_options['load_more_button'] : true;
        
        // Show Month Divider or not
        $this->month_divider = isset($this->skin_options['month_divider']) ? $this->skin_options['month_divider'] : true;

        // Toggle Month Divider or not
        $this->toggle_month_divider = isset($this->skin_options['toggle_month_divider']) ? $this->skin_options['toggle_month_divider'] : 0;

        // The style
        $this->style = isset($this->skin_options['style']) ? $this->skin_options['style'] : 'modern';
        
        // Override the style if the style forced by us in a widget etc
        if(isset($this->atts['style']) and trim($this->atts['style']) != '') $this->style = $this->atts['style'];
        
        // HTML class
        $this->html_class = '';
        if(isset($this->atts['html-class']) and trim($this->atts['html-class']) != '') $this->html_class = $this->atts['html-class'];
        
        // SED Method
        $this->sed_method = isset($this->skin_options['sed_method']) ? $this->skin_options['sed_method'] : '0';

        // Image popup
        $this->image_popup = isset($this->skin_options['image_popup']) ? $this->skin_options['image_popup'] : 0;
        
        // From Widget
        $this->widget = (isset($this->atts['widget']) and trim($this->atts['widget'])) ? true : false;

        // Display Price
        $this->display_price = (isset($this->skin_options['display_price']) and trim($this->skin_options['display_price'])) ? true : false;
        
        // Init MEC
        $this->args['mec-init'] = true;
        $this->args['mec-skin'] = $this->skin;
        
        // Post Type
        $this->args['post_type'] = $this->main->get_main_post_type();

        // Post Status
        $this->args['post_status'] = 'publish';
        
        // Keyword Query
        $this->args['s'] = $this->keyword_query();
        
        // Taxonomy
        $this->args['tax_query'] = $this->tax_query();
        
        // Meta
        $this->args['meta_query'] = $this->meta_query();
        
        // Tag
        $this->args['tag'] = $this->tag_query();
        
        // Author
        $this->args['author'] = $this->author_query();
        
        // Pagination Options
        $this->paged = get_query_var('paged', 1);
        $this->limit = (isset($this->skin_options['limit']) and trim($this->skin_options['limit'])) ? $this->skin_options['limit'] : 12;

        $this->args['posts_per_page'] = $this->limit;
        $this->args['paged'] = $this->paged;
        
        // Sort Options
        $this->args['orderby'] = 'meta_value_num';
        $this->args['order'] = 'ASC';
        $this->args['meta_key'] = 'mec_start_day_seconds';
        
        // Exclude Posts
        if(isset($this->atts['exclude']) and is_array($this->atts['exclude']) and count($this->atts['exclude'])) $this->args['post__not_in'] = $this->atts['exclude'];
        
        // Include Posts
        if(isset($this->atts['include']) and is_array($this->atts['include']) and count($this->atts['include'])) $this->args['post__in'] = $this->atts['include'];

        // Show Only Expired Events
        $this->show_only_expired_events = (isset($this->atts['show_only_past_events']) and trim($this->atts['show_only_past_events'])) ? '1' : '0';

        // Show Past Events
        if($this->show_only_expired_events)
        {
            $this->atts['show_past_events'] = '1';
            $this->args['order'] = 'DESC';
        }

        // Show Past Events
        $this->args['mec-past-events'] = isset($this->atts['show_past_events']) ? $this->atts['show_past_events'] : '0';

        // Start Date
        $this->start_date = $this->get_start_date();
        
        // We will extend the end date in the loop
        $this->end_date = $this->start_date;
        
        // Show Ongoing Events
        $this->show_ongoing_events = (isset($this->atts['show_only_ongoing_events']) and trim($this->atts['show_only_ongoing_events'])) ? '1' : '0';
        if($this->show_ongoing_events)
        {
            $this->args['mec-show-ongoing-events'] = $this->show_ongoing_events;
            $this->maximum_date = $this->start_date;
        }
        
        // Set start time
        if(isset($this->atts['seconds']))
        {
            $this->args['mec-seconds'] = $this->atts['seconds'];
            $this->args['mec-seconds-date'] = isset($this->atts['seconds_date']) ? $this->atts['seconds_date'] : $this->start_date;
        }
        
        // Apply Maximum Date
        if($this->request->getVar('apply_sf_date', 0) == 1 and isset($this->sf) and isset($this->sf['month']) and trim($this->sf['month'])) $this->maximum_date = date('Y-m-t', strtotime($this->start_date));
        
        // Maximum days for loop
        $this->max_days_loop = 732; // 2 years
        
        // Found Events
        $this->found = 0;
    }
    
    /**
     * Returns start day of skin for filtering events
     * @author Webnus <info@webnus.biz>
     * @return string
     */
    public function get_start_date()
    {
        // Default date
        $date = current_time('Y-m-d');
        
        if(isset($this->skin_options['start_date_type']) and $this->skin_options['start_date_type'] == 'today') $date = current_time('Y-m-d');
        elseif(isset($this->skin_options['start_date_type']) and $this->skin_options['start_date_type'] == 'tomorrow') $date = date('Y-m-d', strtotime('Tomorrow'));
        elseif(isset($this->skin_options['start_date_type']) and $this->skin_options['start_date_type'] == 'start_current_month') $date = date('Y-m-d', strtotime('first day of this month'));
        elseif(isset($this->skin_options['start_date_type']) and $this->skin_options['start_date_type'] == 'start_next_month') $date = date('Y-m-d', strtotime('first day of next month'));
        elseif(isset($this->skin_options['start_date_type']) and $this->skin_options['start_date_type'] == 'date') $date = date('Y-m-d', strtotime($this->skin_options['start_date']));
        
        // Hide past events
        if(isset($this->atts['show_past_events']) and !trim($this->atts['show_past_events']))
        {
            $today = current_time('Y-m-d');
            if(strtotime($date) < strtotime($today)) $date = $today;
        }

        // Show only expired events
        if(isset($this->show_only_expired_events) and $this->show_only_expired_events)
        {
            $yesterday = date('Y-m-d', strtotime('Yesterday'));
            if(strtotime($date) > strtotime($yesterday)) $date = $yesterday;
        }
        
        return $date;
    }
    
    /**
     * Load more events for AJAX requert
     * @author Webnus <info@webnus.biz>
     * @return void
     */
    public function load_more()
    {
        $this->sf = $this->request->getVar('sf', array());
        $apply_sf_date = $this->request->getVar('apply_sf_date', 1);
        $atts = $this->sf_apply($this->request->getVar('atts', array()), $this->sf, $apply_sf_date);
        
        // Initialize the skin
        $this->initialize($atts);
        
        // Override variables
        $this->start_date = $this->request->getVar('mec_start_date', date('y-m-d'));
        $this->end_date = $this->start_date;
        $this->offset = $this->request->getVar('mec_offset', 0);
		
        // Apply Maximum Date
        if($apply_sf_date == 1 and isset($this->sf) and isset($this->sf['month']) and trim($this->sf['month'])) $this->maximum_date = date('Y-m-t', strtotime($this->start_date));
        
        // Return the events
        $this->atts['return_items'] = true;
        
        // Fetch the events
        $this->fetch();
        
        // Return the output
        $output = $this->output();
        
        echo json_encode($output);
        exit;
    }
}