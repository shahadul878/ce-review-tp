<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://codereyes.com/
 * @since      1.0.0
 *
 * @package    Ce_Trustpilot_Review
 * @subpackage Ce_Trustpilot_Review/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Ce_Trustpilot_Review
 * @subpackage Ce_Trustpilot_Review/public
 * @author     Codereyes <codereyesit@gmail.com>
 */
class Ce_Trustpilot_Review_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param      string    $plugin_name The name of the plugin.
	 * @param string $version    The version of this plugin.
	 *@since    1.0.0
	 */
	public function __construct( $plugin_name,  $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ce_Trustpilot_Review_Loader as all the hooks are defined
		 * in that particular class.
		 *
		 * The Ce_Trustpilot_Review_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ce-trustpilot-review-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ce_Trustpilot_Review_Loader as all the hooks are defined
		 * in that particular class.
		 *
		 * The Ce_Trustpilot_Review_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ce-trustpilot-review-public.js', array( 'jquery' ), $this->version, false );

	}

    public function get_reviews_from_db( $company_name ) {
        global $wpdb;

        // Check if we have cached reviews in the database
        $table_name     = $wpdb->prefix . CE_TRUSTPILOT_REVIEW_TABLE;
        $cache_lifetime = 3600; // 1 hour
        $cached_reviews = $wpdb->get_results( "SELECT * FROM $table_name WHERE review_date >= NOW() - INTERVAL $cache_lifetime SECOND" );
        if ( ! empty( $cached_reviews ) ) {
            return $cached_reviews;
        }

        $result = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name" );

        if ( $result < 1 ){
            $this->get_all_reviews( $company_name );
        }

        return $review = $wpdb->get_results( "SELECT * FROM $table_name WHERE review_date <= NOW() - INTERVAL $cache_lifetime SECOND" );

    }

//    private  function get_reviews( $company_name ) {
//        global $wpdb;
//
//        // Check if we have cached reviews in the database
//        $table_name     = $wpdb->prefix . CE_TRUSTPILOT_REVIEW_TABLE;
//        $cache_lifetime = 3600; // 1 hour
//        $cached_reviews = $wpdb->get_results( "SELECT * FROM $table_name WHERE review_date >= NOW() - INTERVAL $cache_lifetime SECOND" );
//        if ( ! empty( $cached_reviews ) ) {
//            return $cached_reviews;
//        }
//
//        $result = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name" );
//        // Get the latest review date from the database
//        $latest_review_date = $wpdb->get_var( "SELECT MAX(review_date) FROM $table_name" );
//        $url                = 'https://www.trustpilot.com/review/' . $company_name;
//        $curl               = curl_init( $url );
//        curl_setopt( $curl, CURLOPT_URL, $url );
//        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
//
//        $headers = array(
//            "User-Agent: ReqBin Curl Client/1.0",
//        );
//        curl_setopt( $curl, CURLOPT_HTTPHEADER, $headers );
//        curl_setopt( $curl, CURLOPT_SSL_VERIFYHOST, false );
//        curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false );
//
//        $all_reviews = curl_exec( $curl );
//        curl_close( $curl );
//
//        $dom = new simple_html_dom();
//        $dom->load( $all_reviews );
//        $reviews = $dom->find( 'article[data-service-review-card-paper]' );
//        if ( $result > 0 ) {
//            foreach ( $reviews as $review ) {
//                $review_title      = ( $review->find( 'h2[data-service-review-title-typography]', 0 ) ) ? $review->find( 'h2[data-service-review-title-typography]', 0 )->plaintext : '';
//                $review_content    = ( $review->find( 'p[data-service-review-text-typography]', 0 ) ) ? $review->find( 'p[data-service-review-text-typography]', 0 )->plaintext : '';
//                $reviewer_name     = ( $review->find( 'span[data-consumer-name-typography]', 0 ) ) ? $review->find( 'span[data-consumer-name-typography]', 0 )->plaintext : '';
//               // $reviewer_img     = ( $review->find( 'img[data-consumer-avatar-image]', 1 )->attr['src'] ) ? $review->find( 'img[data-consumer-avatar-image]', 0 )->attr['src'] : plugin_dir_path( __FILE__ ).'public/reviewer.png';
//                $reviewer_location = ( $review->find( 'div[data-consumer-country-typography] > span', 0 ) ) ? $review->find( 'div[data-consumer-country-typography] > span', 0 )->plaintext : '';
//                $review_date       = ( $review->find( 'time[data-service-review-date-time-ago]', 0 )->attr['datetime'] ) ? $review->find( 'time[data-service-review-date-time-ago]', 0 )->attr['datetime'] : ' ';
//                $review_rating     = ( $review->find( 'div[data-service-review-rating]', 0 )->attr['data-service-review-rating'] ) ? $review->find( 'div[data-service-review-rating]', 0 )->attr['data-service-review-rating'] : '';
//                $review_rating_img = ( $review->find( 'div[data-service-review-rating] > div > img', 0 )->attr['src'] ) ? $review->find( 'div[data-service-review-rating] > div > img', 0 )->attr['src'] : '';
//                if ( $latest_review_date < $review_date ) {
//
//                    $wpdb->insert(
//                        $table_name,
//                        array(
//                            'review_title'          => $review_title,
//                            'review_content'        => $review_content,
//                            'reviewer_name'         => $reviewer_name,
//                         //   'reviewer_img_url'      => $reviewer_img,
//                            'reviewer_location'     => $reviewer_location,
//                            'review_rating'         => $review_rating,
//                            'review_rating_img_url' => $review_rating_img,
//                            'review_date'           => date( 'Y-m-d H:i:s', strtotime( $review_date ) ),
//                        )
//                    );
//                }
//            }
//        } else {
//            $this->get_all_reviews( $company_name );
//        }
//
//        // Get the newly cached reviews
//        return $review = $wpdb->get_results( "SELECT * FROM $table_name WHERE review_date >= NOW() - INTERVAL $cache_lifetime SECOND" );
//    }

    private function get_single_page_reviews( $url ) {
        $curl = curl_init( $url );
        curl_setopt( $curl, CURLOPT_URL, $url );
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );

        $headers = array(
            "User-Agent: ReqBin Curl Client/1.0",
        );
        curl_setopt( $curl, CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $curl, CURLOPT_SSL_VERIFYHOST, false );
        curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false );

        $all_reviews = curl_exec( $curl );
        curl_close( $curl );

        $dom = new simple_html_dom();
        $dom->load( $all_reviews );
        $reviews = $dom->find( 'article[data-service-review-card-paper]' );

        global $wpdb;
        $table_name = $wpdb->prefix . CE_TRUSTPILOT_REVIEW_TABLE;
        foreach ( $reviews as $review ) {
            $review_title      = ( $review->find( 'h2[data-service-review-title-typography]', 0 ) ) ? $review->find( 'h2[data-service-review-title-typography]', 0 )->plaintext : '';
            $review_content    = ( $review->find( 'p[data-service-review-text-typography]', 0 ) ) ? $review->find( 'p[data-service-review-text-typography]', 0 )->plaintext : '';
            $reviewer_name     = ( $review->find( 'span[data-consumer-name-typography]', 0 ) ) ? $review->find( 'span[data-consumer-name-typography]', 0 )->plaintext : '';
            $reviewer_location = ( $review->find( 'div[data-consumer-country-typography] > span', 0 ) ) ? $review->find( 'div[data-consumer-country-typography] > span', 0 )->plaintext : '';
            $review_date       = ( $review->find( 'time[data-service-review-date-time-ago]', 0 )->attr['datetime'] ) ? $review->find( 'time[data-service-review-date-time-ago]', 0 )->attr['datetime'] : ' ';
            $review_rating     = ( $review->find( 'div[data-service-review-rating]', 0 )->attr['data-service-review-rating'] ) ? $review->find( 'div[data-service-review-rating]', 0 )->attr['data-service-review-rating'] : '';
            $review_rating_img = ( $review->find( 'div[data-service-review-rating] > div > img', 0 )->attr['src'] ) ? $review->find( 'div[data-service-review-rating] > div > img', 0 )->attr['src'] : '';

            $wpdb->insert(
                $table_name,
                array(
                    'review_title'          => $review_title,
                    'review_content'        => $review_content,
                    'reviewer_name'         => $reviewer_name,
                    'reviewer_location'     => $reviewer_location,
                    'review_rating'         => $review_rating,
                    'review_rating_img_url' => $review_rating_img,
                    'review_date'           => date( 'Y-m-d H:i:s', strtotime( $review_date ) ),
                )
            );
        }
    }

    private function get_all_reviews( $company_name ) {

        $url  = 'https://www.trustpilot.com/review/' . $company_name;
        $curl = curl_init( $url );
        curl_setopt( $curl, CURLOPT_URL, $url );
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
        $headers = array(
            "User-Agent: ReqBin Curl Client/1.0",
        );
        curl_setopt( $curl, CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $curl, CURLOPT_SSL_VERIFYHOST, false );
        curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false );

        $html = curl_exec( $curl );
        curl_close( $curl );

        $dom = new simple_html_dom();
        $dom->load( $html );
        $reviews_total_page = $dom->find( 'a[data-pagination-button-last-link] > span', 0 )->plaintext;

        for ( $x = 1; $x <= $reviews_total_page; $x++ ) {

            switch ( $x ) {
                case "1":
                    $urls = $url;
                    break;
                default:
                    $urls = $url . '?page=' . $x;
            }
            $this->get_single_page_reviews( $urls );
        }
    }

}
