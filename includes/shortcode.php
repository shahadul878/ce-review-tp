<?php

class ReviewSliderShortcode
{
    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $plugin_name The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string $version The current version of the plugin.
     */
    protected $version;

    public function __construct()
    {
        // Register the shortcode
        add_shortcode('ce-trustpilot-reviews', array($this, 'review_slider_shortcode_handler'));

        // Enqueue necessary scripts and styles
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
    }

    // Enqueue scripts and styles
    public function enqueue_scripts()
    {
        // Enqueue slider scripts and styles
        wp_enqueue_script('review-slider-script', 'path/to/review-slider-script.js', array('jquery'), '1.0', true);
        wp_enqueue_style('review-slider-style', 'path/to/review-slider-style.css', array(), '1.0');
    }

    // Shortcode handler function
    public function review_slider_shortcode_handler($atts)
    {
        // Shortcode attributes
        $atts = shortcode_atts(array(
            'count' => '5',
            'company_name' => '',
        ), $atts);

        // Process the shortcode attributes
        $reviews = new Ce_Trustpilot_Review_Public($this->plugin_name(), $this->get_version());

        $reviews = $reviews->get_reviews_from_db($atts['company_name']);

        $reviews = array_slice($reviews, 0, $atts['count']);

        // Process the shortcode
        $output = '<div class="review-slider">';
        $output .= '<div class="slider-wrapper">';

        foreach ($reviews as $review) {
            $output .= '<div class="ce-single-review">';
            $output .= '<div class="author-meta">
           <div class="author-thumb">
            <a href="">
                <img src="./images/author.jpg" alt="">
            </a>
           </div>
           <div class="author-details">
             <h3>'. esc_html( $review->reviewer_name ) .'</h3>
           </div>
        </div>';

            $output .= '<div class="review-content">
            <div class="star-rating-wrapper">
                <div class="star-rating">
                    <img src="'. esc_url( $review->review_rating_img_url ) .'" alt="">
                </div>
            </div>
            <div class="review-text">
                <h3>'.wp_kses_post( $review->review_title ).'</h3>
                <p> '. wp_kses_post( $review->review_content ) .' </p>
            </div>
        </div>';
            $output .= '</div > ';
        }

        $output .= '</div > ';
        $output .= '</div > ';

        return $output;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @return    string    The version number of the plugin.
     * @since     1.0.0
     */
    public function get_version()
    {
        return $this->version;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @return    string    The version number of the plugin.
     * @since     1.0.0
     */
    public function plugin_name()
    {
        return $this->plugin_name;
    }


}






// Instantiate the class
$review_slider_shortcode_class = new ReviewSliderShortcode();



